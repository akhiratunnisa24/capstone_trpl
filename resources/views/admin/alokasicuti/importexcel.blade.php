 {{-- Modal Import Data Excel --}}
 <div class="modal fade" id="ModalImport" tabindex="-1" role="dialog" aria-labelledby="ModalImportLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="ModalImportLabel">Import Alokasi Cuti</h4>
            </div>
            <form action="{{ route('alokasi.importexcel') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-lg-5">
                            <input type="file" name="file" required>
                        </div>
                    </div> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-sm btn-primary">Import Data</button>
                </div>
            </form>
        </div>
    </div>
</div>