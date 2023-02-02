{{-- FORM TAMBAH DATA DEPARTEMEN --}}
<div class="modal fade" id="editDepartmen{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="AddModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{-- <div class="modal-header"> --}}
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel">Edit Data Departemen</h4>
            {{-- </div> --}}
            <div class="modal-body">
                <form action="/departemen/update/{{$data->id}}" method="PUT" >
                    @csrf
                    @method('PUT')
                    <div class="form-group col-xs-12">
                        <label  class="col-form-label">Nama Departemen</label>
                        <input type="text" class="form-control m-t-10" name="nama_departemen" value="{{$data->nama_departemen}}">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success waves-effect waves-light" name="submit"
                            value="save">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>