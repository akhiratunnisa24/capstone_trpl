{{-- FORM TAMBAH KATEGORI CUTI --}}
<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="Modal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel">Tambah Data Benefit</h4>
            </div>
            <div class="modal-body">
                <form action="{{route ('benefit.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group col-sm">
                                    <label class="col-form-label">Nama</label>
                                    <input type="text" class="form-control" name="nama_benefit" placeholder="Masukkan Nama Benefit"  autocomplete="off">
                                </div>
                                <div class="form-group col-sm">
                                    <label class="col-form-label">Kode</label>
                                    <input type="text" class="form-control" name="kode" placeholder="Masukkan Kode" autocomplete="off">
                                </div>
                                <div class="form-group col-sm">
                                    <label  class="col-form-label">Kategori Benefit</label>
                                    <select name="id_kategori" id="id_kategori" class="form-control selectpicker" data-live-search="true" required>
                                        <option>-- Pilih Kategori Benefit --</option>
                                        @foreach ($kategori as $data)
                                                <option value="{{ $data->id}}">
                                                {{ $data->nama_kategori }} 
                                                </option>
                                        @endforeach
                                    </select> 
                                </div>
                                <div class="form-group col-sm">
                                    <div class="checkbox-group">
                                        <label class="col-form-label">Status</label>
                                        <div class="checkboxes">
                                            <input type="checkbox" name="aktif" value="Aktif"> Aktif
                                        </div>
                                    </div>
                                </div>
                               
                            </div>

                            <div class="col-md-6">
                                <div class="form-group col-sm">
                                    <label  class="col-form-label">Siklus Pembayaran</label>
                                    <select name="siklus_pembayaran" class="form-control selectpicker" data-live-search="true" required>
                                        <option value="">-- Pilih Siklus --</option>
                                        <option value="Bulanan">Bulanan</option>
                                        <option value="Mingguan">Mingguan</option>
                                        <option value="Harian">Harian</option>
                                    </select> 
                                </div>
                                <div class="form-group col-sm">
                                    <div class="checkbox-group">
                                        <label class="col-form-label">Dikenakan Pajak </label>
                                        <div class="checkboxes">
                                            <input type="checkbox" name="dikenakan_pajak" value="Ya"> Ya
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm m-t-30">
                                    <label  class="col-form-label">Kelas Pajak </label>
                                    <select name="kelas_pajak" class="form-control selectpicker" data-live-search="true" required>
                                        <option value="">-- Pilih Kelas Pajak --</option>
                                        <option value="Penghasilan Teratur">Penghasilan Teratur</option>
                                        <option value="Penghasilan Tidak Teratur">Penghasilan Tidak Teratur</option>
                                    </select> 
                                </div>
                                <div class="form-group col-sm">
                                    <div class="checkbox-group">
                                        <label class="col-form-label">Muncul Di Penggajian</label>
                                        <div class="checkboxes">
                                            <input type="checkbox" name="muncul_dipenggajian" value="Ya"> Ya
                                        </div>
                                    </div>
                                </div>
                                
                            </div>

                            <input id="partner" type="hidden" class="form-control" name="partner" value="{{Auth::user()->partner}}" autocomplete="off" >
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success waves-effect waves-light" name="submit"
                            value="save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>