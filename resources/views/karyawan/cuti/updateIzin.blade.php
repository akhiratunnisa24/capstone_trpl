<link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">

    <div class="modal modal fade" id="Editizin{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="Modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title text-center" id="Modal">FORM EDIT DATA KETIDAKHADIRAN KARYAWAN</h4>
                </div>
               
                <div class="alert alert-danger" id="error-message" style="display: none;">
                    <button type="button" class="close" onclick="$('#error-message').hide()">&times;</button>
                </div>

                <div class="alert alert-success" id="success-message" style="display: none;">
                    <button type="button" class="close" onclick="$('#success-message').hide()">&times;</button>
                </div>

                <div class="modal-body">
                    <form action="/update-cuti/{{$data->id}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group col-sm">
                                        <label for="tgl_permohonan" class="col-form-label">Tanggal Permohonan</label>
                                        <input type="text" class="form-control" value="{{\Carbon\Carbon::parse($data->tgl_permohonan)->format("d/m/Y")}}" name="tgl_permohonan" id="tgl_permohonan" value="{{ date('d/m/Y') }}" readonly>
                                    </div>               
                                    <div class="form-group col-sm">
                                        <label for="nik" class="col-form-label">Nomor Induk Karyawan</label>
                                        <input type="text" class="form-control"value="{{$data->nik}}"  name="nik" id="nik" readonly>
                                        <input type="hidden" class="form-control"value="{{$data->id}}"  name="id" id="id" readonly>
                                    </div>         
                                    <div class="form-group col-sm">
                                        <label for="id_karyawan" class="col-form-label">Nama Karyawan</label>
                                        <input type="text" class="form-control" id="id_karyawan" value="{{Auth::user()->name}}" readonly>
                                        <input type="hidden" class="form-control" name="id_karyawan" id="id_karyawan" value="{{$data->id_karyawan}}" hidden>
                                    </div>
                                    <div class="form-group col-sm">
                                        <label for="jabatan" class="col-form-label">Jabatan</label>
                                        <input type="text" class="form-control" name="jabatan" id="jabatan" value="{{$data->jabatan}}" readonly>
                                    </div> 
                                    <div class="form-group col-sm">
                                        <label for="departemen" class="col-form-label">Departemen/Divisi</label>
                                        <input type="text" class="form-control" id="departemen" value="{{$departemen->nama_departemen}}" readonly>
                                        <input type="hidden" class="form-control" name="departemen" id="departemen" value="{{$data->departemen}}" hidden>
                                    </div> 
                                </div>

                                <div class="col-md-6">

                                    <div class="form-group col-sm">
                                        <label for="id_jeniscuti" class="col-form-label">Status Ketidakhadiran / Kategori Izin</label>
                                        <input type="text" class="form-control" id="id_jenisizin" value="{{$data->jenis_izin}}" readonly>
                                        <input type="hidden" class="form-control" name="id_jenisizin" id="id_jenisizin" value="{{$data->id_jenisizin}}" hidden>
                                            {{-- <textarea class="form-control" style="height: 39px;" name="keperluan" value="{{$data->id_jeniscuti}}" @if($data->id == $data->id_jeniscuti) selected @endif autocomplete="off" rows="1" readonly>{{$data->jenis_cuti}}</textarea> --}}
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-12">
                                            <div>
                                                <div class="form-group">
                                                    <label for="tgl_mulai" class="form-label">Tanggal Pelaksanaan</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" onchange=(jumlahcutis()) value="{{\Carbon\Carbon::parse($data->tgl_mulai)->format("d/m/Y")}}" placeholder="dd/mm/yyyy" id="datepicker-autoclose44" name="tgl_mulai"  autocomplete="off" rows="10">
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
                                                        <input type="text" class="form-control" onchange=(jumlahcutis()) placeholder="dd/mm/yyyy" value="{{\Carbon\Carbon::parse($data->tgl_selesai)->format("d/m/Y")}}" id="datepicker-autoclose45" name="tgl_selesai"  autocomplete="off" rows="10">
                                                        <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
            
                                    <div class="form-group col-sm">
                                        <label for="keperluan" class="col-form-label">Keterangan</label>
                                        <textarea class="form-control" name="keperluan" id="keperluan" rows="5" placeholder="Masukkan keterangan" autocomplete="off">{{$data->keperluan}}</textarea>
                                        {{-- <input type="text" class="form-control" name="keperluan" id="keperluan" placeholder="Masukkan keterangan" autocomplete="off" required> --}}
                                    </div>
                                    <div class="row">
                                        {{-- <div class="col-sm-6 col-xs-12">
                                            <div class="form-group col-sm">
                                                <label for="" class="col-form-label">Durasi Tersedia</label>
                                                <input type="text" class="form-control" name="durasi" id="durasii" readonly>
                                            </div>
                                        </div> --}}
                                        <div class="col-sm-12 col-xs-12">
                                            <div class="form-group col-sm">
                                                <label for="jml_cuti" class="col-form-label">Jumlah Cuti</label>
                                                <input type="text" class="form-control"  value="{{$data->jml_cuti}}" name="jml_cuti" id="jumla" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm">
                                        <input type="hidden" class="form-control" value="{{$data->id_alokasi}}" name="id_alokasi" id="idalokasi">
                                        <input type="hidden" class="form-control" value="{{$data->id_settingalokasi}}" name="id_settingalokasi" id="idsettingalokasi">
                                    </div>
            
                                    <div class="form-group col-sm">
                                        <input type="hidden" class="form-control" name="status" id="status" value="Pending">
                                    </div>
                                </div>
                            </div>
                        </div>
                            
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" id="submit-button" class="btn btn-success" value="save">Update dan  Kirim</button>
                        </div>
                    </form>
                </div>
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
                url: '{{route('getDurasi')}}',
                data: {'id_jeniscuti':id_jeniscuti},
                success:function(data)
                {
                    $('#idalokasi').val(data.id);
                    $('#idsettingalokasi').val(data.id_settingalokasi);
                    $('#durasii').val(data.durasi);
                    $('#datepicker-autocloses').val(data.aktif_dari);
                    $('#datepicker-autocloset').val(data.sampai);
                    // console.log(data?.durasi)
                    durasi     = data.durasi;
                }
            });
        });
    </script>

    <script type="text/javascript">
        function jumlahcutis()
        {
            var start= $('#datepicker-autocloses').val();
            var end  = $('#datepicker-autocloset').val();
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
                url: '/getliburs',
                type: 'GET',
                dataType: 'json',
                success: function(data){
                    var liburDates = data.map(function(libur) {
                        // return new Date(libur.tanggal).getTime();
                        var dateArray = libur.tanggal.split('/');
                        var dateFormatted = dateArray[2] + '-' + dateArray[1] + '-' + dateArray[0];
                        return new Date(dateFormatted).getTime();
                    });

                     //untuk mendapatkan jumlahh hari cuti
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

                        console.info(daysOfYear.length);
                        $('#jumla').val(daysOfYear.length ?? 0);
                    }

                    // Menjalankan fungsi jumlahcutis saat input tanggal mulai atau tanggal selesai berubah
                    $('#start_date, #end_date').on('change', function() {
                        jumlahcutis();
                    });

                    // Menjalankan fungsi jumlahcutis saat halaman selesai dimuat, jika ada value pada jml_cuti
                    $(document).ready(function() {
                        var jml_cuti = parseInt("{{$data->jml_cuti}}") || 0;
                        $('#jumla').val(jml_cuti);
                    });

                    $('#jumla').val(daysOfYear.length ?? 0);
                    // //mengambil value tanggal mulai
                    // $('#start_date').on('change', function() {
                    //     jumlahcutis();
                    // });

                    // //mengambil value tanggal selesai
                    // $('#end_date').on('change', function() {
                    //     jumlahcutis();
                    // });

                   
                } 
            });
        };
    </script>


   