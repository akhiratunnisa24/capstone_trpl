<div class="modal fade" id="editOrganisasi{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="AddModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{-- <div class="modal-header"> --}}
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel">Edit Organisasi</h4>
            {{-- </div> --}}
            <div class="modal-body">
                <form action="/organisasi/update/{{$data->id}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group col-xs-12">
                        <label  class="col-form-label">Nama Jabatan</label>
                        <input type="text" class="form-control m-t-10" name="nama_jabatan" value="{{$data->nama_jabatan}}">
                    </div>

                    <div class="form-group col-xs-12">
                        <label  class="col-form-label">Nama Web</label>
                        <input type="text" class="form-control"  name="nama_web" value="{{$setting->nama_web}}" required>
                    </div>

                    <div class="form-group col-xs-12">
                        <label  class="col-form-label">Icon</label>
                        <br><img src="{{asset('images/'.$setting->icon) }}" style="width: 100px" required>
                    </div>

                    <div class="form-group col-xs-12">
                        <label  class="col-form-label">Ganti Ikon</label>
                        <input type="file" class="form-control"  name="icon" required>
                        <label>*) Jika Icon tidak diganti, Kosongkan saja.</label>
                    </div>

                    <div class="form-group col-xs-12">
                        <label  class="col-form-label">Email Perusahaan</label>
                        <input type="text" class="form-control"  name="email" value="{{$setting->email_perusahaan}}" required>
                    </div>

                    <div class="form-group col-xs-12">
                        <label  class="col-form-label">Nomor telepon Perusahaan</label>
                        <input type="text" class="form-control"  name="notelp" value="{{$setting->notelp_perusahaan}}" required>
                    </div>
                    <div class="form-group col-xs-12">
                        <label  class="col-form-label">Alamat Perusahaan</label>
                        <input type="text" class="form-control"  name="alamat" value="{{$setting->alamat_perusahaan}}" required>
                    </div>

                    <div class="modal-footer col-xs-12">
                        <button type="button" class="btn btn-sm btn-danger waves-effect" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-sm btn-success waves-effect waves-light" name="submit"
                            value="save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
