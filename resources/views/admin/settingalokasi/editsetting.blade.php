{{-- FORM SETTING ALOKASI--}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />

<div class="modal fade" id="editsetting{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="editsetting"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="editsetting">Edit Setting Cuti</h4>
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
                                <select name="id_jeniscuti" class="form-control selectpicker" data-live-search="true" required>
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
                            <div class="form-group col-sm" id="mode_employe">
                                <label for="mode_karyawan" class="col-form-label">Karyawan</label>
                                <select id="mode_karyawan" name="mode_karyawan[]" multiple="multiple" class="form-control selectpicker" data-live-search="true" style="width:385px">
                                    <option value="Laki-Laki" @if(in_array("Laki-Laki", $data->mode_karyawan_array)) selected @endif>
                                        @if(in_array("Laki-Laki", $data->mode_karyawan_array)) Laki-laki @else Laki-laki @endif
                                    </option>
                                    <option value="Perempuan" @if(in_array("Perempuan", $data->mode_karyawan_array)) selected @endif>
                                        @if(in_array("Perempuan", $data->mode_karyawan_array)) Perempuan @else Perempuan @endif
                                    </option>
                                    <option value="Sudah Menikah" @if(in_array("Sudah Menikah", $data->mode_karyawan_array)) selected @endif>
                                        @if(in_array("Sudah Menikah", $data->mode_karyawan_array)) Sudah Menikah @else Sudah Menikah @endif
                                    </option>
                                    <option value="Belum Menikah" @if(in_array("Belum Menikah", $data->mode_karyawan_array)) selected @endif>
                                        @if(in_array("Belum Menikah", $data->mode_karyawan_array)) Belum Menikah @else Belum Menikah @endif
                                    </option>
                                    <option value="Lama Kerja" @if(in_array("Lama Kerja",$data->mode_karyawan_array)) selected @endif>
                                        @if(in_array("Lama Kerja", $data->mode_karyawan_array)) Lama Kerja @else Lama Kerja @endif
                                    </option>
                                </select>
                                 {{-- hanya menampilkan data sesuai database saja gunakan code berikut --}}
                                    {{-- @foreach($data->mode_karyawan_array as $item)
                                            <option value="{{$item}}" @if(in_array($item, $data->mode_karyawan_array)) selected @endif>{{$item}}</option>
                                    @endforeach --}}
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" name="submit" value="save">Update</button>
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
{{-- <script src="assets/js/app.js"></script> --}}
{{-- // Plugins Init js --}}
<script src="assets/pages/form-advanced.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script type="text/javascript">
        // $(function()
        // {
        //     $('#mode_departement').prop("hidden", true);
        //     $('#mode_employe').prop("hidden", false);

    //     $('#modealokasii').on('change', function(e)
    //     {
    //         if(e.target.value== 'Berdasarkan Departemen')
    //         {
    //             $('#mode_departement').prop("hidden", false);
    //             $('#mode_employe').prop("hidden", true);
    //         }
    //         if(e.target.value== 'Berdasarkan Karyawan')
    //         {
    //             $('#mode_departement').prop("hidden", true);
    //             $('#mode_employe').prop("hidden", false);
    //         }
    //     });
    // });
    // $(document).ready(function () 
    $("#mode_karyawant").select2();
    // );
</script>