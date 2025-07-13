{{-- FORM  CUTI OLEH HRD--}}
<link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">

    <div class="modal modal fade" id="Modals" tabindex="-1" role="dialog" aria-labelledby="Modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title text-center" id="Modal">FORM CUTI TAHUNAN KARYAWAN</h4>
                </div>
                {{-- form --}}
                <div class="modal-body">
                    <form action="{{ route('cuti.stores')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group col-sm">
                                        <label class="form-label">Tanggal Permohonan</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="dd/mm/yyyy" id="datepicker-autoclosew" name="tgl_permohonan"  autocomplete="off" rows="10" required readonly>
                                            <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm">
                                        <label class="col-form-label">Nama Karyawan</label>
                                        <select name="id_karyawans" id="id_karyawans" class="form-control selectpicker" data-live-search="true" required>
                                            <option>-- Pilih Karyawan --</option>
                                            @foreach ($karyawan as $data)
                                                    <option value="{{ $data->id}}">
                                                        {{ $data->nama }}
                                                    </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-sm">
                                        <label class="col-form-label">Nomor Induk Karyawan</label>
                                        <input type="text" class="form-control" name="nik" id="nik" readonly>
                                    </div>
                                    <div class="form-group col-sm">
                                        <label class="col-form-label">Jabatan</label>
                                        <input type="text" class="form-control" name="jabatan" id="jabatan"  readonly>
                                    </div>
                                    <div class="form-group col-sm">
                                        <label class="col-form-label">Divisi</label>
                                        <input type="text" class="form-control" id="namadepartemen" readonly>
                                        <input type="hidden" class="form-control" name="departemen" id="departemen" hidden>
                                    </div>


                                </div>
                                <div class="col-md-6">
                                    <div class="form-group col-sm">
                                        <label  class="col-form-label">Status Ketidakhadiran</label>
                                        <select name="id_jeniscuti" id="id_jeniscuti" class="form-control selectpicker" data-live-search="true" required>
                                            <option>-- Pilih Status Ketidakhadiran --</option>

                                        </select>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6 col-xs-12">
                                            <div>
                                                {{-- <form class="" action="#"> --}}
                                                    <div class="form-group">
                                                        <label class="form-label">Tanggal Pelaksanaan</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" onchange=(jumlahcutis()) placeholder="dd/mm/yyyy" id="datepicker-autocloseh" name="tgl_mulai"  autocomplete="off" rows="10" required readonly>
                                                            <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                                        </div>
                                                    </div>
                                                {{-- </form> --}}
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-xs-12">
                                            <div>
                                                {{-- <form class="" action="#"> --}}
                                                    <div class="form-group">
                                                        <label class="form-label">Sampai</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" onchange=(jumlahcutis()) placeholder="dd/mm/yyyy" id="datepicker-autoclosei" name="tgl_selesai"  autocomplete="off" rows="10" required readonly>
                                                            <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                                        </div>
                                                    </div>
                                                {{-- </form> --}}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-sm">
                                        <label  class="col-form-label">Keterangan</label>
                                        <textarea class="form-control" name="keperluan" id="keperluan" rows="5" placeholder="Masukkan keterangan" autocomplete="off" required></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-12">
                                            <div class="form-group col-sm">
                                                <label class="col-form-label">Durasi Tersedia</label>
                                                <input type="text" class="form-control" name="durasi" id="adurasi" readonly>
                                                <input type="hidden" class="form-control" name="id_alokasi" id="id_alokasicuti">
                                                <input type="hidden" class="form-control" name="id_settingalokasi" id="id_settingalokasicuti">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-12">
                                            <div class="form-group col-sm">
                                                <label class="col-form-label">Jumlah Cuti</label>
                                                <input type="text" class="form-control" name="jml_cuti" id="jumlahct" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" class="form-control" name="aktif_dari" id="aktifdari">
                                    <input type="hidden" class="form-control" name="sampai" id="sampaitanggal">
                                </div>
                                <div class="form-group col-sm">
                                    <input type="hidden" class="form-control" name="status" id="status" value="Pending">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm  btn-danger" data-dismiss="modal">Tutup</button>
                            <button type="submit" id="submit-button" class="btn btn-sm btn-success" value="save">Kirim</button>
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

     {{-- script untuk mendapatkan data karyawan dan jenis cuti yang didapatkan --}}
    <script>
        $("select[name='id_karyawans']").on("change", function() {
            var id_karyawans = $(this).val();
            // console.log(id_karyawans);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "GET",
                url: '/getkaryawan',
                data: { 'id_karyawans': id_karyawans },
                success: function(data) {
                    $('#nik').val(data.nip);
                    $('#jabatan').val(data.nama_jabatan);
                    $('#departemen').val(data.divisi);
                    $('#namadepartemen').val(data.nama_departemen);
                    // console.log(data);

                    $.ajax({
                        type: "GET",
                        url: '/getcuti',
                        data: { 'id_karyawans': id_karyawans },
                        success: function(cutiData) {
                            var jeniscutiSelect = $('#id_jeniscuti');
                            jeniscutiSelect.empty();

                            // $.each(cutiData, function(index, item) {
                            //     jeniscutiSelect.append($('<option>', {
                            //         value: item.id_jeniscuti,
                            //         text: item.jenis_cuti
                            //     }));
                            // });

                            // jeniscutiSelect.selectpicker('refresh');
                            jeniscutiSelect.append($('<option>', {
                                value: '',
                                text: 'Pilih Jenis Cuti',
                                disabled: true,
                                selected: true,
                                'data-durasi': 0,
                                'data-id-alokasicuti': 0,
                                'data-id-settingalokasi': 0
                            }));

                            $.each(cutiData, function(index, item) {
                                var option = $('<option>', {
                                    value: item.id_jeniscuti,
                                    text: item.jenis_cuti,
                                    'data-durasi': item.durasi,
                                    'data-id-alokasicuti': item.id,
                                    'data-id-settingalokasi': item.id_settingalokasi
                                });

                                jeniscutiSelect.append(option);
                            });

                            // Update the HTML of the select element
                            jeniscutiSelect.html(jeniscutiSelect.html());

                            // Refresh the select picker
                            jeniscutiSelect.selectpicker('refresh');
                            jeniscutiSelect.val(jeniscutiSelect.val()).change();
                        }
                    });
                }
            });
        });

        $('#id_jeniscuti').on('change', function() {
            var durasi = $(this).find(':selected').data('durasi');
            var id_alokasicuti = $(this).find(':selected').data('id-alokasicuti');
            var id_settingalokasi = $(this).find(':selected').data('id-settingalokasi');
            console.log(durasi, id_alokasicuti, id_settingalokasi);

            // Isi nilai-nilai ke dalam elemen formulir
            $('#adurasi').val(durasi);
            $('#id_alokasicuti').val(id_alokasicuti);
            $('#id_settingalokasicuti').val(id_settingalokasi);
        });
    </script>

    <script type="text/javascript">
        function jumlahcutis()
        {
            var start= $('#datepicker-autocloseh').val();
            var end  = $('#datepicker-autoclosei').val();

            var startArray = start.split('/');
            var startFormatted = startArray[1] + '/' + startArray[0] + '/' + startArray[2];
            var start_date = new Date(startFormatted);

            // var start_date = new Date(start);
            // var end_date   = new Date(end);


            var endArray = end.split('/');
            var endFormatted = endArray[1] + '/' + endArray[0] + '/' + endArray[2];
            var end_date = new Date(endFormatted);

            var daysOfYear = [];

            //untuk mendapatkan jumlah hari cuti
            $.ajax({
                url: '/getharilibur',
                type: 'GET',
                dataType: 'json',
                success: function(data){
                    var liburDates = data.map(function(libur) {
                        // return new Date(libur.tanggal).getTime();
                        var dateArray = libur.tanggal.split('/');
                        var dateFormatted = dateArray[2] + '-' + dateArray[1] + '-' + dateArray[0];
                        return new Date(dateFormatted).getTime();
                    });

                    for (var d = start_date; d <= end_date; d.setDate(d.getDate() + 1))
                    {
                        //cek workdays
                        let tanggal = new Date(d);
                        if(tanggal.getDay() !=0 && tanggal.getDay() !=6 && !liburDates.includes(tanggal.getTime())){
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

                    console.info(daysOfYear.length);
                    $('#jumlahct').val(daysOfYear.length ?? 0);
                }
            });
        };
    </script>
