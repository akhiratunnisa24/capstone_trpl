{{-- FORM TAMBAH KATEGORI CUTI --}}
<div id="Reject{{$data->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel">Alasan Penolakan</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('izin.reject',$data->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-group col-sm">
                        <label for="alasan" class="col-form-label">Alasan</label>
                        <input type="text" class="form-control" name="alasan" id="alasan" autocomplete="off"
                            placeholder="Masukkan Alasan" required>
                        <input type="hidden" name="status" value="Ditolak" class="form-control" hidden> 
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
