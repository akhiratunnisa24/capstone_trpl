<link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <div class="modal modal fade" id="editslip{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="Modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title text-center" id="Modal">Edit Data Karyawan</h4>
                </div>
                {{-- form --}}
                <div class="modal-body">
                    <form action="/slipgaji-karyawan-grup/rekening/{{$data->karyawans->id}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group col-sm">
                                        <label class="form-label">Nama Karyawan</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="nama" autocomplete="off" rows="10" value="{{$data->karyawans->nama}}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm">
                                        <label class="col-form-label">Tanggal Masuk</label>
                                        <div class="input-group">
                                            <input type="text" name="tglmasuk" autocomplete="off" rows="10" value="{{\Carbon\Carbon::parse($data->karyawans->tglmasuk)->format('d/m/Y')}}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm">
                                        <div class="row">
                                            <label class="form-label text-end">Tanggal Keluar</label>
                                            <div class="input-group">
                                                @if ($data->karyawans->tglkeluar)
                                                    <input type="text" class="form-control" autocomplete="off" value="{{ \Carbon\carbon::parse($data->karyawans->tglkeluar)->format('d/m/Y') }}" >
                                                @else
                                                    <input type="text" class="form-control" autocomplete="off" value="-" >
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm">
                                        <div class="row">
                                            <label class="form-label text-end">Status Karyawan</label>
                                            <div class="input-group">
                                                <select class="form-control" name="statusKaryawan">
                                                    <option value="">Pilih Status Karyawan</option>
                                                    <option value="Pengurus" @if ($data->karyawans->status_karyawan == 'Pengurus') selected @endif> Pengurus</option>
                                                    <option value="Tetap" @if ($data->karyawans->status_karyawan == 'Tetap') selected @endif>Tetap </option>
                                                    <option value="Kontrak"@if ($data->karyawans->status_karyawan == 'Kontrak') selected @endif>Kontrak</option>
                                                    <option value="Percobaan"@if ($data->karyawans->status_karyawan == 'Percobaan') selected @endif> Percobaan</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm">
                                        <label class="col-form-label">Gaji Pokok</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control input-formats" name="nomor_rekening" placeholder="Masukkan Gaji Pokok" id="gaji_pokok" value="{{ number_format($data->gaji_pokok, 0, ',', '.')}}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">   
                                    <div class="form-group col-sm">
                                        <div class="row">
                                            <label class="form-label text-end">Jabatan</label>
                                            <div class="input-group">
                                                <select class="form-control" name="namaJabatan">
                                                    <option value="">Pilih Nama Jabatan</option>
                                                    @foreach ($namajabatan as $nama)
                                                        <option value="{{ $nama->nama_jabatan }}"
                                                            @if($data->karyawans->nama_jabatan == $nama->nama_jabatan) selected @endif>
                                                            {{$nama->nama_jabatan}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm">
                                        <div class="row">
                                            <label class="form-label text-end">Level Jabatan</label>
                                            <div class="input-group">
                                                <select class="form-control" name="leveljabatanKaryawan">
                                                    <option value="">Pilih Level Jabatan</option>
                                                    @foreach ($leveljabatan as $level)
                                                        <option value="{{ $level->nama_level }}"
                                                            @if($data->karyawans->jabatan == $level->nama_level) selected @endif>
                                                            {{$level->nama_level}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm">
                                        <div class="row">
                                            <label
                                                class="form-label text-end">Divisi</label>
                                            <div class="input-group">
                                                <select class="form-control" name="divisi">
                                                    <option value="">Pilih Divisi</option>
                                                    @foreach ($departemen as $d)
                                                        <option value="{{ $d->id }}"
                                                            @if ($data->karyawans->divisi == $d->id) selected @endif>
                                                            {{ $d->nama_departemen }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm" id="nama_bank-group">
                                        <label class="form-label">Nama Bank</label>
                                        <div class="input-group">
                                            <select class="form-control selectpicker" name="nama_bank" width="200px" required>
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
                                                <option value="Mandiri" {{ $data->nama_bank ?? '' == 'Mandiri' ? 'selected' : '' }} >Mandiri</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm">
                                        <label class="col-form-label">No. rekening</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="nomor_rekening" placeholder="Masukkan Nomor Rekening" id="nomor_rekening" value="{{$data->no_rekening}}" required>
                                        </div>
                                    </div>
                                </div>
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

    {{-- <script  type="text/javascript">
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
    </script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputFormats = document.querySelectorAll('.input-formats');
    
            inputFormats.forEach(input => {
                input.addEventListener('input', function() {
                    const value = parseFloat(this.value.replace(/\./g, '').replace(/,/g, ''));
                    if (!isNaN(value)) {
                        const formattedValue = new Intl.NumberFormat('id-ID').format(value);
                        this.value = formattedValue;
                    }
                });
            });
        });
    </script>
    
