<?php
use App\Models\Karyawan;
use App\Models\Izin;
use App\Models\Status;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
?>
<table>
    <style>
        .th {
            font-weight: bold;
        }
    </style>
    <thead>
        <tr>
            <th>No</th>
            <th>NIK</th>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Divisi/Departemen</th>
            <th>Tanggal Permohonan</th>
            <th>Kategori</th>
            <th>Tanggal Ketidakhadiran</th>
            <th>Jam Izin</th>
            <th>Jumlah Jam</th>
            <th>Catatan</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($izin as $data)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $data->nik }}</td>
                <td>{{ $data->nama }}</td>
                <td>{{ $data->jabatan }}</td>
                <td>{{ $data->nama_departemen }}</td>
                <td>{{ \Carbon\Carbon::parse($data->tgl_permohonan)->format("d/m/Y") }}</td>
                <td>{{ $data->jenis_izin }}</td>
                <td>{{ Carbon::parse($data->tgl_mulai)->format("d/m/Y")}} @if($data->tgl_selesai !== NULL) s.d  {{Carbon::parse($data->tgl_selesai)->format("d/m/Y")}} @endif</td>
                <td>{{ Carbon::parse($data->jam_mulai)->format("H:i")}} @if($data->jam_selesai !== NULL) s.d  {{Carbon::parse($data->jam_selesai)->format("H:i")}} @endif</td>
                <td>{{ Carbon::parse($data->jml_jam)->format("H:i")}}</td>
                <td>{{ $data->catatan }}</td>
                <td>
                    <span class="badge badge-{{ $data->status == 1 ? 'warning' : ($data->status == 2 ? 'info' : ($data->status == 5 ? 'danger' : ($data->status == 6 ? 'secondary' : ($data->status == 7 ? 'success' : ($data->status == 9 ? 'danger' : ($data->status == 10 ? 'danger' : ($data->status == 11 ? 'warning' : ($data->status == 12 ? 'secondary' : ($data->status == 13 ? 'danger' : ($data->status == 14 ? 'warning' :($data->status == 15 ? 'primary' : ($data->status == 16 ? 'primary' :  'secondary' )))))))))))) }}">
                        {{ $data->status == 1 ? $data->name_status : ($data->status == 2 ?  $data->name_status : ($data->status == 5 ?  $data->name_status : ($data->status == 6 ?  $data->name_status : ($data->status == 7 ?  $data->name_status : ($data->status == 9 ?  $data->name_status : ($data->status == 10 ?  $data->name_status : ($data->status == 11 ?  $data->name_status : ($data->status == 12 ?  $data->name_status : ($data->status == 13 ?  $data->name_status :  ($data->status == 14 ?  $data->name_status :  ($data->status == 15 ?  $data->name_status :  ($data->status == 16 ?  $data->name_status : '')))))))))))) }}
                    </span>
                </td>


            </tr>
        @endforeach
    </tbody>
</table>
