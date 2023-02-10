<?php
    use App\Models\Karyawan;
    use App\Models\Absensi;
    use App\Models\Departemen;
    use Illuminate\Support\Facades\DB;
?>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Emp. ID</th>
            <th>Nama</th>
            <th>Departemen</th>
            <th>Tanggal</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tidakmasuk as $data)
        <tr>
            <td>{{ $loop->iteration}}</td>
            <td>{{ $data->id_pegawai}}</td>
            <td>{{ $data->nama}}</td>
            <td>
                @if ($data->departemen)
                    {{ $data->departemen->nama_departemen }}
                 @endif
            </td>
            <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d/m/Y')}}</td>
            <td>{{ $data->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>