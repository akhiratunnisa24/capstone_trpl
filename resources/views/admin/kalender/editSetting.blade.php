{{-- FORM TAMBAH DATA DEPARTEMEN --}}
<div class="modal fade" id="editSetting{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="AddModal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel">Edit Data Hari Libur</h4>
            </div>
          
            <div class="modal-body">
                <form action="/update-kalender/{{$data->id}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="" id="start">
                        <div class="form-group">
                            <label class="form-label">Tanggal</label>
                            <div class="input-group">
                                <input type="text" class="form-control" value="{{$data->tanggal}}" placeholder="yyyy/mm/dd" id="datepicker-autoclose34" name="tanggal" autocomplete="off" required>
                                <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-sm">
                        <label for="keterangan" class="col-form-label">Keterangan</label>
                        <input type="text" class="form-control" value="{{$data->keterangan}}" name="keterangan" id="keterangan" autocomplete="off" placeholder="Masukkan Keterangan" required>
                    </div>
                    <input type="hidden" name="_method" value="PUT">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success waves-effect waves-light" name="submit"
                            value="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
