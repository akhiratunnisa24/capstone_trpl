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
                    <form class="input" action="{{ route('setting_alokasi.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="panel-body">
                            <div class="col-md-6">
                                <div class="form-group col-sm" id="jenicuti">
                                    <label for="id_jeniscuti" class="col-form-label">Kategori Cuti</label>
                                    <select name="id_jeniscuti" id="id_jeniscuti" class="form-control">
                                        <option value="">Pilih Kategori Cuti</option>
                                        @foreach ($jeniscuti as $data)
                                            <option value="{{ $data->id}}"
                                                @if ($data->id ==request()->id_jeniscuti)
                                                selected
                                                @endif
                                                >{{ $data->jenis_cuti }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm">
                                    <label for="tipe_alokasi" class="col-form-label">Tipe Alokasi</label>
                                    <select name="tipe_alokasi" id="tipe_alokasi" class="form-control">
                                        <option value="">Pilih Tipe Alokasi</option>
                                        <option value="Reguler">Reguler</option>
                                        <option value="Aktual">Aktual</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="durasi" class="col-form-label">Durasi</label>
                                    <input type="number" class="form-control" name="durasi" placeholder="durasi" id="durasi">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-group col-sm" id="modealokasi">
                                        <label for="mode_alokasi" class="col-form-label">Mode Alokasi</label>
                                        <select name="mode_alokasi" id="mode_alokasi" class="form-control">
                                            <option value="">Pilih Mode Alokasi</option>
                                            <option value="Berdasarkan Departemen">Berdasarkan Departemen</option>
                                            <option value="Berdasarkan Karyawan">Berdasarkan Karyawan</option>
                                        </select>
                                    </div> 
                                </div>
                                
                                <div class="form-group col-sm" id="mode_departemen">
                                    <label for="departemen" class="col-form-label">Departemen</label>
                                    <select name="departemen" id="departemen" class="form-control">
                                        <option value="">Pilih Departemen</option>
                                        <option value="KONVENSIONAL">KONVENSIONAL</option>
                                        <option value="KEUANGAN">KEUANGAN</option>
                                        <option value="TEKNOLOGI INFORMASI">TEKNOLOGI INFORMASI</option>
                                        <option value="HUMAN RESOURCE">HUMAN RESOURCE</option>
                                    </select>
                                </div> 
                                <div class="form-group col-sm" id="mode_employee">
                                    <label for="mode_karyawan" class="col-form-label">Karyawan</label>
                                    <select name="mode_karyawan" id="mode_karyawan" class="form-control">
                                        <option value="">Pilih</option>
                                        <option value="Jenis Kelamin">Jenis Kelamin</option>
                                        <option value="Status">Status</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm" id="jk_employee">
                                    <label for="jenis_kelamin" class="col-form-label">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>

                                <div class="form-group col-sm" id="sm_employee">
                                    <label for="status_pernikahan" class="col-form-label">Status Pernikahan</label>
                                    <select name="status_pernikahan" id="status_pernikahan" class="form-control">
                                        <option value="">Pilih Status Menikah</option>
                                        <option value="Sudah">Sudah Menikah</option>
                                        <option value="Belum">Belum Menikah</option>
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
            $('#mode_departemen').prop("hidden", true);
            $('#mode_employee').prop("hidden", true);
            $('#jk_employee').prop("hidden", true);
            $('#sm_employee').prop("hidden", true);

            $('#modealokasi').on('change', function(b)
            {
                if(b.target.value== 'Berdasarkan Karyawan')
                {
                    $('#mode_departemen').prop("hidden", true);
                    $('#mode_employee').prop("hidden", false);

                    $('#mode_employee').on('change', function(c)
                    {
                        if(c.target.value== 'Jenis Kelamin')
                        {
                            $('#jk_employee').prop("hidden", false);
                            $('#sm_employee').prop("hidden", true);
                        }
                        if(c.target.value== 'Status')
                        {
                            $('#jk_employee').prop("hidden", true);
                            $('#sm_employee').prop("hidden", false);
                        }
                    });
                }
                if(b.target.value== 'Berdasarkan Departemen')
                {
                    $('#mode_departemen').prop("hidden", false);
                    $('#mode_employee').prop("hidden", true);
                    $('#jk_employee').prop("hidden", true);
                    $('#sm_employee').prop("hidden", true);
                }
            });
        });
    </script>


    

    
             