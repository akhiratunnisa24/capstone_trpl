<link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <div class="modal modal fade" id="editslip{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="Modal" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title text-center" id="Modal">Edit Data Karyawan</h4>
                </div>
                {{-- form --}}
                <div class="modal-body">
                    <form action="{{route('storegaji')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="col-md-12">
                            <div class="form-group col-sm">
                                <label class="form-label">Nama Karyawan</label>
                                <input type="text" class="form-control" name="nama" autocomplete="off" rows="10" value="{{$data->karyawans->nama}}" readonly>
                            </div>
                            <div class="form-group col-sm">
                                <label class="col-form-label">Tanggal Masuk</label>
                                <input type="text" name="tglmasuk" autocomplete="off" rows="10" value="{{\Carbon\Carbon::parse($data->karyawans->tglmasuk)->format('d/m/Y')}}" readonly>
                            </div>
                            @if($data->nama_bank !== null)
                                <div class="form-group col-sm" id="nama_bank-group">
                                    <label class="col-form-label">Nama Bank</label>
                                    <input type="text" class="form-control" name="nama_bank" id="nama_bank" value="{{$data->nama_bank}}" required>
                                </div>
                            @else
                                <div class="form-group col-sm" id="nama_bank-group">
                                    <div class="mb-3">
                                    <label class="form-label">Nama Bank <span style="color: red;">*</span></label>
                                    <select class="form-control selectpicker" name="nama_bank" required>
                                        <option value="">Pilih Bank</option>
                                        <option value="Bank ANZ Indonesia" {{ $data->nama_bank  == 'Bank ANZ Indonesia' ? 'selected' : '' }}>Bank ANZ Indonesia</option>
                                        <option value="Bank Bukopin" {{ $data->nama_bank  == 'Bank Bukopin' ? 'selected' : '' }}>Bank Bukopin</option>
                                        <option value="Bank Central Asia (BCA)" {{ $data->nama_bank  == 'Bank Central Asia (BCA)' ? 'selected' : '' }}>Bank Central Asia (BCA)</option>
                                        <option value="Bank Danamon" {{ $data->nama_bank  == 'Bank Danamon' ? 'selected' : '' }} >Bank Danamon</option>
                                        <option value="Bank DBS Indonesia" {{ $data->nama_bank  == 'Bank DBS Indonesia' ? 'selected' : '' }} >Bank DBS Indonesia</option>
                                        <option value="Bank HSBC Indonesia" {{ $data->nama_bank  == 'Bank HSBC Indonesia' ? 'selected' : '' }} >Bank HSBC Indonesia</option>
                                        <option value="Bank Jabar Banten (BJB)" {{ $data->nama_bank  == 'Bank Jabar Banten (BJB)' ? 'selected' : '' }} >Bank Jabar Banten (BJB)</option>
                                        <option value="Bank Mandiri" {{ $data->nama_bank  == 'Bank Mandiri' ? 'selected' : '' }} >Bank Mandiri</option>
                                        <option value="Bank Maybank" {{ $data->nama_bank  == 'Bank Maybank' ? 'selected' : '' }} >Bank Maybank</option>
                                        <option value="Bank Mega" {{ $data->nama_bank  == 'Bank Mega' ? 'selected' : '' }} >Bank Mega</option>
                                        <option value="Bank Muamalat" {{ $data->nama_bank  == 'Bank Muamalat' ? 'selected' : '' }} >Bank Muamalat</option>
                                        <option value="Bank Negara Indonesia (BNI)" {{ $data->nama_bank == 'Bank Negara Indonesia (BNI)' ? 'selected' : '' }} >Bank Negara Indonesia (BNI)</option>
                                        <option value="Bank OCBC NISP" {{ $data->nama_bank  == 'Bank OCBC NISP' ? 'selected' : '' }} >Bank OCBC NISP</option>
                                        <option value="Bank Panin" {{ $data->nama_bank  == 'Bank Panin' ? 'selected' : '' }} >Bank Panin</option>
                                        <option value="Bank Permata" {{ $data->nama_bank  == 'Bank Permata' ? 'selected' : '' }} >Bank Permata</option>
                                        <option value="Bank Rakyat Indonesia (BRI)" {{ $data->nama_bank  == 'Bank Rakyat Indonesia (BRI)' ? 'selected' : '' }} >Bank Rakyat Indonesia (BRI)</option>
                                        <option value="Bank Syariah Mandiri" {{ $data->nama_bank  == 'Bank Syariah Mandiri' ? 'selected' : '' }} >Bank Syariah Mandiri</option>
                                        <option value="Bank Tabungan Negara (BTN)" {{ $data->nama_bank  == 'Bank Tabungan Negara (BTN)' ? 'selected' : '' }} >Bank Tabungan Negara (BTN)</option>
                                        <option value="Bank UOB Indonesia" {{ $data->nama_bank  == 'Bank UOB Indonesia' ? 'selected' : '' }} >Bank UOB Indonesia</option>
                                        <option value="Bank CIMB Niaga" {{ $data->nama_bank  == 'Bank CIMB Niaga' ? 'selected' : '' }} >Bank CIMB Niaga</option>
                                        {{-- <option value="Mandiri" {{ $karyawan->nama_bank ?? '' == 'Mandiri' ? 'selected' : '' }} >Mandiri</option> --}}
                                    </select>
                                </div>
                            @endif
                            <div class="form-group col-sm">
                                <label class="col-form-label">No. rekening</label>
                                <input type="text" class="form-control" name="nomor_rekening" placeholder="Masukkan Nomor Rekening" id="nomor_rekening" value="{{$data->no_rekening}}" required>
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
                success:function(data){
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
