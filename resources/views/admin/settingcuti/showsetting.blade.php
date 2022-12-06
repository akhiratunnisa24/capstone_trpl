{{-- FORM SETTING ALOKASI--}}
<div class="modal fade" id="newsetting" tabindex="-1" role="dialog" aria-labelledby="newsetting" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="newsetting">Setting Alokasi Cuti</h4>
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
                <form class="input" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="panel-body">
                        <div class="col-md-6">
                            <div class="form-group col-sm" id="jenicuti">
                                <label for="id_jeniscuti" class="col-form-label">Kategori Cuti</label>
                                <select name="id_jenisizin" id="id_jenisizin" class="form-control">
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="1">Cuti Tahunan</option>
                                    <option value="2">Cuti Melahirkan</option>
                                    <option value="3">Cuti Keluarga Meninggal</option>
                                    <option value="4">Cuti Menikahkan Anak</option>
                                </select>
                                 {{-- @foreach ($jenisizin as $data)
                                        <option value="{{ $data->id}}" 
                                            {{-- {{ old('id_jenisizin') == $data->id ? 'selected' : '' }}
                                            >{{ $data->jenis_izin }}
                                        </option>
                                    @endforeach --}}
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="tipe_alokasi" class="col-form-label">Tipe Alokasi</label>
                                </div>
                                <div class="col-md-9">
                                    <div class="radio">
                                        <input type="radio" name="tipe_alokasi" id="radio1" value="Regular Allocation" checked>
                                        <label for="tipe_alokasi">
                                            Regular Allocation
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <input type="radio" name="tipe_alokasi" id="radio2" value="Actual Allocation">
                                        <label for="tipe_alokasi">
                                            Actual Allocation
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" id="duration">
                                <label for="durasi" class="col-form-label">Durasi</label>
                                <input type="number" class="form-control" name="durasi" id="durasi">
                            </div>
                        </div>

                        <div class="col-md-6" id="modealokasi">
                            <div class="form-group">
                                <div class="form-group col-sm" id="modealokasi">
                                    <label for="mode" class="col-form-label">Mode Alokasi</label>
                                    <select name="mode" id="mode" class="form-control">
                                        <option value="">-- Pilih Mode Alokasi --</option>
                                        <option value="By Company">By Company</option>
                                        <option value="By Departemen">By Departemen</option>
                                        <option value="By Karyawan">By Tags Karyawan</option>
                                    </select>
                                </div> 
                            </div>
                            <div class="form-group col-sm" id="mode_company">
                                <label for="company" class="col-form-label">Company</label>
                                <select name="company" id="company" class="form-control">
                                    <option value="">-- Pilih Company --</option>
                                    <option value="">A</option>
                                    <option value="">B</option>
                                    <option value="">C</option>
                                </select>
                            </div> 
                            <div class="form-group col-sm" id="mode_departemen">
                                <label for="id_departemen" class="col-form-label">Departemen</label>
                                <select name="id_departemen" id="id_departemen" class="form-control">
                                    <option value="">-- Pilih Departemen --</option>
                                    <option value="">KONVENSIONAL</option>
                                    <option value="">IT DEPARTEMEN</option>
                                    <option value="">KEUANGAN</option>
                                </select>
                            </div> 
                            <div class="form-group col-sm" id="mode_employee">
                                <label for="tags" class="col-form-label">Tags Karyawan</label>
                                <select name="tags" id="tags" class="form-control">
                                    <option value="">-- Pilih Tags --</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                    <option value="Menikah">Menikah</option>
                                    <option value="Belum Menikah">Belum Menikah</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info" name="submit" value="save">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- jQuery  -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/modernizr.min.js"></script>
<script src="assets/js/detect.js"></script>
<script src="assets/js/fastclick.js"></script>
<script src="assets/js/jquery.slimscroll.js"></script>
<script src="assets/js/jquery.blockUI.js"></script>
<script src="assets/js/waves.js"></script>
<script src="assets/js/wow.min.js"></script>
<script src="assets/js/jquery.nicescroll.js"></script>
<script src="assets/js/jquery.scrollTo.min.js"></script>

{{-- // Datatable init js  --}}
<script src="assets/pages/datatables.init.js"></script>
<script src="assets/js/app.js"></script>

{{-- // Plugins Init js --}}
<script src="assets/pages/form-advanced.js"></script>

<script type="text/javascript">
    $(function()
    {
        $('#mode_company').prop("hidden", true);
        $('#mode_departemen').prop("hidden", true);
        $('#mode_employee').prop("hidden", true);

        $('#modealokasi').on('change', function(e)
        {
            if(e.target.value== 'By Company')
            {
                $('#mode_company').prop("hidden", false);
                $('#mode_departemen').prop("hidden", true);
                $('#mode_employee').prop("hidden", true);
            } else if(e.target.value== 'By Departemen')
            {
                $('#mode_company').prop("hidden", true);
                $('#mode_departemen').prop("hidden", false);
                $('#mode_employee').prop("hidden", true);
            }else{
                $('#mode_company').prop("hidden", true);
                $('#mode_departemen').prop("hidden", true);
                $('#mode_employee').prop("hidden", false);
            }
        });
    });


</script>





         