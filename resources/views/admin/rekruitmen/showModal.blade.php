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

                <div class="col-md-12">
                    <label><h4> B. DATA KELUARGA</h4></label>

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
                                {{-- @foreach ($k as $k) --}}
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $k->keluarga->hubungan }}</td>
                                        {{-- <td>{{ $k->keluarga->hubungan }}</td> --}}
                                        {{-- <td>{{ $k->nama}}</td>
                                        <td>{{ $k->jenis_kelamin}}</td>
                                        <td>{{ $k->tgllahir}}</td>
                                        <td>{{ $k->tempatlahir}}</td>
                                        <td>{{ $k->pendidikan_terakhir }}</td>
                                        <td>{{ $k->pekerjaan}}</td> --}}
                                    </tr>
                                {{-- @endforeach --}}
                            </tbody>
                        </table>
                   

                </div>
                


            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
