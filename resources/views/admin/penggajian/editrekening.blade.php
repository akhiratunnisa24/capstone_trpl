<div class="modal fade" id="editslip{{ $data->id_karyawan }}" tabindex="-1" role="dialog" aria-labelledby="AddModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel">Edit Data Karyawan</h4>
            <div class="modal-body">
                <form action="/slipgaji-karyawan-grup/rekening/{{$data->id_karyawan}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group col-sm">
                                    <label class="form-label text-end">Nama Karyawan</label>
                                    <input type="text" class="form-control" name="namaKaryawan" autocomplete="off" value="{{$data->karyawans->nama}}" >
                                    <input type="hidden" class="form-control" name="id_slip" autocomplete="off" value="{{$data->id}}" >
                                </div>
                                <div class="form-group col-sm">
                                    <label class="form-label text-end">Tanggal Masuk</label>
                                    <input type="text" class="form-control" placeholder="yyyy/mm/dd" id="datepicker-autoclose51" name="tglmasukKaryawan"
                                        autocomplete="off" value="{{ \Carbon\Carbon::parse($data->karyawans->tglmasuk)->format('d/m/Y') ?? '-' }}" readonly>
                                </div>
                                <div class="form-group col-sm">
                                    <label class="form-label text-end">Tanggal Keluar</label>
                                    @if ($data->karyawans->tglkeluar)
                                        <input type="text" class="form-control" autocomplete="off" value="{{ \Carbon\carbon::parse($data->karyawans->tglkeluar)->format('d/m/Y') }}" >
                                    @else
                                        <input type="text" class="form-control" autocomplete="off" value="-" >
                                    @endif
                                </div>
                                <div class="form-group col-sm">
                                    <label class="form-label text-end">Status Karyawan</label>
                                    <select class="form-control selectpicker" name="statusKaryawan">
                                        <option value="">Pilih Status Karyawan</option>
                                        <option value="Pengurus" @if ($data->karyawans->status_karyawan == 'Pengurus') selected @endif> Pengurus</option>
                                        <option value="Tetap" @if ($data->karyawans->status_karyawan == 'Tetap') selected @endif>Tetap </option>
                                        <option value="Kontrak"@if ($data->karyawans->status_karyawan == 'Kontrak') selected @endif>Kontrak</option>
                                        <option value="Percobaan"@if ($data->karyawans->status_karyawan == 'Percobaan') selected @endif> Percobaan</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm">
                                    <label class="form-label text-end">Jabatan</label>
                                    <select class="form-control selectpicker" name="namaJabatan">
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
                            <div class="col-md-6">
                                <div class="form-group col-md">
                                    <label class="form-label text-end">Level Jabatan</label>
                                    <select class="form-control selectpicker" name="leveljabatanKaryawan">
                                        <option value="">Pilih Level Jabatan</option>
                                        @foreach ($leveljabatan as $level)
                                            <option value="{{ $level->nama_level }}"
                                                @if($data->karyawans->jabatan == $level->nama_level) selected @endif>
                                                {{$level->nama_level}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm">
                                    <label class="form-label text-end">Divisi</label>
                                    <select class="form-control selectpicker" name="divisi">
                                        <option value="">Pilih Divisi</option>
                                        @foreach ($departemen as $d)
                                            <option value="{{ $d->id }}"
                                                @if ($data->karyawans->divisi == $d->id) selected @endif>
                                                {{ $d->nama_departemen }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm">
                                    <label class="form-label text-end">Gaji Pokok</label>
                                    <input type="text" class="form-control input-formats" placeholder="Masukkan Gaji Pokok" name="gajiKaryawan" autocomplete="off" value="{{ $data->gaji_pokok ? number_format($data->gaji_pokok, 0, ',', '.')  : ''}}" >
                                </div>
                                <div class="form-group col-sm" id="nama_bank-group">
                                    <label class="form-label text-end">Nama Bank</label>
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
                                <div class="form-group col-sm">
                                    <label class="form-label">No. rekening</label>
                                    <input type="text" class="form-control" name="nomor_rekening" placeholder="Masukkan Nomor Rekening" id="nomor_rekening" value="{{$data->no_rekening}}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger waves-effect" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-sm btn-success waves-effect waves-light" name="submit"
                            value="save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

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
