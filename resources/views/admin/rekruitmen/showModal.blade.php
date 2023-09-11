<div id="myModal{{ $k->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="Showcuti">Detail Data Pelamar</h4>
            </div>
            <div class="modal-body row">

                <div class="col-md-12">
                    <label class="">
                        <h4> A. DATA DIRI</h4>
                    </label>
                </div>

                {{-- BARIS KIRI --}}
                <div class="col-md-6">

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">NIK Pelamar</label>
                        <div class="col-sm-9">
                            <label>: {{ $k->nik ?? '' }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-9">
                            <label>: {{ $k->nama ?? '' }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="tgl_mulai" class="col-sm-3 col-form-label">Tanggal Lahir</label>
                        <div class="col-sm-9">
                            <label>: {{ \Carbon\Carbon::parse($k->tgllahir ?? '')->format('d/m/Y') }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Tempat Lahir</label>
                        <div class="col-sm-9">
                            <label>: {{ $k->tempatlahir ?? '' }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-9">
                            @if ($k->jenis_kelamin == 'P')
                                <label>: Perempuan</label>
                            @else
                                <label>: Laki-Laki</label>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Agama</label>
                        <div class="col-sm-9">
                            <label>: {{ $k->agama ?? '' }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Golongan Darah</label>
                        <div class="col-sm-9">
                            <label>: {{ $k->gol_darah ?? '' }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Alamat</label>
                        <div class="col-sm-9">
                            <label>: {{ $k->alamat ?? '' }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <label>: {{ $k->email ?? '' }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Gaji yang diajukan</label>
                        <div class="col-sm-9">
                            <label>: Rp.{{ $k->gaji ?? '' }},-</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">CV</label>
                        <div class="col-sm-9">
                            <label>: {{ $k->cv ?? 'CV Tidak Ada' }}</label>
                            <a href="{{ asset('pdf/' . $k->cv) }}" class="btn btn-sm btn-primary" target='_blank'>Lihat
                                CV</a>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="status" class="col-sm-3 col-form-label">Status Lamaran</label>
                        <div class="col-sm-9">
                            @if ($k->status_lamaran == '6')
                                <span class="badge badge-success">Diterima</span>
                            @else
                                <span class="badge badge-info">{{ $k->mrekruitmen->nama_tahapan }}</span>
                            @endif
                        </div>
                    </div>

                </div>
                {{-- BARIS KANAN --}}
                <div class="col-md-6">

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">No. Handphone</label>
                        <div class="col-sm-9">
                            <label>: {{ $k->no_hp ?? '' }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">No. Kartu Keluarga</label>
                        <div class="col-sm-9">
                            <label>: {{ $k->no_kk ?? '' }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">No. NPWP</label>
                        <div class="col-sm-9">
                            <label>: {{ $k->no_npwp ?? '' }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">No. BPJS Ketenagakerjaan</label>
                        <div class="col-sm-9">
                            <label>: {{ $k->no_bpjs_ket ?? '' }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">No. BPJS Kesehatan</label>
                        <div class="col-sm-9">
                            <label>: {{ $k->no_bpjs_kes ?? '' }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">No. Program ASKES</label>
                        <div class="col-sm-9">
                            <label>: {{ $k->no_program_askes ?? '' }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">No. Asuransi AKDHK</label>
                        <div class="col-sm-9">
                            <label>: {{ $k->no_akdhk ?? '' }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">No. Program Pensiun</label>
                        <div class="col-sm-9">
                            <label>: {{ $k->no_program_pensiun ?? '' }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Bank</label>
                        <div class="col-sm-9">
                            <label>: {{ $k->nama_bank ?? '' }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">No. Rekening</label>
                        <div class="col-sm-9">
                            <label>: {{ $k->no_rek ?? '' }}</label>
                        </div>
                    </div>

                </div>

                {{-- <div class="col-md-12">
                    <label>
                        <h4> B. RIWAYAT PENDIDIKAN</h4>
                    </label>

                    <table class="table table-striped">
                        <br>
                        <label class="text-white badge bg-info">Pendidikan Formal</label>
                        <thead class="alert alert-info">
                            <tr>
                                <th>No</th>
                                <th>Tingkat</th>
                                <th>Nama Sekolah</th>
                                <th>Alamat</th>
                                <th>Jurusan</th>
                                <th>Tahun Lulus</th>
                                <th>Nomor Ijazah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataPendidikan as $k)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $k->tingkat ?? '' }}</td>
                                    <td>{{ $k->nama_sekolah ?? '' }}</td>
                                    <td>{{ $k->kota_pformal ?? '' }}</td>
                                    <td>{{ $k->jurusan ?? '' }}</td>
                                    <td>{{ $k->tahun_lulus_formal ?? '' }}</td>
                                    <td>{{ $k->ijazah_formal ?? '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <table class="table table-striped">
                        <label class="text-white badge bg-info">Pendidikan Non Formal</label>
                        <thead class="alert alert-info">
                            <tr>
                                <th>No</th>
                                    <th>Jenis/Bidang Pendidikan</th>
                                    <th>Lembaga Pendidikan</th>
                                    <th>Alamat</th>
                                    <th>Tahun Lulus</th>
                                    <th>Nomor Ijazah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataPendidikan as $k)
                            @if ($k->jenis_pendidikan != null)
                                <tr>
                                    <td>{{ $loop->iteration ?? '' }}</td>
                                    <td>{{ $k->jenis_pendidikan ?? '' }}</td>
                                    <td>{{ $k->nama_lembaga ?? '' }}</td>
                                    <td>{{ $k->kota_pnonformal ?? '' }}</td>
                                    <td>{{ $k->tahun_lulus_nonformal ?? '' }}</td>
                                    <td>{{ $k->ijazah_nonformal ?? '' }}</td>
                                </tr>
                                    @endif
                            @endforeach
                        </tbody>
                    </table>

                </div>

                <div class="col-md-12">
                    <label>
                        <h4> C. RIWAYAT PEKERJAAN</h4>
                    </label>

                    <table class="table table-striped">
                        <thead class="alert alert-info">
                            <tr>
                                <th>No</th>
                                    <th>Nama Perusahaan</th>
                                    <th>Alamat</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Tanggal Keluar</th>
                                    <th>Jabatan</th>
                                    <th>Level</th>
                                    <th>Gaji</th>
                                    <th>Alasan Berhenti</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataPekerjaan as $k)
                                <tr>
                                    <td>{{ $loop->iteration ?? '' }}</td>
                                    <td>{{ $k->nama_perusahaan ?? '' }}</td>
                                    <td>{{ $k->alamat ?? '' }}</td>
                                    <td>{{ $k->tgl_mulai ?? '' }}</td>
                                    <td>{{ $k->tgl_selesai ?? '' }}</td>
                                    <td>{{ $k->jabatan ?? '' }}</td>
                                    <td>{{ $k->level ?? '' }}</td>
                                    <td>{{ $k->gaji ?? '' }}</td>
                                    <td>{{ $k->alasan_berhenti ?? '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

                <div class="col-md-12">
                    <label>
                        <h4> D. RIWAYAT ORGANISASI</h4>
                    </label>

                    <table class="table table-striped">
                        <thead class="alert alert-info">
                            <tr>
                                <th>No</th>
                                    <th>Nama Organisasi</th>
                                    <th>Alamat</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Tanggal Keluar</th>
                                    <th>Jabatan</th>
                                    <th>Nomor SK</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataOrganisasi as $k)
                                <tr>
                                    <td>{{ $loop->iteration ?? '' }}</td>
                                    <td>{{ $k->nama_organisasi ?? '' }}</td>
                                    <td>{{ $k->alamat ?? '' }}</td>
                                    <td>{{ $k->tgl_mulai ?? '' }}</td>
                                    <td>{{ $k->tgl_selesai ?? '' }}</td>
                                    <td>{{ $k->jabatan ?? '' }}</td>
                                    <td>{{ $k->no_sk ?? '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

                <div class="col-md-12">
                    <label>
                        <h4> E. RIWAYAT PRESTASI</h4>
                    </label>

                    <table class="table table-striped">
                        <thead class="alert alert-info">
                            <tr> 
                                <th>No</th>
                                    <th>Perihal / Keterangan</th>
                                    <th>Instansi Pemberi</th>
                                    <th>Alamat</th>
                                    <th>Nomor Surat / Sertifikat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataPrestasi as $k)
                                <tr>
                                    <td>{{ $loop->iteration ?? '' }}</td>
                                    <td>{{ $k->keterangan ?? '' }}</td>
                                    <td>{{ $k->nama_instansi ?? '' }}</td>
                                    <td>{{ $k->alamat ?? '' }}</td>
                                    <td>{{ $k->tgl_selesai ?? '' }}</td>
                                    <td>{{ $k->no_surat ?? '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

                <div class="col-md-12">
                    <label>
                        <h4> F. DATA KELUARGA & TANGGUNGAN</h4>
                    </label>

                    <table class="table table-striped">
                        <thead class="alert alert-info">
                            <tr>
                                <th>No</th>
                                <th>Hubungan</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>Tanggal Lahir</th>
                                <th>Kota Kelahiran</th>
                                <th>Pendidikan Terakhir</th>
                                <th>Pekerjaan</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataKeluarga as $k)
                                <tr>
                                    <td>{{ $loop->iteration ?? '' }}</td>
                                    <td>{{ $k->hubungan ?? '' }}</td>
                                    <td>{{ $k->nama ?? '' }}</td>
                                    <td>{{ $k->jenis_kelamin ?? '' }}</td>
                                    <td>{{ $k->tgllahir ?? '' }}</td>
                                    <td>{{ $k->tempatlahir ?? '' }}</td>
                                    <td>{{ $k->pendidikan_terakhir ?? '' }}</td>
                                    <td>{{ $k->pekerjaan ?? '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

                

                <div class="col-md-12">
                    <label>
                        <h4> G. KONTAK DARURAT</h4>
                    </label>

                    <table class="table table-striped">
                        <thead class="alert alert-info">
                            <tr> 
                                <th>No</th>
                                    <th>Nama</th>
                                    <th>No HP</th>
                                    <th>Alamat</th>
                                    <th>Hubungan Keluarga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataKdarurat as $k)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $k->nama ?? '' }}</td>
                                    <td>{{ $k->no_hp ?? '' }}</td>
                                    <td>{{ $k->alamat ?? '' }}</td>
                                    <td>{{ $k->hubungan ?? '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div> --}}



            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
