    {{-- FORM PENGAJUAN IZIN--}}
    {{-- bbootsrapt clockpicker  --}}
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.css">
    <link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">

    <div class="modal fade" id="smallModal" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title text-center" id="myModalLabel">FORM KETERANGAN KETIDAKHADIRAN KERJA</h4>
                </div> 
        
                <div class="modal-body">
                    <form class="input" action="{{ route('izinstore')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group col-sm">
                                        <label for="tgl_permohonan" class="col-form-label">Tanggal Permohonan</label>
                                        <input type="text" class="form-control" name="tglpermohonan" id="tgl_permohonan" value="{{ date('d/m/Y') }}" readonly>
                                    </div>
                                    <div class="form-group col-sm">
                                        <label for="nik" class="col-form-label">Nomor Induk Karyawan</label>
                                        <input type="text" class="form-control" name="nik" id="nik" value="{{$datakry->nip}}" readonly>
                                    </div>         
                                    <div class="form-group">
                                        <label for="id_karyawan" class="col-form-label">Nama Karyawan</label>
                                        <input type="text" class="form-control" id="id_karyawan" value="{{Auth::user()->name}}" readonly>
                                        <input type="hidden" class="form-control" name="id_karyawan" id="id_karyawan" value="{{$karyawan}}" hidden>
                                    </div>
                                    <div class="form-group col-sm">
                                        <label for="jabatan" class="col-form-label">Jabatan</label>
                                        <input type="text" class="form-control" name="jabatan" id="jabatan" value="{{$datakry->nama_jabatan}}" readonly>
                                    </div> 
                                    <div class="form-group col-sm">
                                        <label for="departemen" class="col-form-label">Departemen/Divisi</label>
                                        <input type="text" class="form-control" id="departemen" value="{{$departemen->nama_departemen}}" readonly>
                                        <input type="hidden" class="form-control" name="departemen" id="departemen" value="{{$departemen->id}}" hidden>
                                    </div> 
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group col-sm" id="jenisizin">
                                        <label for="id_jenisizin" class="col-form-label">Status Ketidakhadiran Kerja</label>
                                        <select name="id_jenisizin" id="id_jenisizin" class="form-control selectpicker" data-live-search="true" required>
                                            <option>-- Pilih Status --</option>
                                            @foreach ($jenisizin as $data)
                                                <option value="{{ $data->id}}" 
                                                    >{{ $data->jenis_izin }}
                                                </option>
                                            @endforeach
                                        </select> 
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6 col-xs-12">
                                            <div id="tanggalmulai">
                                                <div class="form-group">
                                                    <label for="tgl_mulai" class="form-label">Tanggal Pelaksanaan</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" placeholder="dd/mm/yyyy" id="datepicker-autoclosec" name="tgl_mulai" onchange=(jumlahhari()) autocomplete="off" required>
                                                        <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                       
                                        <div class="col-sm-6 col-xs-12">
                                            <div id="tanggalselesai">
                                                <div class="form-group">
                                                    <label for="tgl_selesai" class="form-label">Sampai</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" placeholder="dd/mm/yyyy" id="datepicker-autoclosed" name="tgl_selesai"  onchange=(jumlahhari()) autocomplete="off">
                                                        <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                                    </div>
                                                </div>
                                            </div>                                           
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="keperluan" class="col-form-label">Keterangan</label>
                                        <textarea class="form-control" name="keperluan" rows="5" placeholder="Masukkan keterangan"  id="keperluan" autocomplete="off" required></textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6" id="jmulai">  
                                            <div class="">
                                                <label for="jam_mulai">Dari Jam</label>
                                                <div class="input-group clockpicker pull-center" data-placement="top" data-align="top" data-autoclose="true">
                                                    <input type="text" class="form-control" autocomplete="off" name="jam_mulai" id="mulai">
                                                    <span class="input-group-addon">
                                                        <span class="fa fa-clock-o"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>  
                                        <div class="col-lg-6" id="jselesai">
                                            <div class="">
                                                <label for="jam_selesai">Sampai Jam</label>
                                                <div class="input-group clockpicker pull-center" data-placement="top" data-align="top"  data-autoclose="true">
                                                    <input type="text" class="form-control" name="jam_selesai" id="selesai" autocomplete="off">
                                                    <span class="input-group-addon">
                                                        <span class="fa fa-clock-o"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-sm" id="jumlahhari">
                                        <label for="jml_hari" class="col-form-label">Jumlah Hari</label>
                                        <input type="text" class="form-control" name="jml_hari" id="jml" readonly>
                                    </div>

                                    <div class="form-group col-sm"  id="jumlahjam">
                                        <input type="hidden" class="form-control" name="jml_jam" id="jam">
                                    </div>

                                    <div class="form-group col-sm">
                                        <input type="hidden" class="form-control" name="status" id="status" value="Pending" hidden>
                                        <input type="hidden" class="form-control" name="catatan" id="catatan" value="" hidden>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success" name="submit" value="save">Send</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery  -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    {{-- clockpicker --}}
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.js"></script>
    {{-- // Datatable init js  --}}
    <script src="assets/pages/datatables.init.js"></script>
    {{-- <script src="assets/js/app.js"></script> --}}
    {{-- // Plugins Init js --}}
    <script src="assets/pages/form-advanced.js"></script>

    <script>
        //show clockpicker 
        jQuery(function($){
            $('.clockpicker').clockpicker()
                .find('input').change(function()
                {
                    console.log(this.value);
                });
            var input = $('#single-input').clockpicker({
                placement: 'bottom',
                align: 'left',
                autoclose: true,
                'default': 'now'
            });
            
        });
    </script>
        
    <script type="text/javascript">
        //show/hide clockpicker when id_jenisizin selected
        $(function()
        {
            $('#jmulai').prop("hidden", true);
            $('#jselesai').prop("hidden", true);
            $('#tanggalmulai').prop("hidden", true);
            $('#tanggalselesai').prop("hidden", true);
            $('#jumlahhari').prop("hidden", true);

            $('#jenisizin').on('change', function(e)
            {
                if(e.target.value== 5)
                {
                    $('#jmulai').prop("hidden", false);
                    $('#jselesai').prop("hidden", false);
                    $('#tanggalmulai').prop("hidden", false);
                    $('#tanggalselesai').prop("hidden", true);
                    $('#jumlahhari').prop("hidden", true);

                } else {
                    $('#jmulai').prop("hidden", true);
                    $('#jselesai').prop("hidden", true);
                    $('#tanggalmulai').prop("hidden", false);
                    $('#tanggalselesai').prop("hidden", false);
                    $('#jumlahhari').prop("hidden", false);
                }
                // alert('id:' + e.target.value);
            });
        });

        function jumlahhari()
        {
            var start= $('#datepicker-autoclosec').val();
            var end  = $('#datepicker-autoclosed').val();

            var startArray = start.split('/');
            var startFormatted = startArray[1] + '/' + startArray[0] + '/' + startArray[2];
            var startdate = new Date(startFormatted);

            var endArray = end.split('/');
            var endFormatted = endArray[1] + '/' + endArray[0] + '/' + endArray[2];
            var enddate = new Date(endFormatted);

            console.log(start,end,startdate,enddate);

            // var startdate= new Date(start);
            // var enddate  = new Date(end);
            var daysOfYear= [];

            //MENDAPATKAN DATA HARI LIBUR
            $.ajax({
                url: '/getliburdata',
                type: 'GET',
                dataType: 'json',
                success: function(data){
                    var liburDate = data.map(function(libur) {
                        // return new Date(libur.tanggal).getTime();
                        var dateArray = libur.tanggal.split('/');
                        var dateFormatted = dateArray[2] + '-' + dateArray[1] + '-' + dateArray[0];
                        return new Date(dateFormatted).getTime();
                    });

                    //mendapatkan jumlah hari izin jika sakit
                    for (var d = startdate; d <= enddate; d.setDate(d.getDate() + 1)){
                        //cek workdays
                        let tgl = new Date(d);
                        if(tgl.getDay() !==0 && tgl.getDay() !==6 && !liburDate.includes(tgl.getTime())){
                            daysOfYear.push(tgl);
                            console.log(tgl);
                        } else{
                            console.log("hari Libur" + tgl.getDay());
                        }
                    };

                    //mengambil value tanggal mulai
                    $('#startdate').on('change', function(){
                        jumlahhari();
                    });
                    //mengambil value tanggal selesai
                    $('#enddate').on('change', function(){
                        jumlahhari();
                    });

                    $('#jml').val(daysOfYear.length ?? 0);
                    console.info(daysOfYear.length);
                },
                error: function(jqXHR, textStatus, errorThrown){
                    console.log(textStatus, errorThrown);
                }
            });    
        };
    </script>

{{-- //FUCNTION JUMLAHHARI ASLI
// function jumlahhari(){
//     var start= $('#datepicker-autoclosec').val();
//     var end  = $('#datepicker-autoclosed').val();

//     var startdate= new Date(start);
//     var enddate  = new Date(end);
//     var daysOfYear= [];

//     //mendapatkan jumlah hari izin jika sakit
//     for (var d = startdate; d <= enddate; d.setDate(d.getDate() + 1)){
//         //cek workdays
//         let tgl = new Date(d);
//         if(tgl.getDay() !=0 && tgl.getDay() !=6){
//             daysOfYear.push(tgl);
//             console.log(tgl);
//         } else{
//             console.log("hari Libur" + tgl.getDay());
//         };
//     };

//     //mengambil value tanggal mulai
//     $('#startdate').on('change', function(){
//         jumlahhari();
//     });
//     //mengambil value tanggal selesai
//     $('#enddate').on('change', function(){
//         jumlahhari();
//     });

//     $('#jml').val(daysOfYear.length ?? 0);
//     console.info(daysOfYear.length);
// }; --}}


    

    
             