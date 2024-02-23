{{-- MODALS SHOW DATA CUTI --}}
<div class="modal fade" id="shoCutiStaff{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="Showcuti" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="Showcuti">Detail Data Cuti</h4>
            </div>
            <div class="modal-body">
                {{-- <div class="form-group row">
                    <label for="id" name="id" class="col-sm-3 col-form-label">ID Cuti</label>
                    <div class="col-sm-9">
                        <label>: {{$data->id}}</label>
                    </div>
                </div> --}}
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
                        {{-- <span class="badge badge-{{ $data->status == 1 ? 'warning' : ($data->status == 2 ? 'info' : ($data->status == 5 ? 'danger' : ($data->status == 6 ? 'secondary' : ($data->status == 7 ? 'success' : ($data->status == 9 ? 'danger' : ($data->status == 10 ? 'danger' :'')))))) }}">
                            {{ $data->status == 1 ? 'Pending' : ($data->status == 2 ? 'Disetujui Manager' : ($data->status == 5 ? 'Ditolak' : ($data->status == 6 ? 'Disetujui Asistant Manager' : ($data->status == 7 ? 'Disetujui' : ($data->status == 9 ? 'Pending Atasan' : ($data->status == 10 ? 'Pending Pimpinan' :'')))))) }}
                        </span> --}}
                        <span class="badge badge-{{ $data->status == 1 ? 'warning' : ($data->status == 2 ? 'info' : ($data->status == 5 ? 'danger' : ($data->status == 6 ? 'secondary' : ($data->status == 7 ? 'success' : ($data->status == 9 ? 'danger' : ($data->status == 10 ? 'danger' : ($data->status == 11 ? 'warning' : ($data->status == 12 ? 'secondary' : ($data->status == 13 ? 'danger' : ($data->status == 14 ? 'warning' :($data->status == 15 ? 'primary' : ($data->status == 16 ? 'primary' :  'secondary' )))))))))))) }}">
                            {{ $data->status == 1 ? $data->name_status : ($data->status == 2 ?  $data->name_status : ($data->status == 5 ?  $data->name_status : ($data->status == 6 ?  $data->name_status : ($data->status == 7 ?  $data->name_status : ($data->status == 9 ?  $data->name_status : ($data->status == 10 ?  $data->name_status : ($data->status == 11 ?  $data->name_status : ($data->status == 12 ?  $data->name_status : ($data->status == 13 ?  $data->name_status :  ($data->status == 14 ?  $data->name_status :  ($data->status == 15 ?  $data->name_status :  ($data->status == 16 ?  $data->name_status : '')))))))))))) }}
                        </span>
                    </div>
                </div>
                @if($data->status == 5)
                    <div class="row">
                        <label for="alasan" class="col-sm-3 col-form-label">Alasan</label>
                        <div class="col-sm-9">
                            <label>: {{$data->alasan}}</label>
                        </div>
                    </div>
                @endif

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
