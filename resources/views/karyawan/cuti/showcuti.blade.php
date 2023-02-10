{{-- MODALS EDIT DATA CUTI --}}
<div class="modal fade" id="Showcuti{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="Showcuti" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="Showcuti">Detail Permintaan Cuti</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="id" class="col-sm-3 col-form-label">Id Cuti</label>
                    <div class="col-sm-9">
                        <label>: {{$data->id}}</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="id_karyawan" class="col-sm-3 col-form-label">Nama Karyawan</label>
                    <div class="col-sm-9">
                        <label>: {{$data->karyawans->nama}}</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="id_jeniscuti" class="col-sm-3 col-form-label">Kategori Cuti</label>
                    <div class="col-sm-9">
                        <label>: {{$data->jeniscutis->jenis_cuti}}</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="id_karyawan" class="col-sm-3 col-form-label">Keperluan</label>
                    <div class="col-sm-9">
                        <label>: {{$data->keperluan}}</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tgl_mulai" class="col-sm-3 col-form-label">Tanggal Mulai</label>
                    <div class="col-sm-9">
                        <label>: {{\Carbon\Carbon::parse($data->tgl_mulai)->format("d/m/Y")}}</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tgl_selesai" class="col-sm-3 col-form-label">Tanggal Selesai</label>
                    <div class="col-sm-9">
                        <label>: {{\Carbon\Carbon::parse($data->tgl_selesai)->format("d/m/Y")}}</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="jml_cuti" class="col-sm-3 col-form-label">Jumlah Cuti</label>
                    <div class="col-sm-9">
                        <label>: {{$data->jml_cuti}} Hari</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="status" class="col-sm-3 col-form-label">Status Cuti</label>
                    <div class="col-sm-9">
                        <span class="badge badge-{{ $data->status == 1 ? 'warning' : ($data->status == 2 ? 'info' : ($data->status == 5 ? 'danger' : ($data->status == 6 ? 'secondary' : ($data->status == 7 ? 'success' : '')))) }}">
                            {{ $data->status == 1 ? 'Pending' : ($data->status == 2 ? 'Disetujui Manager' : ($data->status == 5 ? 'Ditolak' : ($data->status == 6 ? 'Disetujui Supervisor' : ($data->status == 7 ? 'Disetujui' : '')))) }}
                        </span>
                    </div>
                </div>

                @if(isset($alasan) && $data->id == $alasan->id_izin && $data->status == 5)
                    <div class="form-group row">
                        <label for="alasan" class="col-sm-3 col-form-label">Alasan</label>
                        <div class="col-sm-9">
                            <label>: {{$alasan->alasan}}</label>
                        </div>
                    </div>        
                @endif

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
