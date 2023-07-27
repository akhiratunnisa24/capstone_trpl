<!-- MODAL BEGIN -->

<!-- sample modal content -->
<div id="lulusModal{{ $k->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center">Detail Tahap Selanjutnya</h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="update_pelamar{{ $k->id }}">
                    @csrf
                    @method('POST')

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-9">
                            <label>: {{ $k->nama }}</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <label>: {{ $k->email }}</label>
                        </div>
                    </div>

                    {{-- <div class="form-group row">
                    <label for="status" class="col-sm-3 col-form-label">Status Lamaran</label>
                    <div class="col-sm-9">
                        @if ($k->status_lamaran == '6')
                            <span class="badge badge-success">Diterima</span>
                        @else
                            <span class="badge badge-info">{{ $k->mrekruitmen->nama_tahapan }}</span>
                        @endif
                    </div>
                </div> --}}

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Lanjut ke tahap</label>
                        <div class="col-sm-9">
                            <select class="form-control datepicker " name="status_lamaran">
                                <option value="">Pilih Tahap Selanjutnya</option>
                                @foreach ($metode as $k)
                                    <option value="{{ $k->mrekruitmen->id }}">{{ $k->mrekruitmen->nama_tahapan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Pilih Tanggal</label>
                        <div class="col-sm-9">
                            <input id="datepicker-autoclose26" type="text" class="form-control"
                                placeholder="yyyy/mm/dd" name="tgl_tahapan" autocomplete="off" rows="10"
                                required></input>
                        </div>
                    </div> --}}

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Pilih Tanggal</label>
                        <div class="col-sm-9">
                        <input type="date" class="form-control" id="date" placeholder="yyyy/mm/dd" name="tgl_tahapan" autocomplete="off" rows="10"
                                required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Link *</label>
                        <div class="col-sm-9">
                            <input class="form-control" placeholder="Masukkan Link" name="link" autocomplete="off"> 
                        </div>
                    </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Submit</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
