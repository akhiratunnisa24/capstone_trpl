<?php
    use App\Models\Karyawan;
    use App\Models\Absensi;
    use App\Models\Departemen;
    use Illuminate\Support\Facades\DB;
?>
<table>
    <thead>
        <style>
            .th {
                font-weight: bold;
            }
        </style>
        <tr>
            <th>Emp No.</th>
            <th>No. ID</th>
            <th>NIK</th>
            <th>Nama</th>
            {{-- <th>Auto-Assign</th> --}}
            <th>Tanggal</th>
            <th>Jam Kerja</th>
            <th>Jam Masuk</th>
            <th>Jam Pulang</th>
            <th>Scan Masuk</th>
            <th>Scan Pulang</th>
            {{-- <th>Normal</th>
            <th>Riil</th> --}}
            <th>Terlambat</th>
            <th>Plg. Cepat</th>
            <th>Absent</th>
            <th>Lembur</th>
            <th>Jml Jam Kerja</th>
            {{-- <th>Pengecualian</th>
            <th>Harus C/In</th>
            <th>Harus C/Out</th> --}}
            <th>Departemen</th>
            {{-- <th>Hari Normal</th>
            <th>Akhir Pekan</th>
            <th>Hari Libur</th> --}}
            <th>Jml Kehadiran</th>
            {{-- <th>Lembur Hari Normal</th>
            <th>Lembur Akhir Pekan</th>
            <th>Lembur Hari Libur</th> --}}
        </tr>
    </thead>
    <tbody>
        @foreach($absensi as $data)
        <tr>
            <td>{{ $data->id_karyawan}}</td>
            <td>{{ $data->id}}</td>
            <td>{{ $data->nik }}</td>
            <td>{{ $data->karyawans->nama}}</td>
            {{-- <td></td> --}}
            <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d/m/Y')}}</td>
            <td>{{ $data->shift }}</td>
            <td>{{ $data->jadwal_masuk }}</td>
            <td>{{ $data->jadwal_pulang }}</td>
            <td>{{ $data->jam_masuk }}</td>
            <td>{{ $data->jam_keluar }}</td>
            {{-- <td>{{ $data->normal }}</td>
            <td>{{ $data->riil }}</td> --}}
            <td>{{ $data->terlambat }}</td>
            <td>{{ $data->plg_cepat }}</td>
            <td>{{ $data->absent }}</td>
            <td>{{ $data->lembur }}</td>
            <td>{{ $data->jml_jamkerja }}</td>
            {{-- <td>{{ $data->pengecualian }}</td> --}}
            {{-- <td>{{ $data->hci }}</td>
            <td>{{ $data->hco }}</td> --}}
            <td>
                @if ($data->departemens)
                    {{ $data->departemens->nama_departemen }}
                 @endif
            </td>
            {{-- <td>{{ $data->departemens->nama_departemen }}</td> --}}
            {{-- <td>{{ $data->h_normal }}</td>
            <td>{{ $data->ap }}</td>
            <td>{{ $data->hl }}</td> --}}
            <td>{{ $data->jam_kerja }}</td>
            {{-- <td>{{ $data->lemhanor }}</td>
            <td>{{ $data->lemakpek }}</td>
            <td>{{ $data->lemhali  }}</td> --}}
        </tr>
        @endforeach
    </tbody>
</table>