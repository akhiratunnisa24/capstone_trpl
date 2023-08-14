{{-- FORM TAMBAH DATA Jadwal--}}
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.css">

<div class="modal fade" id="AddShift" tabindex="-1" role="dialog" aria-labelledby="AddModal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel">Tambah Shift</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('shift.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-group col-sm">
                        <label for="nama_shift" class="col-form-label">Nama Shift</label>
                        <input type="text" class="form-control" name="nama_shift" id="nama_shift" autocomplete="off"
                            placeholder="Masukkan Nama Shift" required>
                    </div>
                    <div class="form-group col-sm">
                        <label for="jam_mulai">Jam Masuk</label>
                        <div class="input-group clockpicker pull-center" data-placement="bottom" data-align="top" data-autoclose="true">
                            <input type="text" class="form-control" autocomplete="off" name="jam_masuk" id="jam_masuk">
                            <span class="input-group-addon">
                                <span class="fa fa-clock-o"></span>
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-sm">
                        <label for="jam_selesai">Jam Pulang</label>
                        <div class="input-group clockpicker pull-center" data-placement="bottom" data-align="top"  data-autoclose="true">
                            <input type="text" class="form-control" name="jam_pulang" id="jam_pulang" autocomplete="off">
                            <span class="input-group-addon">
                                <span class="fa fa-clock-o"></span>
                            </span>
                        </div>
                    </div>
                    @if($role == 5)
                        <div class="form-group col-xs-12">
                            <label class="form-label">Partner</label>
                            <select class="form-control" name="'partneradmin">
                                <option value="">Pilih Partner</option>
                                @foreach ($partner as $k)
                                    <option value="{{ $k->id }}">
                                        {{ $k->nama_partner }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @elseif($role == 1 || $role == 2)
                        <input  type="hidden" class="form-control" autocomplete="off" value="{{ Auth::user()->partner }}">
                    @endif
                   

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