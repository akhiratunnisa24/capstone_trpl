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
                    
                    {{-- <div class="form-group col-xs-12">
                        <label class="form-label">Role</label>
                            <select type="text" class="form-control selecpicker @error('role') is-invalid @enderror"
                                name="role" required autocomplete="role" autofocus placeholder="Role">
                                <option value="">Pilih Role</option>
                                <option value="4">Management</option>
                                <option value="3">Manager</option>
                                <option value="5">Supervisor</option>
                                <option value="1">HRD</option>
                                <option value="2">Karyawan</option>
                            </select>

                            @error('role')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div> --}}

                    <div class="form-group col-xs-12">
                        <label class="form-label">Role</label>
                        <select  class="form-control selecpicker" name="role" required>
                            <option value="">Pilih Role</option>
                            @foreach ($role as $k)
                                <option value="{{ $k->id }}">{{ $k->role }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-xs-12" id="id_pegawai">
                        <label class="form-label">Karyawan</label>
                        <select  class="form-control selecpicker" name="id_pegawai" required>
                            <option value="">Pilih Karyawan</option>
                            @foreach ($akun as $k)
                                <option value="{{ $k->id }}">{{ $k->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-xs-12">
                        <label class="form-label">Email</label>
                        <input id="emailKaryawan" type="text" class="form-control" name="emailKaryawan"
                            autocomplete="off" placeholder="Email Address" readonly>
                    </div>
                    

                    <div class="form-group col-xs-12">
                        {{-- <div class=""> --}}
                            <label for="exampleInputEmail1" class="form-label">Password</label>
                            <div class="input-group">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="new-password" autofocus placeholder="Password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <a class="input-group-addon" id="toggle-password4"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                            </div>
                        {{-- </div> --}}
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12">
                            <label for="exampleInputEmail1" class="form-label">Confirm Password</label>
                            <div class="input-group">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password" autofocus
                                    placeholder="Confirm Password">
                                <a class="input-group-addon" id="toggle-password5"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                    <input id="partner" type="hidden" class="form-control" name="partner" value="{{Auth::user()->partner}}" autocomplete="off" >

                    {{-- {{-- <div class="form-group"> --}}
                        <div class="col-xs-12">
                            <div class="checkbox checkbox-primary">

                        </div>
                    </div> 

                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-primary w-md waves-effect waves-light"
                                type="submit">Register</button>
                        </div>
                    </div>

                </form>


                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button> --}}
                    <!-- <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Register</button> -->
                </div>

            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->


<!-- END MODAL -->
<!-- jQuery  -->
{{-- <script src="assets/js/jquery.min.js"></script> --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


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
                console.log(data?.email)
            }
        });
    });
</script>

<script>
    $('#id_pegawai2').on('change', function(e) {
        var id_pegawai = e.target.value;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                    .attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: '{{ route('getPersyaratan') }}',
            data: {
                'id_pegawai': id_pegawai
            },
            success: function(data) {
                // console.log(data);
                $('#emailKaryawan2').val(data.persyaratan);
                console.log(data?.persyaratan)
            }
        });
    });
</script>

<style>
    #toggle-password4 i {
        cursor: pointer;
    }
    #toggle-password5 i {
        cursor: pointer;
    }
</style>
<script type="text/javascript">
    document.getElementById("toggle-password4").addEventListener("click", function() {
        var x = document.getElementById("password");
        var toggle = document.getElementById("toggle-password4").firstChild;
        if (x.type === "password") {
            x.type = "text";
            toggle.classList.remove("fa-eye");
            toggle.classList.add("fa-eye-slash");
        } else {
            x.type = "password";
            toggle.classList.remove("fa-eye-slash");
            toggle.classList.add("fa-eye");
        }
    });
    document.getElementById("toggle-password5").addEventListener("click", function() {
        var x = document.getElementById("password-confirm");
        var toggle = document.getElementById("toggle-password5").firstChild;
        if (x.type === "password") {
            x.type = "text";
            toggle.classList.remove("fa-eye");
            toggle.classList.add("fa-eye-slash");
        } else {
            x.type = "password";
            toggle.classList.remove("fa-eye-slash");
            toggle.classList.add("fa-eye");
        }
    });
</script>