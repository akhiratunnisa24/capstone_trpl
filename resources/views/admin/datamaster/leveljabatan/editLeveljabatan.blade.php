<div class="modal fade" id="editLeveljabatan{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="AddModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{-- <div class="modal-header"> --}}
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel">Edit Level Jabatan</h4>
            {{-- </div> --}}
            <div class="modal-body">
                <form action="/level-jabatan/update/{{$data->id}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group col-xs-12">
                        <label  class="col-form-label">Nama Level Jabatan</label>
                        <input type="text" class="form-control m-t-10" name="nama_level" value="{{$data->nama_level}}">
                    </div>

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