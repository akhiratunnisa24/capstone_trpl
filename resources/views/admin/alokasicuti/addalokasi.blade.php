
{{-- FORM SETTING ALOKASI--}}
<div class="modal fade" id="newalokasi" tabindex="-1" role="dialog" aria-labelledby="newalokasi" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="newalokasi">Tambah Alokasi Cuti</h4>
            </div>
            <div class="modal-body">
                <form class="input" action="{{route('alokasi.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="panel-body">
                        {{-- <div class="col-md-12" style="margin-bottom:20px">
                            <div class="form-group col-sm" id="search-container">
                                <input  class="form-control col-sm-10" type="text" id="search-input" placeholder="Cari karyawan...">
                            </div>
                        </div> --}}
                        <div class="col-md-6">
                            <div class="form-group col-sm" id="jeniscuti">
                                <label for="id_jeniscuti" class="col-form-label">Kategori Cuti</label>
                                <select name="id_jeniscuti" id="id_jeniscuti" class="form-control" required>
                                    <option value="">Pilih Kategori Cuti</option>
                                    @foreach ($jeniscuti as $jenis)
                                    <option value="{{ $jenis->id }}">{{ $jenis->jenis_cuti }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <input type="hidden" class="form-control" name="id_settingalokasi" placeholder="id_settingalokasi" id="id_settingalokasi" readonly>
                            
                            <div class="form-group col-sm" id="id_karyawan">
                                <label for="id_karyawan" class="col-form-label">Karyawan</label>
                                <select name="id_karyawan" id="id_karyawan" class="form-control" required>
                                    <option value="">Pilih Karyawan</option>
                                    @foreach ($karyawan as $data)
                                        @foreach ($keluarga as $data_keluarga)
                                            @if($data->id == $data_keluarga->id_pegawai)
                                                <option value="{{ $data->id }}">[Status: {{$data_keluarga->status_pernikahan}}, JK: {{ $data->jenis_kelamin}}, Depart: {{ $data->divisi }}] {{ $data->nama }}</option>
                                                @break
                                            @endif
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                            
                            {{-- <div class="form-group col-sm" id="id_karyawan">
                                <label for="id_karyawan" class="col-form-label">Karyawan</label>
                                <select name="id_karyawan" id="id_karyawan" class="form-control" required>
                                    <option value="">Pilih Karyawan</option>
                                    @foreach ($karyawan as $data)
                                        @if($data->id == $keluarga->id_pegawai)
                                            <option value="{{ $data->id }}"> [Status: {{$keluarga->status_pernikahan}}, JK: {{ $data->jenis_kelamin}}, Depart: {{ $data->divisi }}] {{ $data->nama }}</option>
                                        @else
                                            <option value="{{ $data->id }}"> [JK: {{ $data->jenis_kelamin}}, Depart: {{ $data->divisi }}] {{ $data->nama }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div> --}}
                            <div class="form-group">
                                <label for="durasi" class="col-form-label">Durasi (Hari)</label>
                                <input type="text" class="form-control" name="durasi" placeholder="durasi" id="durasi"
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label for="mode_alokasi" class="col-form-label">Mode Alokasi</label>
                                <input type="text" class="form-control" name="mode_alokasi" placeholder="mode alokasi"
                                    id="mode_alokasi" readonly>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Status/JK/Departemen</label>
                                <input type="text" class="form-control" name="departemen" placeholder="Status/JK/Departemen" id="departemen" readonly>
                            </div>

                        </div>

                        <div class="col-md-6" id="validitas">
                            <div class="" id="tanggalmulai">
                                <div class="form-group">
                                    <label for="tgl_masuk" class="form-label">Tanggal Masuk</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="yyyy/mm/dd" id="tgl_masuk"
                                            name="tgl_masuk" autocomplete="off" readonly>
                                        <span class="input-group-addon bg-custom b-0"><i
                                                class="mdi mdi-calendar text-white"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="" id="tanggalselesai">
                                <div class="form-group">
                                    <label for="tgl_sekarang" class="form-label">Tanggal Sekarang</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="yyyy/mm/dd"
                                            id="tgl_sekarang" name="tgl_sekarang" autocomplete="off" readonly>
                                        <span class="input-group-addon bg-custom b-0"><i
                                                class="mdi mdi-calendar text-white"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="" id="start">
                                <div class="form-group">
                                    <label for="aktif_dari" class="form-label">Aktif Dari</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="yyyy/mm/dd"
                                            id="datepicker-autoclosea1" name="aktif_dari" autocomplete="off" required>
                                        <span class="input-group-addon bg-custom b-0"><i
                                                class="mdi mdi-calendar text-white"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="" id="end">
                                <div class="form-group">
                                    <label for="sampai" class="form-label">Sampai</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="yyyy/mm/dd"
                                            id="datepicker-autoclosea2" name="sampai" autocomplete="off" required>
                                        <span class="input-group-addon bg-custom b-0"><i
                                                class="mdi mdi-calendar text-white"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" name="submit" value="save">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- jQuery  -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/pages/form-advanced.js"></script>

<!-- Script untuk mengambil nilai settingalokasi  -->
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
                var mode_alokasi = data.mode_alokasi;
                if(mode_alokasi == 'Berdasarkan Departemen'){
                    $('#departemen').val(data.departemen);
                }else{
                    $('#departemen').val(data.mode_karyawan);
                }
                
            }
        });
    });
</script>

<!-- script untuk mengambil data tanggalmasuk  -->
<script>
    var tglmasuk;
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
                $('#tgl_masuk').val(data.tglmasuk);
                // console.log(data?.tglmasuk)

                tglmasuk = data.tglmasuk;
                console.log(tglmasuk);
            }
        });
    });
</script>

<!-- Script untuk memunculkan form tanggal masuk dan tanggal sekarang -->
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

                var date = new Date(Date.now());
                var tgl  = (date.getFullYear() + '/' + ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())));
                $('#tgl_sekarang').val(tgl);

            } else
                {
                    $('#tanggalmulai').prop("hidden", true);
                    $('#tanggalselesai').prop("hidden", true);
            }
        });
    });
</script>
<script>
    function durasicuti()
    {
        let start= $('#tgl_masuk').val();
        let end  = $('#tgl_sekarang').val();

        let start_month = new Date(start);
        let end_month   = new Date(end);
           
        //menghitung selisih tahun dan bulan
        let selisihTahun = end_month.getFullYear()-start_month.getFullYear();
        let selisihBulan = end_month.getMonth()-start_month.getMonth();
            
        let durasi = selisihBulan+(selisihTahun*12);

        console.info(durasi);
    }
</script>