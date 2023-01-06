<?php

use Illuminate\Support\Facades\Auth;
use App\Models\Karyawan;
use App\Models\Kdarurat;
use App\Models\Keluarga;
use App\Models\Rpekerjaan;
use App\Models\Rpendidikan;
use Illuminate\Support\Facades\DB;

?>

<h3>Data Karyawan</h3>
<table>
    <thead>
        <tr>
            {{-- IDENTITAS --}}
            <th>No</th>
            <th>Nama Lengkap</th>
            <th>Tanggal Lahir</th>
            <th>Jenis Kelamin</th>
            <th>Departemen</th>
            <th>Manager</th>
            <th>Jabatan</th>
            <th>Alamat</th>
            <th>Nomor Handphone</th>
            <th>Alamat E-mail</th>
            <th>Agama</th>
            <th>Tanggal Masuk</th>
            <th>NIK</th>
            <th>Golongan Darah</th>
            {{-- RIWAYAT PENDIDIKAN  --}}
            <th>Pendidikan Terakhir</th>
            <th>Nama Sekolah</th>
            <th>Kota</th>
            <th>Jurusan</th>
            <th>Lulus Tahun</th>
            <th>Pendidikan Non Formal</th>
            <th>Kota</th>
            <th>Lulus Tahun</th>
            {{-- RIWAYAT PEKERJAAN  --}}
            <th>Nama Perusahaan</th>
            <th>Alamat Perusahaan</th>
            <th>Jenis Usaha</th>
            <th>Jabatan</th>
            <th>Nama Atasan Langsung</th>
            <th>Nama Direktur</th>
            <th>Lama Kerja</th>
            <th>Alasan Berhenti</th>
            <th>Gaji</th>
            {{-- KELUARGA  --}}
            <th>Status Pernikahan</th>
            <th>Nama Lengkap Suami / Istri</th>
            <th>Tanggal Lahir</th>
            <th>Alamat</th>
            <th>Pendidikan Terakhir</th>
            <th>Pekerjaan</th>
            {{-- KONTAK DARURAT  --}}
            <th>Nama Lengkap Kontak Darurat</th>
            <th>Alamat  Kontak Darurat</th>
            <th>No. Handphone Kontak Darurat</th>
            <th>Hubungan dengan  Kontak Darurat</th>
            

        </tr>
    </thead>
    <tbody>
        @foreach($karyawan as $k )
        <tr>
            <td>{{ $loop->iteration}}</td>
            <td>{{ $k->nama }}</td>
            <td>{{ $k->tgllahir }}</td>
            <td>{{ $k->jenis_kelamin }}</td>
            <td>{{ $k->divisi }}</td>
            <td>{{ $k->manager }}</td>
            <td>{{ $k->jabatan }}</td>
            <td>{{ $k->alamat }}</td>
            <td>{{ $k->no_hp }}</td>
            <td>{{ $k->email }}</td>
            <td>{{ $k->agama }}</td>
            <td>{{ $k->tglmasuk }}</td>
            <td>{{ $k->nik }}</td>
            <td>{{ $k->gol_darah }}</td>
            {{-- RIWAYAT PENDIDIKAN  --}}
            <td>{{ $k->rpendidikan->tingkat }}</td>
            <td>{{ $k->rpendidikan->nama_sekolah }}</td>
            <td>{{ $k->rpendidikan->kota_pformal }}</td>
            <td>{{ $k->rpendidikan->jurusan }}</td>
            <td>{{ $k->rpendidikan->tahun_lulus_formal }}</td>
            <td>{{ $k->rpendidikan->jenis_pendidikan }}</td>
            <td>{{ $k->rpendidikan->kota_pnonformal }}</td>
            <td>{{ $k->rpendidikan->tahun_lulus_nonformal }}</td>
            {{-- RIWAYAT PEKERJAAN  --}}
            <td>{{ $k->rpekerjaan->nama_perusahaan  }}</td>
            <td>{{ $k->rpekerjaan->alamat  }}</td>
            <td>{{ $k->rpekerjaan->jenis_usaha  }}</td>
            <td>{{ $k->rpekerjaan->jabatan  }}</td>
            <td>{{ $k->rpekerjaan->nama_atasan  }}</td>
            <td>{{ $k->rpekerjaan->nama_direktur  }}</td>
            <td>{{ $k->rpekerjaan->lama_kerja  }}</td>
            <td>{{ $k->rpekerjaan->alasan_berhenti  }}</td>
            <td>Rp {{ $k->rpekerjaan->gaji  }},- </td>
            {{-- KELUARGA  --}}
            <td>{{ $k->keluarga->status_pernikahan }}</td>
            <td>{{ $k->keluarga->nama }}</td>
            <td>{{ $k->keluarga->tgllahir }}</td>
            <td>{{ $k->keluarga->alamat }}</td>
            <td>{{ $k->keluarga->pendidikan_terakhir }}</td>
            <td>{{ $k->keluarga->pekerjaan }}</td>
            {{-- KONTAK DARURAT  --}}
            <td>{{ $k->kdarurat->nama }}</td>
            <td>{{ $k->kdarurat->alamat }}</td>
            <td>{{ $k->kdarurat->no_hp }}</td>
            <td>{{ $k->kdarurat->hubungan }}</td>
            
        </tr>
        @endforeach
{{-- 
        @foreach($keluarga as $k )
        
            <td>{{ $k->nama }}</td>
            <td>{{ $k->status_penikahan }}</td>
            <td>{{ $k->alamat }}</td>
        
        @endforeach --}}
        
       
    </tbody>
</table>