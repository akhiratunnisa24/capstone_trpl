<!-- MODAL BEGIN -->

<!-- sample modal content -->
<div id="myModal{{ $data->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title text-center" id="myModalLabel">Edit User</h4>


            <div class="modal-body">

                <form method="POST" action="editrole{{ $data->id }}">
                    @csrf
                    @method('put')

                    <div class="form-group col-xs-12">
                        <label class="form-label">Role</label>
                        <input  type="text" class="form-control" name="role"
                            autocomplete="off" value="{{ $data->role }}" >
                    </div>
                    
                    {{-- <div class="form-group col-xs-12">
                        <label class="form-label">Status / Level</label>
                             <select type="text" class="form-control selecpicker"
                                name="status" required autocomplete="role" autofocus placeholder="Role">
                                <option value="">Pilih Level</option>
                                 <option value="1" {{ $data->status == '1' ? 'selected' : '' }}>Admin</option>
                                 <option value="2" {{ $data->status == '2' ? 'selected' : '' }}>User</option>
                                 <option value="3" {{ $data->status == '3' ? 'selected' : '' }}>Super Admin</option>
                            </select>
                    </div> --}}

                    <div class="col-xs-12">
                        <div class="checkbox checkbox-primary">
                        </div>
                    </div>

                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-primary w-md waves-effect waves-light"
                                type="submit">Submit</button>
                        </div>
                    </div>

                </form>


                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Tutup</button> --}}
                    <!-- <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Register</button> -->
                </div>

            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

