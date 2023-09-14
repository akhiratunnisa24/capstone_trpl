<div class="modal fade" id="editMesin{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel">Edit Data Partner</h4>
            </div>
            <div class="modal-body">
                <form action="/list-mesin/update/{{$data->id}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group col-sm">
                        <label class="col-form-label">Nama Mesin</label>
                        <input type="text" class="form-control" name="nama_mesin" value="{{$data->nama_mesin}}" id="nama_mesin" autocomplete="off"
                            placeholder="Edit Nama List Mesin" >
                    </div>
                    <div class="form-group col-sm">
                        <label class="col-form-label">IP Mesin</label>
                        <input type="text" class="form-control" name="ip_mesin" value="{{$data->ip_mesin}}" id="ip_mesin" autocomplete="off"
                            placeholder="Edit IP Mesin" >
                    </div>
                    <div class="form-group col-sm">
                        <label class="col-form-label">Port Mesin</label>
                        <input type="text" class="form-control" name="port" value="{{$data->port}}" id="port" autocomplete="off"
                            placeholder="Edit Port Mesin" >
                    </div>

                    <div class="form-group col-sm">
                        <label class="col-form-label">Comm Key</label>
                        <input type="text" class="form-control" name="comm_key" value="{{$data->comm_key}}" id="comm_key" autocomplete="off"
                            placeholder="Edit Comm Key" >
                    </div>

                    <div class="form-group col-xs-12">
                        <label class="form-label">Partner</label>
                        <select class="form-control" name="partner">
                            <option value="">Pilih Partner</option>
                            @foreach ($partner as $k)
                                <option value="{{ $k->id }}" {{ $k->id == $data->partner ? 'selected' : '' }}>
                                    {{ $k->nama_partner }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger waves-effect" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-sm btn-success waves-effect waves-light" name="submit"
                            value="save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>