<?php

namespace App\Http\Controllers\manager;

use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\Status;
use App\Models\Karyawan;
use App\Models\Sisacuti;
use App\Models\Datareject;
use App\Models\Alokasicuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\PerubahanNotification;
use App\Http\Controllers\Controller;
use App\Mail\PembatalanNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PembatalanPerubahanController extends Controller
{
    public function batalApprove(Request $request, $id)
    {
        $cutis = Cuti::where('id',$id)->first();
        $datacuti = Cuti::leftjoin('karyawan','cuti.id_karyawan','=','karyawan.id')
            ->where('cuti.id', '=',$cutis->id)
            ->select('karyawan.atasan_pertama','karyawan.atasan_kedua')
            ->first();

        // dd($datacuti,$datacut);
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;
        // return $row->jabatan;
        if($datacuti && $role == 3 && $row->jabatan == "Asisten Manajer")
        {
                $status = Status::find(12);
                // return $status->name_status;
                Cuti::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'batal_atasan' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $cuti = Cuti::where('id',$id)->first();
                 //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                $ct = DB::table('cuti')
                    ->join('jeniscuti','cuti.id_jeniscuti','=','jeniscuti.id')
                    ->join('statuses','cuti.catatan','=','statuses.name_status')
                    ->where('cuti.id',$id)
                    ->select('cuti.*','jeniscuti.jenis_cuti as jenis_cuti','statuses.name_status')
                    ->first();
                $karyawan = DB::table('cuti')
                    ->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                    ->join('departemen','cuti.departemen','=','departemen.id')
                    ->where('cuti.id',$cuti->id)
                    ->select('karyawan.email as email','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first(); 
                $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                $atasan2 = NULL;

                if($karyawan->atasan_kedua !== NULL){
                    $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                }
                $tujuan = $atasan2->email;
                $data = [
                    'subject'     => 'Notifikasi Approval Pertama Formulir Pembatalan ' . $ct->jenis_cuti . ' #' . $ct->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$cuti->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR CUTI KARYAWAN',
                    'subtitle' => '[ PERSETUJUAN PEMBATALAN ]',
                    'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $cuti->nik,
                    'jabatankaryawan' => $cuti->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $ct->jenis_cuti,
                    'keperluan'   => $ct->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($ct->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($ct->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $ct->jml_cuti,
                    'status'      => $ct->name_status,
                    'alasan'      =>null,
                    'tgldisetujuiatasan' => Carbon::parse($ct->batal_atasan)->format('d/m/Y H:i'),
                    'tgldisetujuipimpinan' => '-',
                    'tglditolak' => '-',
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }
                // dd($data);
                Mail::to($tujuan)->send(new PembatalanNotification($data));
                // return $data;
            // }else{
                return redirect()->back();
            // }
        }
        elseif($datacuti && $role == 1 && $row->jabatan == "Asisten Manajer")
        {
                $status = Status::find(12);
                // return $status->name_status;
                Cuti::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'batal_atasan' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $cuti = Cuti::where('id',$id)->first();
                 //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                $ct = DB::table('cuti')
                    ->join('jeniscuti','cuti.id_jeniscuti','=','jeniscuti.id')
                    ->join('statuses','cuti.catatan','=','statuses.name_status')
                    ->where('cuti.id',$id)
                    ->select('cuti.*','jeniscuti.jenis_cuti as jenis_cuti','statuses.name_status')
                    ->first();
                $karyawan = DB::table('cuti')
                    ->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                    ->join('departemen','cuti.departemen','=','departemen.id')
                    ->where('cuti.id',$cuti->id)
                    ->select('karyawan.email as email','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first(); 
                $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                $atasan2 = NULL;

                if($karyawan->atasan_kedua !== NULL){
                    $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                }
                $tujuan = $atasan2->email;
                $data = [
                    'subject'     => 'Notifikasi Approval Pertama Formulir Pembatalan ' . $ct->jenis_cuti . ' #' . $ct->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$cuti->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR CUTI KARYAWAN',
                    'subtitle' => '[ PERSETUJUAN PEMBATALAN ]',
                    'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $cuti->nik,
                    'jabatankaryawan' => $cuti->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $ct->jenis_cuti,
                    'keperluan'   => $ct->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($ct->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($ct->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $ct->jml_cuti,
                    'status'      => $ct->name_status,
                    'alasan'      =>null,
                    'tgldisetujuiatasan' => Carbon::parse($ct->batal_atasan)->format('d/m/Y H:i'),
                    'tgldisetujuipimpinan' => '-',
                    'tglditolak' => '-',
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }
                // dd($data);
                Mail::to($tujuan)->send(new PembatalanNotification($data));
                // return $data;
            // }else{
                return redirect()->back();
            // }
        }
        elseif($datacuti && $role == 3 && $row->jabatan == "Manajer")
        {
            if($datacuti && $datacuti->atasan_kedua == Auth::user()->id_pegawai)
            {
                $status = Status::find(13);
                Cuti::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'batal_pimpinan' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $cuti = Cuti::where('id',$id)->first();
                $jml_cuti = $cuti->sisacuti;

                $alokasicuti = Alokasicuti::where('id', $cuti->id_alokasi)
                    ->where('id_karyawan', $cuti->id_karyawan)
                    ->where('id_jeniscuti', $cuti->id_jeniscuti)
                    ->where('id_settingalokasi', $cuti->id_settingalokasi)
                    ->first();

                Alokasicuti::where('id', $alokasicuti->id)
                    ->update(
                        ['durasi' => $jml_cuti]
                    );

                $cekSisacuti = Sisacuti::join('cuti', 'cuti.id_jeniscuti', 'sisacuti.jenis_cuti')
                    ->join('alokasicuti', 'sisacuti.id_alokasi', 'alokasicuti.id')
                    ->where('cuti.id',$cuti->id)
                    ->where('cuti.id_alokasi',$cuti->id_alokasi)
                    ->where('sisacuti.id_alokasi',$cuti->id_alokasi)
                    ->where('sisacuti.id_pegawai',$cuti->id_karyawan)
                    ->exists();
                 
                if($cekSisacuti)
                {
                    $sisacuti = Sisacuti::where('jenis_cuti', $cuti->id_jeniscuti)
                        ->where('id_pegawai', $cuti->id_karyawan)
                        ->first();
    
                    $sisacuti_baru = $sisacuti->sisacuti - $jml_cuti;
    
                    Sisacuti::where('id', $sisacuti->id)
                    ->update(
                            ['sisa_cuti' => $sisacuti_baru]
                    );

                }
                //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jeniscuti
                $ct = DB::table('cuti')
                    ->join('jeniscuti','cuti.id_jeniscuti','=','jeniscuti.id')
                    ->join('statuses','cuti.catatan','=','statuses.name_status')
                    ->where('cuti.id',$id)
                    ->select('cuti.*','jeniscuti.jenis_cuti as jenis_cuti','statuses.name_status')
                    ->first();

                $karyawan = DB::table('cuti')
                    ->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                    ->join('departemen','cuti.departemen','=','departemen.id')
                    ->where('cuti.id',$cuti->id)
                    ->select('karyawan.email as email','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first(); 
                $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                $atasan2 = NULL;
                if($karyawan->atasan_kedua !== NULL){
                    $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                }
                $tujuan = $karyawan->email;
                $data = [
                    'subject'     => 'Notifikasi Persetujuan Formulir Pembatalan ' . $ct->jenis_cuti . ' #' . $ct->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$cuti->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR CUTI KARYAWAN',
                    'subtitle' => '[ PERSETUJUAN PEMBATALAN ]',
                    'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $cuti->nik,
                    'jabatankaryawan' => $cuti->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $ct->jenis_cuti,
                    'keperluan'   => $ct->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($ct->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($ct->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $ct->jml_cuti,
                    'status'      => $ct->name_status,
                    'alasan'      =>null,
                    'tgldisetujuiatasan' => Carbon::parse($ct->batal_atasan)->format("d/m/Y H:i"),
                    'tgldisetujuipimpinan' => Carbon::parse($ct->batal_pimpinan)->format("d/m/Y H:i"),
                    'tglditolak' =>'-',
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }
                // return $data;
                Mail::to($tujuan)->send(new PembatalanNotification($data));
                return redirect()->back();
            }
            elseif($datacuti && $datacuti->atasan_pertama == Auth::user()->id_pegawai)
            {
                // return $datacuti;
                $status = Status::find(12);
                // return $status->id;
                Cuti::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'batal_atasan' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $cuti = Cuti::where('id',$id)->first();

                 //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jeniscuti
                $ct = DB::table('cuti')
                ->join('jeniscuti','cuti.id_jeniscuti','=','jeniscuti.id')
                ->join('statuses','cuti.catatan','=','statuses.name_status')
                ->where('cuti.id',$id)
                ->select('cuti.*','jeniscuti.jenis_cuti as jenis_cuti','statuses.name_status')
                ->first();
                $alasan = Datareject::where('id_cuti',$cuti->id)->first();
                //sementara tidak digunakan
                $karyawan = DB::table('cuti')
                    ->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                    ->join('departemen','cuti.departemen','=','departemen.id')
                    ->where('cuti.id',$cuti->id)
                    ->select('karyawan.email as email','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first(); 
                $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                $atasan2 = NULL;

                if($karyawan->atasan_kedua !== NULL){
                    $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                }
                $tujuan = $atasan2->email;
                $data = [
                    'subject'     => 'Notifikasi Approval Pertama Formulir Pembatalan ' . $ct->jenis_cuti . ' #' . $ct->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$cuti->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR CUTI KARYAWAN',
                    'subtitle' => '[ PERSETUJUAN PEMBATALAN ]',
                    'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $cuti->nik,
                    'jabatankaryawan' => $cuti->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $ct->jenis_cuti,
                    'keperluan'   => $ct->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($ct->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($ct->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $ct->jml_cuti,
                    'status'      => $ct->name_status,
                    'alasan'      =>null,
                    'tgldisetujuiatasan' => Carbon::parse($ct->batal_atasan)->format('d/m/Y H:i'),
                    'tgldisetujuipimpinan' => '-',
                    'tglditolak' => '-',
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }
                // return $data;
                Mail::to($tujuan)->send(new PembatalanNotification($data));
                return redirect()->back();
                // return $data;
            }
            else{
                return redirect()->back();
            }
        }
        elseif($datacuti && $role == 1 && $row->jabatan == "Manajer")
        {
            if($datacuti && $datacuti->atasan_kedua == Auth::user()->id_pegawai)
            {
                $status = Status::find(13);
                Cuti::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'batal_pimpinan' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $cuti = Cuti::where('id',$id)->first();

                $alokasicuti = Alokasicuti::where('id', $cuti->id_alokasi)
                    ->where('id_karyawan', $cuti->id_karyawan)
                    ->where('id_jeniscuti', $cuti->id_jeniscuti)
                    ->where('id_settingalokasi', $cuti->id_settingalokasi)
                    ->first();

                $durasibaru = $cuti->saldohakcuti;
    
                Alokasicuti::where('id', $alokasicuti->id)
                ->update(
                    ['durasi' => $durasibaru]
                );

                $cekSisacuti = Sisacuti::join('cuti', 'cuti.id_jeniscuti', 'sisacuti.jenis_cuti')
                    ->join('alokasicuti', 'sisacuti.id_alokasi', 'alokasicuti.id')
                    ->where('cuti.id',$cuti->id)
                    ->where('cuti.id_alokasi',$cuti->id_alokasi)
                    ->where('sisacuti.id_alokasi',$cuti->id_alokasi)
                    ->where('sisacuti.id_pegawai',$cuti->id_karyawan)
                    ->exists();

                if($cekSisacuti)
                {
                    $sisacuti = Sisacuti::where('jenis_cuti', $cuti->id_jeniscuti)
                        ->where('id_pegawai', $cuti->id_karyawan)
                        ->first();

                    $jml_cuti = $cuti->sisacuti;
                    $sisacuti_baru = $sisacuti->sisacuti - $jml_cuti;

                    Sisacuti::where('id', $sisacuti->id)
                    ->update(
                        ['sisa_cuti' => $sisacuti_baru]
                    );

                }
                
                //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jeniscuti
                $ct = DB::table('cuti')
                    ->join('jeniscuti','cuti.id_jeniscuti','=','jeniscuti.id')
                    ->join('statuses','cuti.catatan','=','statuses.name_status')
                    ->where('cuti.id',$id)
                    ->select('cuti.*','jeniscuti.jenis_cuti as jenis_cuti','statuses.name_status')
                    ->first();

                $karyawan = DB::table('cuti')
                    ->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                    ->join('departemen','cuti.departemen','=','departemen.id')
                    ->where('cuti.id',$cuti->id)
                    ->select('karyawan.email as email','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first(); 
                $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                $atasan2 = NULL;
                if($karyawan->atasan_kedua !== NULL){
                    $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                }
                $tujuan = $karyawan->email;
                $data = [
                    'subject'     => 'Notifikasi Persetujuan Formulir Pembatalan ' . $ct->jenis_cuti . ' #' . $ct->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$cuti->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR CUTI KARYAWAN',
                    'subtitle' => '[ PERSETUJUAN PEMBATALAN ]',
                    'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $cuti->nik,
                    'jabatankaryawan' => $cuti->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $ct->jenis_cuti,
                    'keperluan'   => $ct->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($ct->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($ct->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $ct->jml_cuti,
                    'status'      => $ct->name_status,
                    'alasan'      =>null,
                    'tgldisetujuiatasan' => Carbon::parse($ct->batal_atasan)->format("d/m/Y H:i"),
                    'tgldisetujuipimpinan' => Carbon::parse($ct->batal_pimpinan)->format("d/m/Y H:i"),
                    'tglditolak' =>'-',
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }
                // return $data;
                Mail::to($tujuan)->send(new PembatalanNotification($data));
                return redirect()->back();
            }
            elseif($datacuti && $datacuti->atasan_pertama == Auth::user()->id_pegawai)
            {
                // return $datacuti;
                $status = Status::find(12);
                // return $status->id;
                Cuti::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'batal_atasan' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $cuti = Cuti::where('id',$id)->first();

                 //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jeniscuti
                $ct = DB::table('cuti')
                ->join('jeniscuti','cuti.id_jeniscuti','=','jeniscuti.id')
                ->join('statuses','cuti.catatan','=','statuses.name_status')
                ->where('cuti.id',$id)
                ->select('cuti.*','jeniscuti.jenis_cuti as jenis_cuti','statuses.name_status')
                ->first();
                $alasan = Datareject::where('id_cuti',$cuti->id)->first();
                //sementara tidak digunakan
                $karyawan = DB::table('cuti')
                    ->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                    ->join('departemen','cuti.departemen','=','departemen.id')
                    ->where('cuti.id',$cuti->id)
                    ->select('karyawan.email as email','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first(); 
                $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                $atasan2 = NULL;

                if($karyawan->atasan_kedua !== NULL){
                    $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                }
                $tujuan = $atasan2->email;
                $data = [
                    'subject'     => 'Notifikasi Approval Pertama Formulir Pembatalan ' . $ct->jenis_cuti . ' #' . $ct->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$cuti->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR CUTI KARYAWAN',
                    'subtitle' => '[ PERSETUJUAN PEMBATALAN ]',
                    'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $cuti->nik,
                    'jabatankaryawan' => $cuti->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $ct->jenis_cuti,
                    'keperluan'   => $ct->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($ct->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($ct->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $ct->jml_cuti,
                    'status'      => $ct->name_status,
                    'alasan'      =>null,
                    'tgldisetujuiatasan' => Carbon::parse($ct->batal_atasan)->format('d/m/Y H:i'),
                    'tgldisetujuipimpinan' => '-',
                    'tglditolak' => '-',
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }
                // return $data;
                Mail::to($tujuan)->send(new PembatalanNotification($data));
                return redirect()->back();
                // return $data;
            }
            else{
                return redirect()->back();
            }
        }
        elseif($datacuti && $role == 3 && $row->jabatan == "Direksi")
        {
            // dd("hai direktur ini pembatalan dan perubahan cuti");
            // dd($datacuti);
            if($datacuti && $datacuti->atasan_kedua == Auth::user()->id_pegawai)
            {
                // dd($datacuti);
                $status = Status::find(13);
                Cuti::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'batal_pimpinan' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $cuti = Cuti::where('id',$id)->first();
                // dd($cuti);

                $alokasicuti = Alokasicuti::where('id', $cuti->id_alokasi)
                    ->where('id_jeniscuti', $cuti->id_jeniscuti)
                    ->where('id_settingalokasi', $cuti->id_settingalokasi)
                    ->first();

                $durasibaru = $cuti->saldohakcuti;
                // dd($cuti,$alokasicuti);
    
                Alokasicuti::where('id', $alokasicuti->id)
                ->update(
                    ['durasi' => $durasibaru]
                );

                $cekSisacuti = Sisacuti::join('cuti', 'cuti.id_jeniscuti', 'sisacuti.jenis_cuti')
                    ->join('alokasicuti', 'sisacuti.id_alokasi', 'alokasicuti.id')
                    ->where('cuti.id',$cuti->id)
                    ->where('cuti.id_alokasi',$cuti->id_alokasi)
                    ->where('sisacuti.id_alokasi',$cuti->id_alokasi)
                    ->where('sisacuti.id_pegawai',$cuti->id_karyawan)
                    ->exists();

                if($cekSisacuti)
                {
                    $sisacuti = Sisacuti::where('jenis_cuti', $cuti->id_jeniscuti)
                        ->where('id_pegawai', $cuti->id_karyawan)
                        ->first();

                    $jml_cuti = $cuti->sisacuti;
                    $sisacuti_baru = $sisacuti->sisacuti - $jml_cuti;

                    Sisacuti::where('id', $sisacuti->id)
                    ->update(
                        ['sisa_cuti' => $sisacuti_baru]
                    );

                }
                
                //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jeniscuti
                $ct = DB::table('cuti')
                    ->join('jeniscuti','cuti.id_jeniscuti','=','jeniscuti.id')
                    ->join('statuses','cuti.catatan','=','statuses.name_status')
                    ->where('cuti.id',$id)
                    ->select('cuti.*','jeniscuti.jenis_cuti as jenis_cuti','statuses.name_status')
                    ->first();

                $karyawan = DB::table('cuti')
                    ->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                    ->join('departemen','cuti.departemen','=','departemen.id')
                    ->where('cuti.id',$cuti->id)
                    ->select('karyawan.email as email','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first(); 
                $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                $atasan2 = NULL;
                if($karyawan->atasan_kedua !== NULL){
                    $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                }
                $tujuan = $karyawan->email;
                $data = [
                    'subject'     => 'Notifikasi Persetujuan Formulir Pembatalan ' . $ct->jenis_cuti . ' #' . $ct->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$cuti->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR CUTI KARYAWAN',
                    'subtitle' => '[ PERSETUJUAN PEMBATALAN ]',
                    'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $cuti->nik,
                    'jabatankaryawan' => $cuti->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $ct->jenis_cuti,
                    'keperluan'   => $ct->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($ct->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($ct->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $ct->jml_cuti,
                    'status'      => $ct->name_status,
                    'alasan'      =>null,
                    'tgldisetujuiatasan' => Carbon::parse($ct->batal_atasan)->format("d/m/Y H:i"),
                    'tgldisetujuipimpinan' => Carbon::parse($ct->batal_pimpinan)->format("d/m/Y H:i"),
                    'tglditolak' =>'-',
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }
                // return $data;
                Mail::to($tujuan)->send(new PembatalanNotification($data));
                return redirect()->back();
            }
            elseif($datacuti && $datacuti->atasan_pertama == Auth::user()->id_pegawai)
            {
                // return $datacuti;
                $status = Status::find(12);
                // return $status->id;
                Cuti::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'batal_atasan' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $cuti = Cuti::where('id',$id)->first();

                 //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jeniscuti
                $ct = DB::table('cuti')
                ->join('jeniscuti','cuti.id_jeniscuti','=','jeniscuti.id')
                ->join('statuses','cuti.catatan','=','statuses.name_status')
                ->where('cuti.id',$id)
                ->select('cuti.*','jeniscuti.jenis_cuti as jenis_cuti','statuses.name_status')
                ->first();
                $alasan = Datareject::where('id_cuti',$cuti->id)->first();
                //sementara tidak digunakan
                $karyawan = DB::table('cuti')
                    ->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                    ->join('departemen','cuti.departemen','=','departemen.id')
                    ->where('cuti.id',$cuti->id)
                    ->select('karyawan.email as email','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first(); 
                $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                $atasan2 = NULL;

                if($karyawan->atasan_kedua !== NULL){
                    $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                }
                $tujuan = $atasan2->email;
                $data = [
                    'subject'     => 'Notifikasi Approval Pertama Formulir Pembatalan ' . $ct->jenis_cuti . ' #' . $ct->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$cuti->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR CUTI KARYAWAN',
                    'subtitle' => '[ PERSETUJUAN PEMBATALAN ]',
                    'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $cuti->nik,
                    'jabatankaryawan' => $cuti->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $ct->jenis_cuti,
                    'keperluan'   => $ct->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($ct->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($ct->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $ct->jml_cuti,
                    'status'      => $ct->name_status,
                    'alasan'      =>null,
                    'tgldisetujuiatasan' => Carbon::parse($ct->batal_atasan)->format('d/m/Y H:i'),
                    'tgldisetujuipimpinan' => '-',
                    'tglditolak' => '-',
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }
                // return $data;
                Mail::to($tujuan)->send(new PembatalanNotification($data));
                return redirect()->back();
                // return $data;
            }
            else{
                return redirect()->back();
            }
        }
        else{
            return redirect()->back();
        }
    }

    public function batalRejected(Request $request, $id)
    {
        $cutis = Cuti::where('id',$id)->first();
        $datacuti = Cuti::leftjoin('karyawan','cuti.id_karyawan','=','karyawan.id')
            ->where('cuti.id', '=',$cutis->id)
            ->select('karyawan.atasan_pertama','karyawan.atasan_kedua')
            ->first();

        // dd($datacuti,$datacut);
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;
        // return $row->jabatan;
        if($datacuti && $role == 3 && $row->jabatan == "Asisten Manajer")
        {
                $status = Status::find(9);
                // return $status->name_status;
                Cuti::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'batalditolak' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $cuti = Cuti::where('id',$id)->first();
                 //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                $ct = DB::table('cuti')
                    ->join('jeniscuti','cuti.id_jeniscuti','=','jeniscuti.id')
                    ->join('statuses','cuti.catatan','=','statuses.name_status')
                    ->where('cuti.id',$id)
                    ->select('cuti.*','jeniscuti.jenis_cuti as jenis_cuti','statuses.name_status')
                    ->first();
                $alasan = Datareject::where('id_cuti',$cuti->id)->first();
                $karyawan = DB::table('cuti')
                    ->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                    ->join('departemen','cuti.departemen','=','departemen.id')
                    ->where('cuti.id',$cuti->id)
                    ->select('karyawan.email as email','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first(); 
                $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                $atasan2 = NULL;

                if($karyawan->atasan_kedua !== NULL){
                    $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                }
                $tujuan = $atasan2->email;
                $data = [
                    'subject'     => 'Notifikasi Pembatalan Permohonan Ditolak ' . $ct->jenis_cuti . ' #' . $ct->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$cuti->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN PEMBATALAN FORMULIR CUTI KARYAWAN',
                    'subtitle' => '[ PENDING ATASAN ]',
                    'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $cuti->nik,
                    'jabatankaryawan' => $cuti->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $ct->jenis_cuti,
                    'keperluan'   => $ct->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($ct->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($ct->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $ct->jml_cuti,
                    'status'      => $ct->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' =>'-',
                    'tgldisetujuipimpinan' => '-',
                    'tglditolak' => Carbon::parse($ct->batalditolak)->format("d/m/Y H:i"),
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }
                // dd($data);
                Mail::to($tujuan)->send(new PembatalanNotification($data));
                // return $data;
            // }else{
                return redirect()->back();
            // }
        }
        elseif($datacuti && $role == 1 && $row->jabatan == "Asisten Manajer")
        {
                $status = Status::find(9);
                // return $status->name_status;
                Cuti::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'batalditolak' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $cuti = Cuti::where('id',$id)->first();
                 //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                $ct = DB::table('cuti')
                    ->join('jeniscuti','cuti.id_jeniscuti','=','jeniscuti.id')
                    ->join('statuses','cuti.catatan','=','statuses.name_status')
                    ->where('cuti.id',$id)
                    ->select('cuti.*','jeniscuti.jenis_cuti as jenis_cuti','statuses.name_status')
                    ->first();
                $alasan = Datareject::where('id_cuti',$cuti->id)->first();
                $karyawan = DB::table('cuti')
                    ->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                    ->join('departemen','cuti.departemen','=','departemen.id')
                    ->where('cuti.id',$cuti->id)
                    ->select('karyawan.email as email','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first(); 
                $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                $atasan2 = NULL;

                if($karyawan->atasan_kedua !== NULL){
                    $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                }
                $tujuan = $atasan2->email;
                $data = [
                    'subject'     => 'Notifikasi Pembatalan Permohonan Ditolak ' . $ct->jenis_cuti . ' #' . $ct->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$cuti->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN PEMBATALAN FORMULIR CUTI KARYAWAN',
                    'subtitle' => '[ PENDING ATASAN ]',
                    'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $cuti->nik,
                    'jabatankaryawan' => $cuti->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $ct->jenis_cuti,
                    'keperluan'   => $ct->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($ct->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($ct->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $ct->jml_cuti,
                    'status'      => $ct->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' =>'-',
                    'tgldisetujuipimpinan' => '-',
                    'tglditolak' => Carbon::parse($ct->batalditolak)->format("d/m/Y H:i"),
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }
                // dd($data);
                Mail::to($tujuan)->send(new PembatalanNotification($data));
                // return $data;
            // }else{
                return redirect()->back();
            // }
        }
        else if($datacuti && $role == 3 && $row->jabatan == "Manajer")
        {
            if($datacuti && $datacuti->atasan_kedua == Auth::user()->id_pegawai)
            {
                $status = Status::find(10);
                Cuti::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'batalditolak' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $cuti = Cuti::where('id',$id)->first();

                //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jeniscuti
                $ct = DB::table('cuti')
                    ->join('jeniscuti','cuti.id_jeniscuti','=','jeniscuti.id')
                    ->join('statuses','cuti.catatan','=','statuses.name_status')
                    ->where('cuti.id',$id)
                    ->select('cuti.*','jeniscuti.jenis_cuti as jenis_cuti','statuses.name_status')
                    ->first();
                $alasan = Datareject::where('id_cuti',$cuti->id)->first();
                //sementara tidak digunakan
                $karyawan = DB::table('cuti')
                    ->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                    ->join('departemen','cuti.departemen','=','departemen.id')
                    ->where('cuti.id',$cuti->id)
                    ->select('karyawan.email as email','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first(); 
                $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                $atasan2 = NULL;
                if($karyawan->atasan_kedua !== NULL){
                    $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                }
                $tujuan = $karyawan->email;
                $data = [
                    'subject'     => 'Notifikasi Pembatalan Permohonan Ditolak ' . $ct->jenis_cuti . ' #' . $ct->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$cuti->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN PEMBATALAN FORMULIR CUTI KARYAWAN',
                    'subtitle' => '[ PENDING PIMPINAN UNIT KERJA ]',
                    'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $cuti->nik,
                    'jabatankaryawan' => $cuti->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $ct->jenis_cuti,
                    'keperluan'   => $ct->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($ct->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($ct->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $ct->jml_cuti,
                    'status'      => $ct->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' => Carbon::parse($ct->batal_atasan)->format("d/m/Y H:i"),
                    'tgldisetujuipimpinan' =>'-',
                    'tglditolak' => Carbon::parse($ct->batalditolak)->format('d/m/Y H:i'),
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }
                // return $data;
                Mail::to($tujuan)->send(new PembatalanNotification($data));
                return redirect()->back();
            }
            elseif($datacuti && $datacuti->atasan_pertama == Auth::user()->id_pegawai)
            {
                // return $datacuti;
                $status = Status::find(9);
                // return $status->id;
                Cuti::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'batalditolak' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $cuti = Cuti::where('id',$id)->first();

                 //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jeniscuti
                $ct = DB::table('cuti')
                ->join('jeniscuti','cuti.id_jeniscuti','=','jeniscuti.id')
                ->join('statuses','cuti.catatan','=','statuses.name_status')
                ->where('cuti.id',$id)
                ->select('cuti.*','jeniscuti.jenis_cuti as jenis_cuti','statuses.name_status')
                ->first();
                $alasan = Datareject::where('id_cuti',$cuti->id)->first();
                //sementara tidak digunakan
                $karyawan = DB::table('cuti')
                    ->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                    ->join('departemen','cuti.departemen','=','departemen.id')
                    ->where('cuti.id',$cuti->id)
                    ->select('karyawan.email as email','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first(); 
                $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                $atasan2 = NULL;

                if($karyawan->atasan_kedua !== NULL){
                    $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                }
                $tujuan = $atasan2->email;
                $data = [
                    'subject'     => 'Notifikasi Pembatalan Permohonan Ditolak ' . $ct->jenis_cuti . ' #' . $ct->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$cuti->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR CUTI KARYAWAN',
                    'subtitle' => '[ PERSETUJUAN PEMBATALAN ]',
                    'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $cuti->nik,
                    'jabatankaryawan' => $cuti->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $ct->jenis_cuti,
                    'keperluan'   => $ct->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($ct->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($ct->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $ct->jml_cuti,
                    'status'      => $ct->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' =>'-',
                    'tgldisetujuipimpinan' => '-',
                    'tglditolak' => Carbon::parse($ct->batalditolak)->format('d/m/Y H:i'),
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }
                // return $data;
                Mail::to($tujuan)->send(new PembatalanNotification($data));
                return redirect()->back();
                // return $data;
            }
            else{
                return redirect()->back();
            }
        }
        else if($datacuti && $role == 3 && $row->jabatan == "Direksi")
        {
            // dd("hai");
            if($datacuti && $datacuti->atasan_kedua == Auth::user()->id_pegawai)
            {
                $status = Status::find(10);
                Cuti::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'batalditolak' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $cuti = Cuti::where('id',$id)->first();

                //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jeniscuti
                $ct = DB::table('cuti')
                    ->join('jeniscuti','cuti.id_jeniscuti','=','jeniscuti.id')
                    ->join('statuses','cuti.catatan','=','statuses.name_status')
                    ->where('cuti.id',$id)
                    ->select('cuti.*','jeniscuti.jenis_cuti as jenis_cuti','statuses.name_status')
                    ->first();
                $alasan = Datareject::where('id_cuti',$cuti->id)->first();
                //sementara tidak digunakan
                $karyawan = DB::table('cuti')
                    ->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                    ->join('departemen','cuti.departemen','=','departemen.id')
                    ->where('cuti.id',$cuti->id)
                    ->select('karyawan.email as email','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first(); 
                $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                $atasan2 = NULL;
                if($karyawan->atasan_kedua !== NULL){
                    $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                }
                $tujuan = $karyawan->email;
                $data = [
                    'subject'     => 'Notifikasi Pembatalan Permohonan Ditolak ' . $ct->jenis_cuti . ' #' . $ct->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$cuti->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN PEMBATALAN FORMULIR CUTI KARYAWAN',
                    'subtitle' => '[ PENDING PIMPINAN ]',
                    'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $cuti->nik,
                    'jabatankaryawan' => $cuti->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $ct->jenis_cuti,
                    'keperluan'   => $ct->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($ct->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($ct->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $ct->jml_cuti,
                    'status'      => $ct->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' => Carbon::parse($ct->batal_atasan)->format("d/m/Y H:i"),
                    'tgldisetujuipimpinan' =>'-',
                    'tglditolak' => Carbon::parse($ct->batalditolak)->format('d/m/Y H:i'),
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }
                // return $data;
                Mail::to($tujuan)->send(new PembatalanNotification($data));
                return redirect()->back();
            }
            elseif($datacuti && $datacuti->atasan_pertama == Auth::user()->id_pegawai)
            {
                // return $datacuti;
                $status = Status::find(9);
                // return $status->id;
                Cuti::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'batalditolak' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $cuti = Cuti::where('id',$id)->first();

                 //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jeniscuti
                $ct = DB::table('cuti')
                ->join('jeniscuti','cuti.id_jeniscuti','=','jeniscuti.id')
                ->join('statuses','cuti.catatan','=','statuses.name_status')
                ->where('cuti.id',$id)
                ->select('cuti.*','jeniscuti.jenis_cuti as jenis_cuti','statuses.name_status')
                ->first();
                $alasan = Datareject::where('id_cuti',$cuti->id)->first();
                //sementara tidak digunakan
                $karyawan = DB::table('cuti')
                    ->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                    ->join('departemen','cuti.departemen','=','departemen.id')
                    ->where('cuti.id',$cuti->id)
                    ->select('karyawan.email as email','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first(); 
                $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                $atasan2 = NULL;

                if($karyawan->atasan_kedua !== NULL){
                    $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                }
                $tujuan = $atasan2->email;
                $data = [
                    'subject'     => 'Notifikasi Pembatalan Permohonan Ditolak ' . $ct->jenis_cuti . ' #' . $ct->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$cuti->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR CUTI KARYAWAN',
                    'subtitle' => '[ PERSETUJUAN PEMBATALAN ]',
                    'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $cuti->nik,
                    'jabatankaryawan' => $cuti->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $ct->jenis_cuti,
                    'keperluan'   => $ct->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($ct->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($ct->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $ct->jml_cuti,
                    'status'      => $ct->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' =>'-',
                    'tgldisetujuipimpinan' => '-',
                    'tglditolak' => Carbon::parse($ct->batalditolak)->format('d/m/Y H:i'),
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }
                // return $data;
                Mail::to($tujuan)->send(new PembatalanNotification($data));
                return redirect()->back();
                // return $data;
            }
            else{
                return redirect()->back();
            }
        }
        else if($datacuti && $role == 1 && $row->jabatan == "Manajer")
        {
            if($datacuti && $datacuti->atasan_kedua == Auth::user()->id_pegawai)
            {
                $status = Status::find(10);
                Cuti::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'batalditolak' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $cuti = Cuti::where('id',$id)->first();

                //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jeniscuti
                $ct = DB::table('cuti')
                    ->join('jeniscuti','cuti.id_jeniscuti','=','jeniscuti.id')
                    ->join('statuses','cuti.catatan','=','statuses.name_status')
                    ->where('cuti.id',$id)
                    ->select('cuti.*','jeniscuti.jenis_cuti as jenis_cuti','statuses.name_status')
                    ->first();
                $alasan = Datareject::where('id_cuti',$cuti->id)->first();
                //sementara tidak digunakan
                $karyawan = DB::table('cuti')
                    ->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                    ->join('departemen','cuti.departemen','=','departemen.id')
                    ->where('cuti.id',$cuti->id)
                    ->select('karyawan.email as email','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first(); 
                $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                $atasan2 = NULL;
                if($karyawan->atasan_kedua !== NULL){
                    $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                }
                $tujuan = $karyawan->email;
                $data = [
                    'subject'     => 'Notifikasi Pembatalan Permohonan Ditolak ' . $ct->jenis_cuti . ' #' . $ct->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$cuti->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN PEMBATALAN FORMULIR CUTI KARYAWAN',
                    'subtitle' => '[ PENDING PIMPINAN UNIT KERJA ]',
                    'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $cuti->nik,
                    'jabatankaryawan' => $cuti->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $ct->jenis_cuti,
                    'keperluan'   => $ct->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($ct->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($ct->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $ct->jml_cuti,
                    'status'      => $ct->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' => Carbon::parse($ct->batal_atasan)->format("d/m/Y H:i"),
                    'tgldisetujuipimpinan' =>'-',
                    'tglditolak' => Carbon::parse($ct->batalditolak)->format('d/m/Y H:i'),
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }
                // return $data;
                Mail::to($tujuan)->send(new PembatalanNotification($data));
                return redirect()->back();
            }
            elseif($datacuti && $datacuti->atasan_pertama == Auth::user()->id_pegawai)
            {
                // return $datacuti;
                $status = Status::find(9);
                // return $status->id;
                Cuti::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'batalditolak' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $cuti = Cuti::where('id',$id)->first();

                 //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jeniscuti
                $ct = DB::table('cuti')
                ->join('jeniscuti','cuti.id_jeniscuti','=','jeniscuti.id')
                ->join('statuses','cuti.catatan','=','statuses.name_status')
                ->where('cuti.id',$id)
                ->select('cuti.*','jeniscuti.jenis_cuti as jenis_cuti','statuses.name_status')
                ->first();
                $alasan = Datareject::where('id_cuti',$cuti->id)->first();
                //sementara tidak digunakan
                $karyawan = DB::table('cuti')
                    ->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                    ->join('departemen','cuti.departemen','=','departemen.id')
                    ->where('cuti.id',$cuti->id)
                    ->select('karyawan.email as email','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first(); 
                $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                $atasan2 = NULL;

                if($karyawan->atasan_kedua !== NULL){
                    $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                }
                $tujuan = $atasan2->email;
                $data = [
                    'subject'     => 'Notifikasi Pembatalan Permohonan Ditolak ' . $ct->jenis_cuti . ' #' . $ct->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$cuti->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR CUTI KARYAWAN',
                    'subtitle' => '[ PERSETUJUAN PEMBATALAN ]',
                    'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $cuti->nik,
                    'jabatankaryawan' => $cuti->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $ct->jenis_cuti,
                    'keperluan'   => $ct->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($ct->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($ct->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $ct->jml_cuti,
                    'status'      => $ct->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' =>'-',
                    'tgldisetujuipimpinan' => '-',
                    'tglditolak' => Carbon::parse($ct->batalditolak)->format('d/m/Y H:i'),
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }
                // return $data;
                Mail::to($tujuan)->send(new PembatalanNotification($data));
                return redirect()->back();
                // return $data;
            }
            else{
                return redirect()->back();
            }
        }
        else{
            return redirect()->back();
        }
    }

    public function ubahApprove(Request $request, $id)
    {
        $cutis = Cuti::where('id',$id)->first();
        $datacuti = Cuti::leftjoin('karyawan','cuti.id_karyawan','=','karyawan.id')
            ->where('cuti.id', '=',$cutis->id)
            ->select('karyawan.atasan_pertama','karyawan.atasan_kedua')
            ->first();

        // dd($datacuti,$datacut);
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;
        // return $row->jabatan;
        if($datacuti  && $role == 3 && $row->jabatan == "Asisten Manajer")
        {
                $status = Status::find(15);
                // return $status->name_status;
                Cuti::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'ubah_atasan' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $cuti = Cuti::where('id',$id)->first();
                 //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                $ct = DB::table('cuti')
                    ->join('jeniscuti','cuti.id_jeniscuti','=','jeniscuti.id')
                    ->join('statuses','cuti.catatan','statuses.name_status')
                    ->where('cuti.id',$id)
                    ->select('cuti.*','jeniscuti.jenis_cuti as jenis_cuti','statuses.name_status')
                    ->first();
                // return $ct;
                $alasan = Datareject::where('id_cuti',$cuti->id)->first();
                $karyawan = DB::table('cuti')
                    ->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                    ->join('departemen','cuti.departemen','=','departemen.id')
                    ->where('cuti.id',$cuti->id)
                    ->select('karyawan.email as email','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first(); 
                $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();

                if($karyawan->atasan_kedua == NULL){
                    $atasan2 = NULL;
                }
                $tujuan = $atasan2->email;
                $data = [
                    'subject'     => 'Notifikasi Approval Pertama Formulir Perubahan ' . $ct->jenis_cuti . ' #' . $ct->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$cuti->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR CUTI KARYAWAN',
                    'subtitle' => '[ PERSETUJUAN PERUBAHAN DATA ]',
                    'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $cuti->nik,
                    'jabatankaryawan' => $cuti->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $ct->jenis_cuti,
                    'keperluan'   => $ct->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($ct->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($ct->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $ct->jml_cuti,
                    'status'      => $ct->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' => Carbon::parse($ct->ubah_atasan)->format('d/m/Y H:i'),
                    'tgldisetujuipimpinan' => '-',
                    'tglditolak' => '-',
                    'atasan2' =>$atasan2->email,
                    'namaatasan2' => $atasan2->nama,
                ];
                // dd($data);
                Mail::to($tujuan)->send(new PerubahanNotification($data));
                // return $data;
            // }else{
                return redirect()->back();
            // }
        }
        elseif($datacuti && $role == 1 && $row->jabatan == "Asisten Manajer")
        {
                $status = Status::find(15);
                // return $status->name_status;
                Cuti::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'ubah_atasan' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $cuti = Cuti::where('id',$id)->first();
                 //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                $ct = DB::table('cuti')
                    ->join('jeniscuti','cuti.id_jeniscuti','=','jeniscuti.id')
                    ->join('statuses','cuti.catatan','statuses.name_status')
                    ->where('cuti.id',$id)
                    ->select('cuti.*','jeniscuti.jenis_cuti as jenis_cuti','statuses.name_status')
                    ->first();
                // return $ct;
                $alasan = Datareject::where('id_cuti',$cuti->id)->first();
                $karyawan = DB::table('cuti')
                    ->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                    ->join('departemen','cuti.departemen','=','departemen.id')
                    ->where('cuti.id',$cuti->id)
                    ->select('karyawan.email as email','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first(); 
                $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();

                if($karyawan->atasan_kedua == NULL){
                    $atasan2 = NULL;
                }
                $tujuan = $atasan2->email;
                $data = [
                    'subject'     => 'Notifikasi Approval Pertama Formulir Perubahan ' . $ct->jenis_cuti . ' #' . $ct->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$cuti->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR CUTI KARYAWAN',
                    'subtitle' => '[ PERSETUJUAN PERUBAHAN DATA ]',
                    'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $cuti->nik,
                    'jabatankaryawan' => $cuti->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $ct->jenis_cuti,
                    'keperluan'   => $ct->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($ct->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($ct->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $ct->jml_cuti,
                    'status'      => $ct->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' => Carbon::parse($ct->ubah_atasan)->format('d/m/Y H:i'),
                    'tgldisetujuipimpinan' => '-',
                    'tglditolak' => '-',
                    'atasan2' =>$atasan2->email,
                    'namaatasan2' => $atasan2->nama,
                ];
                // dd($data);
                Mail::to($tujuan)->send(new PerubahanNotification($data));
                // return $data;
            // }else{
                return redirect()->back();
            // }
        }
        elseif($datacuti && $role == 3 && $row->jabatan == "Manajer")
        {
            if($datacuti && $datacuti->atasan_kedua == Auth::user()->id_pegawai)
            {
                $status = Status::find(16);

                Cuti::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'ubah_pimpinan' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $cuti = Cuti::where('id',$id)->first();
                $jml_cuti = $cuti->sisacuti;

                $alokasicuti = Alokasicuti::where('id', $cuti->id_alokasi)
                    ->where('id_karyawan', $cuti->id_karyawan)
                    ->where('id_jeniscuti', $cuti->id_jeniscuti)
                    ->where('id_settingalokasi', $cuti->id_settingalokasi)
                    ->first();
        
                Alokasicuti::where('id', $alokasicuti->id)
                    ->update(
                        ['durasi' => $jml_cuti]
                    );

                $cekSisacuti = Sisacuti::join('cuti', 'cuti.id_jeniscuti', 'sisacuti.jenis_cuti')
                    ->join('alokasicuti', 'sisacuti.id_alokasi', 'alokasicuti.id')
                    ->where('cuti.id',$cuti->id)
                    ->where('cuti.id_alokasi',$cuti->id_alokasi)
                    ->where('sisacuti.id_alokasi',$cuti->id_alokasi)
                    ->where('sisacuti.id_pegawai',$cuti->id_karyawan)
                    ->exists();

                if($cekSisacuti)
                {
                    $sisacuti = Sisacuti::where('jenis_cuti', $cuti->id_jeniscuti)
                        ->where('id_pegawai', $cuti->id_karyawan)
                        ->first();

                    $sisacuti_baru = $sisacuti->sisacuti - $jml_cuti;

                    Sisacuti::where('id', $sisacuti->id)
                    ->update(
                        ['sisa_cuti' => $sisacuti_baru]
                    );

                    // dd($sisacuti);
                }
        
                // dd($alokasicuti,$jml_cuti,$al->durasi);
                //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jeniscuti
                $ct = DB::table('cuti')
                    ->join('jeniscuti','cuti.id_jeniscuti','=','jeniscuti.id')
                    ->join('statuses','cuti.catatan','statuses.name_status')
                    ->where('cuti.id',$id)
                    ->select('cuti.*','jeniscuti.jenis_cuti as jenis_cuti','statuses.name_status')
                    ->first();
                $alasan = Datareject::where('id_cuti',$cuti->id)->first();
                //sementara tidak digunakan
                $karyawan = DB::table('cuti')
                    ->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                    ->join('departemen','cuti.departemen','=','departemen.id')
                    ->where('cuti.id',$cuti->id)
                    ->select('karyawan.email as email','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first(); 
                $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                $atasan2 = NULL;
                if($karyawan->atasan_kedua !== NULL){
                    $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
                        ->select('email as email','nama as nama','jabatan')
                        ->first();
                }
                $tujuan = $karyawan->email;
                $data = [
                    'subject'     => 'Notifikasi Persetujuan Formulir ' . $ct->jenis_cuti . ' #' . $ct->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$cuti->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR CUTI KARYAWAN',
                    'subtitle' => '[ PERSETUJUAN PERUBAHAN DATA ]',
                    'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $cuti->nik,
                    'jabatankaryawan' => $cuti->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $ct->jenis_cuti,
                    'keperluan'   => $ct->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($ct->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($ct->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $ct->jml_cuti,
                    'status'      => $ct->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' =>Carbon::parse($ct->ubah_atasan)->format("d/m/Y H:i"),
                    'tgldisetujuipimpinan' => Carbon::parse($ct->ubah_pimpinan)->format("d/m/Y H:i"),
                    'tglditolak' =>'-',
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }
                // return $data;
                Mail::to($tujuan)->send(new PerubahanNotification($data));
                return redirect()->back();
            }
            elseif($datacuti && $datacuti->atasan_pertama == Auth::user()->id_pegawai)
            {
                // return $datacuti;
                $status = Status::find(15);
                // dd($status->id);
                Cuti::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'ubah_atasan' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $cuti = Cuti::where('id',$id)->first();

                 //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jeniscuti
                $ct = DB::table('cuti')
                    ->join('jeniscuti','cuti.id_jeniscuti','=','jeniscuti.id')
                    ->join('statuses','cuti.catatan','statuses.name_status')
                    ->where('cuti.id',$id)
                    ->select('cuti.*','jeniscuti.jenis_cuti as jenis_cuti','statuses.name_status')
                    ->first();
                $alasan = Datareject::where('id_cuti',$cuti->id)->first();
                //sementara tidak digunakan
                $karyawan = DB::table('cuti')
                    ->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                    ->join('departemen','cuti.departemen','=','departemen.id')
                    ->where('cuti.id',$cuti->id)
                    ->select('karyawan.email as email','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first(); 
                $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                $atasan2 = NULL;

                if($karyawan->atasan_kedua !== NULL){
                    $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                }
                $tujuan = $atasan2->email;
              
                $data = [
                    'subject'     => 'Notifikasi Approval Pertama Formulir Perubahan ' . $ct->jenis_cuti . ' #' . $ct->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$cuti->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR CUTI KARYAWAN',
                    'subtitle' => '[ PERSETUJUAN PERUBAHAN DATA ]',
                    'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $cuti->nik,
                    'jabatankaryawan' => $cuti->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $ct->jenis_cuti,
                    'keperluan'   => $ct->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($ct->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($ct->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $ct->jml_cuti,
                    'status'      => $ct->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' => Carbon::parse($ct->ubah_atasan)->format("d/m/Y H:i"),
                    'tgldisetujuipimpinan' => '-',
                    'tglditolak' => '-',
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }
                // return $data;
                Mail::to($tujuan)->send(new PerubahanNotification($data));
                return redirect()->back();
                // return $data;
            }
            else{
                return redirect()->back();
            }
        }
        elseif($datacuti && $role == 3 && $row->jabatan == "Direksi")
        {
            if($datacuti && $datacuti->atasan_kedua == Auth::user()->id_pegawai)
            {
                $status = Status::find(16);

                Cuti::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'ubah_pimpinan' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $cuti = Cuti::where('id',$id)->first();
                $jml_cuti = $cuti->sisacuti;

                $alokasicuti = Alokasicuti::where('id', $cuti->id_alokasi)
                    ->where('id_karyawan', $cuti->id_karyawan)
                    ->where('id_jeniscuti', $cuti->id_jeniscuti)
                    ->where('id_settingalokasi', $cuti->id_settingalokasi)
                    ->first();
        
                Alokasicuti::where('id', $alokasicuti->id)
                    ->update(
                        ['durasi' => $jml_cuti]
                    );

                $cekSisacuti = Sisacuti::join('cuti', 'cuti.id_jeniscuti', 'sisacuti.jenis_cuti')
                    ->join('alokasicuti', 'sisacuti.id_alokasi', 'alokasicuti.id')
                    ->where('cuti.id',$cuti->id)
                    ->where('cuti.id_alokasi',$cuti->id_alokasi)
                    ->where('sisacuti.id_alokasi',$cuti->id_alokasi)
                    ->where('sisacuti.id_pegawai',$cuti->id_karyawan)
                    ->exists();

                if($cekSisacuti)
                {
                    $sisacuti = Sisacuti::where('jenis_cuti', $cuti->id_jeniscuti)
                        ->where('id_pegawai', $cuti->id_karyawan)
                        ->first();

                    $sisacuti_baru = $sisacuti->sisacuti - $jml_cuti;

                    Sisacuti::where('id', $sisacuti->id)
                    ->update(
                        ['sisa_cuti' => $sisacuti_baru]
                    );

                    // dd($sisacuti);
                }
        
                // dd($alokasicuti,$jml_cuti,$al->durasi);
                //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jeniscuti
                $ct = DB::table('cuti')
                    ->join('jeniscuti','cuti.id_jeniscuti','=','jeniscuti.id')
                    ->join('statuses','cuti.catatan','statuses.name_status')
                    ->where('cuti.id',$id)
                    ->select('cuti.*','jeniscuti.jenis_cuti as jenis_cuti','statuses.name_status')
                    ->first();
                $alasan = Datareject::where('id_cuti',$cuti->id)->first();
                //sementara tidak digunakan
                $karyawan = DB::table('cuti')
                    ->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                    ->join('departemen','cuti.departemen','=','departemen.id')
                    ->where('cuti.id',$cuti->id)
                    ->select('karyawan.email as email','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first(); 
                $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                $atasan2 = NULL;
                if($karyawan->atasan_kedua !== NULL){
                    $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
                        ->select('email as email','nama as nama','jabatan')
                        ->first();
                }
                $tujuan = $karyawan->email;
                $data = [
                    'subject'     => 'Notifikasi Persetujuan Formulir ' . $ct->jenis_cuti . ' #' . $ct->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$cuti->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR CUTI KARYAWAN',
                    'subtitle' => '[ PERSETUJUAN PERUBAHAN DATA ]',
                    'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $cuti->nik,
                    'jabatankaryawan' => $cuti->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $ct->jenis_cuti,
                    'keperluan'   => $ct->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($ct->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($ct->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $ct->jml_cuti,
                    'status'      => $ct->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' =>Carbon::parse($ct->ubah_atasan)->format("d/m/Y H:i"),
                    'tgldisetujuipimpinan' => Carbon::parse($ct->ubah_pimpinan)->format("d/m/Y H:i"),
                    'tglditolak' =>'-',
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }
                // return $data;
                Mail::to($tujuan)->send(new PerubahanNotification($data));
                return redirect()->back();
            }
            elseif($datacuti && $datacuti->atasan_pertama == Auth::user()->id_pegawai)
            {
                // return $datacuti;
                $status = Status::find(15);
                // dd($status->id);
                Cuti::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'ubah_atasan' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $cuti = Cuti::where('id',$id)->first();

                 //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jeniscuti
                $ct = DB::table('cuti')
                    ->join('jeniscuti','cuti.id_jeniscuti','=','jeniscuti.id')
                    ->join('statuses','cuti.catatan','statuses.name_status')
                    ->where('cuti.id',$id)
                    ->select('cuti.*','jeniscuti.jenis_cuti as jenis_cuti','statuses.name_status')
                    ->first();
                $alasan = Datareject::where('id_cuti',$cuti->id)->first();
                //sementara tidak digunakan
                $karyawan = DB::table('cuti')
                    ->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                    ->join('departemen','cuti.departemen','=','departemen.id')
                    ->where('cuti.id',$cuti->id)
                    ->select('karyawan.email as email','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first(); 
                $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                $atasan2 = NULL;

                if($karyawan->atasan_kedua !== NULL){
                    $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                }
                $tujuan = $atasan2->email;
              
                $data = [
                    'subject'     => 'Notifikasi Approval Pertama Formulir Perubahan ' . $ct->jenis_cuti . ' #' . $ct->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$cuti->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR CUTI KARYAWAN',
                    'subtitle' => '[ PERSETUJUAN PERUBAHAN DATA ]',
                    'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $cuti->nik,
                    'jabatankaryawan' => $cuti->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $ct->jenis_cuti,
                    'keperluan'   => $ct->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($ct->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($ct->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $ct->jml_cuti,
                    'status'      => $ct->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' => Carbon::parse($ct->ubah_atasan)->format("d/m/Y H:i"),
                    'tgldisetujuipimpinan' => '-',
                    'tglditolak' => '-',
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }
                // return $data;
                Mail::to($tujuan)->send(new PerubahanNotification($data));
                return redirect()->back();
                // return $data;
            }
            else{
                return redirect()->back();
            }
        }
        elseif($datacuti && $role == 1 && $row->jabatan == "Manajer")
        {
            if($datacuti && $datacuti->atasan_kedua == Auth::user()->id_pegawai)
            {
                $status = Status::find(16);
               
                Cuti::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'ubah_pimpinan' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $cuti = Cuti::where('id',$id)->first();
                $jml_cuti = $cuti->sisacuti;

                $alokasicuti = Alokasicuti::where('id', $cuti->id_alokasi)
                    ->where('id_karyawan', $cuti->id_karyawan)
                    ->where('id_jeniscuti', $cuti->id_jeniscuti)
                    ->where('id_settingalokasi', $cuti->id_settingalokasi)
                    ->first();
        
                Alokasicuti::where('id', $alokasicuti->id)
                    ->update(
                        ['durasi' => $jml_cuti]
                    );

                $cekSisacuti = Sisacuti::join('cuti', 'cuti.id_jeniscuti', 'sisacuti.jenis_cuti')
                    ->join('alokasicuti', 'sisacuti.id_alokasi', 'alokasicuti.id')
                    ->where('cuti.id',$cuti->id)
                    ->where('cuti.id_alokasi',$cuti->id_alokasi)
                    ->where('sisacuti.id_alokasi',$cuti->id_alokasi)
                    ->where('sisacuti.id_pegawai',$cuti->id_karyawan)
                    ->exists();

                if($cekSisacuti)
                {
                    $sisacuti = Sisacuti::where('jenis_cuti', $cuti->id_jeniscuti)
                        ->where('id_pegawai', $cuti->id_karyawan)
                        ->first();

                    $sisacuti_baru = $sisacuti->sisacuti - $jml_cuti;

                    Sisacuti::where('id', $sisacuti->id)
                    ->update(
                        ['sisa_cuti' => $sisacuti_baru]
                    );

                    // dd($sisacuti);
                }
        
                // dd($alokasicuti,$jml_cuti);

                //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jeniscuti
                $ct = DB::table('cuti')
                    ->join('jeniscuti','cuti.id_jeniscuti','=','jeniscuti.id')
                    ->join('statuses','cuti.catatan','statuses.name_status')
                    ->where('cuti.id',$id)
                    ->select('cuti.*','jeniscuti.jenis_cuti as jenis_cuti','statuses.name_status')
                    ->first();
                $alasan = Datareject::where('id_cuti',$cuti->id)->first();
                //sementara tidak digunakan
                $karyawan = DB::table('cuti')
                    ->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                    ->join('departemen','cuti.departemen','=','departemen.id')
                    ->where('cuti.id',$cuti->id)
                    ->select('karyawan.email as email','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first(); 
                $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                $atasan2 = NULL;
                if($karyawan->atasan_kedua !== NULL){
                    $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
                        ->select('email as email','nama as nama','jabatan')
                        ->first();
                }
                $tujuan = $karyawan->email;
                $data = [
                    'subject'     => 'Notifikasi Persetujuan Formulir ' . $ct->jenis_cuti . ' #' . $ct->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$cuti->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR CUTI KARYAWAN',
                    'subtitle' => '[ PERSETUJUAN PERUBAHAN DATA ]',
                    'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $cuti->nik,
                    'jabatankaryawan' => $cuti->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $ct->jenis_cuti,
                    'keperluan'   => $ct->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($ct->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($ct->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $ct->jml_cuti,
                    'status'      => $ct->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' =>Carbon::parse($ct->ubah_atasan)->format("d/m/Y H:i"),
                    'tgldisetujuipimpinan' => Carbon::parse($ct->ubah_pimpinan)->format("d/m/Y H:i"),
                    'tglditolak' =>'-',
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }
                // return $data;
                Mail::to($tujuan)->send(new PerubahanNotification($data));
                return redirect()->back();
            }
            elseif($datacuti && $datacuti->atasan_pertama == Auth::user()->id_pegawai)
            {
                // return $datacuti;
                $status = Status::find(15);
                // return $status->id;
                Cuti::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'ubah_atasan' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $cuti = Cuti::where('id',$id)->first();
                
                 //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jeniscuti
                $ct = DB::table('cuti')
                ->join('jeniscuti','cuti.id_jeniscuti','=','jeniscuti.id')
                ->join('statuses','cuti.catatan','statuses.name_status')
                ->where('cuti.id',$id)
                ->select('cuti.*','jeniscuti.jenis_cuti as jenis_cuti','statuses.name_status')
                ->first();
                $alasan = Datareject::where('id_cuti',$cuti->id)->first();
                //sementara tidak digunakan
                $karyawan = DB::table('cuti')
                    ->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                    ->join('departemen','cuti.departemen','=','departemen.id')
                    ->where('cuti.id',$cuti->id)
                    ->select('karyawan.email as email','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first(); 
                $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                $atasan2 = NULL;

                if($karyawan->atasan_kedua !== NULL){
                    $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                }
                $tujuan = $atasan2->email;
                $data = [
                    'subject'     => 'Notifikasi Approval Pertama Formulir Perubahan ' . $ct->jenis_cuti . ' #' . $ct->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$cuti->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR CUTI KARYAWAN',
                    'subtitle' => '[ PERSETUJUAN PERUBAHAN DATA ]',
                    'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $cuti->nik,
                    'jabatankaryawan' => $cuti->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $ct->jenis_cuti,
                    'keperluan'   => $ct->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($ct->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($ct->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $ct->jml_cuti,
                    'status'      => $ct->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' => Carbon::parse($ct->ubah_atasan)->format("d/m/Y H:i"),
                    'tgldisetujuipimpinan' => '-',
                    'tglditolak' => '-',
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }
                // return $data;
                Mail::to($tujuan)->send(new PerubahanNotification($data));
                return redirect()->back();
                // return $data;
            }
            else{
                return redirect()->back();
            }
        }
        else{
            return redirect()->back();
        }
    }

    public function ubahRejected(Request $request, $id)
    {
        $cutis = Cuti::where('id',$id)->first();
        $datacuti = Cuti::leftjoin('karyawan','cuti.id_karyawan','=','karyawan.id')
            ->where('cuti.id', '=',$cutis->id)
            ->select('karyawan.atasan_pertama','karyawan.atasan_kedua')
            ->first();

        // dd($datacuti,$datacut);
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;
        // return $row->jabatan;
        if($datacuti  && $role == 3 && $row->jabatan == "Asisten Manajer")
        {
                $status = Status::find(9);
                // return $status->name_status;
                Cuti::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'ubahditolak' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $cuti = Cuti::where('id',$id)->first();
                 //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                $ct = DB::table('cuti')
                    ->join('jeniscuti','cuti.id_jeniscuti','=','jeniscuti.id')
                    ->join('statuses','cuti.catatan','statuses.name_status')
                    ->where('cuti.id',$id)
                    ->select('cuti.*','jeniscuti.jenis_cuti as jenis_cuti','statuses.name_status')
                    ->first();
                $alasan = Datareject::where('id_cuti',$cuti->id)->first();
                $karyawan = DB::table('cuti')
                    ->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                    ->join('departemen','cuti.departemen','=','departemen.id')
                    ->where('cuti.id',$cuti->id)
                    ->select('karyawan.email as email','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first(); 
                $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                $atasan2 = NULL;

                if($karyawan->atasan_kedua !== NULL){
                    $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                }
                $tujuan = $atasan2->email;
                $data = [
                    'subject'     => 'Notifikasi Perubahan Permohonan Ditolak ' . $ct->jenis_cuti . ' #' . $ct->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$cuti->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN PERUBAHAN DATA FORMULIR CUTI KARYAWAN',
                    'subtitle' => '[ PENDING ATASAN ]',
                    'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $cuti->nik,
                    'jabatankaryawan' => $cuti->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $ct->jenis_cuti,
                    'keperluan'   => $ct->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($ct->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($ct->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $ct->jml_cuti,
                    'status'      => $ct->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' =>'-',
                    'tgldisetujuipimpinan' => '-',
                    'tglditolak' => Carbon::parse($ct->ubahditolak)->format("d/m/Y H:i"),
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }
                // dd($data);
                Mail::to($tujuan)->send(new PerubahanNotification($data));
                // return $data;
            // }else{
                return redirect()->back();
            // }
        }
        else if($datacuti && $role == 1 && $row->jabatan == "Asisten Manajer")
        {
                $status = Status::find(9);
                // return $status->name_status;
                Cuti::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'ubahditolak' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $cuti = Cuti::where('id',$id)->first();
                 //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                $ct = DB::table('cuti')
                    ->join('jeniscuti','cuti.id_jeniscuti','=','jeniscuti.id')
                    ->join('statuses','cuti.catatan','statuses.name_status')
                    ->where('cuti.id',$id)
                    ->select('cuti.*','jeniscuti.jenis_cuti as jenis_cuti','statuses.name_status')
                    ->first();
                $alasan = Datareject::where('id_cuti',$cuti->id)->first();
                $karyawan = DB::table('cuti')
                    ->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                    ->join('departemen','cuti.departemen','=','departemen.id')
                    ->where('cuti.id',$cuti->id)
                    ->select('karyawan.email as email','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first(); 
                $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                $atasan2 = NULL;

                if($karyawan->atasan_kedua !== NULL){
                    $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                }
                $tujuan = $atasan2->email;
                $data = [
                    'subject'     => 'Notifikasi Perubahan Permohonan Ditolak ' . $ct->jenis_cuti . ' #' . $ct->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$cuti->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN PERUBAHAN DATA FORMULIR CUTI KARYAWAN',
                    'subtitle' => '[ PENDING ATASAN ]',
                    'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $cuti->nik,
                    'jabatankaryawan' => $cuti->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $ct->jenis_cuti,
                    'keperluan'   => $ct->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($ct->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($ct->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $ct->jml_cuti,
                    'status'      => $ct->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' =>'-',
                    'tgldisetujuipimpinan' => '-',
                    'tglditolak' => Carbon::parse($ct->ubahditolak)->format("d/m/Y H:i"),
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }
                // dd($data);
                Mail::to($tujuan)->send(new PerubahanNotification($data));
                // return $data;
            // }else{
                return redirect()->back();
            // }
        }
        else if($datacuti && $role == 3 && $row->jabatan == "Manajer")
        {
            if($datacuti && $datacuti->atasan_kedua == Auth::user()->id_pegawai)
            {
                $status = Status::find(10);
                Cuti::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'ubahditolak' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $cuti = Cuti::where('id',$id)->first();

                //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jeniscuti
                $ct = DB::table('cuti')
                    ->join('jeniscuti','cuti.id_jeniscuti','=','jeniscuti.id')
                    ->join('statuses','cuti.catatan','statuses.name_status')
                    ->where('cuti.id',$id)
                    ->select('cuti.*','jeniscuti.jenis_cuti as jenis_cuti','statuses.name_status')
                    ->first();
                //sementara tidak digunakan
                $karyawan = DB::table('cuti')
                    ->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                    ->join('departemen','cuti.departemen','=','departemen.id')
                    ->where('cuti.id',$cuti->id)
                    ->select('karyawan.email as email','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first(); 
                $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                $atasan2 = NULL;
                if($karyawan->atasan_kedua !== NULL){
                    $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                }
                $tujuan = $karyawan->email;
                $data = [
                    'subject'     => 'Notifikasi Pembatalan Permohonan Ditolak ' . $ct->jenis_cuti . ' #' . $ct->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$cuti->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN PERUBAHAN DATA FORMULIR CUTI KARYAWAN',
                    'subtitle' => '[ PENDING PIMPINAN UNIT KERJA ]',
                    'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $cuti->nik,
                    'jabatankaryawan' => $cuti->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $ct->jenis_cuti,
                    'keperluan'   => $ct->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($ct->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($ct->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $ct->jml_cuti,
                    'status'      => $ct->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' => Carbon::parse($ct->ubah_atasan)->format("d/m/Y H:i"),
                    'tgldisetujuipimpinan' =>'-',
                    'tglditolak' => Carbon::parse($ct->ubahditolak)->format("d/m/Y H:i"),
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }
                // return $data;
                Mail::to($tujuan)->send(new PerubahanNotification($data));
                return redirect()->back();
            }
            elseif($datacuti && $datacuti->atasan_pertama == Auth::user()->id_pegawai)
            {
                // return $datacuti;
                $status = Status::find(9);
                // return $status->id;
                Cuti::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'ubahditolak' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $cuti = Cuti::where('id',$id)->first();

                 //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jeniscuti
                $ct = DB::table('cuti')
                ->join('jeniscuti','cuti.id_jeniscuti','=','jeniscuti.id')
                ->join('statuses','cuti.catatan','statuses.name_status')
                ->where('cuti.id',$id)
                ->select('cuti.*','jeniscuti.jenis_cuti as jenis_cuti','statuses.name_status')
                ->first();
                $alasan = Datareject::where('id_cuti',$cuti->id)->first();
                //sementara tidak digunakan
                $karyawan = DB::table('cuti')
                    ->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                    ->join('departemen','cuti.departemen','=','departemen.id')
                    ->where('cuti.id',$cuti->id)
                    ->select('karyawan.email as email','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first(); 
                $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                $atasan2 = NULL;

                if($karyawan->atasan_kedua !== NULL){
                    $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                }
                $tujuan = $atasan2->email;
                $data = [
                    'subject'     => 'Notifikasi Pembatalan Permohonan Ditolak ' . $ct->jenis_cuti . ' #' . $ct->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$cuti->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR CUTI KARYAWAN',
                    'subtitle' => '[ PERSETUJUAN PEMBATALAN ]',
                    'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $cuti->nik,
                    'jabatankaryawan' => $cuti->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $ct->jenis_cuti,
                    'keperluan'   => $ct->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($ct->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($ct->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $ct->jml_cuti,
                    'status'      => $ct->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' =>'-',
                    'tgldisetujuipimpinan' => '-',
                    'tglditolak' => Carbon::parse($ct->ubahditolak)->format('d/m/Y H:i'),
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }
                // return $data;
                Mail::to($tujuan)->send(new PerubahanNotification($data));
                return redirect()->back();
                // return $data;
            }
            else{
                return redirect()->back();
            }
        }
        else if($datacuti && $role == 3 && $row->jabatan == "Direksi")
        {
            // dd("hai direksi");
            if($datacuti && $datacuti->atasan_kedua == Auth::user()->id_pegawai)
            {
                $status = Status::find(10);
                Cuti::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'ubahditolak' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $cuti = Cuti::where('id',$id)->first();

                //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jeniscuti
                $ct = DB::table('cuti')
                    ->join('jeniscuti','cuti.id_jeniscuti','=','jeniscuti.id')
                    ->join('statuses','cuti.catatan','statuses.name_status')
                    ->where('cuti.id',$id)
                    ->select('cuti.*','jeniscuti.jenis_cuti as jenis_cuti','statuses.name_status')
                    ->first();
                //sementara tidak digunakan
                $karyawan = DB::table('cuti')
                    ->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                    ->join('departemen','cuti.departemen','=','departemen.id')
                    ->where('cuti.id',$cuti->id)
                    ->select('karyawan.email as email','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first(); 
                $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                $atasan2 = NULL;
                if($karyawan->atasan_kedua !== NULL){
                    $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                }
                $tujuan = $karyawan->email;
                $data = [
                    'subject'     => 'Notifikasi Pembatalan Permohonan Ditolak ' . $ct->jenis_cuti . ' #' . $ct->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$cuti->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN PERUBAHAN DATA FORMULIR CUTI KARYAWAN',
                    'subtitle' => '[ PENDING PIMPINAN ]',
                    'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $cuti->nik,
                    'jabatankaryawan' => $cuti->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $ct->jenis_cuti,
                    'keperluan'   => $ct->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($ct->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($ct->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $ct->jml_cuti,
                    'status'      => $ct->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' => Carbon::parse($ct->ubah_atasan)->format("d/m/Y H:i"),
                    'tgldisetujuipimpinan' =>'-',
                    'tglditolak' => Carbon::parse($ct->ubahditolak)->format("d/m/Y H:i"),
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }
                // return $data;
                Mail::to($tujuan)->send(new PerubahanNotification($data));
                return redirect()->back();
            }
            elseif($datacuti && $datacuti->atasan_pertama == Auth::user()->id_pegawai)
            {
                // return $datacuti;
                $status = Status::find(9);
                // return $status->id;
                Cuti::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'ubahditolak' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $cuti = Cuti::where('id',$id)->first();

                 //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jeniscuti
                $ct = DB::table('cuti')
                ->join('jeniscuti','cuti.id_jeniscuti','=','jeniscuti.id')
                ->join('statuses','cuti.catatan','statuses.name_status')
                ->where('cuti.id',$id)
                ->select('cuti.*','jeniscuti.jenis_cuti as jenis_cuti','statuses.name_status')
                ->first();
                $alasan = Datareject::where('id_cuti',$cuti->id)->first();
                //sementara tidak digunakan
                $karyawan = DB::table('cuti')
                    ->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                    ->join('departemen','cuti.departemen','=','departemen.id')
                    ->where('cuti.id',$cuti->id)
                    ->select('karyawan.email as email','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first(); 
                $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                $atasan2 = NULL;

                if($karyawan->atasan_kedua !== NULL){
                    $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                }
                $tujuan = $atasan2->email;
                $data = [
                    'subject'     => 'Notifikasi Pembatalan Permohonan Ditolak ' . $ct->jenis_cuti . ' #' . $ct->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$cuti->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR CUTI KARYAWAN',
                    'subtitle' => '[ PERSETUJUAN PEMBATALAN ]',
                    'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $cuti->nik,
                    'jabatankaryawan' => $cuti->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $ct->jenis_cuti,
                    'keperluan'   => $ct->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($ct->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($ct->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $ct->jml_cuti,
                    'status'      => $ct->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' =>'-',
                    'tgldisetujuipimpinan' => '-',
                    'tglditolak' => Carbon::parse($ct->ubahditolak)->format('d/m/Y H:i'),
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }
                // return $data;
                Mail::to($tujuan)->send(new PerubahanNotification($data));
                return redirect()->back();
                // return $data;
            }
            else{
                return redirect()->back();
            }
        }
        else if($datacuti && $role == 1 && $row->jabatan == "Manajer")
        {
            if($datacuti && $datacuti->atasan_kedua == Auth::user()->id_pegawai)
            {
                $status = Status::find(10);
                Cuti::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'ubahditolak' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $cuti = Cuti::where('id',$id)->first();

                //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jeniscuti
                $ct = DB::table('cuti')
                    ->join('jeniscuti','cuti.id_jeniscuti','=','jeniscuti.id')
                    ->join('statuses','cuti.catatan','statuses.name_status')
                    ->where('cuti.id',$id)
                    ->select('cuti.*','jeniscuti.jenis_cuti as jenis_cuti','statuses.name_status')
                    ->first();
                //sementara tidak digunakan
                $karyawan = DB::table('cuti')
                    ->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                    ->join('departemen','cuti.departemen','=','departemen.id')
                    ->where('cuti.id',$cuti->id)
                    ->select('karyawan.email as email','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first(); 
                $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                $atasan2 = NULL;
                if($karyawan->atasan_kedua !== NULL){
                    $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                }
                $tujuan = $karyawan->email;
                $data = [
                    'subject'     => 'Notifikasi Pembatalan Permohonan Ditolak ' . $ct->jenis_cuti . ' #' . $ct->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$cuti->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN PERUBAHAN DATA FORMULIR CUTI KARYAWAN',
                    'subtitle' => '[ PENDING PIMPINAN UNIT KERJA ]',
                    'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $cuti->nik,
                    'jabatankaryawan' => $cuti->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $ct->jenis_cuti,
                    'keperluan'   => $ct->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($ct->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($ct->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $ct->jml_cuti,
                    'status'      => $ct->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' => Carbon::parse($ct->ubah_atasan)->format("d/m/Y H:i"),
                    'tgldisetujuipimpinan' =>'-',
                    'tglditolak' => Carbon::parse($ct->ubahditolak)->format("d/m/Y H:i"),
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }
                // return $data;
                Mail::to($tujuan)->send(new PerubahanNotification($data));
                return redirect()->back();
            }
            elseif($datacuti && $datacuti->atasan_pertama == Auth::user()->id_pegawai)
            {
                // return $datacuti;
                $status = Status::find(9);
                // return $status->id;
                Cuti::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'ubahditolak' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $cuti = Cuti::where('id',$id)->first();

                 //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jeniscuti
                $ct = DB::table('cuti')
                ->join('jeniscuti','cuti.id_jeniscuti','=','jeniscuti.id')
                ->join('statuses','cuti.catatan','statuses.name_status')
                ->where('cuti.id',$id)
                ->select('cuti.*','jeniscuti.jenis_cuti as jenis_cuti','statuses.name_status')
                ->first();
                $alasan = Datareject::where('id_cuti',$cuti->id)->first();
                //sementara tidak digunakan
                $karyawan = DB::table('cuti')
                    ->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                    ->join('departemen','cuti.departemen','=','departemen.id')
                    ->where('cuti.id',$cuti->id)
                    ->select('karyawan.email as email','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first(); 
                $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                $atasan2 = NULL;

                if($karyawan->atasan_kedua !== NULL){
                    $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                }
                $tujuan = $atasan2->email;
                $data = [
                    'subject'     => 'Notifikasi Pembatalan Permohonan Ditolak ' . $ct->jenis_cuti . ' #' . $ct->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$cuti->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR CUTI KARYAWAN',
                    'subtitle' => '[ PERSETUJUAN PEMBATALAN ]',
                    'tgl_permohonan' =>Carbon::parse($cuti->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $cuti->nik,
                    'jabatankaryawan' => $cuti->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $ct->jenis_cuti,
                    'keperluan'   => $ct->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($ct->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($ct->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $ct->jml_cuti,
                    'status'      => $ct->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' =>'-',
                    'tgldisetujuipimpinan' => '-',
                    'tglditolak' => Carbon::parse($ct->batalditolak)->format('d/m/Y H:i'),
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }
                // return $data;
                Mail::to($tujuan)->send(new PerubahanNotification($data));
                return redirect()->back();
                // return $data;
            }
            else{
                return redirect()->back();
            }
        }
        else{
            return redirect()->back();
        }
    }
}

