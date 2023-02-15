<!--  Modal content for the above example -->
<div class="modal fade bs-example-modal-lg" id="editIdentitas{{$karyawan->id}}" tabindex="-1" role="dialog" aria-labelledby="editIdentitas" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">Edit Identitas Diri</h4>
            </div>
            <div class="modal-body">
                <form id="" action="/updateIdentitas/{{$karyawan->id}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 m-t-10">
                            <input type="hidden" name="id_karyawan" value="{{$karyawan->id}}">
                            <div class="form-group">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Nama Lengkap</label>
                                    <input type="text" name="namaKaryawan" class="form-control" placeholder="Masukkan Nama" autocomplete="off" value="{{$karyawan->nama}}">
                                    <div id="emailHelp" class="form-text"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                   <label>NIK</label> 
                                   <input name="nikKaryawan" type="text" class="form-control" autocomplete="off" value="{{$karyawan->nik}}">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="mb-3">
                                   <label>Tanggal Lahir</label> 
                                    <input name="tgllahirKaryawan" type="text" autocomplete="off"
                                        class="form-control" placeholder="dd/mm/yyyy" id="datepicker-autoclose17" autocomplete="off"
                                        value="{{\Carbon\Carbon::parse($karyawan->tgllahir)->format('Y/m/d')}}">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="mb-3">
                                   <label>Jenis Kelamin</label> 
                                   <select class="form-control selectpicker" name="jenis_kelaminKaryawan" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L" @if($karyawan->jenis_kelamin == "L") selected @endif >Laki-Laki</option>
                                    <option value="P" @if($karyawan->jenis_kelamin == "P") selected @endif >Perempuan</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                   <label>Email</label> 
                                   <input type="text" name="emailKaryawan" class="form-control" autocomplete="off" value="{{$karyawan->email}}">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="mb-3">
                                   <label>Agama</label> 
                                   <select class="form-control selectpicker" name="agamaKaryawan">
                                        <option value="">Pilih Agama</option>
                                        <option value="Islam" @if($karyawan->agama == "Islam") selected @endif>Islam</option>
                                        <option value="Kristen" @if($karyawan->agama == "Kristen") selected @endif>Kristen</option>
                                        <option value="Katholik" @if($karyawan->agama == "Katholik") selected @endif>Katholik</option>
                                        <option value="Hindu" @if($karyawan->agama == "Hindu") selected @endif>Hindu</option>
                                        <option value="Budha" @if($karyawan->agama == "Budha") selected @endif>Budha</option>
                                        <option value="Khong Hu Chu" @if($karyawan->agama == "Khong Hu Chu") selected @endif>Khong Hu Chu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                   <label>Golongan Darah</label> 
                                   <select class="form-control selectpicker" name="gol_darahKaryawan" required>
                                    <option value="">Pilih Golongan Darah</option>
                                    <option value="A" @if($karyawan->gol_darah == "A") selected @endif >A</option>
                                    <option value="B" @if($karyawan->gol_darah == "B") selected @endif >B</option>
                                    <option value="AB" @if($karyawan->gol_darah == "AB") selected @endif >AB</option>
                                    <option value="O" @if($karyawan->gol_darah == "O") selected @endif >O</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                   <label>Alamat</label> 
                                   <input name="alamatKaryawan" type="text" class="form-control" autocomplete="off" value="{{$karyawan->alamat}}">
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
                                        src="{{ asset('Foto_Profile/' . $karyawan->foto)}}" alt="Tidak ada foto profil." style="width:205px;" >
                                    <br><input type="file" name="foto" class="form-control" id="foto" onchange="previewImage()">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="mb-3">
                                       <label>Nomor Handphone</label> 
                                       <input name="no_hpKaryawan" type="text" autocomplete="off" class="form-control" value="{{$karyawan->no_hp}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1" class="form-label">Departemen</label>
                                    <select class="form-control selectpicker" name="divisi" data-live-search="true" required>
                                        <option value="">Pilih Departemen</option>
                                        @foreach ($departemen as $d)
                                            <option value="{{ $d->id }}"
                                                @if($karyawan->divisi == $d->id)
                                                    selected
                                                @endif>{{ $d->nama_departemen }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1" class="form-label">Atasan Langsung (SPV/Manager/Direktur)</label>
                                    <select class="form-control selectpicker" name="atasan_pertama" data-live-search="true">
                                        <option value="">Pilih Atasan Langsung</option>
                                        @foreach ($atasan_pertama as $atasan)
                                            <option value="{{ $atasan->id }}"
                                                @if($karyawan->atasan_pertama == $atasan->id)
                                                    selected
                                                @endif>{{ $atasan->nama }}
                                            </option>
                                               
                                        @endforeach
                                    </select>
                                </div>
            
                                <div class="form-group">
                                    <label for="exampleInputEmail1" class="form-label">Atasan (Manager/Direktur)</label>
                                    <select class="form-control selectpicker" name="atasan_kedua"  data-live-search="true">
                                        <option value="">Pilih Atasan</option>
                                        @foreach ($atasan_kedua as $atasan)
                                            <option value="{{ $atasan->id }}"
                                                @if($karyawan->atasan_kedua == $atasan->id)
                                                    selected
                                                @endif>{{ $atasan->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <div class="mb-3">
                                       <label>Jabatan</label> 
                                       <select type="text" class="form-control selectpicker" name="jabatanKaryawan" required>
                                        <option value="">Pilih Jabatan</option>
                                        <option value="Direktur" @if($karyawan->jabatan == "Direktur") selected @endif >Direktur</option>
                                        <option value="Manager" @if($karyawan->jabatan == "Manager") selected @endif >Manager</option>
                                        <option value="Supervisor" @if($karyawan->jabatan == "Supervisor") selected @endif >Supervisor</option>
                                        <option value="HRD" @if($karyawan->jabatan == "HRD") selected @endif >HRD</option>
                                        <option value="Staff" @if($karyawan->jabatan == "Staff") selected @endif >Staff</option>
                                    </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
            
                    <div class="modal-footer">
                        <input type="hidden" name="id" id="id">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Update</button>
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
        function previewImage(){

        const image = document.querySelector('#foto');
        const imgPreview =document.querySelector('.img-preview');

            imgPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent){
            imgPreview.src = oFREvent.target.result;
        }
        }
    </script>
