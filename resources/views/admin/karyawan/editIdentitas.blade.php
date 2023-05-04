<!--  Modal content for the above example -->
<div class="modal fade bs-example-modal-lg" id="editIdentitas{{ $karyawan->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editIdentitas" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">Edit Identitas Diri</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('identitas.update', $karyawan->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 m-t-10">
                            <input type="hidden" name="id_karyawan" value="{{ $karyawan->id }}">
                            <div class="form-group">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Nama Lengkap</label>
                                    <input type="text" name="namaKaryawan" class="form-control"
                                        placeholder="Masukkan Nama" autocomplete="off" value="{{ $karyawan->nama }}">
                                    <div id="emailHelp" class="form-text"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>NIK</label>
                                    <input name="nikKaryawan" type="text" class="form-control" autocomplete="off"
                                        value="{{ $karyawan->nik }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Tanggal Lahir</label>
                                    <input name="tgllahirKaryawan" type="text" autocomplete="off"
                                        class="form-control" placeholder="dd/mm/yyyy" id="datepicker-autoclose17"
                                        autocomplete="off"
                                        value="{{ \Carbon\Carbon::parse($karyawan->tgllahir)->format('Y/m/d') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Jenis Kelamin</label>
                                    <select class="form-control" name="jenis_kelaminKaryawan">
                                        <option value="L" {{ $karyawan->jenis_kelamin == 'L' ? 'selected' : '' }}>
                                            Laki-laki</option>
                                        <option value="P" {{ $karyawan->jenis_kelamin == 'P' ? 'selected' : '' }}>
                                            Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Email</label>
                                    <input type="text" name="emailKaryawan" class="form-control" autocomplete="off"
                                        value="{{ $karyawan->email }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Agama</label>
                                    <select class="form-control" name="agamaKaryawan">
                                        <option value="">Pilih Agama</option>
                                        <option value="Islam" {{ $karyawan->agama == 'Islam' ? 'selected' : '' }}>Islam
                                        </option>
                                        <option value="Kristen" {{ $karyawan->agama == 'Kristen' ? 'selected' : '' }}>
                                            Kristen</option>
                                        <option value="Katholik"
                                            {{ $karyawan->agama == 'Katholik' ? 'selected' : '' }}>Katholik</option>
                                        <option value="Hindu" {{ $karyawan->agama == 'Hindu' ? 'selected' : '' }}>
                                            Hindu</option>
                                        <option value="Budha"{{ $karyawan->agama == 'Budha' ? 'selected' : '' }}>Budha
                                        </option>
                                        <option
                                            value="Khong Hu Chu"{{ $karyawan->agama == 'Khong Hu Chu' ? 'selected' : '' }}>
                                            Khong Hu Chu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Golongan Darah</label>
                                    <select class="form-control" name="gol_darahKaryawan" required>
                                        <option value="">Pilih Golongan Darah</option>
                                        <option value="A" {{ $karyawan->gol_darah == 'A' ? 'selected' : '' }}>A
                                        </option>
                                        <option value="B" {{ $karyawan->gol_darah == 'B' ? 'selected' : '' }}>B
                                        </option>
                                        <option value="AB"{{ $karyawan->gol_darah == 'AB' ? 'selected' : '' }}>AB
                                        </option>
                                        <option value="O" {{ $karyawan->gol_darah == 'O' ? 'selected' : '' }}>O
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Alamat</label>
                                    <input name="alamatKaryawan" type="text" class="form-control" autocomplete="off"
                                        value="{{ $karyawan->alamat }}">
                                </div>
                            </div>

                        </div>

                        <!-- baris sebelah kanan  -->

                        <div class="col-md-6 m-t-10">
                            <div class="form-group">
                                <div class="form-group">
                                    <div class="mb-3">
                                        <label>Pilih Foto Karyawan</label><br>
                                        <img class="img-preview img-fluid mb-6 col-sm-5"
                                            src="{{ asset('Foto_Profile/' . $karyawan->foto) }}"
                                            alt="Tidak ada foto profil." style="width:205px;">
                                        <br><input type="file" name="foto" class="form-control" id="foto"
                                            onchange="previewImage()">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="mb-3">
                                        <label>Nomor Handphone</label>
                                        <input name="no_hpKaryawan" type="text" autocomplete="off"
                                            class="form-control" value="{{ $karyawan->no_hp }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1" class="form-label">Departemen</label>
                                    <select class="form-control" name="divisi">
                                        <option value="">Pilih Departemen</option>
                                        @foreach ($departemen as $d)
                                            <option value="{{ $d->id }}"
                                                @if ($karyawan->divisi == $d->id) selected @endif>
                                                {{ $d->nama_departemen }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1" class="form-label">Atasan Langsung
                                        (Asisten Manajer/Manajer/Direksi)</label>
                                    <select class="form-control" name="atasan_pertama">
                                        <option value="">Pilih Atasan Langsung</option>
                                        @foreach ($atasan_pertama as $atasan)
                                            <option value="{{ $atasan->id }}"
                                                @if ($karyawan->atasan_pertama == $atasan->id) selected @endif>{{ $atasan->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1" class="form-label">Atasan/Pimpinan Unit Kerja
                                        (Manajer/Direksi)</label>
                                    <select class="form-control" name="atasan_kedua">
                                        <option value="">Pilih Atasan</option>
                                        @foreach ($atasan_kedua as $atasan)
                                            <option value="{{ $atasan->id }}"
                                                @if ($karyawan->atasan_kedua == $atasan->id) selected @endif>{{ $atasan->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <div class="mb-3">
                                        <label for="jabatanKaryawan">Nama Jabatan</label>
                                        <select class="form-control" name="namaJabatan" required>
                                            <option value="">Pilih Nama Jabatan</option>
                                            @foreach ($namajabatan as $nama)
                                                <option value="{{ $nama->nama_jabatan }}"
                                                    {{ $karyawan->nama_jabatan == $level->nama_jabatan ? 'selected' : '' }}>
                                                    {{ $level->nama_jabatan ?? '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="mb-3">
                                        <label for="jabatanKaryawan">Level Jabatan</label>
                                        <select class="form-control" name="jabatanKaryawan" required>
                                            <option value="">Pilih Level Jabatan</option>
                                            @foreach ($leveljabatan as $level)
                                                <option value="{{ $level->nama_level }}"
                                                    {{ $karyawan->jabatan == $level->nama_level ? 'selected' : '' }}>
                                                    {{ $level->nama_level ?? '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="mb-3">
                                        <label>Status Pernikahan</label>
                                        <select type="text" class="form-control" id="status_pernikahan"
                                            name="status_pernikahan" required>
                                            <option value="">Pilih Status Pernikahan</option>
                                            <option value="Belum Menikah"
                                                @if ($status->status_pernikahan == 'Belum Menikah') selected @endif>Belum Menikah</option>
                                            <option value="Sudah Menikah"
                                                @if ($status->status_pernikahan == 'Sudah Menikah') selected @endif>Sudah Menikah</option>
                                            <option value="Duda" @if ($status->status_pernikahan == 'Duda') selected @endif>
                                                Duda</option>
                                            <option value="Janda" @if ($status->status_pernikahan == 'Janda') selected @endif>
                                                Janda</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" value="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script src="assets/js/jquery.min.js"></script>
<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="assets/pages/form-advanced.js"></script>

<script>
    function previewImage() {

        const image = document.querySelector('#foto');
        const imgPreview = document.querySelector('.img-preview');

        imgPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
        }
    }
</script>
