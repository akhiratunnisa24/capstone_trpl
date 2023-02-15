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
                            <input type="hidden" name="id_keluarga" value="{{$keluarga->id}}">
                            @if($keluarga->status_pernikahan != null)
                                <div class="form-group">
                              
                                    <div class="mb-3">
                                        <label>Status Pernikahan</label>
                                        <select type="text" class="form-control selectpicker" name="status_pernikahan" required>
                                            <option value="">Pilih Status Pernikahan</option>
                                            <option value="Belum" @if($keluarga->status_pernikahan == "Belum") selected @endif >Belum Menikah</option>
                                            <option value="Sudah" @if($keluarga->status_pernikahan == "Sudah") selected @endif >Sudah Menikah</option>
                                        </select>
                                    </div>
                                </div>
                            @endif
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Nama Pasangan</label>
                                    <input type="text" name="namaPasangan" class="form-control" autocomplete="off" value="{{$keluarga->nama}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Tanggal Lahir </label>
                                    <input type="text" name="tgllahirPasangan" autocomplete="off" class="form-control" placeholder="yyyy/mm/dd" id="datepicker-autoclose16" value="{{\Carbon\Carbon::parse($keluarga->tgllahir)->format('Y/m/d')}}">
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
                        <input type="hidden" name="id" id="id">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->