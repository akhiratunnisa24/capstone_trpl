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
                            <div class="form-group col-sm">
                                <label for="id_jeniscuti" class="col-form-label">Kategori Cuti</label>
                                <select name="id_jeniscuti" id="idjeniscuti" class="form-control">
                                    <option value="{{$data->id_jeniscuti}}" selected>{{$data->jeniscutis->jenis_cuti}}</option>
                                    @foreach ($jeniscuti as $jenis)
                                        <option value="{{$jenis->id }}">{{ $jenis->jenis_cuti }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="text" class="form-control" name="durasi" placeholder="durasi" id="idsettingalokasi" value="{{$data->id_settingalokasi}} --> id settingalokasi" readonly>
                            <input type="text" class="form-control" name="durasi" placeholder="durasi" id="idjeniscutis" value="{{$data->id_jeniscuti}} --> id kategori" readonly>
                            <input type="text" class="form-control" name="durasi" placeholder="durasi" id="idjeniscutis" value="{{$data->id_karyawan}} -->id karyawan" readonly>
                            <input type="text" class="form-control" name="durasi" placeholder="durasi" id="idjeniscutis" value="{{$data->durasi}} Hari --> durasi" readonly>
                            <input type="text" class="form-control" name="durasi" placeholder="durasi" id="idjeniscutis" value="{{$data->mode_alokasi}} -->mode alokasi" readonly>
                            <input type="text" class="form-control" name="durasi" placeholder="durasi" id="idjeniscutis" value="{{\Carbon\carbon::parse($data->aktif_dari)->format('m/d/Y')}} -->aktif dari" readonly>
                            <input type="text" class="form-control" name="durasi" placeholder="durasi" id="idjeniscutis" value="{{\Carbon\carbon::parse($data->sampai)->format('m/d/Y')}} -->sampai tanggal"readonly>

                            <div class="form-group col-sm" id="idkaryawan">
                                <label for="id_karyawan" class="col-form-label">Karyawan</label>
                                <select name="id_karyawan" id="id_karyawan" class="form-control">
                                    <option value="{{$data->id_karyawan}}" selected>{{$data->karyawans->nama}}</option>
                                    @foreach ($karyawan as $data)
                                        <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="durasi" class="col-form-label">Durasi (Hari)</label>
                                <input type="text" class="form-control" name="durasi" placeholder="durasi" id="duration" value="{{$data->durasi}}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="mode_alokasi" class="col-form-label">Mode Alokasi</label>
                                <input type="text" class="form-control" name="mode_alokasi" placeholder="mode alokasi" value="{{$data->mode_alokasi}}" id="modealokasi" readonly>
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
                                        <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="datepicker-autoclosea3" name="aktif_dari" value="{{\Carbon\carbon::parse($data->aktif_dari)->format('m/d/Y')}}"  autocomplete="off">
                                        <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="" id="tanggalselesai">
                                <div class="form-group">
                                    <label for="sampai" class="form-label">Sampai</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="datepicker-autoclosea4" name="sampai" value="{{\Carbon\carbon::parse($data->sampai)->format('m/d/Y')}}" autocomplete="off">
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

<!-- script untuk mengambil data tanggalmasuk  -->
<script type="text/javascript">
    //button create alokasicuti event
    $('body').on('click','#btn-editalokasi',function() {
        Let id_alokasi =  $(this).data("id");

        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                        .attr('content')
                    }
        });
        //fetch detail post with ajax
        $.ajax({
            url: `/edit-alokasi/${id_alokasi}`,  //url untuk mengambil data ajax, otomatis harus ada 1 route untuk menampilkan datanya
            type: "GET",
            cache: false,
            success: function(response){
                //fill data to form
                $("#idjeniscuti").val(data.alokasicuti.id_jeniscuti);
                $("#idsettingalokasi").val(data.alokasicuti.id_settingalokasi);
                $("#idkaryawana").val(data.alokasicuti.id_karyawan);
                $("#durasi").val(data.alokasicuti.durasi);
                $("#modealokasi").val(data.alokasicuti.mode_alokasi);
                $("#tglmasuk").val(data.alokasicuti.tgl_masuk);
                $("#tglsekarang").val(data.alokasicuti.tgl_Sekarang);
                $("#aktifdari").val(data.alokasicuti.aktif_dari);
                $("#sampai").val(data.alokasicuti.sampai);
                $('#id_alokasi').val(response.data.id);
                
                //open modal
                $('#editalokasi').modal('show');
            }
        });
    });
</script>

<!-- Script untuk mengambil nilai settingalokasi  -->
<script type="text/javascript">
    $('#idjeniscuti').on('change',function(e){
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
                $('#idsettingalokasi').val(data.id);
                $('#duration').val(data.durasi);
                $('#modealokasi').val(data.mode_alokasi);
            }
        });
    });
</script>

<!-- script untuk mengambil data tanggalmasuk  -->
<script type="text/javascript">
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

<!-- script untuk memunculkan form tglmasuk dan tglsekarang ketika kategori cuti == Cuti Tahunan -->
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




         