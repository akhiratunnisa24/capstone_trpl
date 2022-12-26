    {{-- FORM PENGAJUAN IZIN--}}
    {{-- bbootsrapt clockpicker  --}}
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.css">
    <link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">

    <div class="modal fade" id="smallModal" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Form Permohonan Izin</h4>
                </div> 
        
                <div class="modal-body">
                    <form class="input" action="{{ route('izinstore')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <label for="id_karyawan" class="col-form-label">Nama</label>
                            <input type="text" class="form-control" id="id_karyawan" value="{{Auth::user()->name}}" readonly>
                            <input type="hidden" class="form-control" name="id_karyawan" id="id_karyawan" value="{{$karyawan}}" hidden>
                        </div>
                        <div class="form-group col-sm" id="jenisizin">
                            <label for="id_jenisizin" class="col-form-label">Kategori Izin</label>
                            <select name="id_jenisizin" id="id_jenisizin" class="form-control" required>
                                <option>-- Pilih Kategori --</option>
                                @foreach ($jenisizin as $data)
                                    <option value="{{ $data->id}}" 
                                        {{-- {{ old('id_jenisizin') == $data->id ? 'selected' : '' }} --}}
                                        >{{ $data->jenis_izin }}
                                    </option>
                                @endforeach
                            </select> 
                        </div>
                        <div class="form-group">
                            <label for="keperluan" class="col-form-label">Keperluan</label>
                            <input type="text" class="form-control" name="keperluan" placeholder="Masukkan keperluan" id="keperluan" required>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class=""  id="tanggalmulai">
                                    {{-- <form class="" action="#"> --}}
                                        <div class="form-group">
                                            <label for="tgl_mulai" class="form-label">Tanggal Mulai</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="datepicker-autoclosec" name="tgl_mulai" onchange=(jumlahhari()) autocomplete="off">
                                                <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                            </div>
                                        </div>
                                    {{-- </form> --}}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="" id="tanggalselesai">
                                    {{-- <form class="" action="#"> --}}
                                        <div class="form-group">
                                            <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="datepicker-autoclosed" name="tgl_selesai"  onchange=(jumlahhari()) autocomplete="off">
                                                <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                            </div>
                                        </div>
                                    {{-- </form> --}}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6" id="jmulai">  
                                <div class="">
                                    <label for="jam_mulai">Dari Jam</label>
                                    <div class="input-group clockpicker pull-center" data-placement="top" data-align="top" autocomplete="off" data-autoclose="true">
                                        <input type="text" class="form-control" name="jam_mulai" id="mulai">
                                        <span class="input-group-addon">
                                            <span class="fa fa-clock-o"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>  
                            <div class="col-lg-6" id="jselesai">
                                <div class="">
                                    <label for="jam_selesai">Sampai Jam</label>
                                    <div class="input-group clockpicker pull-center" data-placement="top" data-align="top" autocomplete="off" data-autoclose="true">
                                        <input type="text" class="form-control" name="jam_selesai" id="selesai">
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
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" name="submit" value="save">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery  -->
    <script src="assets/js/jquery.min.js"></script>
    
    <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    {{-- clockpicker --}}
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.js"></script>
    {{-- // Datatable init js  --}}
    <script src="assets/pages/datatables.init.js"></script>
    <script src="assets/js/app.js"></script>
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
                if(e.target.value== 1 || e.target.value== 2)
                {
                    $('#jmulai').prop("hidden", false);
                    $('#jselesai').prop("hidden", false);
                    $('#tanggalmulai').prop("hidden", false);
                    $('#tanggalselesai').prop("hidden", true);
                    $('#jumlahhari').prop("hidden", true);

                    if(e.target.value== 1)
                    {
                        //set nilai jam_mulai
                        $('#mulai').val('08:00');
                        $('#mulai').attr('readonly', false);
                        $('#mulai').css('background-color' , '#DEDEDE');
                    }else {
                        //set nilai jam_selesai
                        $('#selesai').val('17:00');
                        $('#selesai').attr('readonly', false);
                        $('#selesai').css('background-color' , '#DEDEDE');
                    }
                    // alert('DATA ADA');
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

        //datepicker for tgl_mulai & tgl_selesai
        $('#datepicker-autoclosec').datepicker({
            autoclose: true,
        });

        $('#datepicker-autoclosed').datepicker({
            autoclose: true,
        });

        function jumlahhari(){
            var start= $('#datepicker-autoclosec').val();
            var end  = $('#datepicker-autoclosed').val();

            var start_date= new Date(start);
            var end_date  = new Date(end) ;
            var daysOfYear= [];

            //mendapatkan jumlah hari izin jika sakit
            for (var d = start_date; d <= end_date; d.setDate(d.getDate() + 1)){
                //cek workdays
                let tgl = new Date(d);
                if(tgl.getDay() !=0 && tgl.getDay() !=6){
                    daysOfYear.push(tgl);
                    console.log(tgl);
                } else{
                    console.log("hari Libur" + tgl.getDay());
                };
            };

            //mengambil value tanggal mulai
            $('#start_date').on('change', function(){
                jumlahhari();
            });
            //mengambil value tanggal selesai
            $('#end_date').on('change', function(){
                jumlahhari();
            });

            console.info(daysOfYear);
            $('#jml').val(daysOfYear.length ?? 0);
        };

    </script>


    

    
             