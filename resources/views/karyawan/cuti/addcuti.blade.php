{{-- FORM PENGAJUAN CUTI --}}
<link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">

    <div class="modal modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="Modal" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="Modal">Form Permohonan Cuti</h4>
                </div>
                @if(session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                    </div>
                @endif
                <div class="modal-body">
                    <form action="{{ route('cuti.store')}}" onsubmit="return validate()" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="form-group col-sm">
                            <label for="id_karyawan" class="col-form-label">Nama</label>
                            <input type="text" class="form-control" id="id_karyawan" value="{{Auth::user()->name}}" readonly>
                            <input type="hidden" class="form-control" id="id_karyawan" value="{{$karyawan}}" hidden>
                        </div>
                    
                        <div class="form-group col-sm">
                            <label for="id_jeniscuti" class="col-form-label">Kategori Cuti</label>
                            <select name="id_jeniscuti" id="id_jeniscuti" class="form-control" required>
                                <option>-- Pilih Kategori --</option>
                                
                                @foreach ($jeniscuti as $data)
                                    @if(isset($sisa_cuti[$data->id]) && $sisa_cuti[$data->id] >= 0) 
                                         <option value="{{ $data->id}}">
                                            (sisa cuti: {{ isset($sisa_cuti[$data->id]) ? $sisa_cuti[$data->id] : 0 }} hari) {{ $data->jenis_cuti }} 
                                        </option>
                                    @else
                                        <option value="{{ $data->id}}">
                                            (cuti is available) {{ $data->jenis_cuti }} 
                                        </option>
                                    @endif
                                @endforeach
                            </select> 
                        </div>
                        <div class="form-group col-sm">
                            <input type="hidden" class="form-control" name="id_alokasi" id="id_alokasi">
                        </div>
                        <div class="form-group col-sm">
                            <label for="keperluan" class="col-form-label">Keperluan</label>
                            <input type="text" class="form-control" name="keperluan" id="keperluan" placeholder="Masukkan keperluan" required>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="m-t-20">
                                    {{-- <form class="" action="#"> --}}
                                        <div class="form-group">
                                            <label for="tgl_mulai" class="form-label">Tanggal Mulai</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" onchange=(jumlahcuti()) placeholder="mm/dd/yyyy" id="datepicker-autoclosea" name="tgl_mulai"  autocomplete="off" rows="10" required>
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
                                                <input type="text" class="form-control" onchange=(jumlahcuti()) placeholder="mm/dd/yyyy" id="datepicker-autocloseb" name="tgl_selesai"  autocomplete="off" rows="10" required>
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
                            <button type="submit" class="btn btn-success" value="save">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
     <!-- jQuery  -->
     {{-- <script src="assets/js/jquery.min.js"></script> --}}
     <script src="assets/js/bootstrap.min.js"></script>

 
     {{-- plugin js --}}
     <script src="assets/plugins/timepicker/bootstrap-timepicker.js"></script>
     <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
   
     <!-- Datatable init js -->
     <script src="assets/pages/datatables.init.js"></script>
     {{-- <script src="assets/js/app.js"></script> --}}
 
     <!-- Plugins Init js -->
     <script src="assets/pages/form-advanced.js"></script>

     <!-- script untuk mengambil data durasi dari tabel alokasi cuti  -->
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
                url: '{{route('get.Durasi')}}',
                data: {'id_jeniscuti':id_jeniscuti},
                success:function(data){
                    $('#id_alokasi').val(data.id);
                    $('#durasi').val(data.durasi);
                    // console.log(data?.durasi)
                    console.log(data?.id)
                }
            });
        });
    </script>
     <script type="text/javascript">
        function jumlahcuti()
        {
            var start= $('#datepicker-autoclosea').val();
            var end  = $('#datepicker-autocloseb').val();

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

            console.info(daysOfYear);
            // alert('test');

            $('#jumlah').val(daysOfYear.length ?? 0);

            // if (isset($sisa_cuti[request()->id_jeniscuti]) && request()->jumlah_cuti > $sisa_cuti[request()->id_jeniscuti]) 
            // {
            //     session()->flash('error', 'Jumlah cuti yang diajukan melebihi sisa cuti yang tersisa. Silakan pilih jumlah cuti yang lebih kecil.');
            //     return redirect()->back();
            // }
        };
    </script>
    <script>
        function validate() {
            var sisaCuti = {!! json_encode($sisa_cuti) !!};// getting value of sisa_cuti from controller 
            // console.log(sisaCuti);
            var jumlah_cuti = document.getElementById("jumlah_cuti").value; // getting input value of jumlah cuti
            var id_jeniscuti = document.getElementById("id_jeniscuti").value; // getting input value of id_jeniscuti
           
            if (sisa_cuti[id_jeniscuti] < jumlah_cuti) {
                alert("Jumlah cuti yang diajukan melebihi sisa cuti yang tersisa. Silakan pilih jumlah cuti yang lebih kecil.");
                console.info(sisa_cuti[id_jeniscuti] < jumlah_cuti);
                return false;
            }
            return true;
        }
    </script>
    
   