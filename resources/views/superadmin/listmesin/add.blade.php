{{-- FORM TAMBAH DATA List Mesin --}}
<div class="modal fade" id="AddMesin" tabindex="-1" role="dialog" aria-labelledby="AddModal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel">Tambah Data List Mesin</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('listmesin.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-group col-sm">
                        <label class="col-form-label">Nama Mesin</label>
                        <input type="text" class="form-control" name="nama_mesin" id="nama_mesin" autocomplete="off"
                            placeholder="Masukkan Nama List Mesin" required>
                    </div>
                    <div class="form-group col-sm">
                        <label class="col-form-label">IP Mesin</label>
                        <input type="text" class="form-control" name="ip_mesin" id="ip_mesin" autocomplete="off"
                            placeholder="Masukkan IP Mesin" required>
                    </div>
                    <div class="form-group col-sm">
                        <label class="col-form-label">Port Mesin</label>
                        <input type="text" class="form-control" name="port" id="port" autocomplete="off"
                            placeholder="Masukkan Port Mesin" required>
                    </div>

                    <div class="form-group col-sm">
                        <label class="col-form-label">Comm Key</label>
                        <input type="text" class="form-control" name="comm_key" id="comm_key" autocomplete="off"
                            placeholder="Masukkan Comm Key" required>
                    </div>

                    <div class="form-group col-xs-12">
                        <label class="form-label">Partner</label>
                        <select  class="form-control" name="partner" required>
                            <option value="">Pilih Partner</option>
                            @foreach ($partner as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_partner }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success waves-effect waves-light" name="submit"
                            value="save">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>