{{-- FORM SETTING ALOKASI--}}
<div class="modal fade" id="editalokasi" tabindex="-1" role="dialog" aria-labelledby="editalokasi" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="editaloaksi">Edit Alokasi Cuti</h4>
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
             {{-- <div class="form-group col-sm">
                                <label for="tipe_alokasi" class="col-form-label">Tipe Alokasi</label>
                                <select name="tipe_alokasi" id="tipe_alokasi" class="form-control">
                                    <option value="{{$data->tipe_alokasi}}" selected>{{$data->tipe_alokasi}}</option>
                                    <option value="Reguler">Reguler</option>
                                    <option value="Aktual">Aktual</option>
                                </select>
                            </div> --}}
            <div class="modal-body">
                <form class="input" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="panel-body">
                        <div class="col-md-6">
                            <div class="form-group col-sm" id="jenicuti">
                                <label for="id_pegawai" class="col-form-label">Karyawan</label>
                                <select name="id_pegawai" id="id_pegawai" class="form-control">
                                    <option value="">Pilih Karyawan</option>
                                    @foreach ($karyawan as $data)
                                        <option value="{{ $data->id}}"
                                            @if ($data->id ==request()->id_pegawai)
                                            selected
                                            @endif
                                            >{{ $data->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
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
                            <div class="form-group">
                                <label for="durasi" class="col-form-label">Durasi (Hari)</label>
                                <input type="text" class="form-control" name="durasi" placeholder="durasi" id="durasi" readonly>
                            </div>
                            <div class="form-group">
                                <label for="mode_alokasi" class="col-form-label">Mode Alokasi</label>
                                <input type="text" class="form-control" name="mode_alokasi" placeholder="mode alokasi" id="mode_alokasi" readonly>
                            </div>
                        </div>

                        <div class="col-md-6" id="validitas">
                            <div class=""  id="tglmulai">
                                <div class="form-group">
                                    <label for="tgl_mulai" class="form-label">Tanggal Masuk</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="tgl_masuk" name="tgl_masuk" autocomplete="off" readonly>
                                        <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="" id="tglnow">
                                <div class="form-group">
                                    <label for="tgl_selesai" class="form-label">Tanggal Sekarang</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}" id="tgl_sekarang" name="tgl_sekarang" autocomplete="off" readonly>
                                        <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class=""  id="tanggalmulai">
                                <div class="form-group">
                                    <label for="tgl_mulai" class="form-label">Aktif Dari</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="datepicker-autoclosea1" name="tgl_mulai" autocomplete="off">
                                        <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="" id="tanggalselesai">
                                <div class="form-group">
                                    <label for="tgl_selesai" class="form-label">Sampai</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="datepicker-autoclosea2" name="tgl_selesai" autocomplete="off">
                                        <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                    </div>
                                </div>
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
<script src="assets/js/app.js"></script>
<script src="assets/pages/form-advanced.js"></script>

<script type="text/javascript">
    $(function()
    {
        $('#tglmulai').prop("hidden", true);
        $('#tglnow').prop("hidden", true);

        $('#jenicuti').on('change', function(a)
        {
            if(a.target.value == 1)
            {
                $('#tglmulai').prop("hidden", false);
                $('#tglnow').prop("hidden", false);
            } else
                {
                    $('#tglmulai').prop("hidden", true);
                    $('#tglnow').prop("hidden", true);
            }
        });
    });
</script>




         