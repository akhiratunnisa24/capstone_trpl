{{-- MODALS SHOW SETTING ALOKASI CUTI --}}
<div class="modal fade" id="Modalshowsetting{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="Modalshowsetting" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="Modalshowsetting">Detail Setting Alokasi</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="id" class="col-sm-3 col-form-label">ID Setting</label>
                    <div class="col-sm-9">
                        <label>: {{$data->id}}</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="id_jenisuti" class="col-sm-3 col-form-label">Kategori Cuti</label>
                    <div class="col-sm-9">
                        <label>: {{$data->jeniscutis->jenis_cuti}}</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="durasi" class="col-sm-3 col-form-label">Durasi Cuti</label>
                    <div class="col-sm-9">
                        <label>: {{$data->durasi}} Hari</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="mode_alokasi" class="col-sm-3 col-form-label">Mode Alokasi</label>
                    <div class="col-sm-9">
                        <label>: {{$data->mode_alokasi}}</label>
                    </div>
                </div>
                @if($data->mode_alokasi == 'Berdasarkan Departemen')
                    <div class="form-group row">
                        <label for="departemen" class="col-sm-3 col-form-label">Departemen</label>
                        <div class="col-sm-9">
                            <label>: {{$data->departemen}}</label>
                        </div>
                    </div>
                @else
                    <div class="form-group row">
                        <label for="mode_karyawan" class="col-sm-3 col-form-label">Mode Karyawan</label>
                        <div class="col-sm-9">
                            <label>: {{$data->mode_karyawan}}</label>
                        </div>
                    </div> 
                @endif

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
