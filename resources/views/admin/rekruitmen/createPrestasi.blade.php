  <head>
      <!-- Datapicker -->
      <link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">


      <meta charset="utf-8" />
      <title>REMS</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
      <meta content="Admin Dashboard" name="description" />
      <meta content="ThemeDesign" name="author" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="csrf-token" content="{{ csrf_token() }}" />

      <link rel="shortcut icon" href="{{ asset('') }}assets/images/remss.png" width="38px" height="20px">

      <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
      <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
      <link href="assets/css/style.css" rel="stylesheet" type="text/css">
  </head>

  <div class="container">
      <!-- Page-Title -->
      <div class="row" style="margin-top: 30px">
          <div class="col-sm-12">
              <div class="page-header-title">
                  <h4 class="pull-left page-title">Form Penerimaan Rekruitmen</h4>

                  <div class="clearfix"></div>
              </div>
          </div>
      </div>

      <div class="row">
          <div class="col-md-12">
              <div class="panel panel-secondary" id="riwayatprestasi">
                  <div class="panel-heading"></div>
                  <div class="content">
                      <div class="container">
                          <div class="row">
                              <div class="col-md-20 col-sm-20 col-xs-20" style="margin-left:15px;margin-right:15px;">
                                  <table id="datatable-responsive10"
                                      class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0"
                                      width="100%">
                                      <thead>
                                          <tr>
                                              <th>No</th>
                                              <th>Perihal / Keterangan</th>
                                              <th>Instansi Pemberi</th>
                                              <th>Alamat</th>
                                              <th>No. Surat</th>
                                              <th>Tanggal Surat</th>
                                              <th>Aksi</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          @foreach ($prestasi as $key => $pres)
                                              <tr>
                                                  {{-- <td id="key">{{ $key }}</td> --}}
                                                  <td>{{ $loop->iteration }}</td>
                                                  <td>{{ $pres['keterangan'] }}</td>
                                                  <td>{{ $pres['nama_instansi'] }}</td>
                                                  <td>{{ $pres['alamat'] }}</td>
                                                  <td>{{ $pres['no_surat'] }}</td>
                                                  <td>{{ \Carbon\Carbon::parse($pres['tanggal_surat'])->format('d/m/Y') }}
                                                  </td>
                                                  <td class="text-center">
                                                      <div class="row d-grid gap-2" role="group"
                                                          aria-label="Basic example">
                                                          <a href="#formUpdatePrestasi" class="btn btn-sm btn-info"
                                                              id="editPrestasi" data-key="{{ $key }}">
                                                              <i class="fa fa-edit" title="Edit"></i>
                                                          </a>
                                                          {{-- /delete-pekerjaan/{{$key}} --}}
                                                          {{-- <form class="pull-right" action="" method="POST"
                                                            style="margin-right:5px;">
                                                            <button type="submit"
                                                                class="btn btn-danger btn-sm delete_dakel"
                                                                data-key="{{ $key }}"><i
                                                                    class="fa fa-trash"></i></button>
                                                        </form> --}}
                                                          {{-- <button type="button" id="hapus_dakel" data-key="{{ $key }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button> --}}
                                                      </div>
                                                  </td>
                                              </tr>
                                          @endforeach
                                      </tbody>
                                  </table><br>
                                  <form action="/store_prestasi" id="formCreatePrestasi" method="POST">
                                      <div class="control-group after-add-more">
                                          @csrf
                                          @method('post')
                                          <div class="modal-body">
                                              <table class="table table-bordered table-striped">
                                                  <div class="col-md-12">
                                                      <div class="row">
                                                          <div>
                                                              <div
                                                                  class="modal-header bg-info panel-heading  col-sm-15 m-b-5">
                                                                  <label class="text-white m-b-10">G. RIWAYAT
                                                                      PRESTASI</label>
                                                              </div>
                                                          </div>

                                                          <div class="col-md-6 m-t-10">

                                                              <div class="form-group">
                                                                  <div class="mb-3">
                                                                      <label class="form-label">Perihal /
                                                                          Keterangan</label>
                                                                      <input type="text" name="keterangan"
                                                                          class="form-control"
                                                                          placeholder="Masukkan Keterangan"
                                                                          autocomplete="off">
                                                                  </div>
                                                              </div>

                                                              <div class="form-group">
                                                                  <div class="mb-3">
                                                                      <label class="form-label">Instansi Pemberi
                                                                      </label>
                                                                      <input type="text" name="namaInstansi"
                                                                          class="form-control"
                                                                          placeholder="Masukkan Nama Instansi"
                                                                          autocomplete="off">
                                                                  </div>
                                                              </div>


                                                              <div class="form-group">
                                                                  <div class="mb-3">
                                                                      <label for="exampleInputEmail1"
                                                                          class="form-label">Alamat </label>
                                                                      <input type="text" name="alamatInstansi"
                                                                          class="form-control"
                                                                          placeholder="Masukkan Alamat"
                                                                          autocomplete="off">
                                                                  </div>
                                                              </div>

                                                          </div>

                                                          {{-- KANAN --}}
                                                          <div class="col-md-6 m-t-10">

                                                              <div class="form-group">
                                                                  <div class="mb-3">
                                                                      <label for="exampleInputEmail1"
                                                                          class="form-label">Nomor Surat / Sertifikat
                                                                      </label>
                                                                      <input type="text" name="noSurat"
                                                                          class="form-control"
                                                                          placeholder="Masukkan Nomor Surat"
                                                                          autocomplete="off">
                                                                  </div>
                                                              </div>
                                                              <div class="form-group">
                                                                  <div class="mb-3">
                                                                      <label class="form-label">Tanggal Surat</label>
                                                                      <div class="input-group">
                                                                          <input id="datepicker-autoclose-format"
                                                                              type="text" class="form-control"
                                                                              placeholder="dd/mm/yyyy" id="4"
                                                                              name="tgl_surat" autocomplete="off"
                                                                              rows="10" required><br>
                                                                          <span
                                                                              class="input-group-addon bg-custom b-0"><i
                                                                                  class="mdi mdi-calendar text-white"></i></span>
                                                                      </div><!-- input-group -->
                                                                  </div>
                                                              </div>

                                                          </div>

                                                      </div>
                                                  </div>
                                                  <div class="row">
                                                      <div class="pull-left">
                                                          <a href="/create_data_organisasi"
                                                              class="btn btn-sm btn-info"><i
                                                                  class="fa fa-backward"></i> Sebelumnya</a>
                                                      </div>
                                                      <div class="pull-right">
                                                          <button type="submit" name="submit"
                                                              class="btn btn-sm btn-dark"> Simpan</button>
                                                          <a href="/preview_data_pelamar"
                                                              class="btn btn-sm btn-primary">Lihat Data <i
                                                                  class="fa fa-forward"></i></a>
                                                      </div>
                                                  </div>
                                              </table>
                                          </div>
                                      </div>
                                  </form>

                                  <form action="/update_prestasi" id="formUpdatePrestasi" method="POST">
                                      @csrf
                                      @method('post')
                                      <div class="modal-body">
                                          {{-- <table class="table table-bordered table-striped"> --}}
                                          <input type="text" name="nomor_index" id="nomor_index_update"
                                              value="" hidden>
                                          <div class="col-md-12">
                                              <div class="row">
                                                  <div>
                                                      <div class="modal-header bg-info panel-heading  col-sm-15 m-b-5">
                                                          <label class="text-white m-b-10">G. RIWAYAT PRESTASI</label>
                                                      </div>
                                                  </div>
                                                  <div class="col-md-6 m-t-10">

                                                      <div class="form-group">
                                                          <div class="mb-3">
                                                              <label class="form-label">Perihal / Keterangan</label>
                                                              <input type="text" name="keterangan"
                                                                  class="form-control"
                                                                  placeholder="Masukkan Keterangan" id="keterangan"
                                                                  autocomplete="off">
                                                          </div>
                                                      </div>

                                                      <div class="form-group">
                                                          <div class="mb-3">
                                                              <label class="form-label">Instansi Pemberi </label>
                                                              <input type="text" name="namaInstansi"
                                                                  class="form-control" id="namaInstansi"
                                                                  placeholder="Masukkan Nama Instansi">
                                                          </div>
                                                      </div>


                                                      <div class="form-group">
                                                          <div class="mb-3">
                                                              <label for="exampleInputEmail1"
                                                                  class="form-label">Alamat </label>
                                                              <input type="text" name="alamatInstansi"
                                                                  id="alamatInstansi" class="form-control"
                                                                  placeholder="Masukkan Alamat" autocomplete="off">
                                                          </div>
                                                      </div>

                                                  </div>

                                                  {{-- KANAN --}}
                                                  <div class="col-md-6 m-t-10">

                                                      <div class="form-group">
                                                          <div class="mb-3">
                                                              <label for="exampleInputEmail1" class="form-label">Nomor
                                                                  Surat / Sertifikat </label>
                                                              <input type="text" name="noSurat" id="noSurat"
                                                                  class="form-control"
                                                                  placeholder="Masukkan Nomor Surat"
                                                                  autocomplete="off">
                                                          </div>
                                                      </div>

                                                      <div class="mb-3">
                                                          <label class="form-label">Tanggal Surat</label>
                                                          <div class="input-group">
                                                              <input id="datepicker-autoclose-format2" type="text"
                                                                  class="form-control" placeholder="yyyy/mm/dd"
                                                                  id="4" name="tgl_surat" autocomplete="off"
                                                                  rows="10" required><br>
                                                              <span class="input-group-addon bg-custom b-0"><i
                                                                      class="mdi mdi-calendar text-white"></i></span>
                                                          </div><!-- input-group -->
                                                      </div>

                                                  </div>

                                              </div>
                                          </div>
                                          <div class="row">
                                              <div class="pull-left">
                                                  <a href="/create_data_organisasi" class="btn btn-sm btn-info"><i
                                                          class="fa fa-backward"></i> Sebelumnya</a>
                                              </div>
                                              <div class="pull-right">
                                                  <button type="submit" name="submit" class="btn btn-sm btn-dark">
                                                      Update
                                                      Data</button>
                                                  <a href="/preview_data_pelamar" class="btn btn-sm btn-primary">Lihat
                                                      Data
                                                      <i class="fa fa-forward"></i></a>
                                              </div>
                                          </div>
                                          {{-- </table> --}}
                                      </div>
                                      {{-- </div> --}}
                                  </form>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>

      {{-- <script src="assets/js/jquery.min.js"></script> --}}
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

      <script type="text/javascript">
          $(document).ready(function() {
              $('#formCreatePrestasi').prop('hidden', false);
              $('#formUpdatePrestasi').prop('hidden', true);
              $(document).on('click', '#editPrestasi', function() {
                  // Menampilkan form update data dan menyembunyikan form create data
                  $('#formCreatePrestasi').prop('hidden', true);
                  $('#formUpdatePrestasi').prop('hidden', false);

                  // Ambil nomor index data yang akan diubah
                  var nomorIndex = $(this).data('key');

                  // Isi nomor index ke input hidden pada form update data
                  $('#nomor_index_update').val(nomorIndex);

                  // Ambil data dari objek yang sesuai dengan nomor index
                  var data = {!! json_encode($prestasi) !!}[nomorIndex];
                  // console.log(data.jenis_usaha, data.gaji);
                  // Isi data ke dalam form
                  $('#keterangan').val(data.keterangan);
                  $('#namaInstansi').val(data.nama_instansi);
                  $('#alamatInstansi').val(data.alamat);
                  $('#noSurat').val(data.no_surat);

                  var tanggal = new Date(data.tanggal_surat);
                  var tanggalFormatted = ("0" + tanggal.getDate()).slice(-2) + '/' + ("0" + (tanggal
                  .getMonth() + 1)).slice(-2) + '/' + tanggal.getFullYear();
                  $('#datepicker-autoclose-format2').val(tanggalFormatted);

              });
          });
      </script>
      <!-- datepicker  -->
      <script src="assets/js/jquery.min.js"></script>
      <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
      <script src="assets/pages/form-advanced.js"></script>
