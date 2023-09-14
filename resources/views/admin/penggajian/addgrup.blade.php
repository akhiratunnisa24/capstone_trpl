<div id="addslip-grup" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title text-center" id="myModalLabel">Tambah Slip Grup</h4>
            </div>
            <div class="modal-body">
                <form id="formCreatePekerjaan" method="POST" action="{{ route('storegrup') }}" onsubmit="return validateForm()">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
                                <div class="form-group col-sm">
                                    <label class="form-label">Tanggal Penggajian</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="dd/mm/yyyy" id="datepicker-autoclose76" name="tgl_penggajian"  autocomplete="off" required readonly>
                                        <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                    </div>
                                </div>
                                {{-- <div class="form-group col-sm">
                                    <label class="col-form-label">Nama Karyawan</label>
                                    <input type="text" class="form-control" name="nama_karyawan[]" id="nama_karyawan" required>
                                </div> --}}
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="mb-3">
                                        <label class="form-label">Periode Gajian</label>
                                        <div>
                                            <div class="input-group">
                                                <input id="datepicker-autoclose-format-as" type="text" class="form-control" placeholder="dd/mm/yyyy"
                                                name="tgl_mulai"  autocomplete="off"  rows="10" required readonly>
                                                <span class="input-group-addon bg-info text-white b-0">-</span>
                                                <input id="datepicker-autoclose-format-at" type="text" class="form-control" placeholder="dd/mm/yyyy"
                                                    name="tgl_selesai" autocomplete="off"  rows="10" required readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="form-group col-sm" id="nama_bank-group">
                                    <label class="col-form-label">Nama Bank</label>
                                    <input type="text" class="form-control" name="nama_bank[]" id="nama_bank" required>
                                </div> --}}
                            </div>
                            <div class="col-md-4">
                                <div class="form-group col-sm">
                                    <label  class="col-form-label">Struktur Penggajian</label>
                                    <select name="id_strukturgaji" id="id_strukturgaji" class="form-control selectpicker" data-live-search="true" required>
                                        <option>-- Pilih Struktur Penggajian --</option>
                                        @foreach($slipgrup as $data)
                                            <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- <div class="form-group col-sm">
                                    <label class="col-form-label">No. rekening</label>
                                    <input type="text" class="form-control" name="nomor_rekening[]" id="nomor_rekening" required>
                                </div> --}}
                            </div>
                                <input id="partner" type="hidden" class="form-control" name="partner" value="{{ Auth::user()->partner }}" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer m-t-30">
                        <button type="button" class="btn btn-sm btn-danger waves-effect" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-sm btn-success waves-effect waves-light" name="submit" value="save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<script src="assets/js/jquery.min.js"></script>
<script>
    $('#id_strukturgaji').on('change', function (e) {
    var id_strukturgaji = e.target.value;
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });
    $.ajax({
        type: "POST",
        url: '{{ route('getkaryawangrup') }}',
        data: { 'id_strukturgaji': id_strukturgaji },
        success: function (data) {
            // Hapus elemen input yang ada di dalam <div class="row">
            $('.row').find('#data').remove();
            $('.row').find('#data2').remove();
            $('.row').find('#data3').remove();

            if (data.length > 0) {
                var newFormGroup = '';

                for (var i = 0; i < data.length; i++) {
                    newFormGroup +=
                        '<div class="col-md-4" id="data">' +
                        '<div class="form-group col-sm">' +
                        '<label class="col-form-label">Nama Karyawan</label>' +
                        '<input type="text" class="form-control" name="nama_karyawan[]" value="' + data[i].nama + '" required>' +
                        '</div>' +
                        '</div>' +
                        '<div class="col-md-4" id="data2">' +
                        '<div class="form-group col-sm" id="nama_bank-group">' +
                        '<label class="col-form-label">Nama Bank</label>' +
                        '<input type="text" class="form-control" name="nama_bank[]" value="' + data[i].nama_bank + '" required>' +
                        '</div>' +
                        '</div>' +
                        '<div class="col-md-4" id="data3">' +
                        '<div class="form-group col-sm">' +
                        '<label class="col-form-label">No. rekening</label>' +
                        '<input type="text" class="form-control" name="nomor_rekening[]" value="' + data[i].nomor_rekening + '" required>' +
                        '</div>' +
                        '</div>';
                }

                // Tambahkan elemen baru pada row terakhir
                $('.row:last').append(newFormGroup);
            }
        }
    });
});

</script>
{{-- <script>
    $('#id_strukturgaji').on('change', function (e) 
    {
        var id_strukturgaji = e.target.value;
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
        $.ajax({
            type: "POST",
            url: '{{ route('getkaryawangrup') }}',
            data: { 'id_strukturgaji': id_strukturgaji },
            success: function (data) {
                // Hapus elemen input yang ada di dalam <div class="row">
                $('.row').find('#data').remove();

                if (data.length > 0) 
                {
                    var newFormGroup = '<div class="col-md-4">' +
                        '<div class="form-group col-sm">' +
                        '<label class="col-form-label">Nama Karyawan</label>' +
                        '</div>' +
                        '</div>' +
                        '<div class="col-md-4">' +
                        '<div class="form-group col-sm" id="nama_bank-group">' +
                        '<label class="col-form-label">Nama Bank</label>' +
                        '</div>' +
                        '</div>' +
                        '<div class="col-md-4">' +
                        '<div class="form-group col-sm">' +
                        '<label class="col-form-label">No. rekening</label>' +
                        '</div>' +
                        '</div>';

                    for (var i = 0; i < data.length; i++) {
                        newFormGroup +=
                            '<div class="col-md-4" id="data">' +
                            '<div class="form-group col-sm">' +
                            '<input type="text" class="form-control" name="nama_karyawan[]" value="' + data[i].nama + '" required>' +
                            '</div>' +
                            '</div>' +
                            '<div class="col-md-4" id="data">' +
                            '<div class="form-group col-sm" id="nama_bank-group">' +
                            '<input type="text" class="form-control" name="nama_bank[]" value="' + data[i].nama_bank + '" required>' +
                            '</div>' +
                            '</div>' +
                            '<div class="col-md-4" id="data">' +
                            '<div class="form-group col-sm">' +
                            '<input type="text" class="form-control" name="nomor_rekening[]" value="' + data[i].nomor_rekening + '" required>' +
                            '</div>' +
                            '</div>';
                    }

                    $('.row:last').append(newFormGroup); // Menambahkan elemen baru pada row terakhir
                }
            }
        });
    });
</script> --}}
