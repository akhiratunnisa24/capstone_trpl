{{-- FORM SETTING ALOKASI--}}
<div class="modal fade" id="newalokasi" tabindex="-1" role="dialog" aria-labelledby="newalokasi" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="newalokasi">Tambah Alokasi Cuti</h4>
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
                <form class="input" action="{{route('alokasi.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="panel-body">
                        <div class="col-md-6">
                            <div class="form-group col-sm" id="jeniscuti">
                                <label for="id_jeniscuti" class="col-form-label">Kategori Cuti</label>
                                <select name="id_jeniscuti" id="id_jeniscuti" class="form-control"> 
                                    <option value="">Pilih Kategori Cuti</option>
                                        @foreach ($jeniscuti as $jenis)
                                            <option value="{{ $jenis->id }}">{{ $jenis->jenis_cuti }}</option>
                                        @endforeach
                                </select>
                            </div>
                            <input type="hidden" class="form-control" name="id_settingalokasi" placeholder="id_settingalokasi" id="id_settingalokasi" readonly>
                            
                            <div class="form-group col-sm" id="id_karyawan">
                                <label for="id_karyawan" class="col-form-label">Karyawan</label>
                                <select name="id_karyawan" id="id_karyawan" class="form-control">
                                    <option value="">Pilih Karyawan</option>
                                    @foreach ($karyawan as $data)
                                        <option value="{{ $data->id }}">{{ $data->nama }}</option>
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
                            <div class=""  id="tanggalmulai">
                                <div class="form-group">
                                    <label for="tgl_masuk" class="form-label">Tanggal Masuk</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="tgl_masuk" name="tgl_masuk" autocomplete="off" readonly>
                                        <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="" id="tanggalselesai">
                                <div class="form-group">
                                    <label for="tgl_sekarang" class="form-label">Tanggal Sekarang</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="tgl_sekarang" name="tgl_sekarang" autocomplete="off" readonly>
                                        <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class=""  id="start">
                                <div class="form-group">
                                    <label for="tgl_mulai" class="form-label">Aktif Dari</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="datepicker-autoclosea1" name="tgl_mulai" autocomplete="off">
                                        <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="" id="end">
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
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/app.js"></script>
<script src="assets/pages/form-advanced.js"></script>
<script type="text/javascript">
    $(function()
    {
        $('#tanggalmulai').prop("hidden", true);
        $('#tanggalselesai').prop("hidden", true);

        $('#jeniscuti').on('change', function(e)
        {
            if(e.target.value== 1)
            {
                $('#tanggalmulai').prop("hidden", false);
                $('#tanggalselesai').prop("hidden", false);

                let d = new Date(Date.now());
                $('#tgl_sekarang').val(d);

            } else
                {
                    $('#tanggalmulai').prop("hidden", true);
                    $('#tanggalselesai').prop("hidden", true);
                }
        });
    });
</script>
<script>
    $('#id_jeniscuti').on('change',function(e){
        var id_jeniscuti = e.target.value;
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                        .attr('content')
                    }
        });
        $.ajax({
            type:"POST",
            url: '{{route('get.Settingalokasi')}}',
            data: {'id_jeniscuti':id_jeniscuti},
            success:function(data){
                // console.log(data);
                $('#id_settingalokasi').val(data.id);
                $('#durasi').val(data.durasi);
                $('#mode_alokasi').val(data.mode_alokasi);
                // console.log(data?.tglmasuk);
            }
        });
    });
</script>
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
            url: '{{route('get.Tglmasuk')}}',
            data: {'id_karyawan':id_karyawan},
            success:function(data){
                // console.log(data);
                $('#tgl_masuk').val(data.tglmasuk);
                console.log(data?.tglmasuk)
            }
        });
    });
</script>


{{-- <script>
    function otomatis(){
        var id_karyawan = $("#id_karyawan").val();
        $.ajax({
            url: '{{ route('alokasi.store')}}',
            method: 'GET',
            data:"id_karyawan="+id_karyawan ,
        }).success(function (data) {
            var json = data,
            obj = JSON.parse(json);
            $('#tgl_masuk').val(obj.tgl_masuk);
        });
    }
</script> --}}

{{-- <script type="text/javascript">
    $(document).ready(function(){
        $(document).on('change','.id_karyawan', function(){
            var id_karyawan = $(this).val();
            var tgl = $(this).parent().parent().parent();
            var tglmasuk =" ";
            $.ajax({
                type: 'get',
                url : '{{ route('alokasi.store')}}',
                data : {'id_karyawan':id_karyawan},
                success:function(data){
                    tglmasuk+='<option value="0" selected disabled</option>';
                    for(var i = 0;i<data.length;i++){
                        tglmasuk+='<option value="'+data[1].id+'">'+data[i].tgl_masuk+'</option>';
                    }
                }
            })
        })
    })
</script> --}}

<script>
    // function isi_otomatis(){
    //     var id_jeniscuti = $("#id_jeniscuti").val();
    //     $.ajax({
    //         url: 'ajax.php',
    //         data:"id_jeniscuti="+id_jeniscuti ,
    //     }).success(function (data) {
    //         var json = data,
    //         obj = JSON.parse(json);
    //         $('#durasi').val(obj.durasi);
    //         $('#mode_alokasi').val(obj.mode_alokasi);
    //     });
    // }
</script>






         