<div class="modal fade" id="editmetode{{ $k->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editalokasi" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
           
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="editalokas">Edit Metode Rekruitmen</h4>
       
            <div class="modal-body">
                    <form action="update_metode_rekrutmen{{$k->id}}" method="POST"    >
                        @csrf
                        @method('put')
                                
                                <div class="form-group col-xs-12  m-t-20">
                                    <label for="id_jeniscuti" class="col-form-label">Nama Tahapan</label>
                                    <input name="namaTahapan" type="text" class="form-control m-t-10" value="{{$k->nama_tahapan}}">
                                </div>

                               

                        <div class="modal-footer">
                            {{-- <button onclick="window.location.reload();" type="button" class="btn btn-success" name="submit"
                                id="update_data" data-dismiss="modal">Simpan</button> --}}
                            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-sm btn-success" name="submit">Simpan</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>