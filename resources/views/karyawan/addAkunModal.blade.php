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
                    @method('POST')
                    <div class="form-group">

                        <div class="col-xs-12">
                            <label class="form-label">Role</label>
                            <select type="text" class="form-control  @error('role') is-invalid @enderror"
                                name="role" required autocomplete="role" autofocus placeholder="Role">
                                <option value="">Pilih Role</option>
                                <option value="3">Manager</option>
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

                    <div class="form-group" id="id_pegawai">

                        <div class="col-xs-12" id="id_pegawai">
                            <label for="id_pegawai" class="form-label">Karyawan</label>
                            <select id="id_pegawai" class="form-control" name="id_pegawai" required>
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
                        <div class="col-xs-12" id="emailKaryawan" >
                            <label for="exampleInputEmail1" class="form-label">Email</label>
                            <input id="emailKaryawan" type="text" class="form-control" name="emailKaryawan"
                                autocomplete="off" placeholder="Email Address">
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
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="new-password" autofocus placeholder="Password">

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
                            <input id="password-confirm" type="password" class="form-control"
                                name="password_confirmation" required autocomplete="new-password" autofocus
                                placeholder="Confirm Password">
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
                            <button class="btn btn-primary w-md waves-effect waves-light"
                                type="submit">Register</button>
                        </div>
                    </div>

                </form>

                
                <div class="form-group col-sm" id="id_karyawan">
                    <label for="id_karyawan" class="col-form-label">Karyawan</label>
                    <select name="id_karyawan" id="id_karyawan" class="form-control" required>
                        <option value="">Pilih Karyawan</option>
                        @foreach ($karyawan as $data)
                            {{-- @if($data->divisi == $departemen->id) --}}
                                <option value="{{ $data->id }}">departemen: {{ $data->divisi }} -- {{ $data->nama }}</option>
                            {{-- @endif --}}
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="durasi" class="col-form-label">Durasi (Hari)</label>
                    <input type="text" class="form-control" name="durasi" placeholder="durasi" id="durasi"
                        readonly>
                </div>
                <div class="form-group">
                    <label for="mode_alokasi" class="col-form-label">Mode Alokasi</label>
                    <input type="text" class="form-control" name="mode_alokasi" placeholder="mode alokasi"
                        id="mode_alokasi" readonly>
                </div>
            </div>

            <div class="col-md-6" id="validitas">
                <div class="" id="tanggalmulai">
                    <div class="form-group">
                        <label for="tgl_masuk" class="form-label">Tanggal Masuk</label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="tgl_masuk"
                                name="tgl_masuk" autocomplete="off" readonly>
                            <span class="input-group-addon bg-custom b-0"><i
                                    class="mdi mdi-calendar text-white"></i></span>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    <!-- <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Register</button> -->
                </div>

            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->


<!-- END MODAL -->
<!-- jQuery  -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/app.js"></script>
<script src="assets/pages/form-advanced.js"></script>


<!-- script untuk mengambil data tanggalmasuk  -->
<script>
    $('#id_karyawan').on('change',function(e){
        var id_karyawan = e.target.value;
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                        .attr('content')
                    }
        });
        $.ajax({
            type:"POST",
            url: '{{route('get.Tglmasuk')}}',
            data: {'id_karyawan':id_karyawan},
            success:function(data){
                // console.log(data);
                $('#tgl_masuk').val(data.tglmasuk);
                console.log(data?.tglmasuk)
            }
        });
    });
</script>

<!-- script untuk mengambil data Email Karyawan  -->
<script>
    $('#id_pegawai').on('change', function(e) {
        var id_pegawai = e.target.value;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                    .attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: '{{ route('getEmail') }}',
            data: {
                'id_pegawai': id_pegawai
            },
            success: function(data) {
                // console.log(data);
                $('#emailKaryawan').val(data.email);
                console.log(data?.email);
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log(textStatus);
            }
        });
    });
</script>
