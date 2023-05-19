{{-- FORM SETTING ALOKASI--}}
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/3.2/select2.css" />

<style>
    .modal-backdrop:nth-child(2n-1) {
        opacity: 0;
    }
</style>

<div class="modal fade" id="newsetting" tabindex="-1" role="dialog" aria-labelledby="newsetting" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="newsetting">Setting Alokasi Cuti</h4>
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
                <form class="input" action="{{ route('setting_alokasi.store')}}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div class="form-group col-sm" id="jenicutis">
                                <label for="id_jeniscuti" class="col-form-label">Kategori Cuti</label>
                                <select name="id_jeniscuti" id="id_jeniscutis" class="form-control">
                                    <option value="">Pilih Kategori Cuti</option>
                                    @foreach ($jeniscuti as $data)
                                    <option value="{{ $data->id}}" @if ($data->id ==request()->id_jeniscuti)
                                        selected
                                        @endif
                                        >{{ $data->jenis_cuti }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" id="durasii">
                                <label for="durasi" class="col-form-label">Durasi (Hari)</label>
                                <input type="number" class="form-control" autocomplete="off" name="durasi" placeholder="durasi" id="durasi" required>
                            </div>
                        {{-- </div>
                        <div class="col-md-6"> --}}
                            <div class="form-group col-sm" id="mode_employee">
                                <label for="mode_karyawan" class="col-form-label">Tipe Alokasi</label>
                                <select class="form-control" id="mode_employee" name="mode_karyawan[]" multiple style="width:507px;height:90px">
                                    <option value="Semua Karyawan">Semua Karyawan</option>
                                    <option value="Perempuan">Perempuan</option>
                                    <option value="Sudah Menikah">Sudah Menikah</option>
                                </select>
                                {{-- <option value="Belum Menikah">Belum Menikah</option> --}}
                                    {{-- <option value="Janda">Janda</option>
                                    <option value="Duda">Duda</option> --}}
                                     {{-- <option value="Laki-Laki">Laki-Laki</option> --}}
                                      {{-- <option value="Semua Karyawan">Semua Karyawan</option> --}}
                            </div>
                            <div class="form-group col-sm" id="mode_employees">
                                <label for="mode_karyawan" class="col-form-label">Tipe Alokasi</label>
                                <select class="form-control" id="modeemployees" name="mode_karyawans" style="width:507px">
                                    <option value="Lama Kerja Lebih Dari Setahun">Lama Kerja Lebih Dari Setahun</option>
                                </select>
                            </div>
                            <div class="form-group col-sm" id="cutibersama">
                                <label for="mode_karyawan" class="col-form-label">Cuti Bersama Terhutang</label>
                                <input type="text" class="form-control" autocomplete="off" name="cuti_bersama_terhutang" value="Ada" id="cuti_bersama_terhutang"
                                    readonly>
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
{{-- <script src="assets/js/app.js"></script> --}}

{{-- // Plugins Init js --}}
{{-- <script src="assets/pages/form-advanced.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/3.2/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Set form awal untuk hidden
        $('#mode_employee').prop("hidden", true);
        $('#mode_employees').prop("hidden", true);
        $('#cutibersama').prop("hidden", true);
        $('#durasii').prop("hidden", true);

        //true hilang
        //false muncul

        $('#id_jeniscutis').on('change', function() {
            var id_jeniscuti = $(this).val();
            if(id_jeniscuti == 1) 
            {
                $('#mode_employee').prop("hidden", true);
                $('#mode_employees').prop("hidden", false);
                $('#cutibersama').prop("hidden", false);
                $('#durasii').prop("hidden", false);

            } else {
                $('#mode_employee').prop("hidden", false);
                $('#mode_employees').prop("hidden", true);
                $('#cutibersama').prop("hidden", true);
                $('#durasii').prop("hidden", false);
            }
        });
    });
</script>

<script>
    jQuery('option').mousedown(function(e) {
    e.preventDefault();
    jQuery(this).toggleClass('selected');
  
    jQuery(this).prop('selected', !jQuery(this).prop('selected'));
    return false;
});
</script>