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
                        <label>: {{$data->nama}}</label>
                    </div>
                </div>
                <div class="row">
                    <label for="id_jeniscuti" class="col-sm-3 col-form-label">Kategori Izin</label>
                    <div class="col-sm-9">
                        <label>: {{$data->jenis_izin}}</label>
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
                        <span class="badge badge-{{ $data->status == 1 ? 'warning' : ($data->status == 2 ? 'info' : ($data->status == 5 ? 'danger' : ($data->status == 6 ? 'secondary' : ($data->status == 7 ? 'success' : ($data->status == 9 ? 'danger' : ($data->status == 10 ? 'danger' :'')))))) }}">
                            {{ $data->status == 1 ? 'Pending' : ($data->status == 2 ? 'Disetujui Manager' : ($data->status == 5 ? 'Ditolak' : ($data->status == 6 ? 'Disetujui Asisten Manajer' : ($data->status == 7 ? 'Disetujui' : ($data->status == 9 ? 'Pending Atasan' : ($data->status == 10 ? 'Pending Pimpinan' :'')))))) }}
                        </span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="keperluan" class="col-sm-5 col-form-label">Tanggal Persetujuan</label>
                    <div class="col-sm-7">
                        @if($data->tgl_setuju_a !== NULL && $data->tgl_setuju_b == NULL && $data->tgl_ditolak == NULL)
                            <label>: Persetujuan Atasan&nbsp;&nbsp;&nbsp;&nbsp;: {{\Carbon\carbon::parse($data->tgl_setuju_a)->format('d/m/Y H:i')}} WIB</label><br>
                        @elseif($data->tgl_setuju_a !== NULL && $data->tgl_setuju_b !== NULL && $data->tgl_ditolak == NULL)
                            <label>: Persetujuan Atasan&nbsp;&nbsp;&nbsp;&nbsp;: {{\Carbon\carbon::parse($data->tgl_setuju_a)->format('d/m/Y H:i')}} WIB</label><br>
                            <label>&nbsp;&nbsp;Persetujuan Pimpinan: {{\Carbon\carbon::parse($data->tgl_setuju_b)->format('d/m/Y H:i')}} WIB</label>
                        @elseif($data->tgl_setuju_a == NULL && $data->tgl_setuju_b == NULL && $data->tgl_ditolak !== NULL)
                            <label>: Permintaan Ditolak&nbsp;&nbsp;&nbsp;&nbsp;: {{\Carbon\carbon::parse($data->tgl_ditolak)->format('d/m/Y H:i')}} WIB</label><br>
                        @elseif($data->tgl_setuju_a !== NULL && $data->tgl_setuju_b == NULL && $data->tgl_ditolak !== NULL)
                            <label>: Persetujuan Atasan&nbsp;&nbsp;&nbsp;&nbsp;: {{\Carbon\carbon::parse($data->tgl_setuju_a)->format('d/m/Y H:i')}} WIB</label><br>
                            <label>: Permintaan Ditolak&nbsp;&nbsp;&nbsp;&nbsp;: {{\Carbon\carbon::parse($data->tgl_ditolak)->format('d/m/Y H:i')}} WIB</label><br>
                            @else
                            <label>: -</label>
                        @endif
                    </div>
                </div>
                @if($data->status == 9 || $data->status == 10)
                    <div class="form-group row">
                        <label for="alasan" class="col-sm-3 col-form-label">Alasan Penolakan</label>
                        <div class="col-sm-9">
                            <label>: {{$data->alasan}}</label>
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
