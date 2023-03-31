<style>
    .col-form-label{
        -webkit-text-fill-color: black,
    }
</style>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.css">

<div class="modal fade" id="edit{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="add" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="add">Edit Setting Absensi</h4>
            </div> 
        
            <div class="modal-body">
                <form class="input" action="/setting-absensi-update/{{$data->id}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @if($data->toleransi_terlambat != NULL)
                        <div class="form-group" id="toleran">
                            <label for="id_jeniscuti" class="col-form-label">Toleransi Terlambat (menit)</label>
                            <div class="input-group clockpicker pull-center" data-placement="bottom" data-align="top" data-autoclose="true">
                                <input type="text" class="form-control" value="{{$data->toleransi_terlambat}}" autocomplete="off" name="toleransi_terlambat">
                                <span class="input-group-addon"><span class="fa fa-clock-o"></span></span>
                            </div>
                        </div>
                        <div class="form-group col-sm" id="jumlahterlambat">
                            <label class="col-form-label">Jumlah Terlambat</label>
                            <input type="number" class="form-control" value="{{$data->jumlah_terlambat}}" autocomplete="off" name="jumlah_terlambat" required>
                        </div>

                        <div class="form-group col-sm" id="sanksiterlambat">
                            <label class="col-form-label">Jenis Sanksi</label>
                            <select name="sanksi_terlambat" class="form-control" required>
                                <option value="">Pilih Jenis Sanksi</option>
                                <option value="Teguran Biasa" @if($data->sanksi_terlambat == "Teguran Biasa") selected @endif>Teguran Biasa</option>
                                <option value="SP Pertama" @if($data->sanksi_terlambat == "SP Pertama") selected @endif>SP Pertama</option>
                                <option value="SP Kedua" @if($data->sanksi_terlambat == "SP Kedua") selected @endif>SP Kedua</option>
                                <option value="SP Ketiga" @if($data->sanksi_terlambat == "SP Ketiga") selected @endif>SP Ketiga</option>
                            </select>
                        </div>
                    @else
                        <div class="form-group col-sm" id="jumlahtidakmasuk">
                            <label class="col-form-label">Jumlah Tidak Masuk</label>
                            <input type="number" class="form-control" autocomplete="off" value="{{$data->jumlah_tidakmasuk}}" name="jumlah_tidakmasuk" required>
                        </div>
                        <div class="form-group col-sm" id="status">
                            <label class="col-form-label">Status Tidak Masuk</label>
                            <input type="text" class="form-control" autocomplete="off" value="{{$data->status_tidakmasuk}}" name="status_tidakmasuk" readonly>
                        </div>

                        <div class="form-group col-sm"  id="sanksitidakmasuk">
                            <label class="col-form-label">Jenis Sanksi</label>
                            <select name="sanksi_tidak_masuk" class="form-control" required>
                                <option value="">Pilih Jenis Sanksi</option>
                                <option value="Potong Uang Transportasi" @if($data->sanksi_tidak_masuk == "Potong Uang Transportasi") selected @endif>Potong Uang Transportasi</option>
                                <option value="Potong Uang Makan" @if($data->sanksi_tidak_masuk == "Potong Uang Makan") selected @endif>Potong Uang Makan</option>
                            </select>
                        </div>
                    @endif
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" name="submit" value="save">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.js"></script>
<script>
    jQuery(function($){
    $('.clockpicker').clockpicker({
        format: 'mm',
    }).find('input').change(function()
    {
        console.log(this.value)
    })
    var input = $('#single-input').clockpicker({
        placement: 'bottom',
        align: 'left',
        autoclose: true,
        'default': 'now',
        format: 'mm',
    })
    });

</script>
