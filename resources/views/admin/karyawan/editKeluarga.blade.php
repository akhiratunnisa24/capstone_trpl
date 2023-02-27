<!--  Modal content for the above example -->
<div class="modal fade bs-example-modal-md" id="editKeluarga{{$keluarga->id}}" tabindex="-1" role="dialog" aria-labelledby="editKeluarga" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">Edit Data Keluarga</h4>
            </div>
            <div class="modal-body">
                <form id="" action="/updateKeluarga/{{$keluarga->id}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" id="id" name="id_keluarga" value="{{$keluarga->id}}">
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Nama Keluarga</label>
                                    <input type="text" name="namaPasangan" id="nama" class="form-control" autocomplete="off" value="{{$keluarga->nama}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Tanggal Lahir </label>
                                    <input type="text" name="tgllahirPasangan"
                                    autocomplete="off" class="form-control" placeholder="yyyy/mm/dd" id="datepicker-autoclosee" 
                                    value="{{\Carbon\Carbon::parse($keluarga->tgllahir)->format('Y/m/d')}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label for="hubungan">Hubungan</label>
                                    <select type="text" class="form-control" id="hubungan" name="hubungan">
                                        <option value="">Pilih Hubungan</option>
                                        <option value="Ayah" @if($keluarga->hubungan == "Ayah") selected @endif >Ayah</option>
                                        <option value="Ibu"  @if($keluarga->hubungan == "Ibu") selected @endif >Ibu</option>
                                        <option value="Suami" @if($keluarga->hubungan == "Suami") selected @endif>Suami</option>
                                        <option value="Istri" @if($keluarga->hubungan == "Istri") selected @endif>Istri</option>
                                        <option value="Kakak" @if($keluarga->hubungan == "Kakak") selected @endif>Kakak</option>
                                        <option value="Adik" @if($keluarga->hubungan == "Adik") selected @endif>Adik</option>
                                        <option value="Anak" @if($keluarga->hubungan == "Anak") selected @endif>Anak</option>
                                    </select>
                                
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Pendidikan Terakhir</label>
                                    <input type="text" name="pendidikan_terakhirPasangan" autocomplete="off" class="form-control" value="{{$keluarga->pendidikan_terakhir}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Alamat</label>
                                    <input type="text" name="alamatPasangan" class="form-control" autocomplete="off" value="{{$keluarga->alamat}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Pekerjaan</label>
                                    <input type="text" name="pekerjaanPasangan" autocomplete="off" class="form-control" value="{{$keluarga->pekerjaan}}">
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