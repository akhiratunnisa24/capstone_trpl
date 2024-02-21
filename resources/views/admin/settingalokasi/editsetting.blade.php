{{-- FORM SETTING ALOKASI--}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />

<div class="modal fade" id="editsetting{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="editsetting"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="editsetting">Tambah Data Karyawan</h4>
            </div>
            <div class="modal-body">
                @if($data->id_jeniscuti == 1)
                    <div class="alert alert-warning" role="alert">
                        Kategori Cuti adalah Cuti Tahunan. Semua data karyawan pada form <b>Tambah Karyawan</b> terceklis otomatis.
                    </div>
                @else
                    <div class="alert alert-warning" role="alert">
                       Silahkan pilih Karyawan yang akan diberikan jatah {{ucwords(strtolower($data->jeniscutis->jenis_cuti))}}.
                    </div>
                @endif
                <form class="input" action="/updatesettingalokasi/{{$data->id}}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="panel-body">
                        <div class="col-md-6">
                            <div class="form-group col-sm" id="jenicuti">
                                <label for="id_jeniscuti" class="col-form-label">Kategori Cuti</label>
                                <input type="hidden" class="form-control" value="{{$data->id_jeniscuti}}" name="id_jeniscuti" id="id_jeniscuti">
                                <input type="text" class="form-control" value="{{$data->jeniscutis->jenis_cuti}}" name="jenis_cuti" id="jenic_cuti" readonly>
                            </div>
                            <div class="form-group" id="duration">
                                <label for="durasi" class="col-form-label">Durasi (Hari)</label>
                                <input type="number" class="form-control" value="{{$data->durasi}}" name="durasi"
                                    id="durasi" readonly required>
                            </div>
                        </div>
                        <div class="col-md-6" id="Karyawan">
                            <div class="form-group col-sm" id="mode_employe">
                                <label for="mode_karyawan" class="col-form-label">Tambah Karyawan :</label>
                                <div style="max-height: 150px; overflow-y: auto;">
                                    @php
                                        $alokasi = $alokasiCuti->where('id_settingalokasi', $data->id)
                                                                ->where('id_jeniscuti', $data->id_jeniscuti)
                                                                ->pluck('id_karyawan');
                                        $employee = $karyawan->whereNotIn('id', $alokasi);
                                    @endphp

                                    @if($employee->isEmpty())
                                        <div class="form-check">
                                            <div class="alert alert-primary" role="alert">
                                                Data karyawan tidak tersedia
                                            </div>
                                        </div>
                                    @else
                                        @foreach($employee as $karyawan)
                                            @if($data->id_jeniscuti == 1)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="hidden" value="{{$karyawan->id}}" id="employee_{{$karyawan->id}}" name="nama_karyawan[]" checked>
                                                    <input class="form-check-input" type="checkbox" value="{{$karyawan->id}}" id="employee_{{$karyawan->id}}" name="nama_karyawan[]" checked disabled>
                                                    <label class="form-check-label" for="employee_{{$karyawan->id}}">
                                                        {{$karyawan->nama}}
                                                    </label>
                                                </div>
                                            @else
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="{{$karyawan->id}}" id="employee_{{$karyawan->id}}" name="nama_karyawan[]">
                                                    <label class="form-check-label" for="employee_{{$karyawan->id}}">
                                                        {{$karyawan->nama}}
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-sm btn-success" name="submit" value="save">Update</button>
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
    // $("#mode_karyawant").select2();
    // );

</script>
  {{-- <div class="col-md-6" id="modealokasii">
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
                                </select> --}}
                                 {{-- hanya menampilkan data sesuai database saja gunakan code berikut --}}
                                    {{-- @foreach($data->mode_karyawan_array as $item)
                                            <option value="{{$item}}" @if(in_array($item, $data->mode_karyawan_array)) selected @endif>{{$item}}</option>
                                    @endforeach --}}
                            {{-- </div>
                        </div> --}}
