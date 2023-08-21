<div class="modal fade" id="show{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="Modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel">Edit Data Benefit</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped">
                    <div class="col-md-12">
                        <div class="row">
                            <div>
                                <div
                                    class="modal-header bg-info panel-heading  col-sm-15 m-b-5">
                                </div>
                            </div>
        
                        </div>
        
                        <div class="col-md-6 m-t-10">
                            <div class="mb-3">
                                <div class="row">
                                    <label class="form-label col-sm-5 text-end">Nama</label>
                                    <div class="col-sm-7">
                                        : {{ $data->nama_benefit }}
                                    </div>
                                </div>
                            </div>
                        </div>
        
                        <div class="col-md-6 m-t-10">
                            <div class="mb-3">
                                <div class="row">
                                    <label
                                        class="form-label col-sm-5 text-end">Kode</label>
                                    <div class="col-sm-7">
                                        : {{ $data->kode }}
                                    </div>
                                </div>
                            </div>
                        </div>
        
                        <div class="col-md-6 m-t-10">
                            <div class="mb-3">
                                <div class="row">
                                    <label class="form-label col-sm-5 text-end">Tanggal
                                        Masuk</label>
                                    <div class="col-sm-7">
                                        :  
                                    </div>
                                </div>
                            </div>
                        </div>
        
                        <div class="col-md-6 m-t-10">
                            <div class="mb-3">
                                <div class="row">
                                    <label class="form-label col-sm-5 text-end">Jabatan</label>
                                    <div class="col-sm-7">
                                        : 
                                    </div>
                                </div>
                            </div>
                        </div>
        
                        <div class="col-md-6 m-t-10">
                            <div class="mb-3">
                                <div class="row">
                                    <label class="form-label col-sm-5 text-end">Tanggal
                                        Keluar</label>
                                    <div class="col-sm-7">
                                        {{-- @if ()
                                           
                                        @else
                                            : -
                                        @endif --}}
                                    </div>
                                </div>
                            </div>
                        </div>
        
                        <div class="col-md-6 m-t-10">
                            <div class="mb-3">
                                <div class="row">
                                    <label class="form-label col-sm-5 text-end">Tipe
                                        Kontrak</label>
                                    <div class="col-sm-7">
                                        : Kontrak / Pekerja Tetap
                                    </div>
                                </div>
                            </div>
                        </div>
        
                        <div class="col-md-6 m-t-10">
                            <div class="mb-3">
                                <div class="row">
                                    <label class="form-label col-sm-5 text-end">Struktur
                                        Gaji</label>
                                    <div class="col-sm-7">
                                        : Bulanan/Mingguan/Harian
                                    </div>
                                </div>
                            </div>
                        </div>
        
                    </div>
                </table>
                <div class="modal-footer m-t-30">
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success waves-effect waves-light" name="submit"
                        value="save">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>
