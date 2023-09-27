<!-- MODAL BEGIN -->

<!-- sample modal content -->
<div id="myModal{{ $data->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title text-center" id="myModalLabel">Edit User</h4>


            <div class="modal-body">

                <form method="POST" action="editUser{{ $data->id }}" onsubmit="return validateForm()">
                    @csrf
                    @method('put')

                    <div class="form-group col-xs-12">
                        <label class="form-label">Nama</label>
                        <input  type="text" class="form-control"
                            autocomplete="off" value="{{ $data->name }}" readonly>
                    </div>
                    
                    <div class="form-group col-xs-12">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control"
                            autocomplete="off" value="{{ $data->email }}" readonly>

                    </div>

                     <div class="form-group col-xs-12">
                        <label class="form-label">Role Login</label>
                            <select type="text" class="form-control selecpicker @error('role') is-invalid @enderror"
                                name="role" required autocomplete="role" autofocus placeholder="Role">
                                <option value="">Pilih Role</option>
                                <option value="1" {{ $data->role == '1' ? 'selected' : '' }}>HRD Manager</option>
                                <option value="2" {{ $data->role == '2' ? 'selected' : '' }}>HRD Staff</option>
                                <option value="3" {{ $data->role == '3' ? 'selected' : '' }}>Manager / Supervisor</option>
                                <option value="4" {{ $data->role == '4' ? 'selected' : '' }}>Staff</option>
                                <option value="5" {{ $data->role == '5' ? 'selected' : '' }}>Admin (Full Access)</option>
                            </select>

                            @error('role')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>


                    <div class="form-group col-xs-12">
                        <label for="exampleInputEmail1" class="form-label">New Password</label>
                        <div class="input-group">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="new-password" autofocus placeholder="Password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <a class="input-group-addon" id="toggle-password4"><i class="fa fa-eye-slash"
                                    aria-hidden="true"></i></a>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12">
                            <label for="exampleInputEmail1" class="form-label">Confirm Password</label>
                            <div class="input-group">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password" autofocus
                                    placeholder="Confirm Password">
                                <a class="input-group-addon" id="toggle-password5"><i class="fa fa-eye-slash"
                                        aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>

                    @if($role == 5)
                        <div class="form-group col-xs-12">
                            <label class="form-label">Partner</label>
                            <select class="form-control" name="'partneradmin">
                                <option value="">Pilih Partner</option>
                                @foreach ($partner as $k)
                                    <option value="{{ $k->id }}" {{ $k->id == $data->partner ? 'selected' : '' }}>
                                        {{ $k->nama_partner }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @elseif($role == 1 || $role == 2)
                        <input  type="hidden" class="form-control" autocomplete="off" value="{{ $data->partner }}">
                    @endif

                    <div class="col-xs-12">
                        <div class="checkbox checkbox-primary">
                        </div>
                    </div>

                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-sm btn-primary w-md waves-effect waves-light" type="submit">Submit</button>
                        </div>
                    </div>

                </form>


                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Tutup</button> --}}
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

{{-- <script>
    const password = document.querySelector('#password');
    const passwordConfirm = document.querySelector('#password-confirm');
    const submitBtn = document.querySelector('button[type=submit]');

    passwordConfirm.addEventListener('input', () => {
        if (password.value !== passwordConfirm.value) {
            passwordConfirm.setCustomValidity('Passwords do not match');
            submitBtn.disabled = true;
        } else {
            passwordConfirm.setCustomValidity('');
            submitBtn.disabled = false;
        }
    });
</script> --}}

<script>
    function validateForm() {
        var password = document.getElementsByName("password")[0].value;
        var confirmPassword = document.getElementsByName("password_confirmation")[0].value;

        if (password != confirmPassword) {
            alert("Password and confirmation password do not match.");
            return false;
        }

        return true;
    }
</script>


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
