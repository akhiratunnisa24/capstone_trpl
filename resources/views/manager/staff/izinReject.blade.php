{{-- FORM ALASAN DITOLAK --}}
    <div class="modal fade" id="Reject{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="Modal" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title text-center" id="myModalLabel">Form Alasan Penolakan</h4>
                </div> 
        
                <div class="modal-body">
                    <form class="input" action="{{ route('izin.reject',$data->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="form-group col-sm">
                            <input type="hidden" class="form-control" name="status" id="status" value="Ditolak" hidden>
                        </div>
                        <div class="form-group">
                            <label for="alasan" class="col-form-label">Alasan</label><br>
                            <input type="text" class="form-control" name="alasan" placeholder="Masukkan alasan Anda" id="alasan" autocomplete="off" required>
                        </div><br><br>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" name="submit" value="save">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <style>
        #alasan {
            width: 550px;
        }
    </style>
    