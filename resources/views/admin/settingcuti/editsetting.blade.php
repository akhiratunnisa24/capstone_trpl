{{-- FORM SETTING ALOKASI--}}
<div class="modal fade" id="editsetting{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="editsetting" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="editsetting">Edit Setting Cuti</h4>
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
                <form class="input" action="/updatesettingalokasi/{{$data->id}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="panel-body">
                        <div class="col-md-6">
                            <div class="form-group col-sm" id="jenicuti">
                                <label for="id_jeniscuti" class="col-form-label">Kategori Cuti</label>
                                <select name="id_jeniscuti" class="form-control">
                                    @foreach ($jeniscuti as $data)
                                    <option value="{{ $data->id }}"
                                        @if($data->id_jeniscuti == $jeniscuti->id_jeniscuti) 
                                            selected
                                        @endif
                                        >{{ $data->jenis_cuti }}</option>
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
                            <div class="form-group" id="duration">
                                <label for="durasi" class="col-form-label">Durasi</label>
                                <input type="number" class="form-control" name="durasi" id="durasi">
                            </div>
                        </div>

                        <div class="col-md-6" id="modealokasii">
                            <div class="form-group">
                                <div class="form-group col-sm" id="modealokasii">
                                    <label for="mode" class="col-form-label">Mode Alokasi</label>
                                    <select name="mode" id="mode" class="form-control">
                                        <option value="">-- Pilih Mode Alokasi --</option>
                                        <option value="Berdasarkan Departemen">Berdasarkan Departemen</option>
                                        <option value="Berdasarkan Karyawan">Berdasarkan Karyawan</option>
                                    </select>
                                </div> 
                            </div>
                            <div class="form-group col-sm" id="mode_departement">
                                <label for="id_departemen" class="col-form-label">Departemen</label>
                                <select name="id_departemen" id="id_departemen" class="form-control">
                                    <option value="">-- Pilih Departemen --</option>
                                    <option value="KONVENSIONAL">KONVENSIONAL</option>
                                    <option value="IT DEPARTEMEN">IT DEPARTEMEN</option>
                                    <option value="KEUANGAN">KEUANGAN</option>
                                </select>
                            </div>
                            <div class="form-group col-sm" id="mode_employe">
                                <label for="mode_karyawan" class="col-form-label">Karyawan</label>
                                <select id="mode_karyawant" name="mode_karyawan[]" multiple="multiple" class="form-control">
                                    {{-- <option value=""> ----- Pilih -----</option> --}}
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                    <option value="Sudah">Sudah Menikah</option>
                                    <option value="Belum">Belum Menikah</option>
                                    <option value=">= 1 Tahun">>= 1 Tahun</option>
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
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

{{-- // Datatable init js  --}}
<script src="assets/js/app.js"></script>
{{-- // Plugins Init js --}}
<script src="assets/pages/form-advanced.js"></script>

<script type="text/javascript">
    $(function()
    {
        $('#mode_departement').prop("hidden", true);
        $('#mode_employe').prop("hidden", true);

        $('#modealokasii').on('change', function(e)
        {
            if(e.target.value== 'Berdasarkan Departemen')
            {
                $('#mode_departement').prop("hidden", false);
                $('#mode_employe').prop("hidden", true);
            }
            if(e.target.value== 'Berdasarkan Karyawan')
            {
                $('#mode_departement').prop("hidden", true);
                $('#mode_employe').prop("hidden", false);
            }
        });

        $(document).ready(function () {
            $("#mode_karyawant").select2();
        });
    });
</script>





         