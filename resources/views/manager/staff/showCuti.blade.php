{{-- MODALS SHOW DATA CUTI --}}
<div class="modal fade" id="shoCutiStaff{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="Showcuti" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="Showcuti">Detail Permintaan Cuti</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="id" name="id" class="col-sm-3 col-form-label">ID Cuti</label>
                    <div class="col-sm-9">
                        <label>: {{$data->id}}</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="id_karyawan" class="col-sm-3 col-form-label">Nama Karyawan</label>
                    <div class="col-sm-9">
                        <label>: {{$data->nama}}</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="id_jeniscuti" class="col-sm-3 col-form-label">Kategori Cuti</label>
                    <div class="col-sm-9">
                        <label>: {{$data->jenis_cuti}}</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="keperluan" class="col-sm-3 col-form-label">Keperluan</label>
                    <div class="col-sm-9">
                        <label>: {{$data->keperluan}}</label>
                    </div>
                </div>
                {{-- @if($data->) --}}
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
                        @if($data->status == 'Pending')
                            <span class="badge badge-warning">Pending</span>
                        @elseif($data->status == 'Disetujui Manager')
                            <span class="badge badge-info">Disetujui Manager</span>
                        @elseif($data->status == 'Disetujui')
                            <span class="badge badge-success">Disetujui</span>
                        @else
                            <span class="badge badge-danger">Ditolak</span>
                        @endif
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
