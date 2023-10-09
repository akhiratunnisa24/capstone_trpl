<div class="modal fade" id="edit{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel">Edit Data Bank</h4>
            </div>
            <div class="modal-body">
                <form action="/bank/update/{{$data->id}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group col-xs-12">
                        <label  class="col-form-label">Nama Bank</label>
                        <input type="text" class="form-control m-t-10" name="nama_bank" value="{{$data->nama_bank}}">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger waves-effect" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-sm btn-success waves-effect waves-light" name="submit"
                            value="save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>