<div class="modal fade" id="edit{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="AddModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel">Edit Data Organisasi</h4>
            </div>
            <div class="modal-body">
                <form action="/settingorganisasi/update/{{$data->id}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group col-sm">
                                    <label class="form-label">Nama Perusahaan</label>
                                    <input type="text" name="nama_perusahaan" class="form-control" value="{{ $data->nama_perusahaan ?? '' }}" placeholder="Masukkan Nama Perusahaan" autocomplete="off" required>
                                </div>

                                <div class="form-group col-sm">
                                    <label class="form-label">E-mail Perusahaan</label>
                                    <input type="email" name="email" value="{{ $data->email ?? '' }}" class="form-control" aria-describedby="emailHelp" placeholder="Masukkan Email" autocomplete="off" required>
                                </div>

                                <div class="form-group col-sm">
                                    <label class="form-label">Nomor Telepon Perusahaan</label>
                                    <input type="text" name="no_telp" value="{{ $data->no_telp ?? '' }}" class="form-control" aria-describedby="emailHelp" placeholder="Masukkan No Telp." autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                 <div class="form-group col-sm">
                                    <label class="form-label">Alamat Perusahaan</label>
                                    <input type="text" name="alamat" value="{{ $data->alamat ?? '' }}" class="form-control" aria-describedby="emailHelp" placeholder="Masukkan Alamat Perusahaan" autocomplete="off" required>
                                </div>
                                <div class="form-group col-sm">
                                    <div class="mb-3">
                                        <label class="form-label">Kode Pos</label>
                                        <input type="number" name="kode_pos" value="{{ $data->kode_pos ?? '' }}" class="form-control" aria-describedby="emailHelp" placeholder="Masukkan Kode Pos" autocomplete="off" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label pull-left">Logo Perusahaan</label><br>
                                    <div class="mb-3">
                                        {{-- <label class="form-label col-sm-4 pull-left">Logo Perusahaan</label> --}}
                                        @if($data->logo != null)
                                            <img class="img-preview img-fluid mb-3 col-sm-4" src="{{ asset('images/'.$data->logo) }}">
                                            <input type="file" name="logo" class="form-control" id="foto" onchange="previewImage()"> 
                                        @else
                                            <img class="img-preview img-fluid mb-3 col-sm-4">
                                            <input type="file" name="logo" class="form-control" id="foto" onchange="previewImage()" required> 
                                        @endif   
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Tutup</button>
                        <button type="submit"  name="submit" value="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
  
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <script>
        function previewImage() 
        {
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
