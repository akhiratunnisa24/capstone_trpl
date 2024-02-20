{{-- FORM TAMBAH KATEGORI CUTI --}}
<link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">

<style>
    .col-form-label{
        -webkit-text-fill-color: black;
    }
</style>
<div class="modal fade" id="Modaltugas" tabindex="-1" role="dialog" aria-labelledby="Modal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel">Tambah Tugas</h4>
            </div>
            <div class="modal-body">
                <form action="{{route ('tugaskaryawan.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-group col-sm">
                        <label for="tim_id" class="col-form-label">Nama Tim</label>
                        <select name="tim_id" id="tim_id" class="form-control" required>
                            <option>-- Pilih Tim --</option>
                            @foreach ($tim as $data)
                                    <option value="{{ $data->id }}">
                                       {{ $data->namatim }}
                                    </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm">
                        <label for="id_karyawan" class="col-form-label">Karyawan</label>
                        <select name="id_karyawan" id="id_karyawan" class="form-control" required>
                            <option>-- Pilih Karyawan--</option>

                        </select>
                    </div>
                    <div class="form-group col-sm">
                        <label for="nik" class="col-form-label">NIK Karyawan</label>
                        <input type="text" class="form-control" name="nik" id="niks" autocomplete="off" disabled>
                        <input type="hidden" class="form-control" name="nik" id="nik" autocomplete="off" required>
                    </div>
                    <div class="form-group col-sm">
                        <label for="divisi" class="col-form-label">Divisi</label>
                        <input type="text" class="form-control" name="divisis" id="divisis" autocomplete="off" required>
                        <input type="hidden" class="form-control" name="divisi" id="divisi" autocomplete="off" required>
                    </div>

                    <div class="form-group col-sm">
                        <label for="judul" class="col-form-label">Judul</label>
                        <input type="text" class="form-control" name="judul" id="judul" autocomplete="off" required>
                    </div>
                    <div class="form-group col-sm">
                        <label for="deskripsi" class="col-form-label">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-xs-12">
                            <div>
                                {{-- <form class="" action="#"> --}}
                                    <div class="form-group">
                                        <label class="form-label">Tanggal Mulai</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="dd/mm/yyyy" id="datepicker-autoclosez" name="tgl_mulai"  autocomplete="off" rows="10" required readonly>
                                            <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                        </div>
                                    </div>
                                {{-- </form> --}}
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div>
                                {{-- <form class="" action="#"> --}}
                                    <div class="form-group">
                                        <label class="form-label">Deadline</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="dd/mm/yyyy" id="datepicker-autoclosezz" name="tgl_selesai"  autocomplete="off" rows="10" required readonly>
                                            <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                        </div>
                                    </div>
                                {{-- </form> --}}
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger waves-effect" data-dismiss="modal">Tutup</button>
                        <button type="submit" name="submit" value="save" class="btn btn-sm btn-success waves-effect waves-light">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    {{-- <script src="assets/js/jquery.min.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="assets/pages/form-advanced.js"></script>
    <script>
        $('#tim_id').on('change', function(e) {
            var tim_id = e.target.value;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: '{{ route('get.tim') }}',
                data: {
                    'tim_id': tim_id
                },
                success: function(data) {
                    $('#id_karyawan').empty(); // Menghapus semua opsi sebelumnya
                    $('#id_karyawan').append('<option>-- Pilih Karyawan--</option>'); // Menambahkan opsi default

                    // Menambahkan opsi karyawan berdasarkan data yang diterima
                    for (var i = 0; i < data.length; i++) {
                        $('#id_karyawan').append('<option value="' + data[i].karyawans.id + '">' + data[i].karyawans.nama + '</option>');
                    }
                    $('#divisis').val(data[0].departemens.nama_departemen); // Mengisi nilai input divisi dengan nama departemen
                    $('#divisi').val(data[0].departemens.id); // Mengisi nilai input divisis dengan id divisi
                }
            });
        });
    </script>


    <script>
        $('#id_karyawan').on('change', function(e) {
            var id_karyawan = e.target.value;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                        .attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: '{{ route('get.nik') }}',
                data: {
                    'id_karyawan': id_karyawan
                },
                success: function(data) {
                    $('#nik').val(data.nip);
                    $('#niks').val(data.nip);
                }
            });
        });
    </script>

