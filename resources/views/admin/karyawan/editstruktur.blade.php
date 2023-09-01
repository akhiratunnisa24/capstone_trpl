
<div class="modal fade" id="editD{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="AddModal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel">Edit Benefit Karyawan</h4>
            <div class="modal-body">
                <form action="/update-detail-informasi{{$data->id}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="col-md-12">
                        <div class="form-group col-sm">
                            <div class="row">
                                <label class="form-label col-sm-3 text-end">Nama</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="namaKaryawan" autocomplete="off" value="{{$data->karyawans->nama}}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm">
                            <div class="row">
                                <label class="form-label col-sm-3 text-end">Struktur Gaji</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="strukturGaji" autocomplete="off" value="{{$data->strukturgaji->nama}}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm">
                            <div class="row">
                                <label class="form-label col-sm-3 text-end">Benefit</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="benefit" autocomplete="off" value="{{$data->benefit->nama_benefit}}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm">
                            <div class="row">
                                <label class="form-label col-sm-3 text-end">Nominal</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control input-formats" name="nominal" autocomplete="off" value="{{ number_format($data->nominal,0, ',', '.') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                      <input type="hidden" class="form-control" name="partner" autocomplete="off" value="{{$data->partner}}">
                    
                    <div class="modal-footer" style="margin-top:30px">
                        <button type="button" class="btn btn-danger btn-sm waves-effect" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success btn-sm waves-effect waves-light" name="submit"
                            value="save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputFormats = document.querySelectorAll('.input-formats');
    
        inputFormats.forEach(input => {
            input.addEventListener('input', function() {
                const value = parseFloat(this.value.replace(/\./g, '').replace(/,/g, ''));
                if (!isNaN(value)) {
                    const formattedValue = new Intl.NumberFormat('id-ID').format(value);
                    this.value = formattedValue;
                }
            });
        });
    });
</script> 