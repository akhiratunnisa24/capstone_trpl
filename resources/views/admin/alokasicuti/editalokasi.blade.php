{{-- FORM SETTING ALOKASI--}}
<link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">

<div class="modal fade" data-alokasi="{{$data->id}}" id="editalokasi" tabindex="-1" role="dialog"
    aria-labelledby="editalokasi" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="editalokas">Edit Alokasi Cuti</h4>
            </div>
            <div class="modal-body">
                {{-- <form class="input" action="/updatealokasi/{{$data->id}}" method="POST"
                    enctype="multipart/form-data"> --}}
                    <form class="input" action="" id="input">
                        @csrf
                        {{-- @method('PUT') --}}
                        <div class="panel-body">
                            <div class="col-md-6">
                                <input type="hidden" id="id_alokasi" name="id">
                                <input type="hidden" id="idsettingalokasi" name="id_settingalokasi">

                                <div class="form-group col-sm">
                                    <label for="id_jeniscuti" class="col-form-label">Kategori Cuti</label>
                                    <select name="id_jeniscuti" id="idjeniscuti" class="form-control">
                                        @foreach ($jeniscuti as $jenis)
                                        <option value="{{$jenis->id }}">{{ $jenis->jenis_cuti }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="id_karyawan" class="col-form-label">Karyawan</label>
                                    <input type="text" class="form-control" name="id_karyawan" id="id_karyawan"
                                        value="{{$data->id_karyawan}} - {{$data->karyawans->nama}}" readonly>
                                </div>
                                {{-- <div class="form-group col-sm" id="idkaryawan">
                                    <label for="id_karyawan" class="col-form-label">Karyawan</label>
                                    <select name="id_karyawan" id="id_karyawan" class="form-control" readonly>
                                        <option value="{{$data->id_karyawan}}" selected>
                                            {{$data->id_karyawan}}{{$data->karyawans->nama}}</option>
                                        @foreach ($karyawan as $item)
                                        <option value="{{$item->id}}" @if($item->id == $data->id_karyawan)
                                            selected
                                            @endif
                                            >{{$item->nama}}</option>
                                        @endforeach
                                    </select>
                                </div> --}}
                                <div class="form-group">
                                    <label for="durasi" class="col-form-label">Durasi (Hari)</label>
                                    <input type="text" class="form-control" name="durasi" placeholder="durasi"
                                        id="duration" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="mode_alokasi" class="col-form-label">Mode Alokasi</label>
                                    <input type="text" class="form-control" name="mode_alokasi"
                                        placeholder="mode alokasi" id="modealokasi" readonly>
                                </div>
                            </div>


                            <div class="col-md-6">
                                @if($data->tgl_masuk != null && $data->tgl_sekarang != null)
                                <div class="" id="tglmulai">
                                    <div class="form-group">
                                        <label for="tgl_masuk" class="form-label">Tanggal Masuk</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="yyyy/mm/dd"
                                                id="tglmasuk" name="tgl_masuk" autocomplete="off" readonly>
                                            <span class="input-group-addon bg-custom b-0"><i
                                                    class="mdi mdi-calendar text-white"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="" id="tglnow">
                                    <div class="form-group">
                                        <label for="tgl_sekarang" class="form-label">Tanggal Sekarang</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="tglsekarang" name="tgl_sekarang"
                                                autocomplete="off" readonly>
                                            <span class="input-group-addon bg-custom b-0"><i
                                                    class="mdi mdi-calendar text-white"></i></span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="" id="tanggalmulai">
                                    <div class="form-group">
                                        <label for="tgl_mulai" class="form-label">Aktif Dari</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="yyyy/mm/dd"
                                                id="datepicker-autoclosea3" name="aktif_dari" autocomplete="off">
                                            <span class="input-group-addon bg-custom b-0"><i
                                                    class="mdi mdi-calendar text-white"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="" id="tanggalselesai">
                                    <div class="form-group">
                                        <label for="sampai" class="form-label">Sampai</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="yyyy/mm/dd"
                                                id="datepicker-autoclosea4" name="sampai" autocomplete="off">
                                            <span class="input-group-addon bg-custom b-0"><i
                                                    class="mdi mdi-calendar text-white"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            {{-- <button type="submit" class="btn btn-info" name="submit" value="submit"
                                id="update_data">Update</button> --}}
                            <button onclick="window.location.reload();" type="button" class="btn btn-success" name="submit"
                                id="update_data" data-dismiss="modal">Update</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>

<!-- jQuery  -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/pages/form-advanced.js"></script>
<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

<!-- script untuk mengambil data alokasi cuti  -->
<script type="text/javascript">
    $('body').on('click','.btn-editalokasi',function() 
    {
        var id_alokasi =$(this).data('alokasi');

        // console.log(id_alokasi);
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                        .attr('content')
                    }
        });
        $.ajax({
            url: "/edit-alokasi/"+id_alokasi,
            type: "GET",
            cache: false,
            success: function (response) {
                // console.log(response);
                $('#id_alokasi').val(response.data.id);
                $("#idjeniscuti").val(response.data.id_jeniscuti);
                $("#idsettingalokasi").val(response.data.id_settingalokasi);
                $("#id_karyawan").val(response.data.id_karyawan);
                $("#duration").val(response.data.durasi);
                $("#modealokasi").val(response.data.mode_alokasi);
                $("#tglmasuk").val(response.data.tgl_masuk);
                $("#tglsekarang").val(response.data.tgl_sekarang);
                $("#datepicker-autoclosea3").val(response.data.aktif_dari);
                $("#datepicker-autoclosea4").val(response.data.sampai);

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
        $('#tglmulai').prop("hidden", false);
        $('#tglnow').prop("hidden", false);
       
        $('#idjeniscuti').on('change', function(a)
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

<!-- script untuk menyimpan data update-->
<script type="text/javascript">
    $("#update_data").click(function(e){
        e.preventDefault();
        let id_alokasi       = $("#id_alokasi").val();
        let id_settingalokasi= $("#idsettingalokasi").val();
        let id_jeniscuti     = $("#idjeniscuti").val();
        let id_karyawan      = $("#id_karyawan").val();
        let durasi           = $("#duration").val();
        let mode_alokasi     = $("#modealokasi").val();
        let tgl_masuk        = $("#tglmasuk").val();
        let tgl_sekarang     = $("#tglsekarang").val();
        let aktif_dari       = $("#datepicker-autoclosea3").val();
        let sampai           = $("#datepicker-autoclosea4").val();
        let _token           = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: "/updatealokasi/"+id_alokasi,
            type: "PUT",
            data: {
                    "id":id_alokasi, 
                    "id_settingalokasi": id_settingalokasi,
                    "id_jeniscuti": id_jeniscuti,
                    "id_karyawan": id_karyawan,
                    "durasi": durasi,
                    "mode_alokasi": mode_alokasi,
                    "tgl_masuk": tgl_masuk,
                    "tgl_sekarang": tgl_sekarang,
                    "aktif_dari":aktif_dari,
                    "sampai": sampai,
                    "_token": _token,
                },
                success: function (response) {
                    $('#aid'+ response.id +' td:nth-child(1)').text(response.id_karyawan);
                    $('#aid'+ response.id +' td:nth-child(2)').text(response.id_jeniscuti);
                    $('#aid'+ response.id +' td:nth-child(3)').text(response.durasi);
                    $('#aid'+ response.id +' td:nth-child(4)').text(response.mode_alokasi);
                    $('#aid'+ response.id +' td:nth-child(5)').text(response.aktif_dari);
                    $('#aid'+ response.id +' td:nth-child(6)').text(response.sampai);
                    
                    modal.hide();
                    // $('#editalokasi').modal('hide');
                    // $("#editalokasi").modal(toggle);
                    $("#input")[0].reset();
                    
                   
                    // $('#aid'+ response.id +' td:nth-child(1)').text(response.id_settingalokasi);
                    // $('#aid'+ response.id +' td:nth-child(6)').text(response.tgl_masuk);
                    // $('#aid'+ response.id +' td:nth-child(7)').text(response.tgl_sekarang);
                }
        });
    });
</script>