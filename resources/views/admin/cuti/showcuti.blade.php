{{-- MODALS SHOW DATA CUTI --}}
<div class="modal fade" id="Showcuti{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="Showcuti" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="Showcuti">DETAIL DATA CUTI</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="id" name="id" class="col-sm-5 col-form-label">Nomor Registrasi</label>
                    <div class="col-sm-7">
                        <label>: {{$data->id}}</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="id" name="id" class="col-sm-5 col-form-label">Tanggal Permohonan</label>
                    <div class="col-sm-7">
                        <label>: {{\Carbon\carbon::parse($data->tgl_permohonan)->format('d/m/Y')}}</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" name="id" class="col-sm-5 col-form-label">Nomor Induk Karyawan</label>
                    <div class="col-sm-7">
                        <label>: {{$data->nik}}</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="id_karyawan" class="col-sm-5 col-form-label">Nama Karyawan</label>
                    <div class="col-sm-7">
                        <label>: {{$data->nama}}</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="id" name="id" class="col-sm-5 col-form-label">Jabatan</label>
                    <div class="col-sm-7">
                        <label>: {{$data->jabatan}}</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" name="id" class="col-sm-5 col-form-label">Divisi/Departemen</label>
                    <div class="col-sm-7">
                        <label>: {{$data->nama_departemen ?? ''}}</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tgl_mulai" class="col-sm-5 col-form-label">Tanggal Pelaksanaan</label>
                    <div class="col-sm-7">
                        <label>: {{\Carbon\Carbon::parse($data->tgl_mulai)->format("d/m/Y")}} @if($data->tgl_selesai !== NULL) s.d {{\Carbon\Carbon::parse($data->tgl_selesai)->format("d/m/Y")}} @endif</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="id_jeniscuti" class="col-sm-5 col-form-label">Status Ketidakhadiran</label>
                    <div class="col-sm-7">
                        <label>: {{$data->jenis_cuti}}</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="keperluan" class="col-sm-5 col-form-label">Keterangan</label>
                    <div class="col-sm-7">
                        <label>: {{$data->keperluan}}</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="status" class="col-sm-5 col-form-label">Status Cuti</label>
                    <div class="col-sm-7">
                        <span class="badge badge-{{ $data->status == 1 ? 'warning' : ($data->status == 2 ? 'info' : ($data->status == 5 ? 'danger' : ($data->status == 6 ? 'secondary' : ($data->status == 7 ? 'success' : ($data->status == 9 ? 'danger' : ($data->status == 10 ? 'danger' : ($data->status == 11 ? 'warning' : ($data->status == 12 ? 'secondary' : ($data->status == 13 ? 'danger' : ($data->status == 14 ? 'warning' :($data->status == 15 ? 'primary' : ($data->status == 16 ? 'primary' :  'secondary' )))))))))))) }}">
                            {{ $data->status == 1 ? $data->name_status : ($data->status == 2 ?  $data->name_status : ($data->status == 5 ?  $data->name_status : ($data->status == 6 ?  $data->name_status : ($data->status == 7 ?  $data->name_status : ($data->status == 9 ?  $data->name_status : ($data->status == 10 ?  $data->name_status : ($data->status == 11 ?  $data->name_status : ($data->status == 12 ?  $data->name_status : ($data->status == 13 ?  $data->name_status :  ($data->status == 14 ?  $data->name_status :  ($data->status == 15 ?  $data->name_status :  ($data->status == 16 ?  $data->name_status : '')))))))))))) }}
                        </span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="keperluan" class="col-sm-5 col-form-label">Tanggal Persetujuan</label>
                    <div class="col-sm-7">

                        @if($data->status == 1)
                            <label>: -</label>
                        @elseif($data->status == 2 || $data->status == 6)
                            <label>: Persetujuan Atasan&nbsp;&nbsp;&nbsp;&nbsp;: {{\Carbon\carbon::parse($data->tgldisetujui_a)->format('d/m/Y H:i')}} WIB</label><br>
                        @elseif($data->status == 6)
                            <label>: Persetujuan Atasan&nbsp;&nbsp;&nbsp;&nbsp;: {{\Carbon\carbon::parse($data->tgldisetujui_a)->format('d/m/Y H:i')}} WIB</label><br>
                        @elseif($data->status == 7)
                            <label>: Persetujuan Atasan&nbsp;&nbsp;&nbsp;&nbsp;: {{\Carbon\carbon::parse($data->tgldisetujui_a)->format('d/m/Y H:i')}} WIB</label><br>
                            <label>&nbsp;&nbsp;Persetujuan Pimpinan: {{\Carbon\carbon::parse($data->tgldisetujui_b)->format('d/m/Y H:i')}} WIB</label>
                        @elseif($data->status == 9)
                            <label>: Permintaan Ditolak&nbsp;&nbsp;&nbsp;&nbsp;: {{\Carbon\carbon::parse($data->tglditolak)->format('d/m/Y H:i')}} WIB</label><br>
                        @elseif($data->status == 10)
                            <label>: Persetujuan Atasan&nbsp;&nbsp;&nbsp;&nbsp;: {{\Carbon\carbon::parse($data->tgldisetujui_a)->format('d/m/Y H:i')}} WIB</label><br>
                            <label>: Permintaan Ditolak&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{\Carbon\carbon::parse($data->tglditolak)->format('d/m/Y H:i')}} WIB</label><br>
                        @elseif($data->status == 11)
                            <label>: -</label>
                        @elseif($data->status == 12)
                            <label>: Persetujuan Atasan&nbsp;&nbsp;&nbsp;&nbsp;: {{\Carbon\carbon::parse($data->batal_atasan)->format('d/m/Y H:i')}} WIB</label><br>
                        @elseif($data->status == 13)
                            <label>: Persetujuan Atasan&nbsp;&nbsp;&nbsp;&nbsp;: {{\Carbon\carbon::parse($data->batal_atasan)->format('d/m/Y H:i')}} WIB</label><br>
                            <label>&nbsp;&nbsp;Persetujuan Pimpinan: {{\Carbon\carbon::parse($data->batal_pimpinan)->format('d/m/Y H:i')}} WIB</label>
                        @else
                            <label>: -</label>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label for="status" class="col-sm-5 col-form-label">Catatan</label>
                    <div class="col-sm-7">
                        <label>: {{$data->catatan ?? ''}}</label>
                    </div>
                </div>
                @if($data->status == 9 || $data->status == 10)
                    <div class="form-group row">
                        <label for="alasan" class="col-sm-5 col-form-label">Alasan Penolakan</label>
                        <div class="col-sm-7">
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
