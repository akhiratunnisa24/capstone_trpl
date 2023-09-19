<link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
<div id="addslip-grup" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title text-center" id="myModalLabel">Tambah Slip Grup</h4>
            </div>
            <div class="modal-body">
                <form id="formCreatePekerjaan" method="POST" action="{{ route('storegrup') }}" onsubmit="return validateForm()">
                    @csrf
                    @method('POST')
                    <div class="col-md-12 m-b-50">
                        <div class="form-group col-sm">
                            <label class="form-label">Nama Grup</label>
                            <div class="input-group col-md-12">
                                <input id="nama_grup" type="text" placeholder="Masukkan Nama Slip Grup" class="form-control" name="nama_grup" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group col-sm">
                            <label class="form-label">Tanggal Penggajian</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="dd/mm/yyyy" id="datepicker-autoclose76" name="tgl_penggajian"  autocomplete="off" required>
                                <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="mb-3">
                                <label class="form-label">Periode Gajian</label>
                                <div>
                                    <div class="input-group">
                                        <input id="datepicker-autoclose-format-as" type="text" class="form-control" placeholder="dd/mm/yyyy"
                                        name="tgl_mulai"  autocomplete="off"  rows="10" required readonly>
                                        <span class="input-group-addon bg-info text-white b-0">-</span>
                                        <input id="datepicker-autoclose-format-at" type="text" class="form-control" placeholder="dd/mm/yyyy"
                                                name="tgl_selesai" autocomplete="off"  rows="10" required readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="form-group col-sm">
                            <label  class="col-form-label">Struktur Penggajian</label>
                            <select name="id_strukturgaji" id="id_strukturgaji" class="form-control selectpicker" data-live-search="true" required>
                                <option>-- Pilih Struktur Penggajian --</option>
                                @foreach($slipgrup as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                @endforeach
                            </select>
                        </div>  --}}
                        <input id="partner" type="hidden" class="form-control" name="partner" value="{{ Auth::user()->partner }}" autocomplete="off">
                    </div>
                    <div class="modal-footer m-t-50">
                        <button type="button" class="btn btn-sm btn-danger waves-effect" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-sm btn-success waves-effect waves-light" name="submit" value="save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<script src="assets/js/jquery.min.js"></script>
