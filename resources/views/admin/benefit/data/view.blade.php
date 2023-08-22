<div class="modal fade" id="show{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="show" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="show">Detail Benefit</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6 m-t-10">
                            <div class="mb-3">
                                <div class="row">
                                    <label class="form-label col-sm-5 text-end">Nama</label>
                                    <div class="col-sm-7">
                                        : {{ $data->nama_benefit }}
                                    </div>
                                </div>
                            </div>
                             <div class="mb-3">
                                <div class="row">
                                    <label class="form-label col-sm-5 text-end">Kategori</label>
                                    <div class="col-sm-7">
                                        :  {{ $data->kategoribenefits->nama_kategori }}
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <label
                                        class="form-label col-sm-5 text-end">Kode</label>
                                    <div class="col-sm-7">
                                        : {{ $data->kode }}
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <label class="form-label col-sm-5 text-end">Siklus Pembayaran</label>
                                    <div class="col-sm-7">
                                        : {{ $data->siklus_pembayaran }}
                                    </div>
                                </div>
                            </div>
                            @if($data->siklus_pembayaran == "Bulan")
                                <div class="mb-3">
                                    <div class="row">
                                        <label class="form-label col-sm-5 text-end">Nominal/Bulan</label>
                                        <div class="col-sm-7">
                                            : Rp. {{ number_format($data->besaran_bulanan, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                            @elseif($data->siklus_pembayaran == "Minggu")
                                <div class="mb-3">
                                    <div class="row">
                                        <label class="form-label col-sm-5 text-end">Nominal/Minggu</label>
                                        <div class="col-sm-7">
                                            : Rp. {{ number_format($data->besaran_mingguan, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                            @elseif($data->siklus_pembayaran == "Hari")
                                <div class="mb-3">
                                    <div class="row">
                                        <label class="form-label col-sm-5 text-end">Nominal/Hari</label>
                                        <div class="col-sm-7">
                                            : Rp. {{ number_format($data->besaran_harian, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                            @elseif($data->siklus_pembayaran == "Jam")
                                <div class="mb-3">
                                    <div class="row">
                                        <label class="form-label col-sm-5 text-end">Nominal/Jam</label>
                                        <div class="col-sm-7">
                                            : Rp. {{ number_format($data->besaran_jam, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="mb-3">
                                    <div class="row">
                                        <label class="form-label col-sm-5 text-end">Nominal</label>
                                        <div class="col-sm-7">
                                            : Rp. {{ number_format($data->besaran, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-6 m-t-10">
                            <div class="mb-3">
                                <div class="row">
                                    <label class="form-label col-sm-5 text-end">Status</label>
                                    <div class="col-sm-7">
                                        : {{$data->aktif}}
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <label class="form-label col-sm-5 text-end">Dikenakan Pajak</label>
                                    <div class="col-sm-7">
                                        : {{$data->dikenakan_pajak}}
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <label class="form-label col-sm-5 text-end">Kelas Pajak</label>
                                    <div class="col-sm-7">
                                        : {{$data->kelas_pajak}}
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <label class="form-label col-sm-5 text-end">Tipe</label>
                                    <div class="col-sm-7">
                                        : {{$data->tipe}}
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <label class="form-label col-sm-5 text-end">Muncul di Penggajian</label>
                                    <div class="col-sm-7">
                                        : {{$data->muncul_dipenggajian}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
