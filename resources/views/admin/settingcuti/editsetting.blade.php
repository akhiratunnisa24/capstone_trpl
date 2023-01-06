{{-- FORM SETTING ALOKASI--}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />

<div class="modal fade" id="editsetting{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="editsetting"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="editsetting">Edit Setting Cuti</h4>
            </div>
            <div class="modal-body">
                <form class="input" action="/updatesettingalokasi/{{$data->id}}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="panel-body">
                        <div class="col-md-6">
                            <div class="form-group col-sm" id="jenicuti">
                                <label for="id_jeniscuti" class="col-form-label">Kategori Cuti</label>
                                <select name="id_jeniscuti" class="form-control" required>
                                    @foreach ($jeniscuti as $item)
                                    <option value="{{$item->id}}" @if($item->id == $data->id_jeniscuti)
                                        selected
                                        @endif
                                        >{{$item->jenis_cuti}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" id="duration">
                                <label for="durasi" class="col-form-label">Durasi (Hari)</label>
                                <input type="number" class="form-control" value="{{$data->durasi}}" name="durasi"
                                    id="durasi" required>
                            </div>
                        </div>

                        <div class="col-md-6" id="modealokasii">
                            <div class="form-group">
                                <div class="form-group col-sm" id="modealokasii">
                                    <label for="mode_alokasi" class="col-form-label">Mode Alokasi</label>
                                    <select name="mode_alokasi" id="mode_lokasi" class="form-control">
                                        <option value="{{$data->mode_alokasi}}" selected>{{$data->mode_alokasi}}
                                        </option>
                                        <option value="Berdasarkan Departemen">Berdasarkan Departemen</option>
                                        <option value="Berdasarkan Karyawan">Berdasarkan Karyawan</option>
                                    </select>
                                </div>
                            </div>
                            @if($data->mode_alokasi == 'Berdasarkan Departemen')
                            <div class="form-group col-sm" id="mode_Alokasi_departement">
                                <label for="departemen" class="col-form-label">Departemen</label>
                                <select name="departemen" id="departemen" class="form-control">
                                    @foreach ($departemen as $item)
                                    <option value="{{$item->id}}" @if($item->id == $data->departemen)
                                        selected
                                        @endif
                                        >{{$item->nama_departemen}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @else
                            <div class="form-group col-sm" id="mode_employe">
                                <label for="mode_karyawan" class="col-form-label">Karyawan</label>
                                <select id="mode_karyawant" name="mode_karyawan[]" multiple="multiple"
                                    class="form-control" style="width:300px">
                                    <option value="{{$data->mode_karyawan}}" selected>{{$data->mode_karyawan}}</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                    <option value="Sudah">Sudah Menikah</option>
                                    <option value="Belum">Belum Menikah</option>
                                    <option value=">= 1 Tahun">>= 1 Tahun</option>
                                </select>
                            </div>
                            @endif
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

{{-- // Datatable init js --}}
<script src="assets/js/app.js"></script>
{{-- // Plugins Init js --}}
<script src="assets/pages/form-advanced.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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
    });
    // $(document).ready(function () 
    $("#mode_karyawant").select2();
    // );
</script>