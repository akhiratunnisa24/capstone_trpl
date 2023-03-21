<!--  Modal content for the above example -->
<div class="modal fade bs-example-modal-md" id="editKeluarga{{$kel->id}}" tabindex="-1" role="dialog" aria-labelledby="editKeluarga" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">Edit Data Keluarga</h4>
            </div>
            <div class="modal-body">
                <form id="" action="/updateKeluarga/{{$kel->id}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" id="id" name="id_keluarga" value="{{$kel->id}}">
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Nama Keluarga</label>
                                    <input type="text" name="namaKeluarga" id="nama" class="form-control" autocomplete="off" value="{{$kel->nama}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label for="hubungan">Hubungan</label>
                                    <select type="text" class="form-control" id="hubungan" name="hubungankeluarga">
                                        <option value="">Pilih Hubungan</option>
                                        <option value="Ayah" @if($kel->hubungan == "Ayah") selected @endif >Ayah</option>
                                        <option value="Ibu"  @if($kel->hubungan == "Ibu") selected @endif >Ibu</option>
                                        <option value="Suami" @if($kel->hubungan == "Suami") selected @endif>Suami</option>
                                        <option value="Istri" @if($kel->hubungan == "Istri") selected @endif>Istri</option>
                                        <option value="Kakak" @if($kel->hubungan == "Kakak") selected @endif>Kakak</option>
                                        <option value="Adik" @if($kel->hubungan == "Adik") selected @endif>Adik</option>
                                        <option value="Anak" @if($kel->hubungan == "Anak") selected @endif>Anak</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Jenis Kelamin</label>
                                <select class="form-control" name="jenis_kelaminKeluarga">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-Laki" @if($kel->jenis_kelamin == "Laki-Laki") selected @endif >Laki-Laki</option>
                                    <option value="Perempuan" @if($kel->jenis_kelamin == "Perempuan") selected @endif>Perempuan</option>
                                </select>
                            </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Tanggal Lahir </label>
                                    <input type="date" name="tgllahirKeluarga"
                                    autocomplete="off" class="form-control" placeholder="yyyy/mm/dd" 
                                    value="{{ $kel->tgllahir }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Tempat Lahir</label>
                                    <input class="form-control" name="tempatlahirKeluarga" autocomplete="off" rows="9"
                                        placeholder="Masukkan Tempat Lahir" value="{{$kel->tempatlahir}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Pendidikan Terakhir</label>
                                <select class="form-control" name="pendidikan_terakhirKeluarga">
                                    <option value="">Pilih Pendidikan Terakhir</option>
                                    <option value="SD" @if($kel->pendidikan_terakhir == "SD") selected @endif >SD</option>
                                    <option value="SMP" @if($kel->pendidikan_terakhir == "SMP") selected @endif >SMP</option>
                                    <option value="SMA/K" @if($kel->pendidikan_terakhir == "SMA/K") selected @endif >SMA/K</option>
                                    <option value="D-3" @if($kel->pendidikan_terakhir == "D-3") selected @endif >D-3</option>
                                    <option value="S-1" @if($kel->pendidikan_terakhir == "S-1") selected @endif >S-1</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Pekerjaan</label>
                                    <input type="text" name="pekerjaanKeluarga" autocomplete="off" class="form-control" value="{{$kel->pekerjaan}}">
                                </div>
                            </div> 
                            
                        </div>
                    </div>
            
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="assets/pages/form-advanced.js"></script>