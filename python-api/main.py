from fastapi import FastAPI, Request
import joblib
import pandas as pd
import numpy as np
import json
import datetime
from fastapi.middleware.cors import CORSMiddleware

app = FastAPI()

# Aktifkan CORS untuk akses dari Laravel lokal
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_methods=["*"],
    allow_headers=["*"],
)

# Load model & mapping
preprocessing = joblib.load("preprocessing.pkl")
model         = joblib.load("decision_tree_model.pkl")

label_encoder   = preprocessing['label_encoder']
status_mapping  = preprocessing['status_mapping']
feature_columns = preprocessing['feature_columns']

# Fungsi bantu hitung keterlambatan dan pulang cepat
def is_late(jadwal, masuk):
    try:
        return datetime.datetime.strptime(masuk, "%H:%M:%S") > datetime.datetime.strptime(jadwal, "%H:%M:%S")
    except:
        return False

def is_early(pulang, keluar):
    try:
        return datetime.datetime.strptime(keluar, "%H:%M:%S") < datetime.datetime.strptime(pulang, "%H:%M:%S")
    except:
        return False

@app.post("/predict-all")
async def predict_all(request: Request):
    data = await request.json()

    df_karyawan = pd.DataFrame(data["karyawan"])
    df_absensi  = pd.DataFrame(data["absensi"])
    df_izin     = pd.DataFrame(data["izin"])
    df_sakit    = pd.DataFrame(data["sakit"])
    df_cuti     = pd.DataFrame(data["cuti"])

    # Hitung jumlah hari kerja dari absensi
    total_hari_kerja = df_absensi['tanggal'].nunique() if not df_absensi.empty else 1

    # Hitung keterlambatan dan pulang cepat
    df_absensi["is_late"] = df_absensi.apply(lambda row: is_late(row["jadwal_masuk"], row["jam_masuk"]), axis=1)
    df_absensi["is_early"] = df_absensi.apply(lambda row: is_early(row["jadwal_pulang"], row["jam_keluar"]), axis=1)

    # late_count = df_absensi.groupby("id_karyawan")["is_late"].sum().reset_index(name="jumlah_keterlambatan")
    # early_count = df_absensi.groupby("id_karyawan")["is_early"].sum().reset_index(name="jumlah_pulang_cepat")
    # izin_count = df_izin.groupby("id_karyawan")["jml_hari"].sum().reset_index(name="total_hari_izin")
    # sakit_count = df_sakit.groupby("id_karyawan")["jml_hari"].sum().reset_index(name="total_hari_sakit")
    # cuti_count = df_cuti.groupby("id_karyawan")["jml_cuti"].sum().reset_index(name="jumlah_cuti")

    # Jumlah keterlambatan
    if not df_absensi.empty and "id_karyawan" in df_absensi.columns and "is_late" in df_absensi.columns:
        late_count = df_absensi.groupby("id_karyawan")["is_late"].sum().reset_index(name="jumlah_keterlambatan")
    else:
        late_count = pd.DataFrame(columns=["id_karyawan", "jumlah_keterlambatan"])

    # Jumlah pulang cepat
    if not df_absensi.empty and "id_karyawan" in df_absensi.columns and "is_early" in df_absensi.columns:
        early_count = df_absensi.groupby("id_karyawan")["is_early"].sum().reset_index(name="jumlah_pulang_cepat")
    else:
        early_count = pd.DataFrame(columns=["id_karyawan", "jumlah_pulang_cepat"])

    # Jumlah hari izin
    if not df_izin.empty and "id_karyawan" in df_izin.columns and "jml_hari" in df_izin.columns:
        izin_count = df_izin.groupby("id_karyawan")["jml_hari"].sum().reset_index(name="total_hari_izin")
    else:
        izin_count = pd.DataFrame(columns=["id_karyawan", "total_hari_izin"])

    # Jumlah hari sakit
    if not df_sakit.empty and "id_karyawan" in df_sakit.columns and "jml_hari" in df_sakit.columns:
        sakit_count = df_sakit.groupby("id_karyawan")["jml_hari"].sum().reset_index(name="total_hari_sakit")
    else:
        sakit_count = pd.DataFrame(columns=["id_karyawan", "total_hari_sakit"])

    # Jumlah cuti
    if not df_cuti.empty and "id_karyawan" in df_cuti.columns and "jml_cuti" in df_cuti.columns:
        cuti_count = df_cuti.groupby("id_karyawan")["jml_cuti"].sum().reset_index(name="jumlah_cuti")
    else:
        cuti_count = pd.DataFrame(columns=["id_karyawan", "jumlah_cuti"])


    # Gabungkan semua ke dataframe karyawan
    df = df_karyawan.rename(columns={"id": "id_karyawan"})
    df = df.merge(late_count, on="id_karyawan", how="left")
    df = df.merge(early_count, on="id_karyawan", how="left")
    df = df.merge(izin_count, on="id_karyawan", how="left")
    df = df.merge(sakit_count, on="id_karyawan", how="left")
    df = df.merge(cuti_count, on="id_karyawan", how="left")
    df.fillna(0, inplace=True)

    # Encoding dan rasio
    df["status_karyawan_encoded"] = df["status_karyawan"].map(status_mapping)
    df["rasio_keterlambatan"] = df["jumlah_keterlambatan"] / total_hari_kerja
    df["rasio_pulang_cepat"] = df["jumlah_pulang_cepat"] / total_hari_kerja
    df["rasio_absen"] = (df["total_hari_izin"] + df["total_hari_sakit"]) / total_hari_kerja

    # Pilih fitur
    fitur = df[[
        "jumlah_keterlambatan", "jumlah_pulang_cepat", "total_hari_izin",
        "total_hari_sakit", "jumlah_cuti", "status_karyawan_encoded",
        "rasio_keterlambatan", "rasio_pulang_cepat", "rasio_absen"
    ]]

    # Prediksi
    df["prediksi_status_encoded"] = model.predict(fitur)
    df["resign_probability"] = model.predict_proba(fitur)[:, 1] * 100

    # Skor risiko
    df["risk_score"] = (
        df["resign_probability"] * 0.6 +
        df["rasio_keterlambatan"] * 100 * 0.15 +
        df["rasio_pulang_cepat"] * 100 * 0.15 +
        (df["total_hari_izin"] / 10) * 0.1
    )

    df["risk_score"] = df["risk_score"].round(2)
    df["resign_probability"] = df["resign_probability"].round(2)
    df["prediksi_resign"] = df["prediksi_status_encoded"].apply(lambda x: 1 if x == 1 else 0)

    # Ambil kolom untuk Laravel
    hasil = df[[
        "id_karyawan", "nama", "status_karyawan", "status_kerja",
        "rasio_keterlambatan", "rasio_pulang_cepat",
        "total_hari_izin", "total_hari_sakit", "jumlah_cuti",
        "resign_probability", "risk_score", "prediksi_resign"
    ]].rename(columns={"id_karyawan": "id"}).sort_values(by="risk_score", ascending=False)

    return hasil.to_dict(orient="records")
