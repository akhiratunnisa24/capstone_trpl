<div class="modal fade" id="AddJadwal" tabindex="-1" role="dialog" aria-labelledby="AddModal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel">Tambah Jadwal Karyawan</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('jadwal.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-group col-sm">
                        <label class="col-form-label">Tipe Jadwal</label>
                        <select name="tipe_jadwal" id="tipe_jadwal" class="form-control" required>
                            <option>-- Pilih Tipe Jadwal --</option>
                            <option value="harian">Harian</option>
                            <option value="bulanan">Bulanan</option>
                        </select>
                    </div>
                    {{-- <div class="form-group col-sm" id="pegawai">
                        <label for="id_pegawai" class="col-form-label">Karyawan</label>
                        <select name="id_pegawai" id="id_pegawai" class="form-control">
                            <option>-- Pilih Karyawan --</option>
                            @foreach ($karyawan as $data)
                                <option value="{{ $data->id }}">
                                    {{ $data->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div> --}}
                    @if($role == 1 || $role ==2)
                        <div class="form-group col-sm">
                            <label for="id_shift" class="col-form-label">Shift</label>
                            <select name="id_shift" id="id_shift" class="form-control" required>
                                <option>-- Pilih Shift --</option>
                                @foreach ($shift as $data)
                                    <option value="{{ $data->id }}">
                                        {{ $data->nama_shift }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @elseif($role == 5)
                        <div class="form-group col-sm">
                            <label for="id_shift" class="col-form-label">Shift</label>
                            <select name="id_shift" id="id_shift" class="form-control" required>
                                <option>-- Pilih Shift --</option>
                                @foreach ($shift as $data)
                                    <option value="{{ $data->id }}">
                                        {{ $data->nama_shift }} (Partner {{ $data->partner }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="form-group col-sm" id="tanggal">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="dd/mm/yyyy" id="datepicker-autoclosep" name="tanggal"  autocomplete="off" rows="10" readonly>
                            <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                        </div>
                    </div>
                    {{-- <div class="form-group" id="date_range">
                        <div class="mb-3">
                            <label class="form-label">Tanggal</label>
                            <div>
                                <div class="input-daterange input-group" id="date-range5">
                                    <input type="text" class="form-control" name="tgl_mulai" id="tgl_mulai" autocomplete="off"/>
                                    <span class="input-group-addon bg-primary text-white b-0">To</span>
                                    <input type="text" class="form-control" name="tgl_selesai" id="tgl_selesai" autocomplete="off"/>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="row" id="date_range">
                        <div class="col-sm-6 col-xs-12">
                            <div class="m-t-10">

                                    <div class="form-group">
                                        <label for="tgl_mulai" class="form-label">Tanggal Mulai</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="dd/mm/yyyy" id="datepicker-autoclose42" name="tgl_mulai"  autocomplete="off" rows="10" readonly>
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
                                            <input type="text" class="form-control" placeholder="dd/mm/yyyy" id="datepicker-autoclose43" name="tgl_selesai"  autocomplete="off" rows="10" readonly>
                                            <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                        </div>
                                    </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group col-sm">
                                <label for="jadwal_masuk">Jadwal Masuk</label>
                                <input type="text" class="form-control" name="jadwal_masuk" id="jadwal_masuk" autocomplete="off" readonly>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group col-sm">
                                <label for="jadwal_pulang">Jadwal Pulang</label>
                                <input type="text" class="form-control" name="jadwal_pulang" id="jadwal_pulang" autocomplete="off" readonly>
                            </div>
                        </div>
                    </div>

                    @if($role == 5)
                        <div class="form-group col-xs-12">
                            <label class="form-label">Partner</label>
                            <select class="form-control" name="partner">
                                <option value="">Pilih Partner</option>
                                @foreach ($partner as $k)
                                    <option value="{{ $k->id }}">
                                        {{ $k->nama_partner }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger waves-effect" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-sm btn-success waves-effect waves-light" name="submit"
                            value="save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="assets/js/jquery.min.js"></script>
<script src="assets/pages/form-advanced.js"></script>
<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

<script type="text/javascript">
    $(function()
        {
            // $('#pegawai').prop("hidden", true);
            $('#tanggal').prop("hidden", true);
            $('#date_range').prop("hidden", true);

            $('#tipe_jadwal').on('change', function(a)
            {
                if(a.target.value== 'harian')
                {
                    // $('#pegawai').prop("hidden", false);
                    $('#tanggal').prop("hidden", false);
                    $('#date_range').prop("hidden", true);
                }
                if(a.target.value== 'bulanan')
                {
                    // $('#pegawai').prop("hidden", true);
                    $('#tanggal').prop("hidden", true);
                    $('#date_range').prop("hidden", false);
                }
            });
        }
    );
</script>


<script  type="text/javascript">
    $('#id_shift').on('change',function(e){
        var id_shift = e.target.value;
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                        .attr('content')
                    }
        });
        $.ajax({
            type:"POST",
            url: '{{route('get.Shift')}}',
            data: {'id_shift':id_shift},
            success:function(data)
            {
                $('#jadwal_masuk').val(data.jam_masuk);
                $('#jadwal_pulang').val(data.jam_pulang);
            }
        });
    });
</script>
