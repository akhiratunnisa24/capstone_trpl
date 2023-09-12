<div class="modal fade" id="editstruktur{{ $struktur->id }}" tabindex="-1" role="dialog" aria-labelledby="AddModal"
    aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel">Edit Benefit Karyawan</h4>
            <div class="modal-body">
                <form action="/update-detail-informasi{{$struktur->id}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="col-md-12">
                        <div class="form-group col-sm">
                            <div class="row">
                                <label class="form-label col-sm-3 text-end">Struktur Gaji</label>
                                <div class="col-sm-9">
                                    <select class="form-select" name="strukturGaji" readonly>
                                        <option value="">Pilih Struktur</option>
                                        @foreach($strukturgaji as $item)
                                            <option value="{{ $item->id}}">
                                                {{ $item->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                      <input type="hidden" class="form-control" name="partner" autocomplete="off" value="{{$data->partner}}">
                    
                    <div class="modal-footer" style="margin-top:30px">
                        <button type="button" class="btn btn-danger btn-sm waves-effect"
                            data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success btn-sm waves-effect waves-light" name="submit"
                            value="save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
