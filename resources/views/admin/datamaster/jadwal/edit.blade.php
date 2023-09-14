{{-- FORM TAMBAH DATA DEPARTEMEN --}}
<div class="modal fade" id="editJadwal{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="AddModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{-- <div class="modal-header"> --}}
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel">Edit Data Jadwal</h4>
            {{-- </div> --}}
            <div class="modal-body">
                <form action="/jadwal/update/{{$data->id}}" method="POST">
                    @csrf
                    @method('PUT')
                    @if($role == 1 || $role ==2)
                        <div class="form-group col-sm">
                            <label for="id_shift" class="col-form-label">Shift</label>
                            <select name="id_shift" id="id_shifts" class="form-control">
                                @foreach ($shift as $d)
                                    <option value="{{ $d->id }}" @if ($data->id_shift == $d->id) selected @endif>
                                        {{ $d->nama_shift }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @elseif($role == 5)
                        <div class="form-group col-sm">
                            <label for="id_shift" class="col-form-label">Shift</label>
                            <select name="id_shift" id="id_shifts" class="form-control">
                                @foreach ($shift as $d)
                                    <option value="{{ $d->id }}" @if ($data->id_shift == $d->id) selected @endif>
                                        {{ $d->nama_shift }} (Partner {{ $d->partner }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="form-group col-sm" id="tanggal">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="dd/mm/yyyy" id="datepicker-autoclosey" name="tanggal"  value="{{\Carbon\Carbon::parse($data->tanggal)->format('d/m/Y')}}" autocomplete="off" rows="10" readonly>
                            <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group col-sm">
                                <label for="jadwal_masuk">Jadwal Masuk</label>
                                <input type="text" class="form-control" name="jadwal_masuk" id="jadwal_masuks" value="{{$data->jadwal_masuk}}" autocomplete="off" readonly>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group col-sm">
                                <label for="jadwal_pulang">Jadwal Pulang</label>
                                <input type="text" class="form-control" name="jadwal_pulang" id="jadwal_pulangs" value="{{$data->jadwal_pulang}}" autocomplete="off" readonly>
                            </div>
                        </div>
                    </div>
                    @if($role == 5)
                        <div class="form-group col-xs-12">
                            <label class="form-label">Partner</label>
                            <select class="form-control" name="'partneradmin">
                                <option value="">Pilih Partner</option>
                                @foreach ($partner as $k)
                                    <option value="{{ $k->id }}" {{ $k->id == $data->partner ? 'selected' : '' }}>
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

<script  type="text/javascript">
    $('#id_shifts').on('change',function(e){
        var id_shift = e.target.value;
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                        .attr('content')
                    }
        });
        $.ajax({
            type:"POST",
            url: '{{route('getshift')}}',
            data: {'id_shift':id_shift},
            success:function(data)
            {
                $('#jadwal_masuks').val(data.jam_masuk);
                $('#jadwal_pulangs').val(data.jam_pulang);
            }
        });
    });
</script>
