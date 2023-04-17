<?php
use App\Models\Karyawan;
use App\Models\Izin;
use App\Models\Status;
use Illuminate\Support\Facades\DB;
?>
<table>
    <thead>
        <tr>
            <th>Emp No.</th>
            <th>Nama</th>
            <th>Keperluan</th>
            <th>Tanggal Mulai</th>
            <th>Tanggal Selesai</th>
            <th>Jam Mulai</th>
            <th>Jam Selesai</th>
            <th>Jumlah Jam</th>
            <th>Status</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($izin as $data)
            <tr>
                <td>{{ $data->id_karyawan }}</td>
                <td>{{ $data->karyawans->nama }}</td>
                <td>{{ $data->keperluan }}</td>
                <td>{{ $data->tgl_mulai }}</td>
                <td>{{ $data->tgl_selesai }}</td>
                <td>{{ $data->jam_mulai }}</td>
                <td>{{ $data->jam_selesai }}</td>
                <td>{{ $data->jml_jam }}</td>
                <td>
                    <span class="badge badge-{{ $data->status == 1 ? 'warning' : ($data->status == 2 ? 'info' : ($data->status == 5 ? 'danger' : ($data->status == 6 ? 'secondary' : ($data->status == 7 ? 'success' : ($data->status == 9 ? 'danger' : ($data->status == 10 ? 'danger' : ($data->status == 11 ? 'warning' : ($data->status == 12 ? 'secondary' : ($data->status == 13 ? 'success' : ($data->status == 14 ? 'warning' :($data->status == 15 ? 'primary' : ($data->status == 16 ? 'primary' :  'secondary' )))))))))))) }}">
                        {{ $data->status == 1 ? $data->name_status : ($data->status == 2 ?  $data->name_status : ($data->status == 5 ?  $data->name_status : ($data->status == 6 ?  $data->name_status : ($data->status == 7 ?  $data->name_status : ($data->status == 9 ?  $data->name_status : ($data->status == 10 ?  $data->name_status : ($data->status == 11 ?  $data->name_status : ($data->status == 12 ?  $data->name_status : ($data->status == 13 ?  $data->name_status :  ($data->status == 14 ?  $data->name_status :  ($data->status == 15 ?  $data->name_status :  ($data->status == 16 ?  $data->name_status : '')))))))))))) }}
                    </span>
                </td>


            </tr>
        @endforeach
    </tbody>
</table>
