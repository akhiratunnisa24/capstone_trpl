{{-- FORM  CUTI OLEH HRD--}}
<link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">

    <div class="modal modal fade" id="Modals" tabindex="-1" role="dialog" aria-labelledby="Modal" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title text-center" id="Modal">Form Permohonan Cuti</h4>
                </div>
                {{-- alert danger --}}
                <div class="alert alert-danger" id="error-message" style="display: none;">
                    <button type="button" class="close" onclick="$('#error-message').hide()">&times;</button>
                </div>

                {{-- alert success --}}
                <div class="alert alert-success" id="success-message" style="display: none;">
                    <button type="button" class="close" onclick="$('#success-message').hide()">&times;</button>
                </div>

                {{-- form --}}
                <div class="modal-body">
                    <form action="{{ route('cuti.stores')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="form-group col-sm">
                            <label for="id_karyawan" class="col-form-label">Nama</label>
                            <select name="id_karyawan" id="id_karyawan" class="form-control" required>
                                <option>-- Pilih Karyawan --</option>
                                @foreach ($karyawan as $data)
                                        <option value="{{ $data->id}}">
                                           {{ $data->nama }} 
                                        </option>
                                @endforeach
                            </select> 
                        </div>
                        <div class="form-group col-sm">
                            <label for="jeniscuti" class="col-form-label">Kategori Cuti</label>
                            <input type="text" class="form-control" name="jeniscuti" id="jeniscuti" readonly>
                        </div>
                        <div class="form-group col-sm">
                            <input type="hidden" class="form-control" name="id_jeniscuti" id="id_jeniscutis">
                            <input type="hidden" class="form-control" name="id_alokasi" id="id_alokasicuti">
                            <input type="hidden" class="form-control" name="id_settingalokasi" id="id_settingalokasicuti">
                        </div>
                        <div class="form-group col-sm">
                            <label for="keperluan" class="col-form-label">Keperluan</label>
                            <input type="text" class="form-control" name="keperluan" id="keperluan" placeholder="Masukkan keperluan" autocomplete="off" required>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="m-t-20">
                                    {{-- <form class="" action="#"> --}}
                                        <div class="form-group">
                                            <label for="tgl_mulai" class="form-label">Tanggal Mulai</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" onchange=(jumlahcutis()) placeholder="yyyy/mm/dd" id="datepicker-autocloseh" name="tgl_mulai"  autocomplete="off" rows="10" required>
                                                <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                            </div>
                                        </div>
                                    {{-- </form> --}}
                                </div>
                            </div>
                           
                            <div class="col-sm-6 col-xs-12">
                                <div class="m-t-20">
                                    {{-- <form class="" action="#"> --}}
                                        <div class="form-group">
                                            <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" onchange=(jumlahcutis()) placeholder="yyyy/mm/dd" id="datepicker-autoclosei" name="tgl_selesai"  autocomplete="off" rows="10" required>
                                                <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                            </div>
                                        </div>
                                    {{-- </form> --}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group col-sm">
                                    <label for="" class="col-form-label">Durasi Tersedia</label>
                                    <input type="text" class="form-control" name="durasi" id="adurasi" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group col-sm">
                                    <label for="jml_cuti" class="col-form-label">Jumlah Cuti</label>
                                    <input type="text" class="form-control" name="jml_cuti" id="jumlahct" readonly>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" class="form-control" name="aktif_dari" id="aktifdari">
                        <input type="hidden" class="form-control" name="sampai" id="sampaitanggal">

                        <div class="form-group col-sm">
                            <input type="hidden" class="form-control" name="status" id="status" value="Pending">
                        </div>
                            
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" id="submit-button" class="btn btn-success" value="save">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
     <!-- jQuery  -->
     {{-- <script src="assets/js/jquery.min.js"></script> --}}
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
     <script src="assets/pages/form-advanced.js"></script>

     <!-- script untuk mengambil data durasi dari tabel alokasi cuti  -->
    <script  type="text/javascript">
        var durasi;
        $('#id_karyawan').on('change',function(e){
            var id_karyawan = e.target.value;
            console.log(id_karyawan);
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                            .attr('content')
                        }
            });
            $.ajax({
                type:"POST",
                url: '{{route('get.Alokasicuti')}}',
                data: {'id_karyawan':id_karyawan},
                success:function(data)
                {
                    $('#jeniscuti').val(data.jenis_cuti);
                    $('#id_jeniscutis').val(data.id_jeniscuti);
                    $('#id_alokasicuti').val(data.id);
                    $('#id_settingalokasicuti').val(data.id_settingalokasi);
                    $('#adurasi').val(data.durasi);
                    $('#aktifdari').val(data.aktif_dari);
                    $('#sampaitanggal').val(data.sampai);
                    
                    durasi     = data.durasi;
                }
            });
        });
    </script>

    {{-- <script  type="text/javascript">
        var durasi;
        $('#id_karyawan').on('change',function(e){
            var id_karyawan = e.target.value;
            console.log(id_karyawan);
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                            .attr('content')
                        }
            });
            $.ajax({
                type:"POST",
                url: '{{route('get.Alokasicuti')}}',
                data: {'id_karyawan':id_karyawan},
                success:function(data)
                {
                    $('#jeniscuti').val(data.jenis_cuti);
                        $('#id_jeniscutis').val(data.id_jeniscuti);
                        $('#id_alokasicuti').val(data.id);
                        $('#id_settingalokasicuti').val(data.id_settingalokasi);
                        $('#adurasi').val(data.durasi);
                        $('#aktifdari').val(data.aktif_dari);
                        $('#sampaitanggal').val(data.sampai);
                        
                        durasi     = data.durasi;
                }
            });
        });
    </script> --}}

    <script type="text/javascript">
        function jumlahcutis()
        {
            var start= $('#datepicker-autocloseh').val();
            var end  = $('#datepicker-autoclosei').val();

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
                jumlahcutis();
            });

            //mengambil value tanggal selesai
            $('#end_date').on('change', function() {
                jumlahcutis();
            });

            $('#jumlahct').val(daysOfYear.length ?? 0);

            //mengambil value jml_cuti
            var jml_cuti = $("#jumlahct").val();
            var durasi   = $("#adurasi").val(); ////ambil value dari input field durasi yang didapat dari ajax request
        
            if(jml_cuti > durasi){
                $('#success-message').hide();
                $('#error-message').html(' "WARNING !!"<br>Jumlah cuti yang diinput melebihi durasi cuti yang tersedia.<br>Silahkan pilih jumlah cuti yang lebih kecil atau sama dengan durasi');
                $('#error-message').show();
                $('#submit-button').attr('disabled', true); //nonaktifkan tombol submit

                setTimeout(function() 
                {
                    $('#error-message').hide();
                }, 3000);
            }else if(jml_cuti < durasi && jml_cuti != 0){
                 $('#error-message').hide();
                 $('#success-message').html('Cuti Tersedia');
                 $('#success-message').show();
                 $('#submit-button').attr('disabled', false); //aktifkan tombol submit
            }else{
                $('#error-message').hide();
                $('#submit-button').attr('disabled', false); //aktifkan tombol submit
            }
        };
    </script>