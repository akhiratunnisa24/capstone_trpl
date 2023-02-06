{{-- MODALS EDIT DATA CUTI --}}
<div class="modal fade" id="Showresign{{$r->id}}" tabindex="-1" role="dialog" aria-labelledby="Showresign" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="Showresign">Detail Permintaan Resign</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="id" class="col-sm-3 col-form-label">Id Resign</label>
                    <div class="col-sm-9">
                        <label>: {{$r->id}}</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="id_karyawan" class="col-sm-3 col-form-label">Nama Karyawan</label>
                    <div class="col-sm-9">
                        <label>: {{$r->karyawans->nama}}</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="id_jeniscuti" class="col-sm-3 col-form-label">Departemen</label>
                    <div class="col-sm-9">
                        <label>: {{$r->departemens->nama_departemen}}</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="id_karyawan" class="col-sm-3 col-form-label">Tanggal Bergabung</label>
                    <div class="col-sm-9">
                        <label>: {{\Carbon\Carbon::parse($r->tgl_masuk)->format('d/m/Y')}}</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tgl_mulai" class="col-sm-3 col-form-label">Tanggal Resign</label>
                    <div class="col-sm-9">
                        <label>: {{\Carbon\Carbon::parse($r->tgl_resign)->format('d/m/Y')}}</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tgl_selesai" class="col-sm-3 col-form-label">Tipe Resign</label>
                    <div class="col-sm-9">
                        <label>: {{$r->tipe_resign}}</label>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="status" class="col-sm-3 col-form-label">Status Resign</label>
                    <div class="col-sm-9">
                        @if($r->status == '1')
                            <span class="badge badge-warning">Pending</span>
                        @elseif($r->status == '2')
                            <span class="badge badge-info">Disetujui Manager</span>
                        @elseif($r->status == '3')
                            <span class="badge badge-success">Disetujui</span>
                        @elseif($r->status == '4')
                            <span class="badge badge-warning">Pending HRD</span>
                        @else
                            <span class="badge badge-danger">Ditolak</span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tgl_selesai" class="col-sm-3 col-form-label">Alasan Resign</label>
                    <div class="col-sm-9">
                        <label>: {{$r->alasan}}</label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
