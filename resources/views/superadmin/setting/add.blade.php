<div class="modal fade" id="Add" tabindex="-1" role="dialog" aria-labelledby="AddModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel">Tambah Data Organisasi</h4>
            </div>
            <div class="modal-body">
                <form action="/settingorganisasi" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6 m-t-10">
                                <div class="form-group col-sm">
                                    <label class="form-label">Nama Perusahaan</label>
                                    <input type="text" name="nama_perusahaan" class="form-control" placeholder="Masukkan Nama Perusahaan" autocomplete="off" required>
                                            
                                </div>

                                <div class="form-group col-sm">
                                    <label class="form-label">E-mail Perusahaan</label>
                                    <input type="email" name="email" class="form-control" aria-describedby="emailHelp" placeholder="Masukkan Email" autocomplete="off" required>
                                </div>

                                <div class="form-group col-sm">
                                    <label class="form-label">Nomor Telepon Perusahaan</label>
                                    <input type="text" name="no_telp" class="form-control" aria-describedby="emailHelp" placeholder="Masukkan No Telp." autocomplete="off" required>
                                </div>
                                <div class="form-group col-sm">
                                    <label class="form-label">Alamat Perusahaan</label>
                                    <input type="text" name="alamat" class="form-control" aria-describedby="emailHelp" placeholder="Masukkan Alamat Perusahaan" autocomplete="off" required>
                                </div>
                            </div>

                            <div class="col-md-6 m-t-10">
                                <div class="form-group col-sm">
                                    <label class="col-form-label">Partner</label>
                                    <select name="partner" id="partner" style="height: 100px;" class="form-control selectpicker" data-live-search="true" required>
                                        <option>-- Pilih Partner --</option>
                                        @foreach ($partner as $data)
                                            <option value="{{ $data->id }}">
                                                {{ $data->nama_partner }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm">
                                    <label class="form-label">Kode Pos</label>
                                    <input type="number" name="kode_pos" class="form-control" aria-describedby="emailHelp" placeholder="Masukkan Kode Pos" autocomplete="off" required>
                                </div>

                                <div class="form-group col-sm">
                                    <label class="form-label pull-left">Logo Perusahaan</label><br>
                                    <div class="mb-3">
                                        <img class="img-previews img-fluid mb-3 col-sm-4">
                                        <input type="file" name="logo" class="form-control" id="foto" onchange="previewImages()" required> 
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

     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <script src="assets/pages/form-advanced.js"></script>

     <script>
        function previewImages() 
        {
            const image = document.querySelector('#foto');
            const imgPreview = document.querySelector('.img-previews');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
     </script>