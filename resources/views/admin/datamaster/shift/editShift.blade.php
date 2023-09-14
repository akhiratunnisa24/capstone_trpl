<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.css">
<div class="modal fade" id="editShift{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="AddModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{-- <div class="modal-header"> --}}
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel">Edit Shift</h4>
            {{-- </div> --}}
            <div class="modal-body">
                <form action="/shift/update/{{$data->id}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group col-xs-12">
                        <label  class="col-form-label">Nama Shift</label>
                        <input type="text" class="form-control m-t-10" name="nama_shift" value="{{$data->nama_shift}}">
                    </div>
                    <div class="form-group col-sm">
                        <label for="jam_mulai">Jam Masuk</label>
                        <div class="input-group clockpicker pull-center" data-placement="bottom" data-align="top" data-autoclose="true">
                            <input type="text" class="form-control" value="{{$data->jam_masuk}}" autocomplete="off" name="jam_masuk" id="jam_masuk">
                            <span class="input-group-addon">
                                <span class="fa fa-clock-o"></span>
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-sm">
                        <label for="jam_selesai">Jam Pulang</label>
                        <div class="input-group clockpicker pull-center" data-placement="bottom" data-align="top"  data-autoclose="true">
                            <input type="text" class="form-control"   value="{{$data->jam_pulang}}" name="jam_pulang" id="jam_pulang" autocomplete="off">
                            <span class="input-group-addon">
                                <span class="fa fa-clock-o"></span>
                            </span>
                        </div>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.js"></script>

<script>
       //show clockpicker 
       jQuery(function($){
           $('.clockpicker').clockpicker()
               .find('input').change(function()
               {
                   console.log(this.value);
               });
           var input = $('#single-input').clockpicker({
               placement: 'bottom',
               align: 'left',
               autoclose: true,
               'default': 'now'
           });
           
       });
   </script>