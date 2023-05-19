<?php

namespace App\Http\Controllers\manager;

use Carbon\Carbon;
use App\Models\Izin;
use App\Models\Status;
use App\Models\Karyawan;
use App\Models\Datareject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\PerubahanNotification;
use App\Http\Controllers\Controller;
use App\Mail\PembatalanNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PembatalanIzinController extends Controller
{
    public function batalApprove(Request $request, $id)
    {
        $izins = Izin::where('id',$id)->first();
        $dataizin = Izin::leftjoin('karyawan','izin.id_karyawan','=','karyawan.id')
            ->where('izin.id', '=',$izins->id)
            ->select('karyawan.atasan_pertama','karyawan.atasan_kedua')
            ->first();

        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;
        // return $row->jabatan;
        if($dataizin && $role == 3 && $row->jabatan == "Asistant Manager")
        {
                $status = Status::find(12);
                // return $status->name_status;
                Izin::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'batal_atasan' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $izin = Izin::where('id',$id)->first();
                 //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                $iz = DB::table('izin')
                    ->join('jenisizin','izin.id_jenisizin','=','jenisizin.id')
                    ->join('statuses','izin.catatan','=','statuses.name_status')
                    ->where('izin.id',$id)
                    ->select('izin.*','jenisizin.jenis_izin as jenis_izin','statuses.name_status')
                    ->first();
                $karyawan = DB::table('izin')
                    ->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->join('departemen','izin.departemen','=','departemen.id')
                    ->where('izin.id',$izin->id)
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
                // return $tujuan;
                $data = [
                    'subject'     => 'Notifikasi Approval Pertama Formulir Pembatalan ' . $iz->jenis_izin . ' #' . $iz->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$izin->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR IZIN KARYAWAN',
                    'subtitle' => '[ PERSETUJUAN PEMBATALAN ]',
                    'tgl_permohonan' =>Carbon::parse($izin->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $izin->nik,
                    'jabatankaryawan' => $izin->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $iz->jenis_izin,
                    'keperluan'   => $iz->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($iz->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($iz->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $iz->jml_hari,
                    'status'      => $iz->name_status,
                    'alasan'      =>null,
                    'tgldisetujuiatasan' => Carbon::parse($iz->batal_atasan)->format('d/m/Y H:i'),
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
        elseif($dataizin && $role == 1 && $row->jabatan == "Asistant Manager")
        {
                $status = Status::find(12);
                // return $status->name_status;
                Izin::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'batal_atasan' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $izin = Izin::where('id',$id)->first();
                 //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                $iz = DB::table('izin')
                    ->join('jenisizin','izin.id_jenisizin','=','jenisizin.id')
                    ->join('statuses','izin.catatan','=','statuses.name_status')
                    ->where('izin.id',$id)
                    ->select('izin.*','jenisizin.jenis_izin as jenis_izin','statuses.name_status')
                    ->first();
                $karyawan = DB::table('izin')
                    ->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->join('departemen','izin.departemen','=','departemen.id')
                    ->where('izin.id',$izin->id)
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
                // return $tujuan;
                $data = [
                    'subject'     => 'Notifikasi Approval Pertama Formulir Pembatalan ' . $iz->jenis_izin . ' #' . $iz->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$izin->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR IZIN KARYAWAN',
                    'subtitle' => '[ PERSETUJUAN PEMBATALAN ]',
                    'tgl_permohonan' =>Carbon::parse($izin->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $izin->nik,
                    'jabatankaryawan' => $izin->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $iz->jenis_izin,
                    'keperluan'   => $iz->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($iz->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($iz->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $iz->jml_hari,
                    'status'      => $iz->name_status,
                    'alasan'      =>null,
                    'tgldisetujuiatasan' => Carbon::parse($iz->batal_atasan)->format('d/m/Y H:i'),
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
        elseif($dataizin && $role == 3 && $row->jabatan == "Manager")
        {
            if($dataizin && $dataizin->atasan_kedua == Auth::user()->id_pegawai)
            {
                $status = Status::find(13);
                Izin::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'batal_pimpinan' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $izin = Izin::where('id',$id)->first();
        
                //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jenisizin
                $iz = DB::table('izin')
                    ->join('jenisizin','izin.id_jenisizin','=','jenisizin.id')
                    ->join('statuses','izin.catatan','=','statuses.name_status')
                    ->where('izin.id',$id)
                    ->select('izin.*','jenisizin.jenis_izin as jenis_izin','statuses.name_status')
                    ->first();

                $karyawan = DB::table('izin')
                    ->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->join('departemen','izin.departemen','=','departemen.id')
                    ->where('izin.id',$izin->id)
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
                    'subject'     => 'Notifikasi Persetujuan Formulir Pembatalan ' . $iz->jenis_izin . ' #' . $iz->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$izin->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR IZIN KARYAWAN',
                    'subtitle' => '[ PERSETUJUAN PEMBATALAN ]',
                    'tgl_permohonan' =>Carbon::parse($izin->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $izin->nik,
                    'jabatankaryawan' => $izin->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $iz->jenis_izin,
                    'keperluan'   => $iz->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($iz->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($iz->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $iz->jml_hari,
                    'status'      => $iz->name_status,
                    'alasan'      =>null,
                    'tgldisetujuiatasan' => Carbon::parse($iz->batal_atasan)->format("d/m/Y H:i"),
                    'tgldisetujuipimpinan' => Carbon::parse($iz->batal_pimpinan)->format("d/m/Y H:i"),
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
            elseif($dataizin && $dataizin->atasan_pertama == Auth::user()->id_pegawai)
            {
                // return $dataizin;
                $status = Status::find(12);
                // return $status->id;
                Izin::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'batal_atasan' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $izin = Izin::where('id',$id)->first();

                 //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jenisizin
                $iz = DB::table('izin')
                ->join('jenisizin','izin.id_jenisizin','=','jenisizin.id')
                ->join('statuses','izin.catatan','=','statuses.name_status')
                ->where('izin.id',$id)
                ->select('izin.*','jenisizin.jenis_izin as jenis_izin','statuses.name_status')
                ->first();
                $alasan = Datareject::where('id_cuti',$izin->id)->first();
                //sementara tidak digunakan
                $karyawan = DB::table('izin')
                    ->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->join('departemen','izin.departemen','=','departemen.id')
                    ->where('izin.id',$izin->id)
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
                    'subject'     => 'Notifikasi Approval Pertama Formulir Pembatalan ' . $iz->jenis_izin . ' #' . $iz->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$izin->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR IZIN KARYAWAN',
                    'subtitle' => '[ PERSETUJUAN PEMBATALAN ]',
                    'tgl_permohonan' =>Carbon::parse($izin->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $izin->nik,
                    'jabatankaryawan' => $izin->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $iz->jenis_izin,
                    'keperluan'   => $iz->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($iz->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($iz->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $iz->jml_hari,
                    'status'      => $iz->name_status,
                    'alasan'      =>null,
                    'tgldisetujuiatasan' => Carbon::parse($iz->batal_atasan)->format('d/m/Y H:i'),
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
        elseif($dataizin && $role == 1 && $row->jabatan == "Manager")
        {
            if($dataizin->atasan_kedua == Auth::user()->id_pegawai)
            {
                // return $row->jabatan;
                $status = Status::find(13);
                Izin::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'batal_pimpinan' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $izin = Izin::where('id',$id)->first();
        
                //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jenisizin
                $iz = DB::table('izin')
                    ->join('jenisizin','izin.id_jenisizin','=','jenisizin.id')
                    ->join('statuses','izin.catatan','=','statuses.name_status')
                    ->where('izin.id',$id)
                    ->select('izin.*','jenisizin.jenis_izin as jenis_izin','statuses.name_status')
                    ->first();

                $karyawan = DB::table('izin')
                    ->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->join('departemen','izin.departemen','=','departemen.id')
                    ->where('izin.id',$izin->id)
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
                    'subject'     => 'Notifikasi Persetujuan Formulir Pembatalan ' . $iz->jenis_izin . ' #' . $iz->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$izin->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR IZIN KARYAWAN',
                    'subtitle' => '[ PERSETUJUAN PEMBATALAN ]',
                    'tgl_permohonan' =>Carbon::parse($izin->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $izin->nik,
                    'jabatankaryawan' => $izin->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $iz->jenis_izin,
                    'keperluan'   => $iz->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($iz->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($iz->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $iz->jml_hari,
                    'status'      => $iz->name_status,
                    'alasan'      =>null,
                    'tgldisetujuiatasan' => Carbon::parse($iz->batal_atasan)->format("d/m/Y H:i"),
                    'tgldisetujuipimpinan' => Carbon::parse($iz->batal_pimpinan)->format("d/m/Y H:i"),
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
            elseif($dataizin && $dataizin->atasan_pertama == Auth::user()->id_pegawai)
            {
                // return $dataizin;
                $status = Status::find(12);
                // return $status->id;
                Izin::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'batal_atasan' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $izin = Izin::where('id',$id)->first();

                 //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jenisizin
                $iz = DB::table('izin')
                ->join('jenisizin','izin.id_jenisizin','=','jenisizin.id')
                ->join('statuses','izin.catatan','=','statuses.name_status')
                ->where('izin.id',$id)
                ->select('izin.*','jenisizin.jenis_izin as jenis_izin','statuses.name_status')
                ->first();
                $alasan = Datareject::where('id_cuti',$izin->id)->first();
                //sementara tidak digunakan
                $karyawan = DB::table('izin')
                    ->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->join('departemen','izin.departemen','=','departemen.id')
                    ->where('izin.id',$izin->id)
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
                    'subject'     => 'Notifikasi Approval Pertama Formulir Pembatalan ' . $iz->jenis_izin . ' #' . $iz->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$izin->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR IZIN KARYAWAN',
                    'subtitle' => '[ PERSETUJUAN PEMBATALAN ]',
                    'tgl_permohonan' =>Carbon::parse($izin->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $izin->nik,
                    'jabatankaryawan' => $izin->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $iz->jenis_izin,
                    'keperluan'   => $iz->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($iz->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($iz->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $iz->jml_hari,
                    'status'      => $iz->name_status,
                    'alasan'      =>null,
                    'tgldisetujuiatasan' => Carbon::parse($iz->batal_atasan)->format('d/m/Y H:i'),
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
        elseif($dataizin && $role == 3 && $row->jabatan == "Direksi")
        {
            // dd("hai direksi");
            if( $dataizin->atasan_kedua == Auth::user()->id_pegawai && $dataizin)
            {
                $status = Status::find(13);
                Izin::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'batal_pimpinan' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $izin = Izin::where('id',$id)->first();
        
                //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jenisizin
                $iz = DB::table('izin')
                    ->join('jenisizin','izin.id_jenisizin','=','jenisizin.id')
                    ->join('statuses','izin.catatan','=','statuses.name_status')
                    ->where('izin.id',$id)
                    ->select('izin.*','jenisizin.jenis_izin as jenis_izin','statuses.name_status')
                    ->first();

                $karyawan = DB::table('izin')
                    ->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->join('departemen','izin.departemen','=','departemen.id')
                    ->where('izin.id',$izin->id)
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
                    'subject'     => 'Notifikasi Persetujuan Formulir Pembatalan ' . $iz->jenis_izin . ' #' . $iz->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$izin->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR IZIN KARYAWAN',
                    'subtitle' => '[ PERSETUJUAN PEMBATALAN ]',
                    'tgl_permohonan' =>Carbon::parse($izin->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $izin->nik,
                    'jabatankaryawan' => $izin->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $iz->jenis_izin,
                    'keperluan'   => $iz->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($iz->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($iz->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $iz->jml_hari,
                    'status'      => $iz->name_status,
                    'alasan'      =>null,
                    'tgldisetujuiatasan' => Carbon::parse($iz->batal_atasan)->format("d/m/Y H:i"),
                    'tgldisetujuipimpinan' => Carbon::parse($iz->batal_pimpinan)->format("d/m/Y H:i"),
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
            elseif($dataizin && $dataizin->atasan_pertama == Auth::user()->id_pegawai)
            {
                // return $dataizin;
                $status = Status::find(12);
                // return $status->id;
                // dd($dataizin, Auth::user()->name);
                Izin::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'batal_atasan' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $izin = Izin::where('id',$id)->first();

                 //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jenisizin
                $iz = DB::table('izin')
                ->join('jenisizin','izin.id_jenisizin','=','jenisizin.id')
                ->join('statuses','izin.catatan','=','statuses.name_status')
                ->where('izin.id',$id)
                ->select('izin.*','jenisizin.jenis_izin as jenis_izin','statuses.name_status')
                ->first();
                $alasan = Datareject::where('id_cuti',$izin->id)->first();
                //sementara tidak digunakan
                $karyawan = DB::table('izin')
                    ->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->join('departemen','izin.departemen','=','departemen.id')
                    ->where('izin.id',$izin->id)
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
                    'subject'     => 'Notifikasi Approval Pertama Formulir Pembatalan ' . $iz->jenis_izin . ' #' . $iz->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$izin->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR IZIN KARYAWAN',
                    'subtitle' => '[ PERSETUJUAN PEMBATALAN ]',
                    'tgl_permohonan' =>Carbon::parse($izin->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $izin->nik,
                    'jabatankaryawan' => $izin->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $iz->jenis_izin,
                    'keperluan'   => $iz->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($iz->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($iz->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $iz->jml_hari,
                    'status'      => $iz->name_status,
                    'alasan'      =>null,
                    'tgldisetujuiatasan' => Carbon::parse($iz->batal_atasan)->format('d/m/Y H:i'),
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
        $izins = Izin::where('id',$id)->first();
        $dataizin = Izin::leftjoin('karyawan','izin.id_karyawan','=','karyawan.id')
            ->where('izin.id', '=',$izins->id)
            ->select('karyawan.atasan_pertama','karyawan.atasan_kedua')
            ->first();

        // dd($dataizin,$datacut);
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;
        // return $row->jabatan;
        // dd(Auth::user()->role,$row->jabatan,$role);
        if($dataizin && $role == 3 && $row->jabatan == "Asistant Manager")
        {
                $status = Status::find(9);
                // return $status->name_status;
                Izin::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'batalditolak' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $izin = Izin::where('id',$id)->first();
                 //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                $iz = DB::table('izin')
                    ->join('jenisizin','izin.id_jenisizin','=','jenisizin.id')
                    ->join('statuses','izin.catatan','=','statuses.name_status')
                    ->where('izin.id',$id)
                    ->select('izin.*','jenisizin.jenis_izin as jenis_izin','statuses.name_status')
                    ->first();
                $alasan = Datareject::where('id_cuti',$izin->id)->first();
                $karyawan = DB::table('izin')
                    ->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->join('departemen','izin.departemen','=','departemen.id')
                    ->where('izin.id',$izin->id)
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
                    'subject'     => 'Notifikasi Pembatalan Permohonan Ditolak ' . $iz->jenis_izin . ' #' . $iz->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$izin->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN PEMBATALAN FORMULIR IZIN KARYAWAN',
                    'subtitle' => '[ PENDING ATASAN ]',
                    'tgl_permohonan' =>Carbon::parse($izin->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $izin->nik,
                    'jabatankaryawan' => $izin->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $iz->jenis_izin,
                    'keperluan'   => $iz->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($iz->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($iz->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $iz->jml_hari,
                    'status'      => $iz->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' =>'-',
                    'tgldisetujuipimpinan' => '-',
                    'tglditolak' => Carbon::parse($iz->batalditolak)->format("d/m/Y H:i"),
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
        elseif($dataizin && $role == 1 && $row->jabatan == "Asistant Manager")
        {
            $status = Status::find(9);
            // return $status->name_status;
            Izin::where('id',$id)->update([
                'catatan' => $status->name_status,
                'batalditolak' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
            $izin = Izin::where('id',$id)->first();
             //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
            $iz = DB::table('izin')
                ->join('jenisizin','izin.id_jenisizin','=','jenisizin.id')
                ->join('statuses','izin.catatan','=','statuses.name_status')
                ->where('izin.id',$id)
                ->select('izin.*','jenisizin.jenis_izin as jenis_izin','statuses.name_status')
                ->first();
            $alasan = Datareject::where('id_cuti',$izin->id)->first();
            $karyawan = DB::table('izin')
                ->join('karyawan','izin.id_karyawan','=','karyawan.id')
                ->join('departemen','izin.departemen','=','departemen.id')
                ->where('izin.id',$izin->id)
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
                'subject'     => 'Notifikasi Pembatalan Permohonan Ditolak ' . $iz->jenis_izin . ' #' . $iz->id . ' ' . $karyawan->nama,
                'noregistrasi'=>$izin->id,
                'title' =>  'NOTIFIKASI PERSETUJUAN PEMBATALAN FORMULIR IZIN KARYAWAN',
                'subtitle' => '[ PENDING ATASAN ]',
                'tgl_permohonan' =>Carbon::parse($izin->tgl_permohonan)->format("d/m/Y"),
                'nik'         => $izin->nik,
                'jabatankaryawan' => $izin->jabatan,
                'departemen' => $karyawan->nama_departemen,
                'atasan1'     => $atasan1->email,
                'namaatasan1' => $atasan1->nama,
                'karyawan_email'=>$karyawan->email,
                'id_jeniscuti'=> $iz->jenis_izin,
                'keperluan'   => $iz->keperluan,
                'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                'tgl_mulai'   => Carbon::parse($iz->tgl_mulai)->format("d/m/Y"),
                'tgl_selesai' => Carbon::parse($iz->tgl_selesai)->format("d/m/Y"),
                'jml_cuti'    => $iz->jml_hari,
                'status'      => $iz->name_status,
                'alasan'      => $status->name_status,
                'tgldisetujuiatasan' =>'-',
                'tgldisetujuipimpinan' => '-',
                'tglditolak' => Carbon::parse($iz->batalditolak)->format("d/m/Y H:i"),
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
        elseif($dataizin && $role == 3 && $row->jabatan == "Manager")
        {
            if($dataizin && $dataizin->atasan_kedua == Auth::user()->id_pegawai)
            {
                $status = Status::find(10);
                Izin::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'batalditolak' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $izin = Izin::where('id',$id)->first();

                //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jenisizin
                $iz = DB::table('izin')
                    ->join('jenisizin','izin.id_jenisizin','=','jenisizin.id')
                    ->join('statuses','izin.catatan','=','statuses.name_status')
                    ->where('izin.id',$id)
                    ->select('izin.*','jenisizin.jenis_izin as jenis_izin','statuses.name_status')
                    ->first();
                $alasan = Datareject::where('id_cuti',$izin->id)->first();
                //sementara tidak digunakan
                $karyawan = DB::table('izin')
                    ->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->join('departemen','izin.departemen','=','departemen.id')
                    ->where('izin.id',$izin->id)
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
                    'subject'     => 'Notifikasi Pembatalan Permohonan Ditolak ' . $iz->jenis_izin . ' #' . $iz->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$izin->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN PEMBATALAN FORMULIR IZIN KARYAWAN',
                    'subtitle' => '[ PENDING PIMPINAN UNIT KERJA ]',
                    'tgl_permohonan' =>Carbon::parse($izin->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $izin->nik,
                    'jabatankaryawan' => $izin->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $iz->jenis_izin,
                    'keperluan'   => $iz->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($iz->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($iz->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $iz->jml_hari,
                    'status'      => $iz->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' => Carbon::parse($iz->batal_atasan)->format("d/m/Y H:i"),
                    'tgldisetujuipimpinan' =>'-',
                    'tglditolak' =>  Carbon::parse($iz->batalditolak)->format("d/m/Y H:i"),
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }
                // return $data;
                Mail::to($tujuan)->send(new PembatalanNotification($data));
                return redirect()->back();
            }
            elseif($dataizin && $dataizin->atasan_pertama == Auth::user()->id_pegawai)
            {
                // return $dataizin;
                $status = Status::find(9);
                // return $status->id;
                Izin::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'batalditolak' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $izin = Izin::where('id',$id)->first();

                 //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jenisizin
                $iz = DB::table('izin')
                ->join('jenisizin','izin.id_jenisizin','=','jenisizin.id')
                ->join('statuses','izin.catatan','=','statuses.name_status')
                ->where('izin.id',$id)
                ->select('izin.*','jenisizin.jenis_izin as jenis_izin','statuses.name_status')
                ->first();
                $alasan = Datareject::where('id_cuti',$izin->id)->first();
                //sementara tidak digunakan
                $karyawan = DB::table('izin')
                    ->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->join('departemen','izin.departemen','=','departemen.id')
                    ->where('izin.id',$izin->id)
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
                    'subject'     => 'Notifikasi Pembatalan Permohonan Ditolak ' . $iz->jenis_izin . ' #' . $iz->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$izin->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR IZIN KARYAWAN',
                    'subtitle' => '[ PERSETUJUAN PEMBATALAN ]',
                    'tgl_permohonan' =>Carbon::parse($izin->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $izin->nik,
                    'jabatankaryawan' => $izin->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $iz->jenis_izin,
                    'keperluan'   => $iz->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($iz->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($iz->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $iz->jml_hari,
                    'status'      => $iz->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' =>'-',
                    'tgldisetujuipimpinan' => '-',
                    'tglditolak' => Carbon::parse($iz->batalditolak)->format('d/m/Y H:i'),
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
        elseif($dataizin && $role == 1 && $row->jabatan == "Manager")
        {
            if($dataizin && $dataizin->atasan_kedua == Auth::user()->id_pegawai)
            {
                $status = Status::find(10);
                Izin::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'batalditolak' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $izin = Izin::where('id',$id)->first();

                //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jenisizin
                $iz = DB::table('izin')
                    ->join('jenisizin','izin.id_jenisizin','=','jenisizin.id')
                    ->join('statuses','izin.catatan','=','statuses.name_status')
                    ->where('izin.id',$id)
                    ->select('izin.*','jenisizin.jenis_izin as jenis_izin','statuses.name_status')
                    ->first();
                $alasan = Datareject::where('id_cuti',$izin->id)->first();
                //sementara tidak digunakan
                $karyawan = DB::table('izin')
                    ->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->join('departemen','izin.departemen','=','departemen.id')
                    ->where('izin.id',$izin->id)
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
                    'subject'     => 'Notifikasi Pembatalan Permohonan Ditolak ' . $iz->jenis_izin . ' #' . $iz->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$izin->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN PEMBATALAN FORMULIR IZIN KARYAWAN',
                    'subtitle' => '[ PENDING PIMPINAN UNIT KERJA ]',
                    'tgl_permohonan' =>Carbon::parse($izin->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $izin->nik,
                    'jabatankaryawan' => $izin->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $iz->jenis_izin,
                    'keperluan'   => $iz->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($iz->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($iz->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $iz->jml_hari,
                    'status'      => $iz->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' => Carbon::parse($iz->batal_atasan)->format("d/m/Y H:i"),
                    'tgldisetujuipimpinan' =>'-',
                    'tglditolak' => Carbon::parse($iz->batalditolak)->format('d/m/Y H:i'),
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }
                // return $data;
                Mail::to($tujuan)->send(new PembatalanNotification($data));
                return redirect()->back();
            }
            elseif($dataizin && $dataizin->atasan_pertama == Auth::user()->id_pegawai)
            {
                // return $dataizin;
                $status = Status::find(9);
                // return $status->id;
                Izin::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'batalditolak' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $izin = Izin::where('id',$id)->first();

                 //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jenisizin
                $iz = DB::table('izin')
                ->join('jenisizin','izin.id_jenisizin','=','jenisizin.id')
                ->join('statuses','izin.catatan','=','statuses.name_status')
                ->where('izin.id',$id)
                ->select('izin.*','jenisizin.jenis_izin as jenis_izin','statuses.name_status')
                ->first();
                $alasan = Datareject::where('id_cuti',$izin->id)->first();
                //sementara tidak digunakan
                $karyawan = DB::table('izin')
                    ->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->join('departemen','izin.departemen','=','departemen.id')
                    ->where('izin.id',$izin->id)
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
                    'subject'     => 'Notifikasi Pembatalan Permohonan Ditolak ' . $iz->jenis_izin . ' #' . $iz->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$izin->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR IZIN KARYAWAN',
                    'subtitle' => '[ PERSETUJUAN PEMBATALAN ]',
                    'tgl_permohonan' =>Carbon::parse($izin->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $izin->nik,
                    'jabatankaryawan' => $izin->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $iz->jenis_izin,
                    'keperluan'   => $iz->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($iz->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($iz->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $iz->jml_hari,
                    'status'      => $iz->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' =>'-',
                    'tgldisetujuipimpinan' => '-',
                    'tglditolak' => Carbon::parse($iz->batalditolak)->format('d/m/Y H:i'),
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
        elseif($dataizin && $role == 3 && $row->jabatan == "Direksi")
        {
            // return "Hai Direksi";
            if($dataizin && $dataizin->atasan_kedua == Auth::user()->id_pegawai)
            {
                $status = Status::find(10);
                Izin::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'batalditolak' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $izin = Izin::where('id',$id)->first();

                //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jenisizin
                $iz = DB::table('izin')
                    ->join('jenisizin','izin.id_jenisizin','=','jenisizin.id')
                    ->join('statuses','izin.catatan','=','statuses.name_status')
                    ->where('izin.id',$id)
                    ->select('izin.*','jenisizin.jenis_izin as jenis_izin','statuses.name_status')
                    ->first();
                $alasan = Datareject::where('id_cuti',$izin->id)->first();
                //sementara tidak digunakan
                $karyawan = DB::table('izin')
                    ->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->join('departemen','izin.departemen','=','departemen.id')
                    ->where('izin.id',$izin->id)
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
                    'subject'     => 'Notifikasi Pembatalan Permohonan Ditolak ' . $iz->jenis_izin . ' #' . $iz->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$izin->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN PEMBATALAN FORMULIR IZIN KARYAWAN',
                    'subtitle' => '[ PENDING PIMPINAN ]',
                    'tgl_permohonan' =>Carbon::parse($izin->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $izin->nik,
                    'jabatankaryawan' => $izin->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $iz->jenis_izin,
                    'keperluan'   => $iz->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($iz->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($iz->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $iz->jml_hari,
                    'status'      => $iz->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' => Carbon::parse($iz->batal_atasan)->format("d/m/Y H:i"),
                    'tgldisetujuipimpinan' =>'-',
                    'tglditolak' =>  Carbon::parse($iz->batalditolak)->format("d/m/Y H:i"),
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }
                // return $data;
                Mail::to($tujuan)->send(new PembatalanNotification($data));
                return redirect()->back();
            }
            elseif($dataizin && $dataizin->atasan_pertama == Auth::user()->id_pegawai)
            {
                // return $dataizin;
                $status = Status::find(9);
                // return $status->id;
                Izin::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'batalditolak' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $izin = Izin::where('id',$id)->first();

                 //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jenisizin
                $iz = DB::table('izin')
                ->join('jenisizin','izin.id_jenisizin','=','jenisizin.id')
                ->join('statuses','izin.catatan','=','statuses.name_status')
                ->where('izin.id',$id)
                ->select('izin.*','jenisizin.jenis_izin as jenis_izin','statuses.name_status')
                ->first();
                $alasan = Datareject::where('id_cuti',$izin->id)->first();
                //sementara tidak digunakan
                $karyawan = DB::table('izin')
                    ->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->join('departemen','izin.departemen','=','departemen.id')
                    ->where('izin.id',$izin->id)
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
                    'subject'     => 'Notifikasi Pembatalan Permohonan Ditolak ' . $iz->jenis_izin . ' #' . $iz->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$izin->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR IZIN KARYAWAN',
                    'subtitle' => '[ PERSETUJUAN PEMBATALAN ]',
                    'tgl_permohonan' =>Carbon::parse($izin->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $izin->nik,
                    'jabatankaryawan' => $izin->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $iz->jenis_izin,
                    'keperluan'   => $iz->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($iz->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($iz->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $iz->jml_hari,
                    'status'      => $iz->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' =>'-',
                    'tgldisetujuipimpinan' => '-',
                    'tglditolak' => Carbon::parse($iz->batalditolak)->format('d/m/Y H:i'),
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
        $izins = Izin::where('id',$id)->first();
        $dataizin = Izin::leftjoin('karyawan','izin.id_karyawan','=','karyawan.id')
            ->where('izin.id', '=',$izins->id)
            ->select('karyawan.atasan_pertama','karyawan.atasan_kedua')
            ->first();

        // dd($dataizin,$datacut);
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;
        // dd($row->jabatan,$role);
        if($dataizin && $role == 3 && $row->jabatan == "Asistant Manager")
        {
                $status = Status::find(15);
                // return $status->name_status;
                Izin::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'ubah_atasan' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $izin = Izin::where('id',$id)->first();
                 //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                $iz = DB::table('izin')
                    ->join('jenisizin','izin.id_jenisizin','=','jenisizin.id')
                    ->join('statuses','izin.catatan','statuses.name_status')
                    ->where('izin.id',$id)
                    ->select('izin.*','jenisizin.jenis_izin as jenis_izin','statuses.name_status')
                    ->first();
                $karyawan = DB::table('izin')
                    ->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->join('departemen','izin.departemen','=','departemen.id')
                    ->where('izin.id',$izin->id)
                    ->select('karyawan.email as email','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first(); 
                $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
               
                $atasan2 = NULL;
                if($karyawan->atasan_kedua == NULL)
                {
                    $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                }
                $tujuan = $atasan2->email ?? null;
                $data = [
                    'subject'     => 'Notifikasi Approval Pertama Formulir Perubahan ' . $iz->jenis_izin . ' #' . $iz->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$izin->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR IZIN KARYAWAN',
                    'subtitle' => '[ PERSETUJUAN PERUBAHAN DATA ]',
                    'tgl_permohonan' =>Carbon::parse($izin->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $izin->nik,
                    'jabatankaryawan' => $izin->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $iz->jenis_izin,
                    'keperluan'   => $iz->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($iz->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($iz->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $iz->jml_hari,
                    'status'      => $iz->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' => Carbon::parse($iz->ubah_atasan)->format('d/m/Y H:i'),
                    'tgldisetujuipimpinan' => '-',
                    'tglditolak' => '-',
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }
                Mail::to($tujuan)->send(new PerubahanNotification($data));
                // return $data;
            // }else{
                return redirect()->back();
            // }
        }
        if($dataizin && $role == 1 && $row->jabatan == "Asistant Manager")
        {
                $status = Status::find(15);
                // return $status->name_status;
                Izin::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'ubah_atasan' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $izin = Izin::where('id',$id)->first();
                 //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                $iz = DB::table('izin')
                    ->join('jenisizin','izin.id_jenisizin','=','jenisizin.id')
                    ->join('statuses','izin.catatan','statuses.name_status')
                    ->where('izin.id',$id)
                    ->select('izin.*','jenisizin.jenis_izin as jenis_izin','statuses.name_status')
                    ->first();
                $karyawan = DB::table('izin')
                    ->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->join('departemen','izin.departemen','=','departemen.id')
                    ->where('izin.id',$izin->id)
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
                    'subject'     => 'Notifikasi Approval Pertama Formulir Perubahan ' . $iz->jenis_izin . ' #' . $iz->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$izin->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR IZIN KARYAWAN',
                    'subtitle' => '[ PERSETUJUAN PERUBAHAN DATA ]',
                    'tgl_permohonan' =>Carbon::parse($izin->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $izin->nik,
                    'jabatankaryawan' => $izin->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $iz->jenis_izin,
                    'keperluan'   => $iz->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($iz->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($iz->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $iz->jml_hari,
                    'status'      => $iz->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' =>  Carbon::parse($iz->ubah_atasan)->format('d/m/Y H:i'),
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
        else if($dataizin && $role == 3 && $row->jabatan == "Manager")
        {
            if($dataizin && $dataizin->atasan_kedua == Auth::user()->id_pegawai)
            {
                $status = Status::find(16);
                Izin::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'ubah_pimpinan' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $izin = Izin::where('id',$id)->first();
        
                //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jenisizin
                $iz = DB::table('izin')
                    ->join('jenisizin','izin.id_jenisizin','=','jenisizin.id')
                    ->join('statuses','izin.catatan','statuses.name_status')
                    ->where('izin.id',$id)
                    ->select('izin.*','jenisizin.jenis_izin as jenis_izin','statuses.name_status')
                    ->first();
        
                $karyawan = DB::table('izin')
                    ->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->join('departemen','izin.departemen','=','departemen.id')
                    ->where('izin.id',$izin->id)
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
                     'subject'     => 'Notifikasi Persetujuan Formulir Perubahan ' . $iz->jenis_izin . ' #' . $iz->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$izin->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR IZIN KARYAWAN',
                    'subtitle' => '[ PERSETUJUAN PERUBAHAN DATA ]',
                    'tgl_permohonan' =>Carbon::parse($izin->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $izin->nik,
                    'jabatankaryawan' => $izin->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $iz->jenis_izin,
                    'keperluan'   => $iz->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($iz->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($iz->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $iz->jml_hari,
                    'status'      => $iz->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' =>Carbon::parse($iz->ubah_atasan)->format("d/m/Y H:i"),
                    'tgldisetujuipimpinan' => Carbon::parse($iz->ubah_pimpinan)->format("d/m/Y H:i"),
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
            elseif($dataizin && $dataizin->atasan_pertama == Auth::user()->id_pegawai)
            {
                // return $dataizin;
                $status = Status::find(15);
                // return $status->id;
                Izin::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'ubah_atasan' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $izin = Izin::where('id',$id)->first();

                 //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jenisizin
                $iz = DB::table('izin')
                    ->join('jenisizin','izin.id_jenisizin','=','jenisizin.id')
                    ->join('statuses','izin.catatan','statuses.name_status')
                    ->where('izin.id',$id)
                    ->select('izin.*','jenisizin.jenis_izin as jenis_izin','statuses.name_status')
                    ->first();
                $alasan = Datareject::where('id_cuti',$izin->id)->first();
                //sementara tidak digunakan
                $karyawan = DB::table('izin')
                    ->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->join('departemen','izin.departemen','=','departemen.id')
                    ->where('izin.id',$izin->id)
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
                    'subject'     => 'Notifikasi Approval Pertama Formulir Perubahan ' . $iz->jenis_izin . ' #' . $iz->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$izin->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR IZIN KARYAWAN',
                    'subtitle' => '[ PERSETUJUAN PERUBAHAN DATA ]',
                    'tgl_permohonan' =>Carbon::parse($izin->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $izin->nik,
                    'jabatankaryawan' => $izin->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $iz->jenis_izin,
                    'keperluan'   => $iz->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($iz->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($iz->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $iz->jml_hari,
                    'status'      => $iz->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' => Carbon::parse($iz->ubah_atasan)->format("d/m/Y"),
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
        else if($dataizin && $role == 1 && $row->jabatan == "Manager")
        {
            if($dataizin && $dataizin->atasan_kedua == Auth::user()->id_pegawai)
            {
                $status = Status::find(16);
                Izin::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'ubah_pimpinan' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $izin = Izin::where('id',$id)->first();
        
                //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jenisizin
                $iz = DB::table('izin')
                    ->join('jenisizin','izin.id_jenisizin','=','jenisizin.id')
                    ->join('statuses','izin.catatan','statuses.name_status')
                    ->where('izin.id',$id)
                    ->select('izin.*','jenisizin.jenis_izin as jenis_izin','statuses.name_status')
                    ->first();
        
                $karyawan = DB::table('izin')
                    ->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->join('departemen','izin.departemen','=','departemen.id')
                    ->where('izin.id',$izin->id)
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
                     'subject'     => 'Notifikasi Persetujuan Formulir Perubahan ' . $iz->jenis_izin . ' #' . $iz->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$izin->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR IZIN KARYAWAN',
                    'subtitle' => '[ PERSETUJUAN PERUBAHAN DATA ]',
                    'tgl_permohonan' =>Carbon::parse($izin->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $izin->nik,
                    'jabatankaryawan' => $izin->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $iz->jenis_izin,
                    'keperluan'   => $iz->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($iz->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($iz->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $iz->jml_hari,
                    'status'      => $iz->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' =>Carbon::parse($iz->ubah_atasan)->format("d/m/Y H:i"),
                    'tgldisetujuipimpinan' => Carbon::parse($iz->ubah_pimpinan)->format("d/m/Y H:i"),
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
            elseif($dataizin && $dataizin->atasan_pertama == Auth::user()->id_pegawai)
            {
                // return $dataizin;
                $status = Status::find(15);
                // return $status->id;
                Izin::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'batal_atasan' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $izin = Izin::where('id',$id)->first();

                 //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jenisizin
                $iz = DB::table('izin')
                ->join('jenisizin','izin.id_jenisizin','=','jenisizin.id')
                ->join('statuses','izin.catatan','statuses.name_status')
                ->where('izin.id',$id)
                ->select('izin.*','jenisizin.jenis_izin as jenis_izin','statuses.name_status')
                ->first();
                $alasan = Datareject::where('id_cuti',$izin->id)->first();
                //sementara tidak digunakan
                $karyawan = DB::table('izin')
                    ->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->join('departemen','izin.departemen','=','departemen.id')
                    ->where('izin.id',$izin->id)
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
                    'subject'     => 'Notifikasi Approval Pertama Formulir Perubahan ' . $iz->jenis_izin . ' #' . $iz->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$izin->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR IZIN KARYAWAN',
                    'subtitle' => '[ PERSETUJUAN PERUBAHAN DATA ]',
                    'tgl_permohonan' =>Carbon::parse($izin->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $izin->nik,
                    'jabatankaryawan' => $izin->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $iz->jenis_izin,
                    'keperluan'   => $iz->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($iz->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($iz->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $iz->jml_hari,
                    'status'      => $iz->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' => Carbon::parse($iz->ubah_atasan)->format("d/m/Y H:i"),
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
        else if($dataizin && $role == 3 && $row->jabatan == "Direksi")
        {
            if($dataizin && $dataizin->atasan_kedua == Auth::user()->id_pegawai)
            {
                // dd($row->jabatan,$role);
                $status = Status::find(16);
                Izin::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'ubah_pimpinan' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $izin = Izin::where('id',$id)->first();
        
                //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jenisizin
                $iz = DB::table('izin')
                    ->join('jenisizin','izin.id_jenisizin','=','jenisizin.id')
                    ->join('statuses','izin.catatan','statuses.name_status')
                    ->where('izin.id',$id)
                    ->select('izin.*','jenisizin.jenis_izin as jenis_izin','statuses.name_status')
                    ->first();
        
                $karyawan = DB::table('izin')
                    ->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->join('departemen','izin.departemen','=','departemen.id')
                    ->where('izin.id',$izin->id)
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
                    'subject'     => 'Notifikasi Persetujuan Formulir Perubahan ' . $iz->jenis_izin . ' #' . $iz->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$izin->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR IZIN KARYAWAN',
                    'subtitle' => '[ PERSETUJUAN PERUBAHAN DATA ]',
                    'tgl_permohonan' =>Carbon::parse($izin->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $izin->nik,
                    'jabatankaryawan' => $izin->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $iz->jenis_izin,
                    'keperluan'   => $iz->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($iz->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($iz->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $iz->jml_hari,
                    'status'      => $iz->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' =>Carbon::parse($iz->ubah_atasan)->format("d/m/Y H:i"),
                    'tgldisetujuipimpinan' => Carbon::parse($iz->ubah_pimpinan)->format("d/m/Y H:i"),
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
            elseif($dataizin->atasan_pertama == Auth::user()->id_pegawai && $dataizin)
            {
                // return $dataizin;
                $status = Status::find(15);
                // return $status->id;
                Izin::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'ubah_atasan' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $izin = Izin::where('id',$id)->first();

                 //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jenisizin
                $iz = DB::table('izin')
                ->join('jenisizin','izin.id_jenisizin','=','jenisizin.id')
                ->join('statuses','izin.catatan','statuses.name_status')
                ->where('izin.id',$id)
                ->select('izin.*','jenisizin.jenis_izin as jenis_izin','statuses.name_status')
                ->first();
                $alasan = Datareject::where('id_cuti',$izin->id)->first();
                //sementara tidak digunakan
                $karyawan = DB::table('izin')
                    ->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->join('departemen','izin.departemen','=','departemen.id')
                    ->where('izin.id',$izin->id)
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
                    'subject'     => 'Notifikasi Approval Pertama Formulir Perubahan ' . $iz->jenis_izin . ' #' . $iz->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$izin->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR IZIN KARYAWAN',
                    'subtitle' => '[ PERSETUJUAN PERUBAHAN DATA ]',
                    'tgl_permohonan' =>Carbon::parse($izin->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $izin->nik,
                    'jabatankaryawan' => $izin->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $iz->jenis_izin,
                    'keperluan'   => $iz->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($iz->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($iz->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $iz->jml_hari,
                    'status'      => $iz->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' => Carbon::parse($iz->ubah_atasan)->format("d/m/Y H:i"),
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
        $izins = Izin::where('id',$id)->first();
        $dataizin = Izin::leftjoin('karyawan','izin.id_karyawan','=','karyawan.id')
            ->where('izin.id', '=',$izins->id)
            ->select('karyawan.atasan_pertama','karyawan.atasan_kedua')
            ->first();

        // dd($dataizin);
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;
        // return $row->jabatan;
        if($dataizin &&  $role == 3 && $row->jabatan == "Asistant Manager")
        {
                $status = Status::find(9);
                // return $status->name_status;
                Izin::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'ubahditolak' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $izin = Izin::where('id',$id)->first();
                 //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                $iz = DB::table('izin')
                    ->join('jenisizin','izin.id_jenisizin','=','jenisizin.id')
                    ->join('statuses','izin.catatan','statuses.name_status')
                    ->where('izin.id',$id)
                    ->select('izin.*','jenisizin.jenis_izin as jenis_izin','statuses.name_status')
                    ->first();
                $karyawan = DB::table('izin')
                    ->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->join('departemen','izin.departemen','=','departemen.id')
                    ->where('izin.id',$izin->id)
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
                // return $tujuan;
                $data = [
                    'subject'     => 'Notifikasi Permohonan Perubahan  Ditolak ' . $iz->jenis_izin . ' #' . $iz->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$izin->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN PERUBAHAN DATA FORMULIR IZIN KARYAWAN',
                    'subtitle' => '[ PENDING ATASAN ]',
                    'tgl_permohonan' =>Carbon::parse($izin->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $izin->nik,
                    'jabatankaryawan' => $izin->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $iz->jenis_izin,
                    'keperluan'   => $iz->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($iz->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($iz->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $iz->jml_hari,
                    'status'      => $iz->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' =>'-',
                    'tgldisetujuipimpinan' => '-',
                    'tglditolak' => Carbon::parse($iz->ubahditolak)->format("d/m/Y H:i"),
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
        if($dataizin && $role == 1 && $row->jabatan == "Asistant Manager")
        {
                $status = Status::find(9);
                // return $status->name_status;
                Izin::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'ubahditolak' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $izin = Izin::where('id',$id)->first();
                 //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                $iz = DB::table('izin')
                    ->join('jenisizin','izin.id_jenisizin','=','jenisizin.id')
                    ->join('statuses','izin.catatan','statuses.name_status')
                    ->where('izin.id',$id)
                    ->select('izin.*','jenisizin.jenis_izin as jenis_izin','statuses.name_status')
                    ->first();
                $karyawan = DB::table('izin')
                    ->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->join('departemen','izin.departemen','=','departemen.id')
                    ->where('izin.id',$izin->id)
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
                // return $tujuan;
                $data = [
                    'subject'     => 'Notifikasi Permohonan Perubahan Ditolak ' . $iz->jenis_izin . ' #' . $iz->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$izin->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN PERUBAHAN DATA FORMULIR IZIN KARYAWAN',
                    'subtitle' => '[ PENDING ATASAN ]',
                    'tgl_permohonan' =>Carbon::parse($izin->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $izin->nik,
                    'jabatankaryawan' => $izin->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $iz->jenis_izin,
                    'keperluan'   => $iz->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($iz->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($iz->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $iz->jml_hari,
                    'status'      => $iz->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' =>'-',
                    'tgldisetujuipimpinan' => '-',
                    'tglditolak' => Carbon::parse($iz->ubahditolak)->format("d/m/Y H:i"),
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
        else if($dataizin && $role == 3 && $row->jabatan == "Manager")
        {
            if($dataizin && $dataizin->atasan_kedua == Auth::user()->id_pegawai)
            {
                $status = Status::find(10);
                Izin::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'ubahditolak' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $izin = Izin::where('id',$id)->first();

                //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jenisizin
                $iz = DB::table('izin')
                    ->join('jenisizin','izin.id_jenisizin','=','jenisizin.id')
                    ->join('statuses','izin.catatan','statuses.name_status')
                    ->where('izin.id',$id)
                    ->select('izin.*','jenisizin.jenis_izin as jenis_izin','statuses.name_status')
                    ->first();
                //sementara tidak digunakan
                $karyawan = DB::table('izin')
                    ->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->join('departemen','izin.departemen','=','departemen.id')
                    ->where('izin.id',$izin->id)
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
                    'subject'     => 'Notifikasi Permohonan Perubahan Ditolak ' . $iz->jenis_izin . ' #' . $iz->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$izin->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN PERUBAHAN DATA FORMULIR IZIN KARYAWAN',
                    'subtitle' => '[ PENDING PIMPINAN UNIT KERJA ]',
                    'tgl_permohonan' =>Carbon::parse($izin->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $izin->nik,
                    'jabatankaryawan' => $izin->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $iz->jenis_izin,
                    'keperluan'   => $iz->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($iz->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($iz->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $iz->jml_hari,
                    'status'      => $iz->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' => Carbon::parse($iz->ubah_atasan)->format("d/m/Y H:i"),
                    'tgldisetujuipimpinan' =>'-',
                    'tglditolak' => Carbon::parse($iz->ubahditolak)->format("d/m/Y H:i"),
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }
                // return $data;
                Mail::to($tujuan)->send(new PerubahanNotification($data));
                return redirect()->back();
            }
            elseif($dataizin && $dataizin->atasan_pertama == Auth::user()->id_pegawai)
            {
                // return $dataizin;
                $status = Status::find(9);
                // return $status->id;
                Izin::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'ubahditolak' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $izin = Izin::where('id',$id)->first();

                 //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jenisizin
                $iz = DB::table('izin')
                ->join('jenisizin','izin.id_jenisizin','=','jenisizin.id')
                ->join('statuses','izin.catatan','statuses.name_status')
                ->where('izin.id',$id)
                ->select('izin.*','jenisizin.jenis_izin as jenis_izin','statuses.name_status')
                ->first();
                $alasan = Datareject::where('id_cuti',$izin->id)->first();
                //sementara tidak digunakan
                $karyawan = DB::table('izin')
                    ->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->join('departemen','izin.departemen','=','departemen.id')
                    ->where('izin.id',$izin->id)
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
                    'subject'     => 'Notifikasi Permohonan Perubahan Ditolak ' . $iz->jenis_izin . ' #' . $iz->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$izin->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN PERUBAHAN DATA FORMULIR IZIN KARYAWAN',
                    'subtitle' => '[ PENDING ATASAN ]',
                    'tgl_permohonan' =>Carbon::parse($izin->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $izin->nik,
                    'jabatankaryawan' => $izin->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $iz->jenis_izin,
                    'keperluan'   => $iz->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($iz->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($iz->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $iz->jml_hari,
                    'status'      => $iz->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' =>'-',
                    'tgldisetujuipimpinan' => '-',
                    'tglditolak' => Carbon::parse($iz->ubahditolak)->format('d/m/Y H:i'),
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
        else if($dataizin && $role == 3 && $row->jabatan == "Direksi")
        {
            // dd("hai direksi");
            if($dataizin && $dataizin->atasan_kedua == Auth::user()->id_pegawai)
            {
                $status = Status::find(10);
                Izin::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'ubahditolak' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $izin = Izin::where('id',$id)->first();

                //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jenisizin
                $iz = DB::table('izin')
                    ->join('jenisizin','izin.id_jenisizin','=','jenisizin.id')
                    ->join('statuses','izin.catatan','statuses.name_status')
                    ->where('izin.id',$id)
                    ->select('izin.*','jenisizin.jenis_izin as jenis_izin','statuses.name_status')
                    ->first();
                //sementara tidak digunakan
                $karyawan = DB::table('izin')
                    ->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->join('departemen','izin.departemen','=','departemen.id')
                    ->where('izin.id',$izin->id)
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
                    'subject'     => 'Notifikasi Permohonan Perubahan Ditolak ' . $iz->jenis_izin . ' #' . $iz->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$izin->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN PERUBAHAN DATA FORMULIR IZIN KARYAWAN',
                    'subtitle' => '[ PENDING PIMPINAN ]',
                    'tgl_permohonan' =>Carbon::parse($izin->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $izin->nik,
                    'jabatankaryawan' => $izin->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $iz->jenis_izin,
                    'keperluan'   => $iz->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($iz->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($iz->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $iz->jml_hari,
                    'status'      => $iz->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' => Carbon::parse($iz->ubah_atasan)->format("d/m/Y H:i"),
                    'tgldisetujuipimpinan' =>'-',
                    'tglditolak' => Carbon::parse($iz->ubahditolak)->format("d/m/Y H:i"),
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }
                // return $data;
                Mail::to($tujuan)->send(new PerubahanNotification($data));
                return redirect()->back();
            }
            elseif($dataizin && $dataizin->atasan_pertama == Auth::user()->id_pegawai)
            {
                // return $dataizin;
                $status = Status::find(9);
                // return $status->id;
                Izin::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'ubahditolak' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $izin = Izin::where('id',$id)->first();

                 //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jenisizin
                $iz = DB::table('izin')
                ->join('jenisizin','izin.id_jenisizin','=','jenisizin.id')
                ->join('statuses','izin.catatan','statuses.name_status')
                ->where('izin.id',$id)
                ->select('izin.*','jenisizin.jenis_izin as jenis_izin','statuses.name_status')
                ->first();
                $alasan = Datareject::where('id_cuti',$izin->id)->first();
                //sementara tidak digunakan
                $karyawan = DB::table('izin')
                    ->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->join('departemen','izin.departemen','=','departemen.id')
                    ->where('izin.id',$izin->id)
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
                    'subject'     => 'Notifikasi Permohonan Perubahan Ditolak ' . $iz->jenis_izin . ' #' . $iz->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$izin->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN PERUBAHAN DATA FORMULIR IZIN KARYAWAN',
                    'subtitle' => '[ PENDING ATASAN ]',
                    'tgl_permohonan' =>Carbon::parse($izin->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $izin->nik,
                    'jabatankaryawan' => $izin->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $iz->jenis_izin,
                    'keperluan'   => $iz->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($iz->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($iz->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $iz->jml_hari,
                    'status'      => $iz->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' =>'-',
                    'tgldisetujuipimpinan' => '-',
                    'tglditolak' => Carbon::parse($iz->ubahditolak)->format('d/m/Y H:i'),
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
        else if($dataizin && $role == 1 && $row->jabatan == "Manager")
        {
            if($dataizin && $dataizin->atasan_kedua == Auth::user()->id_pegawai)
            {
                $status = Status::find(10);
                Izin::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'ubahditolak' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $izin = Izin::where('id',$id)->first();

                //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jenisizin
                $iz = DB::table('izin')
                    ->join('jenisizin','izin.id_jenisizin','=','jenisizin.id')
                    ->join('statuses','izin.catatan','statuses.name_status')
                    ->where('izin.id',$id)
                    ->select('izin.*','jenisizin.jenis_izin as jenis_izin','statuses.name_status')
                    ->first();
                //sementara tidak digunakan
                $karyawan = DB::table('izin')
                    ->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->join('departemen','izin.departemen','=','departemen.id')
                    ->where('izin.id',$izin->id)
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
                    'subject'     => 'Notifikasi Permohonan Perubahan Ditolak ' . $iz->jenis_izin . ' #' . $iz->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$izin->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN PERUBAHAN DATA FORMULIR IZIN KARYAWAN',
                    'subtitle' => '[ PENDING PIMPINAN UNIT KERJA ]',
                    'tgl_permohonan' =>Carbon::parse($izin->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $izin->nik,
                    'jabatankaryawan' => $izin->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $iz->jenis_izin,
                    'keperluan'   => $iz->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($iz->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($iz->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $iz->jml_hari,
                    'status'      => $iz->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' => Carbon::parse($iz->ubah_atasan)->format("d/m/Y H:i"),
                    'tgldisetujuipimpinan' =>'-',
                    'tglditolak' => Carbon::parse($iz->ubahditolak)->format("d/m/Y H:i"),
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }
                // return $data;
                Mail::to($tujuan)->send(new PerubahanNotification($data));
                return redirect()->back();
            }
            elseif($dataizin && $dataizin->atasan_pertama == Auth::user()->id_pegawai)
            {
                // return $dataizin;
                $status = Status::find(9);
                // return $status->id;
                Izin::where('id',$id)->update([
                    'catatan' => $status->name_status,
                    'ubahditolak' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $izin = Izin::where('id',$id)->first();

                 //----SEND EMAIL KE KARYAWAN DAN SEMUA ATASAN -------
                //ambil nama jenisizin
                $iz = DB::table('izin')
                ->join('jenisizin','izin.id_jenisizin','=','jenisizin.id')
                ->join('statuses','izin.catatan','statuses.name_status')
                ->where('izin.id',$id)
                ->select('izin.*','jenisizin.jenis_izin as jenis_izin','statuses.name_status')
                ->first();
                $alasan = Datareject::where('id_cuti',$izin->id)->first();
                //sementara tidak digunakan
                $karyawan = DB::table('izin')
                    ->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->join('departemen','izin.departemen','=','departemen.id')
                    ->where('izin.id',$izin->id)
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
                    'subject'     => 'Notifikasi Permohonan Perubahan  Ditolak ' . $iz->jenis_izin . ' #' . $iz->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$izin->id,
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR IZIN KARYAWAN',
                    'subtitle' => '[ PENDING ATASAN ]',
                    'tgl_permohonan' =>Carbon::parse($izin->tgl_permohonan)->format("d/m/Y"),
                    'nik'         => $izin->nik,
                    'jabatankaryawan' => $izin->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'namaatasan1' => $atasan1->nama,
                    'karyawan_email'=>$karyawan->email,
                    'id_jeniscuti'=> $iz->jenis_izin,
                    'keperluan'   => $iz->keperluan,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'tgl_mulai'   => Carbon::parse($iz->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' => Carbon::parse($iz->tgl_selesai)->format("d/m/Y"),
                    'jml_cuti'    => $iz->jml_hari,
                    'status'      => $iz->name_status,
                    'alasan'      => $status->name_status,
                    'tgldisetujuiatasan' =>'-',
                    'tgldisetujuipimpinan' => '-',
                    'tglditolak' => Carbon::parse($iz->ubahditolak)->format('d/m/Y H:i'),
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

