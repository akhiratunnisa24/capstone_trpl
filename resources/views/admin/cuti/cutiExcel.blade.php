<?php
use App\Models\Karyawan;
use App\Models\Cuti;
use App\Models\Status;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
?>
<table>
    @php 
        $year = Carbon::now()->year;
    @endphp
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
            <th>Tanggal Mulai Kerja</th>
            <th>Jatuh Tempo Pengambilan Hak Cuti</th>
            <th>Tanggal Pelaksanaan Cuti</th>
            <th>Kategori Cuti</th>
            <th>Jumlah Hari Kerja</th>
            <th>Saldo Hak Cuti {{$year}}</th>
            <th>Jumlah Cuti {{$year}}</th>
            <th>Sisa Cuti {{$year}}</th>
            <th>Keterangan</th>
            <th>Status</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($cuti as $data)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $data->nik }}</td>
                <td>{{ $data->karyawans->nama }}</td>
                <td>{{ $data->jabatan }}</td>
                <td>{{ $data->departemens->nama_departemen }}</td>
                <td>
                        {{ \Carbon\Carbon::parse($data->tgl_permohonan)->format("d/m/Y") }}
                </td>
                <td>
                    @if($data->alokasi->tgl_masuk !== NULL)
                    {{ carbon::parse($data->alokasi->tgl_masuk)->format("d/m/Y")}}
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if($data->alokasi->jatuhtempo_awal != NULL)
                        {{ Carbon::parse($data->alokasi->jatuhtempo_awal)->format("d/m/Y")}} s.d  {{Carbon::parse($data->alokasi->jatuhtempo_akhir)->format("d/m/Y")}}
                    @else
                        -
                    @endif
                </td>
                <td>{{ Carbon::parse($data->tgl_mulai)->format("d/m/Y")}} @if($data->tgl_selesai !== NULL) s.d  {{Carbon::parse($data->tgl_selesai)->format("d/m/Y")}} @endif</td>
                <td>{{ $data->jeniscuti->jenis_cuti }}</td>
                <td>{{ $data->jmlharikerja }}</td>
                <td>
                    @if($data->saldohakcuti !== NULL)
                        {{ $data->saldohakcuti }}
                    @else
                    -
                    @endif
                </td>
                <td>
                    @if($data->saldohakcuti !== NULL)
                        {{ $data->saldohakcuti }}
                    @else
                    -
                    @endif
                </td>
                <td>
                    @if($data->sisacuti !== NULL)
                        {{ $data->sisacuti }}
                    @else
                    -
                    @endif
                </td>
                <td>{{ $data->keterangan }}</td>
                <td>
                    <span class="badge badge-{{ $data->status == 1 ? 'warning' : ($data->status == 2 ? 'info' : ($data->status == 5 ? 'danger' : ($data->status == 6 ? 'secondary' : ($data->status == 7 ? 'success' : ($data->status == 9 ? 'danger' : ($data->status == 10 ? 'danger' : ($data->status == 11 ? 'warning' : ($data->status == 12 ? 'secondary' : ($data->status == 13 ? 'success' : ($data->status == 14 ? 'warning' :($data->status == 15 ? 'primary' : ($data->status == 16 ? 'primary' :  'secondary' )))))))))))) }}">
                        {{ $data->status == 1 ? $data->name_status : ($data->status == 2 ?  $data->name_status : ($data->status == 5 ?  $data->name_status : ($data->status == 6 ?  $data->name_status : ($data->status == 7 ?  $data->name_status : ($data->status == 9 ?  $data->name_status : ($data->status == 10 ?  $data->name_status : ($data->status == 11 ?  $data->name_status : ($data->status == 12 ?  $data->name_status : ($data->status == 13 ?  $data->name_status :  ($data->status == 14 ?  $data->name_status :  ($data->status == 15 ?  $data->name_status :  ($data->status == 16 ?  $data->name_status : '')))))))))))) }}
                    </span>
                </td>


            </tr>
        @endforeach
    </tbody>
</table>
