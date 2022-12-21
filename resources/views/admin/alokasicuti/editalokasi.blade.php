{{-- FORM SETTING ALOKASI--}}
<div class="modal fade"  data-alokasi="{{$data->id}}" id="editalokasi" tabindex="-1" role="dialog" aria-labelledby="editalokasi" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="editalokasi">Edit Alokasi Cuti</h4>
            </div>  
            <div class="modal-body">
                {{-- action="/updatealokasi/{{$data->id}}" --}}
                <form class="input" action="/updatealokasi/{{$data->id}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="panel-body">
                        <div class="col-md-6">
                            <input type="hidden" id="id_alokasi" name="id" value="{{$data->id}}">
                            <input type="hidden" name="id_settingalokasi" id="idsettingalokasi" value="{{$data->id_settingalokasi}}">
                    
                            <div class="form-group col-sm">
                                <label for="id_jeniscuti" class="col-form-label">Kategori Cuti</label>
                                <select name="id_jeniscuti" id="idjeniscuti" class="form-control">
                                    <option value="{{$data->id_jeniscuti}}" selected>{{$data->jeniscutis->jenis_cuti}}</option>
                                    @foreach ($jeniscuti as $jenis)
                                        <option value="{{$jenis->id }}">{{ $jenis->jenis_cuti }}</option>
                                    @endforeach
                                </select>
                            </div>
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
                                <input type="text" class="form-control" name="durasi" placeholder="durasi" id="duration" readonly>
                            </div>
                            <div class="form-group">
                                <label for="mode_alokasi" class="col-form-label">Mode Alokasi</label>
                                <input type="text" class="form-control" name="mode_alokasi" placeholder="mode alokasi" id="modealokasi" readonly>
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
                        <button type="submit" class="btn btn-info" name="submit" value="submit" id="update_data">Update</button>
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
                // $("#tglmasuk").val(response.data.tgl_masuk);
                // $("#tglsekarang").val(response.data.tgl_sekarang);
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

<!-- script untuk menyimpan data update-->
<script type="text/javascript">
    $(".input").click(function(e) {
        e.preventDefault();
        //nama variabel | id field pada form | value
        var id_alokasi       = $("#id_alokasi").val();
        var id_settingalokasi= $("idsettingalokasi").val();
        var id_jeniscuti     = $("#idjeniscuti").val();
        var id_karyawan      = $("#id_karyawan").val();
        var durasi           = $("#duration").val();
        var mode_alokasi     = $("#modealokasi").val();
        var tgl_masuk        = $("#tglmasuk").val();
        var tgl_sekarang     = $("#tglsekarang").val();
        var aktif_dari       = $("#datepicker-autoclosea3").val();
        var sampai           = $("#datepicker-autoclosea4").val();
        var token            = $('meta[name="csrf-token"]').attr('content');
    });
    $.ajax({
        url: "/updatealokasi/{$id_alokasi}"
        type:"PUT",
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
            "_token": token,
        },
        success: function(response) { 
            //CARA 1
            $('#aid'+ response.id +' td:nth-child(1)').text(response.id_karyawan);
            $('#aid'+ response.id +' td:nth-child(2)').text(response.id_jeniscuti);
            $('#aid'+ response.id +' td:nth-child(3)').text(response.durasi);
            $('#aid'+ response.id +' td:nth-child(4)').text(response.mode_alokasi);
            $('#aid'+ response.id +' td:nth-child(5)').text(response.aktif_dari);
            $('#aid'+ response.id +' td:nth-child(6)').text(response.sampai);
           
            $(".input")[0].reset();

            if(response.statusCode)
             {
                window.location.href = "/alokasicuti";
             }
             else{
                 alert("Internal Server Error");
             }
          
            //window.location.replace("http://127.0.0.1:8000/alokasicuti");

            // $('#aid'+ response.id +' td:nth-child(1)').text(response.id_settingalokasi);
            // $('#aid'+ response.id +' td:nth-child(6)').text(response.tgl_masuk);
            // $('#aid'+ response.id +' td:nth-child(7)').text(response.tgl_sekarang);

            //CARA 2
            // let alokasicuti = '<tr id="aid${response.data.id}">
            //                         <td>${response.data.id_karyawan}</td>
            //                         <td>${response.data.id_jeniscuti}</td>
            //                         <td>${response.data.durasi}</td>
            //                         <td>${response.data.mode_alokasi}</td>
            //                         <td>${response.data.aktif_dari}</td>
            //                         <td>${response.data.sampai}</td>
            //                         <td class="text-center"> 
            //                             <div class="row">
            //                                 <a id="bs" class="btn btn-info btn-sm showalokasi" data-toggle="modal" data-target="#showalokasi{{$data->id}}">
            //                                     <i class="fa fa-eye"></i>
            //                                 </a> 
            //                                 <a class="btn btn-sm btn-success btn-editalokasi" data-toggle="modal" data-alokasi="{{$data->id}}" data-target="#editalokasi">
            //                                     <i class="fa fa-edit"></i>
            //                                     {{-- {{$data->id}} --}}
            //                                 </a> 
            //                                 <button onclick="alokasicuti({{$data->id}})"  class="btn btn-danger btn-sm">
            //                                     <i class="fa fa-trash"></i>
            //                                 </button> 
            //                             </div> 
            //                         </td> 
            //                     </tr>';
            //     //append to post data
            //     $(`#aid${response.data.id}`).replaceWith(alokasicuti);
        },
    });
</script>





         