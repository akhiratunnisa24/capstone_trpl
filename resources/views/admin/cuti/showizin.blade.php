{{-- MODALS EDIT DATA CUTI --}}
<div class="modal fade" id="Showizinadmin{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="Showizinadmin" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="col-md-12 modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="Showizinadmin">Detail Permohonan Izin</h4>
            </div>
            <div class="modal-body col-md-12">
                <div class="row">
                    <label for="id" class="col-sm-3 col-form-label">Id Izin</label>
                    <div class="col-sm-9">
                        <label>: {{$data->id}}</label>
                    </div>
                </div>
                
                <div class="row">
                    <label for="id_karyawan" class="col-sm-3 col-form-label">Nama Karyawan</label>
                    <div class="col-sm-9">
                        <label>: {{$data->karyawans->nama}}</label>
                    </div>
                </div>
                <div class="row">
                    <label for="id_jeniscuti" class="col-sm-3 col-form-label">Kategori Izin</label>
                    <div class="col-sm-9">
                        <label>: {{$data->jenisizins->jenis_izin}}</label>
                    </div>
                </div>
                <div class="row">
                    <label for="id_karyawan" class="col-sm-3 col-form-label">Keperluan</label>
                    <div class="col-sm-9">
                        <label>: {{$data->keperluan}}</label>
                    </div>
                </div>

                @if($data->tgl_mulai != $data->tgl_selesai)
                    <div class="row">
                        <label for="tgl_mulai" class="col-sm-3 col-form-label">Tanggal Izin</label>
                        <div class="col-sm-9">
                            <label>: {{\Carbon\Carbon::parse($data->tgl_mulai)->format("d/m/Y")}} s/d {{\Carbon\Carbon::parse($data->tgl_selesai)->format("d/m/Y")}}</label>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <label for="tgl_mulai" class="col-sm-3 col-form-label">Tanggal Izin</label>
                        <div class="col-sm-9">
                            <label>: {{\Carbon\Carbon::parse($data->tgl_mulai)->format("d M Y")}}</label>
                        </div>
                    </div>    
                @endif

                @if($data->jml_hari != null)
                    <div class="row">
                        <label for="jml_cuti" class="col-sm-3 col-form-label">Jumlah Hari</label>
                        <div class="col-sm-9">
                            <label>: {{$data->jml_hari}} Hari</label>
                        </div>
                    </div>        
                @endif

                @if($data->jam_mulai != null && $data->jam_selesai != null)
                    <div class="row">
                        <label for="jam_mulai" class="col-sm-3 col-form-label">Jam Izin</label>
                        <div class="col-sm-9">
                            <label>: {{\Carbon\Carbon::parse($data->jam_mulai)->format("H:i")}} s/d {{\Carbon\Carbon::parse($data->jam_selesai)->format("H:i")}}</label>
                        </div>
                    </div>        
                @endif

                @if($data->jml_jam != null)
                    <div class="row">
                        <label for="jml_cuti" class="col-sm-3 col-form-label">Jumlah Jam</label>
                        <div class="col-sm-9">
                            <label>: {{\Carbon\Carbon::parse($data->jml_jam)->format("H:i")}}</label>
                        </div>
                    </div>        
                @endif

                <div class="row">
                    <label for="status" class="col-sm-3 col-form-label">Status Izin</label>
                    <div class="col-sm-9">
                        @if($data->status == 'Pending')
                            <span class="badge badge-warning">Pending</span>
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
