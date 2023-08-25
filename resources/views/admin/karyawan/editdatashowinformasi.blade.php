<div class="modal fade" id="editDatakaryawan{{ $karyawan->id }}" tabindex="-1" role="dialog" aria-labelledby="AddModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel">Edit Data Karyawan</h4>
            <div class="modal-body">
                <form action="/update-identitas{{$karyawan->id}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group col-sm">
                                    <div class="row">
                                        <label class="form-label col-sm-3 text-end">Nama</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="namaKaryawan" autocomplete="off" value="{{$karyawan->nama}}" >
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm">
                                    <div class="row">
                                        <label class="form-label col-sm-3 text-end">Tanggal Masuk</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="yyyy/mm/dd" id="datepicker-autoclose51" name="tglmasukKaryawan"
                                                autocomplete="off" value="{{ \Carbon\Carbon::parse($karyawan->tglmasuk)->format('d/m/Y') ?? '-' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm">
                                    <div class="row">
                                        <label class="form-label col-sm-3 text-end">Tanggal Keluar</label>
                                        <div class="col-sm-9">
                                            @if ($karyawan->tglkeluar)
                                            <input type="text" class="form-control" autocomplete="off" value="{{ \Carbon\carbon::parse($karyawan->tglkeluar)->format('d/m/Y') }}" >
                                            @else
                                            <input type="text" class="form-control" autocomplete="off" value="-" >
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm">
                                    <div class="row">
                                        <label class="form-label col-sm-3 text-end">Status Karyawan</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="statusKaryawan">
                                                <option value="">Pilih Status Karyawan</option>
                                                <option value="Pengurus" @if ($karyawan->status_karyawan == 'Pengurus') selected @endif> Pengurus</option>
                                                <option value="Tetap" @if ($karyawan->status_karyawan == 'Tetap') selected @endif>Tetap </option>
                                                <option value="Kontrak"@if ($karyawan->status_karyawan == 'Kontrak') selected @endif>Kontrak</option>
                                                <option value="Percobaan"@if ($karyawan->status_karyawan == 'Percobaan') selected @endif> Percobaan</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group col-sm">
                                    <div class="row">
                                        <label class="form-label col-sm-3 text-end">Gaji Pokok</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control input-formats" name="gajiKaryawan" autocomplete="off" value="{{ $karyawan->gaji ? number_format($karyawan->gaji, 0, ',', '.')  : 'Masukkan Gaji Pokok'}}" >
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm">
                                    <div class="row">
                                        <label
                                            class="form-label col-sm-3 text-end">Divisi</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="divisi">
                                                <option value="">Pilih Divisi</option>
                                                @foreach ($departemen as $d)
                                                    <option value="{{ $d->id }}"
                                                        @if ($karyawan->divisi == $d->id) selected @endif>
                                                        {{ $d->nama_departemen }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm">
                                    <div class="row">
                                        <label class="form-label col-sm-3 text-end">Jabatan</label>
                                        <div class="col-sm-9">
                                            {{-- <input type="text" name="namaJabatan" class="form-control" autocomplete="off" value="{{$karyawan->nama_jabatan ? $karyawan->nama_jabatan : 'Masukkan Level Jabatan'}}" > --}}
                                            <select class="form-control" name="namaJabatan">
                                                <option value="">Pilih Nama Jabatan</option>
                                                @foreach ($namajabatan as $nama)
                                                    <option value="{{ $nama->nama_jabatan }}"
                                                        @if($karyawan->nama_jabatan == $nama->nama_jabatan) selected @endif>
                                                        {{$nama->nama_jabatan}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md">
                                    <div class="row">
                                        <label class="form-label col-sm-3 text-end">Level Jabatan</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="leveljabatanKaryawan">
                                                <option value="">Pilih Level Jabatan</option>
                                                @foreach ($leveljabatan as $level)
                                                    <option value="{{ $level->nama_level }}"
                                                        @if($karyawan->jabatan == $level->nama_level) selected @endif>
                                                        {{$level->nama_level}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success waves-effect waves-light" name="submit"
                            value="save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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
