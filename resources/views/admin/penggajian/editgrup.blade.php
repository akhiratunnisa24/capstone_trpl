{{-- FORM TAMBAH DATA DEPARTEMEN --}}
<div class="modal fade" id="editgrup{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="AddModal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel">Edit Data Hari Libur</h4>
            </div>

            <div class="modal-body">
                <form action="/slipgaji-karyawan-grup/update/{{$data->id}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group col-sm">
                        <label class="form-label">Nama Grup</label>
                        <input type="text" class="form-control" name="nama" value="{{$data->nama_grup}}"
                            placeholder="Masukkan nama grup" required>
                    </div>
                    <link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
                    <div class="form-group col-sm">
                        <label class="form-label">Tanggal Penggajian</label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="dd/mm/yyyy" id="datepicker-autoclose76a" name="tgl_penggajian" value="{{\Carbon\Carbon::parse($data->tglgajian)->format("d/m/Y")}}" autocomplete="off" required>
                            <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                            <label class="form-label">Periode Gajian</label>
                            <div>
                                <div class="input-group">
                                    <input id="datepicker-autoclose-format-au" type="text" class="form-control" placeholder="dd/mm/yyyy" value="{{\Carbon\Carbon::parse($data->tglawal)->format("d/m/Y")}}"
                                    name="tgl_mulai"  autocomplete="off"  rows="10" required>
                                    <span class="input-group-addon bg-info text-white b-0">-</span>
                                    <input id="datepicker-autoclose-format-av" type="text" class="form-control" placeholder="dd/mm/yyyy" value="{{\Carbon\Carbon::parse($data->tglakhir)->format("d/m/Y")}}"
                                        name="tgl_selesai" autocomplete="off"  rows="10" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-form-label">Struktur Penggajian</label>
                    <select name="id_struktur" id="id_struktur" class="form-control selectpicker" data-live-search="true" required>
                        {{-- <option>-- Pilih Struktur Penggajian --</option> --}}
                        @foreach($slipgrup as $data1)
                        <option value="{{ $data->id }}" {{ $data->id == $data1->id_struktur ? 'selected' : '' }}>{{ $data1->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <input id="partner" type="hidden" class="form-control" name="partner" value="{{ Auth::user()->partner }}" autocomplete="off">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success waves-effect waves-light" name="submit"
                            value="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
