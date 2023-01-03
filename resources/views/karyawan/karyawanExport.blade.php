<?php

use Illuminate\Support\Facades\Auth;
use App\Models\Karyawan;
use App\Models\Kdarurat;
use App\Models\Keluarga;
use App\Models\Rpekerjaan;
use App\Models\Rpendidikan;
use Illuminate\Support\Facades\DB;

?>

<h2>Data Karyawan</h2>
<table>
    <thead>
        <tr>
            <th>NIP</th>
            <th>NIK</th>
            <th>Nama</th>
            <th>Nama Keluarga</th>
            <th>Nama Keluarga</th>
            <th>Nama Keluarga</th>
        </tr>
    </thead>
    <tbody>
        @foreach($karyawan as $k )
        <tr>
            <td>{{ $k->nip }}</td>
            <td>{{ $k->nik }}</td>
            <td>{{ $k->nama }}</td>
        </tr>
        @endforeach

        @foreach($keluarga as $k )
        <tr>
            <td>{{ $k->nama }}</td>
            <td>{{ $k->status_penikahan }}</td>
            <td>{{ $k->nama }}</td>
        </tr>
        @endforeach
        
       
    </tbody>
</table>