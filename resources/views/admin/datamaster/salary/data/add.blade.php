<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title text-center" id="myModalLabel">Tambah Struktur Penggajian</h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('salary.store') }}" onsubmit="return validateForm()">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group col-xs">
                                    <label class="form-label">Nama Struktur Penggajian</label>
                                    <input type="text" class="form-control" name="nama"
                                        placeholder="Masukkan nama struktur penggajian" required>
                                </div>

                                <div class="form-group col-xs">
                                    <label for="id_level_jabatan">Level Jabatan</label>
                                    <select class="form-control" name="id_level_jabatan"required>
                                        <option value="" disabled selected>Pilih Level Jabatan</option>
                                        @foreach ($levelJabatanOptions as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-xs">
                                    <label for="status_karyawan">Jenis Status Karyawan</label>
                                    <select class="form-control" name="status_karyawan"required>
                                        @foreach ($statusKaryawanOptions as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group col-xs">
                                    <label for="benefits">Komponen Penggajian</label>
                                    @foreach ($benefits as $benefit)
                                        <div class="checkbox checkbox-success">
                                            <input type="checkbox" id="checkbox{{ $benefit->id }}" class="form-check-input"
                                                name="benefits[]" value="{{ $benefit->id }}"
                                                {{ in_array($benefit->id, $selectedBenefits) ? 'checked disabled' : '' }}>
                                            <label for="checkbox{{ $benefit->id }}">
                                                {{ $benefit->nama_benefit }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <input id="partner" type="hidden" class="form-control" name="partner" value="{{ Auth::user()->partner }}" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer m-t-30">
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success waves-effect waves-light" name="submit" value="save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<!-- END MODAL -->
