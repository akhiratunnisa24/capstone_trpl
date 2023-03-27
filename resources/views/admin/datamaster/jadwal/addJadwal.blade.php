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
                        <label for="id_pegawai" class="col-form-label">Karyawan</label>
                        <select name="id_pegawai" id="id_pegawai" class="form-control" required>
                            <option>-- Pilih Karyawan --</option>
                            @foreach ($karyawan as $data)
                                <option value="{{ $data->id }}">
                                    {{ $data->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
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
                    <div class="form-group col-sm">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="yyyy/mm/dd" id="datepicker-autoclosep" name="tanggal"  autocomplete="off" rows="10" required>
                            <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
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
                    
                   
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success waves-effect waves-light" name="submit"
                            value="save">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="assets/js/jquery.min.js"></script>
<script src="assets/pages/form-advanced.js"></script>
<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

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
