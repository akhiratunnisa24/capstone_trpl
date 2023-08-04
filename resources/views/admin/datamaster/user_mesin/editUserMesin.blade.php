<div class="modal fade" id="editUserMesin{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="AddModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel">Edit User Mesin</h4>
            </div>
            <div class="modal-body">
                <form action="/user_mesin/update/{{$data->id}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group col-xs-12">
                        <label class="col-form-label">Nama User Mesin</label>
                        <input type="text" class="form-control m-t-10" name="nama_user_mesin" value="{{ $data->karyawan->nama }}" readonly>
                    </div>

                    <div class="form-group col-xs-12">
                        <label class="col-form-label">NIK</label>
                        <input type="text" class="form-control m-t-10" name="nik" value="{{ $data->nik }}" readonly>
                    </div>

                    <div class="form-group col-xs-12">
                        <label class="col-form-label">Departemen</label>
                        <input type="text" class="form-control m-t-10" name="departemen" value="{{ $data->karyawan->departemens->nama_departemen }}" readonly>
                        {{-- Tampilkan nama departemen karyawan yang telah dipilih, di-disabled agar tidak bisa diubah --}}
                    </div>
                    @if (auth()->user()->role == 5)
                        <div class="form-group col-xs-12">
                            <label class="col-form-label">Partner</label>
                            <input type="text" class="form-control m-t-10" name="partner" value="{{ $data->partner }}" required>
                        </div>
                    @else
                             <input type="hidden" class="form-control m-t-10" name="partner" value="{{ $data->partner }}" required>
                    @endif

                    <div class="form-group col-xs-12">
                        <label class="col-form-label">Nomor ID</label>
                        <input type="text" class="form-control m-t-10" name="noid" value="{{ $data->noid }}" readonly>
                    </div>
                    <div class="form-group col-xs-12">
                        <label class="col-form-label">Nomor ID 2</label>
                        <input type="text" class="form-control m-t-10" name="noid2" value="{{ $data->noid2 }}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success waves-effect waves-light" name="submit" value="save">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
