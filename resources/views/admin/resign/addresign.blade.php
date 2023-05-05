  <!-- MODAL BEGIN -->

  <!-- sample modal content -->
  <div id="Modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="addresign">Form Resign</h4>
            </div>

              <div class="modal-body">

                  <form method="POST" action="{{ route('resign.store') }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      @method('POST')
                      <div class="form-group col-xs-15">        
                        <label for="namaKaryawan" class="form-label">Nama</label>
                        <select name="namaKaryawan" id="user-select" class="form-control selectpicker"
                            data-live-search="true" required>
                            <option>-- Pilih Karyawan --</option>
                            @foreach ($karyawan1 as $data)
                                <option value="{{ $data->id }}" @if ($data->id == request()->nama) selected @endif>
                                    {{ $data->nama }}
                                </option>
                            @endforeach
                        </select>
                      </div>

                      <div class="form-group col-xs-15">
                        <label for="departemen1" class="form-label">Departemen</label>
                        <input id="departemen1" class="form-control" name="departemen1" autocomplete="off"
                            placeholder="" readonly>
                    </div>
                      <div class="form-group col-xs-15"hidden>
                          <label for="departemen" class="form-label">Departemen</label>
                          <input id="departemen" class="form-control" name="departemen" autocomplete="off"
                              placeholder="" readonly>
                      </div>
                      <div class="form-group col-xs-15">
                          <label for="tgl_masuk" class="form-label">Tanggal Bergabung</label>
                          <input id="tgl_masuk" type="text" class="form-control" name="tgl_masuk" autocomplete="off"
                              placeholder="" readonly>
                      </div>
                      <div class="form-group col-xs-15">
                          <label for="tgl_resign" class="form-label">Tanggal Resign</label>
                          <div class="input-group">
                              <input type="text" class="form-control" placeholder="yyyy/mm/dd"
                                  id="datepicker-autoclose23" name="tgl_resign" onchange=(tgl_resign())
                                  autocomplete="off">
                              <span class="input-group-addon bg-custom b-0"><i
                                      class="mdi mdi-calendar text-white"></i></span>
                          </div>
                      </div>

                      <div class="form-group col-xs-15">
                          <label for="tipe_resign" class="form-label">Tipe Resign</label>
                          {{-- <input id="tipe_resign" class="form-control" name="tipe_resign" autocomplete="off" readonly> --}}
                          <select class="form-control" name="tipe_resign" required>
                              <option value="">Pilih Tipe Resign</option>

                              <option value="Normal Resign">Normal Resign</option>
                              <option value="Fired from a company">Fired from a company</option>
                          </select>
                      </div>

                      <div class="form-group col-xs-15">
                          <label for="alasan" class="form-label">Alasan Resign</label>
                          <textarea id="alasan" type="text" class="form-control" name="alasan" autocomplete="off"
                              placeholder="Alasan Resign" required></textarea>
                      </div>        
                      <div class="form-group col-xs-15">
                          <input id="status" type="text" class="form-control" name="status" value='1' hidden>
                      </div>                   
                      {{-- <div class="col-xs-12">
                          <div class="checkbox checkbox-primary">

                          </div>
                      </div> --}}

                      <div class="form-group">
                        <label for="filepdf">File PDF</label>
                        <input type="file" name="filepdf" id="filepdf" accept="application/pdf" required>
                    </div>

                      <div class="form-group text-center m-t-20">
                          <div class="col-xs-15">
                              <button class="btn btn-primary w-md waves-effect waves-light"
                                  type="submit">Ajukan</button>
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
  <script src="assets/js/jquery.min.js"></script>


  <!-- script untuk mengambil data Email Karyawan  -->
  <script>
      $('#namaKaryawan').on('change', function(e) {
          var namaKaryawan = e.target.value;
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

  <script>
      $(document).ready(function() {
          $('#user-select').on('change', function() {
              var userId = $(this).val();
              if (!userId) {
                  return;
              }

              $.ajax({
                  url: '/getUserData/' + userId,
                  type: 'GET',
                  success: function(user) {
                      $('#namaKaryawan').val(user.nama);
                      $('#departemen').val(user.departemen.id);
                      $('#departemen1').val(user.departemen.nama_departemen);
                      $('#tgl_masuk').val(user.tglmasuk);
                  }
              });
          });
      });
  </script>
