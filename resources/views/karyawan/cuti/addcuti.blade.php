{{-- FORM PENGAJUAN CUTI --}}
<link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">

    <div class="modal modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="Modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title text-center" id="Modal">FORM CUTI TAHUNAN KARYAWAN</h4>
                </div>
               
                <div class="alert alert-danger" id="error-message" style="display: none;">
                    <button type="button" class="close" onclick="$('#error-message').hide()">&times;</button>
                </div>

                <div class="alert alert-success" id="success-message" style="display: none;">
                    <button type="button" class="close" onclick="$('#success-message').hide()">&times;</button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('cuti.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group col-sm">
                                        <label for="tgl_permohonan" class="col-form-label">Tanggal Permohonan</label>
                                        <input type="text" class="form-control" name="tgl_permohonan" id="tgl_permohonan" value="{{ date('d/m/Y') }}" readonly>
                                    </div>               
                                    <div class="form-group col-sm">
                                        <label for="nik" class="col-form-label">Nomor Induk Karyawan</label>
                                        <input type="text" class="form-control" name="nik" id="nik" value="{{$datakry->nip}}" readonly>
                                    </div>         
                                    <div class="form-group col-sm">
                                        <label for="id_karyawan" class="col-form-label">Nama Karyawan</label>
                                        <input type="text" class="form-control" id="id_karyawan" value="{{Auth::user()->name}}" readonly>
                                        <input type="hidden" class="form-control" name="id_karyawan" id="id_karyawan" value="{{$karyawan}}" hidden>
                                    </div>
                                    <div class="form-group col-sm">
                                        <label for="jabatan" class="col-form-label">Jabatan</label>
                                        <input type="text" class="form-control" name="jabatan" id="jabatan" value="{{$datakry->jabatan}}" readonly>
                                    </div> 
                                    <div class="form-group col-sm">
                                        <label for="departemen" class="col-form-label">Departemen/Divisi</label>
                                        <input type="text" class="form-control" id="departemen" value="{{$departemen->nama_departemen}}" readonly>
                                        <input type="hidden" class="form-control" name="departemen" id="departemen" value="{{$departemen->id}}" hidden>
                                    </div> 
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group col-sm">
                                        <label for="id_jeniscuti" class="col-form-label">Status Ketidakhadiran / Kategori Cuti</label>
                                        <select name="id_jeniscuti" id="id_jeniscuti" class="form-control selectpicker" data-live-search="true" required>
                                            <option>-- Pilih Status Ketidakhadiran --</option>
                                            @foreach ($jeniscuti as $data)
                                                    <option value="{{ $data->id_jeniscuti}}">
                                                       {{ $data->jenis_cuti }} 
                                                    </option>
                                            @endforeach
                                        </select> 
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-12">
                                            <div>
                                                <div class="form-group">
                                                    <label for="tgl_mulai" class="form-label">Tanggal Pelaksanaan</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" onchange=(jumlahcuti()) placeholder="dd/mm/yyyy" id="datepicker-autoclosef" name="tgl_mulai"  autocomplete="off" rows="10" required>
                                                        <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                       
                                        <div class="col-sm-6 col-xs-12">
                                            <div>
                                                <div class="form-group">
                                                    <label for="tgl_selesai" class="form-label">Sampai</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" onchange=(jumlahcuti()) placeholder="dd/mm/yyyy" id="datepicker-autocloseg" name="tgl_selesai"  autocomplete="off" rows="10" required>
                                                        <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
            
                                    <div class="form-group col-sm">
                                        <label for="keperluan" class="col-form-label">Keterangan</label>
                                        <textarea class="form-control" name="keperluan" id="keperluan" rows="5" placeholder="Masukkan keterangan" autocomplete="off" required></textarea>
                                        {{-- <input type="text" class="form-control" name="keperluan" id="keperluan" placeholder="Masukkan keterangan" autocomplete="off" required> --}}
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-12">
                                            <div class="form-group col-sm">
                                                <label for="" class="col-form-label">Durasi Tersedia</label>
                                                <input type="text" class="form-control" name="durasi" id="durasi" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-12">
                                            <div class="form-group col-sm">
                                                <label for="jml_cuti" class="col-form-label">Jumlah Cuti</label>
                                                <input type="text" class="form-control" name="jml_cuti" id="jumlah" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm">
                                        <input type="hidden" class="form-control" name="id_alokasi" id="id_alokasi">
                                        <input type="hidden" class="form-control" name="id_settingalokasi" id="id_settingalokasi">
                                    </div>
            
                                    <div class="form-group col-sm">
                                        <input type="hidden" class="form-control" name="status" id="status" value="Pending">
                                    </div>
                                </div>
                            </div>
                        </div>
                            
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" id="submit-button" class="btn btn-success" value="save">Send</button>
                        </div>
                    </form>
                </div>
                {{--<div class="modal-body">
                    <form action="{{ route('cuti.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="form-group col-sm">
                            <label for="tgl_permohonan" class="col-form-label">Tanggal Permohonan</label>
                            <input type="text" class="form-control" id="tgl_permohonan" value="{{ date('d/m/Y') }}" readonly>
                        </div>               
                        <div class="form-group col-sm">
                            <label for="nik" class="col-form-label">Nomor Induk Karyawan</label>
                            <input type="text" class="form-control" id="nik" value="{{$datakry->nip}}" readonly>
                        </div>         
                        <div class="form-group col-sm">
                            <label for="id_karyawan" class="col-form-label">Nama Karyawan</label>
                            <input type="text" class="form-control" id="id_karyawan" value="{{Auth::user()->name}}" readonly>
                            <input type="hidden" class="form-control" id="id_karyawan" value="{{$karyawan}}" hidden>
                        </div>
                        <div class="form-group col-sm">
                            <label for="jabatan" class="col-form-label">Jabatan</label>
                            <input type="text" class="form-control" id="jabatan" value="{{$datakry->jabatan}}" readonly>
                        </div> 
                        <div class="form-group col-sm">
                            <label for="departemen" class="col-form-label">Departemen/Divisi</label>
                            <input type="text" class="form-control" id="departemen" value="{{$departemen->nama_departemen}}" readonly>
                            <input type="hidden" class="form-control" id="nik" value="{{$departemen->id}}" hidden>
                        </div> 
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="m-t-20">
                                    <div class="form-group">
                                        <label for="tgl_mulai" class="form-label">Tanggal Mulai</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" onchange=(jumlahcuti()) placeholder="yyyy/mm/dd" id="datepicker-autoclosef" name="tgl_mulai"  autocomplete="off" rows="10" required>
                                            <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                            <div class="col-sm-6 col-xs-12">
                                <div class="m-t-20">
                                    <div class="form-group">
                                        <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" onchange=(jumlahcuti()) placeholder="yyyy/mm/dd" id="datepicker-autocloseg" name="tgl_selesai"  autocomplete="off" rows="10" required>
                                            <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-sm">
                            <label for="id_jeniscuti" class="col-form-label">Status Ketidakhadiran / Kategori Cuti</label>
                            <select name="id_jeniscuti" id="id_jeniscuti" class="form-control selectpicker" data-live-search="true" required>
                                <option>-- Pilih Kategori --</option>
                                @foreach ($jeniscuti as $data)
                                        <option value="{{ $data->id_jeniscuti}}">
                                           {{ $data->jenis_cuti }} 
                                        </option>
                                @endforeach
                            </select> 
                        </div>
                        <div class="form-group col-sm">
                            <input type="hidden" class="form-control" name="id_alokasi" id="id_alokasi">
                            <input type="hidden" class="form-control" name="id_settingalokasi" id="id_settingalokasi">
                        </div>
                        <div class="form-group col-sm">
                            <label for="keperluan" class="col-form-label">Keterangan</label>
                            <input type="text" class="form-control" name="keperluan" id="keperluan" placeholder="Masukkan keperluan" autocomplete="off" required>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group col-sm">
                                    <label for="" class="col-form-label">Durasi Tersedia</label>
                                    <input type="text" class="form-control" name="durasi" id="durasi" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group col-sm">
                                    <label for="jml_cuti" class="col-form-label">Jumlah Cuti</label>
                                    <input type="text" class="form-control" name="jml_cuti" id="jumlah" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-sm">
                            <input type="hidden" class="form-control" name="status" id="status" value="Pending">
                        </div>
                            
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" id="submit-button" class="btn btn-success" value="save">Send</button>
                        </div>
                    </form>
                </div> --}}
            </div>
        </div>
    </div>
     <!-- jQuery  -->
     {{-- <script src="assets/js/jquery.min.js"></script> --}}
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     {{-- <script src="assets/js/bootstrap.min.js"></script> --}}

 
     {{-- plugin js --}}
     <script src="assets/plugins/timepicker/bootstrap-timepicker.js"></script>
     <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
   
     <!-- Datatable init js -->
     <script src="assets/pages/datatables.init.js"></script>
     {{-- <script src="assets/js/app.js"></script> --}}
 
     <!-- Plugins Init js -->
     <script src="assets/pages/form-advanced.js"></script>

     <!-- script untuk mengambil data durasi dari tabel alokasi cuti  -->
     

    <script  type="text/javascript">
        var durasi;
        $('#id_jeniscuti').on('change',function(e){
            var id_jeniscuti = e.target.value;
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                            .attr('content')
                        }
            });
            $.ajax({
                type:"POST",
                url: '{{route('get.Durasi')}}',
                data: {'id_jeniscuti':id_jeniscuti},
                success:function(data)
                {
                    $('#id_alokasi').val(data.id);
                    $('#id_settingalokasi').val(data.id_settingalokasi);
                    $('#durasi').val(data.durasi);
                    $('#aktif_dari').val(data.aktif_dari);
                    $('#sampai').val(data.sampai);
                    // console.log(data?.durasi)
                    durasi     = data.durasi;
                }
            });
        });
    </script>

    <script type="text/javascript">
        function jumlahcuti()
        {
            var start= $('#datepicker-autoclosef').val();
            var end  = $('#datepicker-autocloseg').val();
            console.log(start,end);

            // Mengubah format tanggal pada variabel start
            var startArray = start.split('/');
            var startFormatted = startArray[1] + '/' + startArray[0] + '/' + startArray[2];
            var start_date = new Date(startFormatted);

            // Mengubah format tanggal pada variabel end
            var endArray = end.split('/');
            var endFormatted = endArray[1] + '/' + endArray[0] + '/' + endArray[2];
            var end_date = new Date(endFormatted);

            console.log(start_date,end_date);
            // var start_date = new Date(start);
            // var end_date   = new Date(end);
            var daysOfYear = [];

            //MENDAPATKAN DATA HARI LIBUR
            $.ajax({
                url: '/getlibur',
                type: 'GET',
                dataType: 'json',
                success: function(data){
                    var liburDates = data.map(function(libur) {
                        // return new Date(libur.tanggal).getTime();
                        var dateArray = libur.tanggal.split('/');
                        var dateFormatted = dateArray[2] + '-' + dateArray[1] + '-' + dateArray[0];
                        return new Date(dateFormatted).getTime();
                    });

                     //untuk mendapatkan jumlah hari cuti
                    for (var d = start_date; d <= end_date; d.setDate(d.getDate() + 1)) 
                    {
                        //cek workdays
                        let tanggal = new Date(d);
                        if (tanggal.getDay() != 0 && tanggal.getDay() != 6 && !liburDates.includes(tanggal.getTime())) {
                            daysOfYear.push(tanggal);
                            console.log(tanggal);
                        } else {
                            console.log(" Hari Libur " + tanggal.getDay());
                        }
                    }

                    //mengambil value tanggal mulai
                    $('#start_date').on('change', function() {
                        jumlahcuti();
                    });

                    //mengambil value tanggal selesai
                    $('#end_date').on('change', function() {
                        jumlahcuti();
                    });

                    console.info(daysOfYear.length);
                    $('#jumlah').val(daysOfYear.length ?? 0);

                    //mengambil value jml_cuti
                    // var jml_cuti = $("#jumlah").val();
                    // var durasi   = $("#durasi").val(); ////ambil value dari input field durasi yang didapat dari ajax request
            
                    // if(jml_cuti > durasi){
                    //     $('#success-message').hide();
                    //     $('#error-message').html(' "WARNING !!"<br>Jumlah cuti yang diinput melebihi durasi cuti yang tersedia.<br>Silahkan pilih jumlah cuti yang lebih kecil atau sama dengan durasi');
                    //     $('#error-message').show();
                    //     $('#submit-button').attr('disabled', true); //nonaktifkan tombol submit

                    //     setTimeout(function() 
                    //     {
                    //         $('#error-message').hide();
                    //     }, 3000);
                    // }
                    // else if(jml_cuti < durasi && jml_cuti !=0)
                    // {
                    //     $('#error-message').hide();
                    //     $('#success-message').html('Cuti Tersedia');
                    //     $('#success-message').show();
                    //     $('#submit-button').attr('disabled', false); //aktifkan tombol submit
                    // }else{
                    //     $('#error-message').hide();
                    //     $('#submit-button').attr('disabled', false); //aktifkan tombol submit
                    // }

                } 
            });
        };
    </script>


    {{-- SCRIPT KEDUA DIUBAH 11 APRIL 2023 --}}
    {{-- <script type="text/javascript">
        function jumlahcuti()
        {
            var start= $('#datepicker-autoclosef').val();
            var end  = $('#datepicker-autocloseg').val();
            console.log(start,end);

            // Mengubah format tanggal pada variabel start
            var startArray = start.split('/');
            var startFormatted = startArray[1] + '/' + startArray[0] + '/' + startArray[2];
            var start_date = new Date(startFormatted);

            // Mengubah format tanggal pada variabel end
            var endArray = end.split('/');
            var endFormatted = endArray[1] + '/' + endArray[0] + '/' + endArray[2];
            var end_date = new Date(endFormatted);

            console.log(start_date,end_date);
            // var start_date = new Date(start);
            // var end_date   = new Date(end);
            var daysOfYear = [];

            //MENDAPATKAN DATA HARI LIBUR
            $.ajax({
                url: '/getlibur',
                type: 'GET',
                dataType: 'json',
                success: function(data){
                    var liburDates = data.map(function(libur) {
                        return new Date(libur.tanggal).getTime();
                    });

                    //untuk mendapatkan jumlah hari cuti
                    for (var d = start_date; d <= end_date; d.setDate(d.getDate() + 1)) 
                    {
                        //cek workdays
                        let tanggal = new Date(d);
                        if (tanggal.getDay() != 0 && tanggal.getDay() != 6 && !liburDates.includes(tanggal.getTime())) {
                            daysOfYear.push(tanggal);
                            console.log(tanggal);
                        } else {
                            console.log(" Hari Libur " + tanggal.getDay());
                        }
                        // if(tanggal.getDay() !=0 && tanggal.getDay() !=6){
                        //     daysOfYear.push(tanggal);
                        //     console.log(tanggal);
                        // } else{
                        //     console.log(" Hari Libur" + tanggal.getDay());
                        // }

                        // // Memeriksa apakah tanggal saat ini adalah hari libur
                        // if (liburDates.includes(tanggal.getTime())) {
                        //     daysOfYear.pop();
                        // }else{
                        //     console.log(" Hari Libur Nasional " + tanggal.getDay());
                        // }
                    }

                    //mengambil value tanggal mulai
                    $('#start_date').on('change', function() {
                        jumlahcuti();
                    });

                    //mengambil value tanggal selesai
                    $('#end_date').on('change', function() {
                        jumlahcuti();
                    });

                    // console.info(daysOfYear);
                    $('#jumlah').val(daysOfYear.length ?? 0);

                    //mengambil value jml_cuti
                    var jml_cuti = $("#jumlah").val();
                    var durasi   = $("#durasi").val(); ////ambil value dari input field durasi yang didapat dari ajax request
            
                    if(jml_cuti > durasi){
                        $('#success-message').hide();
                        $('#error-message').html(' "WARNING !!"<br>Jumlah cuti yang diinput melebihi durasi cuti yang tersedia.<br>Silahkan pilih jumlah cuti yang lebih kecil atau sama dengan durasi');
                        $('#error-message').show();
                        $('#submit-button').attr('disabled', true); //nonaktifkan tombol submit

                        setTimeout(function() 
                        {
                            $('#error-message').hide();
                        }, 3000);
                    }
                    else if(jml_cuti < durasi && jml_cuti !=0)
                    {
                        $('#error-message').hide();
                        $('#success-message').html('Cuti Tersedia');
                        $('#success-message').show();
                        $('#submit-button').attr('disabled', false); //aktifkan tombol submit
                    }else{
                        $('#error-message').hide();
                        $('#submit-button').attr('disabled', false); //aktifkan tombol submit
                    }

                } 
            });
        };
    </script> --}}

    {{-- SCRIPT JUMLAH CUTI ASLI --}}
    {{-- <script type="text/javascript">
        function jumlahcuti()
        {
            var start= $('#datepicker-autoclosef').val();
            var end  = $('#datepicker-autocloseg').val();

            var start_date = new Date(start);
            var end_date   = new Date(end);
            var daysOfYear = [];

            //untuk mendapatkan jumlah hari cuti
            for (var d = start_date; d <= end_date; d.setDate(d.getDate() + 1)) 
            {
                //cek workdays
                let tanggal = new Date(d);
                if(tanggal.getDay() !=0 && tanggal.getDay() !=6){
                    daysOfYear.push(tanggal);
                    console.log(tanggal);
                } else{
                    console.log(" Hari Libur" + tanggal.getDay());
                }
            }
            //mengambil value tanggal mulai
            $('#start_date').on('change', function() {
                jumlahcuti();
            });

            //mengambil value tanggal selesai
            $('#end_date').on('change', function() {
                jumlahcuti();
            });

            // console.info(daysOfYear);
            $('#jumlah').val(daysOfYear.length ?? 0);

           
            //mengambil value jml_cuti
            var jml_cuti = $("#jumlah").val();
            var durasi   = $("#durasi").val(); ////ambil value dari input field durasi yang didapat dari ajax request
            
        
            if(jml_cuti > durasi){
                $('#success-message').hide();
                $('#error-message').html(' "WARNING !!"<br>Jumlah cuti yang diinput melebihi durasi cuti yang tersedia.<br>Silahkan pilih jumlah cuti yang lebih kecil atau sama dengan durasi');
                $('#error-message').show();
                $('#submit-button').attr('disabled', true); //nonaktifkan tombol submit

                setTimeout(function() 
                {
                    $('#error-message').hide();
                }, 3000);
            }else if(jml_cuti < durasi && jml_cuti !=0){
                 $('#error-message').hide();
                 $('#success-message').html('Cuti Tersedia');
                 $('#success-message').show();
                 $('#submit-button').attr('disabled', false); //aktifkan tombol submit
            }else{
                $('#error-message').hide();
                $('#submit-button').attr('disabled', false); //aktifkan tombol submit
            }
        };
    </script> --}}











































{{-- var aktif_dari = $("#aktif_dari").val();
var sampai = $("#sampai").val();
var startDate = new Date(aktif_dari);
var endDate = new Date(sampai);

console.log(startDate);

// $(document).ready(function(){
    $('#datepicker-autoclosef').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        // minDate: startDate,
        // maxDate: endDate,
        todayHighlight: true,
        beforeShowDay: function(date){
            if (date < startDate || date > endDate)
                return {enabled : false};
            return;
        }
    });
    $('#datepicker-autocloseg').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        // minDate: startDate,
        // maxDate: endDate,
        todayHighlight: true,
        beforeShowDay: function(date){
            if (date < startDate || date > endDate)
                return {enabled : false};
            return;
        }
    });
// }); --}}

