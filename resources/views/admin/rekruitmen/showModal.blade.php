<!-- MODAL BEGIN -->

<!-- sample modal content -->
<div id="myModal{{ $k->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

           <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="Showcuti">Detail Data Pelamar</h4>
            </div>
            <div class="modal-body">

                <div class="form-group row">
                    <label  class="col-sm-3 col-form-label">NIK</label>
                    <div class="col-sm-9">
                        <label>: {{$k->nik}}</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label  class="col-sm-3 col-form-label">Nama Lengkap</label>
                    <div class="col-sm-9">
                        <label>: {{$k->nama}}</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tgl_mulai" class="col-sm-3 col-form-label">Tanggal Lahir</label>
                    <div class="col-sm-9">
                        <label>: {{\Carbon\Carbon::parse($k->tgllahir)->format("d/m/Y")}}</label>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label  class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <label>: {{$k->email}}</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label  class="col-sm-3 col-form-label">Agama</label>
                    <div class="col-sm-9">
                        <label>: {{$k->agama}}</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label  class="col-sm-3 col-form-label">Jenis Kelamin</label>
                    <div class="col-sm-9">
                         @if($k->jenis_kelamin == 'P')
                            <label>: Perempuan</label>
                        @else
                            <label>: Laki-Laki</label>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label  class="col-sm-3 col-form-label">Alamat</label>
                    <div class="col-sm-9">
                        <label>: {{$k->alamat}}</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label  class="col-sm-3 col-form-label">Nomor Handphone</label>
                    <div class="col-sm-9">
                        <label>: {{$k->no_hp}}</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label  class="col-sm-3 col-form-label">Nomor Kartu Keluarga</label>
                    <div class="col-sm-9">
                        <label>: {{$k->no_kk}}</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label  class="col-sm-3 col-form-label">Gaji yang diajukan</label>
                    <div class="col-sm-9">
                        <label>: {{$k->gaji}}</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label  class="col-sm-3 col-form-label">CV</label>
                    <div class="col-sm-9">
                        <label>: {{$k->cv}}</label>
                        {{-- <embed src="{{ asset('pdf/' . $k->cv)}}" type="application/pdf" width="100%" height="600px"> --}}
                            <a href="{{ asset('pdf/' . $k->cv)}}" class="btn btn-primary">Download</a>
                            {{-- <img src="{{ asset('pdf/' . $k->cv)}}" alt="" style="width:280px;"> --}}
                    </div>
                </div>

                </div>
                <div class="form-group row">
                    <label for="status" class="col-sm-3 col-form-label">Status Lamaran</label>
                    <div class="col-sm-9">
                        @if($k->status_lamaran == 'tahap 1')
                            <span class="badge badge-warning">tahap 1</span>
                        @elseif($k->status_lamaran == 'tahap 2')
                            <span class="badge badge-info">tahap 2</span>
                        @elseif($k->status_lamaran == 'tahap 3')
                            <span class="badge badge-success">tahap 3</span>
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
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

