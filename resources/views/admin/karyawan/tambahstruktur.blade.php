
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="AddModal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel">Tambah Struktur Gaji</h4>
            <div class="modal-body">
                <form action="/tambah-struktur{{$karyawan->id}}" method="POST">
                    @csrf
                    @method('POST')
                  
                    <div class="col-md-12" style="margin-bottom:30px">
                        <div class="form-group col-sm">
                            <div class="row">
                                <label class="form-label col-sm-3 text-end">Struktur Gaji</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="strukturgaji">
                                        <option value="">Pilih Struktur</option>
                                        {{-- @if($informasigaji !== null) --}}
                                            @foreach ($strukturgaji as $d)
                                                <option value="{{ $d->id }}"
                                                    {{ $informasigaji ? ($informasigaji->id_strukturgaji == $d->id ? 'selected' : '') : '' }}>
                                                    {{ $d->nama }}
                                                </option>
                                            @endforeach
                                        {{-- @endif --}}
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="margin-top:30px">
                        <button type="button" class="btn btn-danger btn-sm waves-effect" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success btn-sm waves-effect waves-light" name="submit"
                            value="save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
