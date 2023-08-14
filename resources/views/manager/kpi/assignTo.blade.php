{{-- FORM TAMBAH KATEGORI CUTI --}}
<div class="modal fade" id="assignTo" tabindex="-1" role="dialog" aria-labelledby="Modal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel">Tambah Alokasi</h4>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-group col-sm">
                        <label for="" class="col-form-label">Karyawan</label>
                        <select class="form-control selectpicker" name="karyawan" id="karyawan" autocomplete="off" data-live-search="true">
                            <option value="">Pilih Karyawan</option>
                            <option value="">Karyawan A</option>
                            <option value="">karyawan B</option>
                            {{-- @foreach ($departemen as $dep)
                                <option value="{{ $dep->id }}">{{ $dep->nama_departemen }}
                                </option>
                            @endforeach --}}
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success waves-effect waves-light" name="submit"
                            value="save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>