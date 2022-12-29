<link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">

<!-- MODAL BEGIN -->

<!-- sample modal content -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title text-center" id="myModalLabel">Buat Akun Karyawan </h4>
           

            <div class="modal-body">

                <form method="POST" action="{{ url('/registrasi') }}">
                    @csrf

                    <div class="form-group">

                        <div class="col-xs-12">
                            <label class="form-label">Role</label>
                            <select type="text" class="form-control  @error('role') is-invalid @enderror" name="role" required autocomplete="role" autofocus placeholder="Role">
                                <option value="">Pilih Role</option>
                                <option value="3">Manager Konvensional</option>
                                <option value="4">Manager Keuangan</option>
                                <option value="5">Manager Teknologi Informasi</option>
                                <option value="6">Manager Human Resource</option>
                                <option value="1">HRD</option>
                                <option value="2">Karyawan</option>
                            </select>

                            @error('role')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>
                    </div>

                    <div class="form-group">

                        <div class="col-xs-12">
                            <label for="exampleInputEmail1" class="form-label">Karyawan</label>
                            <select id="id_pegawai" type="text" class="form-control  @error('name') is-invalid @enderror" name="id_pegawai" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Nama">
                                <option value="">Pilih Karyawan</option>
                                @foreach ($akun as $k)
                                <option value="{{ $k->id }}">{{ $k->nama }}</option>
                                @endforeach
                            </select>

                            @error('id_pegawai')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror   

                        </div>
                    </div>

                    <div class="form-group">
                               

                        <div class="col-xs-12">
                            <label for="exampleInputEmail1" class="form-label">Email</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email Address">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                   

                    <div class="form-group">

                        <div class="col-xs-12">
                            <label for="exampleInputEmail1" class="form-label">Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" autofocus placeholder="Password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>
                    </div>

                    <div class="form-group">

                        <div class="col-xs-12">
                            <label for="exampleInputEmail1" class="form-label">Confirm Password</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" autofocus placeholder="Confirm Password">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="checkbox checkbox-primary">
                                <input id="checkbox-signup" type="checkbox" checked="checked">
                                <label for="checkbox-signup">
                                    I accept <a href="#">Terms and Conditions</a>
                                </label>
                            </div>

                        </div>
                    </div>

                    <div class="form-group text-center m-t-20">
<div class="col-xs-12">
<button class="btn btn-primary w-md waves-effect waves-light" type="submit">Register</button>
</div>
</div>

                </form>



                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    <!-- <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Register</button> -->
                </div>


            </div>

        </div>

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->


<!-- END MODAL -->

<script>
    var rupiah = document.getElementById('gaji');
    rupiah.addEventListener('keyup', function(e) {
        // tambahkan 'Rp.' pada saat form di ketik
        // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
        rupiah.value = formatRupiah(this.value);
    });
    /* Fungsi formatRupiah */
    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);
        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
    }

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

<!-- jQuery  -->


<script src="assets/js/jquery.min.js"></script>



<!-- Plugins js -->
<script src="assets/plugins/timepicker/bootstrap-timepicker.js"></script>
<script src="assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
<script src="assets/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script>

<!-- Plugins Init js -->
<script src="assets/pages/form-advanced.js"></script>