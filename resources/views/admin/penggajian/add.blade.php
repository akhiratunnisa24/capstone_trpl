<link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <div class="modal modal fade" id="addslip" tabindex="-1" role="dialog" aria-labelledby="Modal" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title text-center" id="Modal">Tambah Slip Gaji Karyawan</h4>
                </div>
                {{-- form --}}
                <div class="modal-body">
                    <form action="{{route('storegaji')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="col-md-12">
                            <div class="form-group col-sm">
                                <label class="form-label">Tanggal Penggajian</label>
                                <input id="datepicker-autoclose-format-ak" type="text" class="form-control" placeholder="dd/mm/yyyy"
                                            name="tglgajian" autocomplete="off" value="{{\Carbon\Carbon::now()->format('d/m/Y')}}" rows="10" required readonly>
                            </div>
                            <div class="form-group col-sm">
                                <label class="col-form-label">Nama Karyawan</label>
                                <select name="id_karyawan" id="id_karyawan" class="form-control selectpicker" data-live-search="true" required>
                                    <option>-- Pilih Karyawan --</option>
                                    @foreach ($karyawan as $data)
                                            <option value="{{ $data->id}}">
                                                {{ $data->nama }}
                                            </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label class="form-label">Periode Gajian</label>
                                    <div>
                                        <div class="input-group">
                                            <input id="datepicker-autoclose-format-ai" type="text" class="form-control" placeholder="dd/mm/yyyy"
                                            name="tgl_awal"  autocomplete="off"  rows="10" required readonly>
                                            <span class="input-group-addon bg-info text-white b-0">-</span>
                                            <input id="datepicker-autoclose-format-aj" type="text" class="form-control" placeholder="dd/mm/yyyy"
                                                name="tgl_akhir" autocomplete="off"  rows="10" required readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="form-group col-sm">
                                <label class="col-form-label">Struktur Gaji</label>
                                <input type="text" class="form-control" name="id_strukturgaji" id="id_strukturgaji" required>
                            </div>  --}}
                            <div class="form-group col-sm">
                                <label class="col-form-label">Tanggal Masuk</label>
                                <input id="datepicker-autoclose-format-al" type="text" class="form-control" placeholder="dd/mm/yyyy"
                                    name="tglmasuk" autocomplete="off" rows="10" required readonly>
                            </div>
                            <div class="form-group col-sm" id="nama_bank-group">
                                <label class="col-form-label">Nama Bank</label>
                                <input type="text" class="form-control" name="nama_bank" id="nama_bank" required>
                            </div>
                            <div class="form-group col-sm">
                                <label class="col-form-label">No. rekening</label>
                                <input type="text" class="form-control" name="nomor_rekening" id="nomor_rekening" required>
                            </div>
                    </div>

                        <input type="hidden" class="form-control" name="partner" value="{{Auth::user()->partner}}">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</button>
                            <button type="submit" id="submit-button" class="btn btn-sm btn-success" value="save">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
     <!-- jQuery  -->
     <script src="assets/js/jquery.min.js"></script>
     <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

    <script  type="text/javascript">
        $('#id_karyawan').on('change',function(e){
            var id_karyawan = e.target.value;
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                            .attr('content')
                        }
            });
            $.ajax({
                type:"POST",
                url: '{{route('get.Karyawan')}}',
                data: {'id_karyawan':id_karyawan},
                success:function(data)
                {
                    if (data.nama_bank === null && data.no_rek === null) {
                        $('#nama_bank-group').html('<label class="col-form-label">Nama Bank</label><select class="form-control" name="nama_bank" id="nama_bank" required><option>-- Pilih Nama Bank --</option><option value="Bank ANZ Indonesia">Bank ANZ Indonesia</option><option value="Bank Bukopin">Bank Bukopin</option><option value="Bank Central Asia (BCA)">Bank Central Asia (BCA)</option><option value="Bank Danamon">Bank Danamon</option><option value="Bank DBS Indonesia">Bank DBS Indonesia</option><option value="Bank HSBC Indonesian">Bank HSBC Indonesia</option><option value="Bank Jabar Banten (BJB)">Bank Jabar Banten (BJB)</option><option value="Bank Mandiri">Bank Mandiri</option><option value="Bank Maybank">Bank Maybank</option><option value="Bank Mega">Bank Mega</option><option value="Bank Muamalat">Bank Muamalat</option><option value="Bank Negara Indonesia (BNI)">Bank Negara Indonesia (BNI)</option><option value="Bank OCBC NISP">Bank OCBC NISP</option><option value="Bank Panin">Bank Panin</option><option value="Bank Permata">Bank Permata</option><option value="Bank Rakyat Indonesia (BRI)">Bank Rakyat Indonesia (BRI)</option><option value="Bank Syariah Mandiri">Bank Syariah Mandiri</option><option value="Bank Tabungan Negara (BTN)">Bank Tabungan Negara (BTN)</option><option value="Bank UOB Indonesia">Bank UOB Indonesia</option><option value="Bank CIMB Niaga">Bank CIMB Niaga</option><option value="Bank Mandiri">Bank Mandiri</option></select>');
                        $('#nomor_rekening').val(data.no_rek);

                        var tanggalMasuk = data.tglmasuk.split('-');
                        var tanggalFormatted = tanggalMasuk[2] + '/' + tanggalMasuk[1] + '/' + tanggalMasuk[0];
                        $('#datepicker-autoclose-format-al').val(tanggalFormatted);
                    } else {
                        $('#nama_bank-group').html('<label class="col-form-label">Nama Bank</label><input type="text" class="form-control" name="nama_bank" id="nama_bank" required>');
                        $('#nama_bank').val(data.nama_bank);
                        $('#nomor_rekening').val(data.no_rek);

                        var tanggalMasuk = data.tglmasuk.split('-');
                        var tanggalFormatted = tanggalMasuk[2] + '/' + tanggalMasuk[1] + '/' + tanggalMasuk[0];
                        $('#datepicker-autoclose-format-al').val(tanggalFormatted);
                    }
                }
            });
        });
    </script>
