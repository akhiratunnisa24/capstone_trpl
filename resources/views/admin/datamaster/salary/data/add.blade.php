<!-- MODAL BEGIN -->

<!-- Sample modal content -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title text-center" id="myModalLabel">Tambah Struktur Penggajian</h4>

            <div class="modal-body">
                <form method="POST" action="{{ route('salary.store') }}" onsubmit="return validateForm()">
                    @csrf
                    @method('POST')

                    <div class="form-group col-xs-12">
                        <label class="form-label">Nama Struktur Penggajian</label>
                        <input type="text" class="form-control" name="nama"
                            placeholder="Masukkan nama struktur penggajian" required>
                    </div>

                    <div class="form-group col-xs-12">
                        <label for="level_jabatan">Level Jabatan</label>
                        <select class="form-control" name="level_jabatan"required>
                            @foreach ($levelJabatanOptions as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-xs-12">
                        <label for="status_karyawan">Jenis Status Karyawan</label>
                        <select class="form-control" name="status_karyawan"required>
                            @foreach ($statusKaryawanOptions as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-xs-12">
                        <label for="benefits">Pilih Benefit</label>
                        @foreach ($benefits as $benefit)
                            <div class="checkbox checkbox-success">
                                <input type="checkbox" id="checkbox{{ $benefit->id }}" class="form-check-input"
                                    name="benefits[]" value="{{ $benefit->id }}">
                                <label for="checkbox{{ $benefit->id }}">
                                    {{ $benefit->nama_benefit }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <input id="partner" type="hidden" class="form-control" name="partner"
                        value="{{ Auth::user()->partner }}" autocomplete="off">
                    <!-- ... (lanjutkan dengan bagian lain dari form) ... -->

                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <!-- Tombol Tutup atau yang lainnya jika diperlukan -->
            </div>

        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<script>
    // Fungsi validasi (seperti yang Anda implementasikan sebelumnya)
    function validateForm() {
        var checkboxes = document.getElementsByName('benefits[]');
        var checkboxChecked = false;

        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                checkboxChecked = true;
                break;
            }
        }

        return checkboxChecked;
    }
</script>

<!-- END MODAL -->
