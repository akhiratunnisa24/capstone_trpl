<div class="modal fade" id="editInfor{{ $informasigaji->id }}" tabindex="-1" role="dialog" aria-labelledby="AddModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel">Edit Informasi Gaji Karyawan</h4>
            <div class="modal-body">
                <form action="/update-informasigaji{{$informasigaji->id}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group col-sm">
                                    <div class="row">
                                        <label class="form-label col-sm-3 text-end">Nama</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="namaKaryawan" autocomplete="off" value="{{$informasigaji->karyawans->nama}}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm">
                                    <div class="row">
                                        <label class="form-label col-sm-3 text-end">Struktur Gaji</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="strukturGaji" autocomplete="off" value="{{$informasigaji->strukturgajis->nama}}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                
                                <div class="col-md-6">
                                    <div class="form-group col-xs">
                                        <label for="benefits" class="form-label">Benefit :</label>
                                        <div>
                                            @foreach ($benefits as $manfaat)
                                                <div class="checkbox checkbox-success">
                                                    <input type="checkbox" id="checkbox{{ $manfaat->id }}" class="form-check-input"
                                                        name="benefits[]" value="{{ $manfaat->id }}"
                                                        {{ (in_array($manfaat->id, $selectedBenefits) || $detailinformasigaji->contains('id_benefit', $manfaat->id)) ? 'checked' : '' }}
                                                        {{ in_array($manfaat->id, $selectedBenefits) ? 'disabled' : '' }}>
                                                    <label for="checkbox{{ $manfaat->id }}">
                                                        {{ $manfaat->nama_benefit }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
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
