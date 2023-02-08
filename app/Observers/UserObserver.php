<?php

namespace App\Observers;

use App\Models\Karyawan;

class UserObserver
{
    public function deleting(User $user)
{
    $karyawan = Karyawan::where('id_pegawai', $user->id_pegawai)->first();

    if ($karyawan && $karyawan->status_kerja === 'Non-Aktif') {
        $user->delete();
    }
}
}
