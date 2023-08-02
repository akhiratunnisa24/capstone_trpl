<style>
    .col-form-label{
        -webkit-text-fill-color: black;
    }
</style>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.css">

<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="add" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="add">Tambah Setting Absensi</h4>
            </div> 
        
            <div class="modal-body">
                <form class="input" action="{{route('settingabsensi.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div class="form-group col-sm" >
                                <label class="col-form-label">Tipe Absensi</label>
                                <select name="tipe" id="tipe" class="form-control" required>
                                    <option value="">Pilih Tipe Absensi</option>
                                    <option value="Terlambat">Terlambat</option>
                                    <option value="Tidak Masuk">Tidak Masuk</option>
                                </select>
                            </div>
                            <div class="form-group col-sm" id="toleransi">
                                <label for="id_jeniscuti" class="col-form-label">Toleransi Terlambat</label>
                                <div class="input-group clockpicker pull-center" data-placement="bottom" data-align="top" data-autoclose="true">
                                    <input type="text" class="form-control" autocomplete="off" name="toleransi_terlambat"  id="toleransi_terlambat">
                                    <span class="input-group-addon"><span class="fa fa-clock-o"></span></span>
                                </div>
                                {{-- <input type="text" class="form-control" autocomplete="off" name="toleransi_terlambat" placeholder="Masukkan Toleransi Keterlambatan" id="toleransi_terlambat"> --}}
                            </div>
                           
                            <div class="form-group" id="jumlah_terlambat">
                                <label class="col-form-label">Jumlah Terlambat</label>
                                <input type="text" class="form-control" autocomplete="off" name="jumlah_terlambat" >
                            </div>
                            <div class="form-group col-sm"  id="sanksi_terlambat">
                                <label class="col-form-label">Jenis Sanksi</label>
                                <select name="sanksi_terlambat" class="form-control" >
                                    <option value="">Pilih Jenis Sanksi</option>
                                    <option value="Teguran Biasa">Teguran Biasa</option>
                                    <option value="SP Pertama">SP Pertama</option>
                                    <option value="SP Kedua">SP Kedua</option>
                                    <option value="SP Ketiga">SP Ketiga</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="form-group"  id="jumlah_tidakmasuk">
                                <label class="col-form-label">Jumlah Tidak Masuk</label>
                                <input type="text" class="form-control" autocomplete="off" name="jumlah_tidakmasuk" >
                            </div>
                            <div class="form-group col-sm"  id="sanksi_tidak_masuk">
                                <label class="col-form-label">Jenis Sanksi</label>
                                <select name="sanksi_tidak_masuk" class="form-control" >
                                    <option value="">Pilih Jenis Sanksi</option>
                                    <option value="Potong Uang Transportasi">Potong Uang Transportasi</option>
                                    <option value="Potong Uang Makan">Potong Uang Makan</option>
                                </select>
                            </div>
                            <input type="hidden" class="form-control" autocomplete="off" name="partner" value="{{Auth::user()->partner}}">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" name="submit" value="save">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.js"></script>
<script type="text/javascript">
    $(function()
        {
            $('#toleransi').prop("hidden", true);
            $('#jumlah_terlambat').prop("hidden", true);
            $('#sanksi_terlambat').prop("hidden", true);
            $('#jumlah_tidakmasuk').prop("hidden", true);
            $('#sanksi_tidak_masuk').prop("hidden", true);
        
            $('#tipe').on('change', function(a)
            {
                if(a.target.value== 'Terlambat')
                {
                    $('#toleransi').prop("hidden", false);
                    $('#jumlah_terlambat').prop("hidden", false);
                    $('#sanksi_terlambat').prop("hidden", false);
                    $('#jumlah_tidakmasuk').prop("hidden", true);
                    $('#sanksi_tidak_masuk').prop("hidden", true);

                    // Set required attributes for Terlambat
                    $('#toleransi_terlambat').prop('required', true);
                    $('#jumlah_terlambat').prop('required', true);
                    $('#sanksi_terlambat').prop('required', true);
                    $('#jumlah_tidakmasuk').prop('required', false);
                    $('#sanksi_tidak_masuk').prop('required', false);
                }
                if(a.target.value== 'Tidak Masuk')
                {
                    $('#toleransi').prop("hidden", true);
                    $('#jumlah_terlambat').prop("hidden", true);
                    $('#sanksi_terlambat').prop("hidden", true);
                    $('#jumlah_tidakmasuk').prop("hidden", false);
                    $('#sanksi_tidak_masuk').prop("hidden", false);

                    // Set required attributes for Tidak Masuk
                    $('#toleransi_terlambat').prop('required', false);
                    $('#jumlah_terlambat').prop('required', false);
                    $('#sanksi_terlambat').prop('required', false);
                    $('#jumlah_tidakmasuk').prop('required', true);
                    $('#sanksi_tidak_masuk').prop('required', true);
                }
            });
        }
    );  
</script>
<script>
    jQuery(function($){
    $('.clockpicker').clockpicker({
        format: 'mm'
    }).find('input').change(function()
    {
        console.log(this.value);
    });
    var input = $('#single-input').clockpicker({
        placement: 'bottom',
        align: 'left',
        autoclose: true,
        'default': 'now',
        format: 'mm'
    }); 
});

</script>
