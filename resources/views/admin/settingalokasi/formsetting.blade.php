{{-- FORM SETTING ALOKASI--}}
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/3.2/select2.css" />

<style>
    .modal-backdrop:nth-child(2n-1) {
        opacity: 0;
    }
</style>

<div class="modal fade" id="newsetting" tabindex="-1" role="dialog" aria-labelledby="newsetting" aria-hidden="true">
    <div class="modal-dialog modal-lg">
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
                        <div class="col-md-6">
                            <div class="form-group col-sm" id="jenicutis">
                                <label for="id_jeniscuti" class="col-form-label">Kategori Cuti</label>
                                <select name="id_jeniscuti" id="id_jeniscuti" class="form-control">
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
                            <div class="form-group">
                                <label for="durasi" class="col-form-label">Durasi (Hari)</label>
                                <input type="number" class="form-control" autocomplete="off" name="durasi" placeholder="durasi" id="durasi"
                                    required>
                            </div>
                            <div class="form-group">
                                <div class="form-group col-sm" id="tipeapproval">
                                    <label for="tipe_approval" class="col-form-label">Tipe Approval</label>
                                    <select name="tipe_approval" id="tipe_approval" class="form-control" required>
                                        <option value="">Pilih Tipe Approval</option>
                                        <option value="Tidak Bertingkat">Tidak Bertingkat</option>
                                        <option value="Bertingkat">Bertingkat</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group col-sm" id="modalokasi">
                                    <label for="mode_alokasi" class="col-form-label">Mode Alokasi</label>
                                    <select name="mode_alokasi" id="mode_alokasi" class="form-control" required>
                                        <option value="">Pilih Mode Alokasi</option>
                                        <option value="Berdasarkan Departemen">Berdasarkan Departemen</option>
                                        <option value="Berdasarkan Karyawan">Berdasarkan Karyawan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group col-sm" id="mode_departemen">
                                <label for="departemen" class="col-form-label">Departemen</label>
                                <select name="departemen" id="departemen" class="form-control">
                                    <option>-- Pilih Departemen --</option>
                                    @foreach ($departemen as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_departemen }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-sm" id="mode_employee">
                                <label for="mode_karyawan" class="col-form-label">Karyawan</label>
                                <select class="form-control" id="mode_employee" name="mode_karyawan[]" multiple style="width:395px">
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                    <option value="Sudah Menikah">Sudah Menikah</option>
                                    <option value="Belum Menikah">Belum Menikah</option>
                                    <option value="Lama Kerja">Lama Kerja</option>
                                </select>
                            </div>
                            <div class="form-group col-sm" id="mode_employees">
                                <label for="mode_karyawan" class="col-form-label">Karyawan</label>
                                <select class="form-control" id="modeemployees" name="mode_karyawans" multiple style="width:395px">
                                    <option value="Lama Kerja">Lama Kerja</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="form-group col-sm" id="lamakerja">
                                    <label class="col-form-label">Lama Kerja</label>
                                    <select name="lama_kerja" id="lama_kerja" class="form-control" required>
                                        <option value="">Pilih Lama Kerja</option>
                                        <option value="Lebih Dari Setahun">Lebih Dari 1 Tahun</option>
                                        <option value="Kurang Dari Setahun">Kurang Dari 1 Tahun</option>
                                    </select>
                                </div>
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

{{-- <script type="text/javascript">
    $(function()
        {
            $('#mode_departemen').prop("hidden", true);
            $('#mode_employee').prop("hidden", true);
            $('#mode_employees').prop("hidden", true);
            $('#lamakerja').prop("hidden", true);

            $('#jeniscutis').on('change', function(e)
            {
                var id = $(this).val();
                console.log(id);
                if(e.target.value== 1)
                {
                    $('#mode_departemen').prop("hidden", true);
                    $('#mode_employee').prop("hidden", true);
                    $('#mode_employees').prop("hidden", false);
                    $('#lamakerja').prop("hidden", false);

                    $('#modalokasi').on('change', function(a)
                    {
                        if(a.target.value== 'Berdasarkan Departemen')
                        {
                            $('#mode_departemen').prop("hidden", false);
                            $('#mode_employee').prop("hidden", true);
                            $('#mode_employees').prop("hidden", false);
                            $('#lamakerja').prop("hidden", false);
                        }
                        if(a.target.value== 'Berdasarkan Karyawan')
                        {
                            $('#mode_departemen').prop("hidden", true);
                            $('#mode_employee').prop("hidden", true);
                            $('#mode_employees').prop("hidden", false);
                            $('#lamakerja').prop("hidden", false);

                            $('#mode_employees').on('change', function(b)
                            {
                                if(b.target.value== 'Lama Kerja')
                                {
                                    $('#mode_departemen').prop("hidden", true);
                                    $('#mode_employee').prop("hidden", true);
                                    $('#lamakerja').prop("hidden", false);
                                }
                            });
                        }
                    });
                }
            });
        }
    );
        
            // $('#modalokasi').on('change', function(a)
            // {
            //     if(a.target.value== 'Berdasarkan Departemen')
            //     {
            //         $('#mode_departemen').prop("hidden", false);
            //         $('#mode_employee').prop("hidden", true);
            //         $('#lamakerja').prop("hidden", true);
            //     }
            //     if(a.target.value== 'Berdasarkan Karyawan')
            //     {
            //         $('#mode_departemen').prop("hidden", true);
            //         $('#mode_employee').prop("hidden", false);
            //         $('#lamakerja').prop("hidden", true);

                    // $('#mode_employee').on('change', function(b)
                    // {
                    //     if(b.target.value== 'Lama Kerja')
                    //     {
                    //         $('#mode_departemen').prop("hidden", true);
                    //         $('#mode_employee').prop("hidden",false);
                    //         $('#lamakerja').prop("hidden", false);
                    //     }
                        
                    // });
            //     }
            // });

    //     }
    // );
       
        // $(document).ready(function () 
            $("#mode_karyawan").select2();
        // );
</script> --}}

<script type="text/javascript">
    $(function()
        {
            $('#mode_departemen').prop("hidden", true);
            $('#mode_employee').prop("hidden", true);
            $('#mode_employees').prop("hidden", true);
            $('#lamakerja').prop("hidden", true);
        
            $('#modalokasi').on('change', function(a)
            {
                if(a.target.value== 'Berdasarkan Departemen')
                {
                    $('#mode_departemen').prop("hidden", false);
                    $('#mode_employee').prop("hidden", true);
                    $('#lamakerja').prop("hidden", true);  
                }
                if(a.target.value== 'Berdasarkan Karyawan')
                {
                    $('#mode_departemen').prop("hidden", true);
                    $('#mode_employee').prop("hidden", false);
                    $('#lamakerja').prop("hidden", true);

                    $('#mode_employee').on('change', function(b)
                    {
                        var selectedValues = $(this).val();
                        if (selectedValues.includes('Lama Kerja')) {
                            $('#mode_departemen').prop("hidden", true);
                            $('#lamakerja').prop("hidden", false);
                        }
                        // if(b.target.value== 'Lama Kerja')
                        // {
                        //     $('#mode_departemen').prop("hidden", true);
                        //     $('#lamakerja').prop("hidden", false);
                        // }
                    });
                }
            });
        });
       
        // $(document).ready(function () 
            $("#mode_karyawan").select2();
        // );
</script>


<script>
    jQuery('option').mousedown(function(e) {
    e.preventDefault();
    jQuery(this).toggleClass('selected');
  
    jQuery(this).prop('selected', !jQuery(this).prop('selected'));
    return false;
});
</script>