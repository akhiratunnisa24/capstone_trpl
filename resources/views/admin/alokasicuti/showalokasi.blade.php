{{-- MODALS SHOW SETTING ALOKASI CUTI --}}
<div class="modal fade" id="showalokasi{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="showalokasi" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="showsalokasi">Detail Alokasi Cuti</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="id_jenisuti" class="col-sm-3 col-form-label">Karyawan</label>
                    <div class="col-sm-9">
                        <label>: {{$data->karyawans->nama}}</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="id" class="col-sm-3 col-form-label">Kategori Cuti</label>
                    <div class="col-sm-9">
                        <label>: {{$data->jeniscutis->jenis_cuti}}</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="durasi" class="col-sm-3 col-form-label">Durasi</label>
                    <div class="col-sm-9">
                        <label>: {{$data->durasi}} Hari</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="mode_alokasi" class="col-sm-3 col-form-label">Mode Alokasi</label>
                    <div class="col-sm-9">
                        <label>: {{$data->mode_alokasi}}</label>
                    </div>
                </div>
                {{-- @if($data->tgl_masuk != NULL) --}}
                    <div class="form-group row">
                        <label for="tgl_masuk" class="col-sm-3 col-form-label">Tanggal Masuk</label>
                        <div class="col-sm-9">
                            <label>: {{\Carbon\Carbon::parse($data->tgl_masuk)->format("d/m/Y")}}</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tgl_sekarang" class="col-sm-3 col-form-label">Tanggal Sekarang</label>
                        <div class="col-sm-9">
                            <label>: {{\Carbon\Carbon::parse($data->tgl_sekarang)->format("d/m/Y")}}</label>
                        </div>
                    </div>
                {{-- @else --}}
                    {{-- <td></td> --}}
                {{-- @endif --}}
                <div class="form-group row">
                    <label for="aktif_dari" class="col-sm-3 col-form-label">Aktif dari</label>
                    <div class="col-sm-9">
                        <label>: {{\Carbon\Carbon::parse($data->aktif_dari)->format("d/m/Y")}}</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="sampai" class="col-sm-3 col-form-label">Sampai Tanggal</label>
                    <div class="col-sm-9">
                        <label>: {{\Carbon\Carbon::parse($data->sampai)->format("d/m/Y")}}</label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
