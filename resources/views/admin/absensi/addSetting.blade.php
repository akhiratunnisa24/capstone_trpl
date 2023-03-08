<style>
    .modal-backdrop:nth-child(2n-1) {
        opacity: 0;
    }
</style>
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="newsetting" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="newsetting">Setting Absensi</h4>
            </div>

            @if ($errors->any())
            <div class="alert alert-danger show" role="alert">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="modal-body">
                <form class="input" action="" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-group col-sm" id="tipe">
                                    <label class="col-form-label">Tipe Absensi</label>
                                    <select name="tipe" id="tipe" class="form-control" required>
                                        <option value="">Pilih Tipe Absensi</option>
                                        <option value="Terlambat">Terlambat</option>
                                        <option value="Tidak Masuk">Tidak Masuk</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-sm" id="toleransi">
                                <label for="id_jeniscuti" class="col-form-label">Toleransi Terlambat</label>
                                <input type="text" class="form-control" autocomplete="off" name="toleransi_terlambat" placeholder="Masukkan Toleransi Keterlambatan" id="toleransi_terlambat"
                                required>
                            </div>
                            <div class="form-group" id="jumlah_terlambat">
                                <label class="col-form-label">Jumlah Terlambat</label>
                                <input type="number" class="form-control" autocomplete="off" name="jumlah_terlambat" 
                                    required>
                            </div>
                            <div class="form-group col-sm"  id="sanksi_terlambat">
                                <label class="col-form-label">Jenis Sanksi</label>
                                <select name="sanksi_terlambat" class="form-control" required>
                                    <option value="">Pilih Jenis Sanksi</option>
                                    <option value="Teguran Biasa">Terlambat</option>
                                    <option value="SP Pertama">SP Pertama</option>
                                    <option value="SP Kedua">SP Kedua</option>
                                    <option value="SP Ketiga">SP Ketiga</option>
                                </select>
                            </div>
                            <div class="form-group"  id="jumlah_tidakmasuk">
                                <label class="col-form-label">Jumlah Tidak Masuk</label>
                                <input type="number" class="form-control" autocomplete="off" name="jumlah_tidakmasuk"
                                    required>
                            </div>
                            <div class="form-group col-sm"  id="sanksi_tidak_masuk">
                                <label class="col-form-label">Jenis Sanksi</label>
                                <select name="sanksi_tidak_masuk" class="form-control" required>
                                    <option value="">Pilih Jenis Sanksi</option>
                                    <option value="Potong Gaji">Potong Gaji</option>
                                    <option value="Potong Cuti Tahunan">Potong Cuti Tahunan</option>
                                </select>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" name="submit" value="save">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- jQuery  -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/pages/form-advanced.js"></script>

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
                }
                if(a.target.value== 'Tidak Masuk')
                {
                    $('#toleransi').prop("hidden", true);
                    $('#jumlah_terlambat').prop("hidden", true);
                    $('#sanksi_terlambat').prop("hidden", true);
                    $('#jumlah_tidakmasuk').prop("hidden", false);
                    $('#sanksi_tidak_masuk').prop("hidden", false);
                }
            });
        });
       
        // $(document).ready(function () 
            $("#mode_karyawan").select2();
        // );
</script>
