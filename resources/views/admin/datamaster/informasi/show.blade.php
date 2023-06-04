{{-- MODALS SHOW DATA CUTI --}}
<div class="modal fade" id="ShowInformasi{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="Showcuti" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="Showcuti">Detail Data Informasi</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label name="judul" class="col-sm-5 col-form-label">Judul</label>
                    <div class="col-sm-7">
                        <label>: {{$data->judul}}</label>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-5 col-form-label">Masa Aktif
                    <div class="col-sm-7">
                        <label>: {{\Carbon\Carbon::parse($data->tanggal_aktif)->format("d/m/Y")}} @if($data->taggal_berakhir !== NULL) s.d {{\Carbon\Carbon::parse($data->tanggal_berakhir)->format("d/m/Y")}} @endif</label>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
