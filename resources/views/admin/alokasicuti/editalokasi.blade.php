{{-- FORM SETTING ALOKASI--}}
<div class="modal fade" id="editalokasi{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="editalokasi" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="editalokasi">Edit Alokasi Cuti</h4>
            </div>  
            <div class="modal-body">
                <form class="input" action="/updatealokasi/{{$data->id}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="panel-body">
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="id" id="id" value="{{$data->id}}" required>
                            <div class="form-group col-sm" id="jenicuti">
                                <label for="id_jeniscuti" class="col-form-label">Kategori Cuti</label>
                                <select name="id_jeniscuti" id="id_jeniscuti" class="form-control">
                                    @foreach ($jeniscuti as $data)
                                        <option value="{{ $data->id}}"
                                            @if ($data->id == $data->id_jeniscuti)
                                                selected
                                            @endif
                                            >{{ $data->jenis_cuti }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-sm" id="idkaryawan">
                                <label for="id_karyawan" class="col-form-label">Karyawan</label>
                                <select name="id_karyawan" id="id_karyawan" class="form-control">
                                    @foreach ($karyawan as $data)
                                        <option value="{{ $data->id}}"
                                            @if ($data->id == $data->id_karyawan)
                                                selected
                                            @endif
                                            >{{ $data->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="durasi" class="col-form-label">Durasi (Hari)</label>
                                <input type="text" class="form-control" name="durasi" placeholder="durasi" id="durasi" value="{{$data->durasi}}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="mode_alokasi" class="col-form-label">Mode Alokasi</label>
                                <input type="text" class="form-control" name="mode_alokasi" placeholder="mode alokasi" value="{{$data->mode_alokasi}}" id="mode_alokasi" readonly>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class=""  id="tglmulai">
                                <div class="form-group">
                                    <label for="tgl_masuk" class="form-label">Tanggal Masuk</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="tglmasuk" name="tgl_masuk" autocomplete="off" readonly>
                                        <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="" id="tglnow">
                                <div class="form-group">
                                    <label for="tgl_sekarang" class="form-label">Tanggal Sekarang</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="tglsekarang" name="tgl_sekarang" autocomplete="off" readonly>
                                        <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class=""  id="tanggalmulai">
                                <div class="form-group">
                                    <label for="tgl_mulai" class="form-label">Aktif Dari</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="datepicker-autoclosea3" name="aktif_dari" autocomplete="off">
                                        <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="" id="tanggalselesai">
                                <div class="form-group">
                                    <label for="sampai" class="form-label">Sampai</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="datepicker-autoclosea4" name="sampai" autocomplete="off">
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

<!-- Script untuk mengambil nilai settingalokasi  -->
<script>
    $('#jeniscuti').on('change',function(e){
        var id_jeniscuti = e.target.value;
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                        .attr('content')
                    }
        });
        $.ajax({
            type:"POST",
            url: '{{route('get.Setting.alokasi')}}',
            data: {'id_jeniscuti':id_jeniscuti},
            success:function(data){
                // console.log(data);
                $('#id_settingalokasi').val(data.id);
                $('#durasi').val(data.durasi);
                $('#mode_alokasi').val(data.mode_alokasi);
            }
        });
    });
</script>

<!-- script untuk mengambil data tanggalmasuk  -->
<script>
    $('#id_karyawan').on('change',function(e){
        var id_karyawan = e.target.value;
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                        .attr('content')
                    }
        });
        $.ajax({
            type:"POST",
            url: '{{route('get.Tanggalmasuk')}}',
            data: {'id_karyawan':id_karyawan},
            success:function(data){
                // console.log(data);
                $('#tgl_masuk').val(data.tglmasuk);
                // console.log(data?.tglmasuk)
            }
        });
    });
</script> 

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




         