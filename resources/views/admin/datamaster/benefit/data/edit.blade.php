<div class="modal fade" id="edit{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="Modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel"Edit Data Benefit</h4>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUTT')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group col-sm">
                                    <label class="col-form-label">Nama</label>
                                    <input type="text" class="form-control" value="{{$data->nama_benefit}}" name="nama_benefit" placeholder="Masukkan Nama Benefit"  autocomplete="off">
                                </div>
                                <div class="form-group col-sm">
                                    <label  class="col-form-label">Kategori Benefit</label>
                                    <select name="id_kategori" id="id_kategori" class="form-control selectpicker" data-live-search="true" >
                                        <option>-- Pilih Kategori Benefit --</option>
                                        @foreach ($kategori as $kategoriData)
                                            <option value="{{ $kategoriData->id }}" @if($data->id_kategori == $kategoriData->id) selected @endif>
                                                {{ $kategoriData->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select> 
                                </div>
                                
                                <div class="form-group col-sm">
                                    <label  class="col-form-label">Tipe Pembayaran</label>
                                    <select name="siklus_pembayaran" class="form-control selectpicker" data-live-search="true">
                                        <option value="">-- Pilih Siklus --</option>
                                        <option value="Bulan" @if($data->siklus_pembayaran == 'Bulan') selected @endif>Bulan</option>
                                        <option value="Minggu" @if($data->siklus_pembayaran == 'Minggu') selected @endif>Minggu</option>
                                        <option value="Hari" @if($data->siklus_pembayaran == 'Hari') selected @endif>Hari</option>
                                        <option value="THR" @if($data->siklus_pembayaran == 'THR') selected @endif>THR</option>
                                        <option value="Bonus" @if($data->siklus_pembayaran == 'Bonus') selected @endif>Bonus</option>
                                    </select>                                    
                                </div>
                                <div class="form-group col-sm">
                                    <label class="col-form-label">Kode</label>
                                    <input type="text" class="form-control" name="kode" value="{{$data->kode}}" placeholder="Masukkan Kode" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group col-sm">
                                    <div class="checkbox-group">
                                        <label class="col-form-label">Status</label>
                                        <div class="checkboxes">
                                            <input type="checkbox" name="aktif" value="Aktif" style="margin-left:98px" @if($data->aktif) checked @endif> Aktif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm">
                                    <div class="checkbox-group">
                                        <label class="col-form-label">Dikenakan Pajak</label>
                                        <div class="checkboxes">
                                            <input type="checkbox" name="dikenakan_pajak" value="Ya" style="margin-left:35px" @if($data->dikenakan_pajak) checked @endif> Ya
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm">
                                    <label class="col-form-label">Kelas Pajak</label>
                                    <select name="kelas_pajak" class="form-control selectpicker" data-live-search="true">
                                        <option value="">-- Pilih Kelas Pajak --</option>
                                        <option value="Penghasilan Teratur" @if($data->kelas_pajak == 'Penghasilan Teratur') selected @endif>Penghasilan Teratur</option>
                                        <option value="Penghasilan Tidak Teratur" @if($data->kelas_pajak == 'Penghasilan Tidak Teratur') selected @endif>Penghasilan Tidak Teratur</option>
                                    </select>
                                </div>

                                <div class="form-group col-sm">
                                    <label class="col-form-label">Tipe</label>
                                    <select name="tipe" class="form-control selectpicker" data-live-search="true">
                                        <option value="">-- Pilih Tipe --</option>
                                        <option value="Komponen Tetap" @if($data->tipe == 'Komponen Tetap') selected @endif>Komponen Tetap</option>
                                        <option value="Komponen Tidak Tetap" @if($data->tipe == 'Komponen Tidak Tetap') selected @endif>Komponen Tidak Tetap</option>
                                    </select>
                                </div>

                                <div class="form-group col-sm m-b-30">
                                    <div class="checkbox-group">
                                        <label class="col-form-label">Muncul Di Penggajian</label>
                                        <div class="checkboxes">
                                            <input type="checkbox" name="muncul_dipenggajian" value="Ya" @if($data->muncul_dipenggajian) checked @endif> Ya
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <input id="partner" type="hidden" class="form-control" name="partner" value="{{Auth::user()->partner}}" autocomplete="off" >
                    <div class="modal-footer m-t-30">
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success waves-effect waves-light" name="submit"
                            value="save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>