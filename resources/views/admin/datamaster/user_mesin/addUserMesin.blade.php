{{-- FORM TAMBAH DATA USER MESIN --}}
<div class="modal fade" id="AddModal" tabindex="-1" role="dialog" aria-labelledby="AddModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="AddModalLabel">Tambah User Mesin</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('user_mesin.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-group">
                        <label for="id_pegawai" class="col-form-label">Nama Karyawan</label>
                        <select class="form-control select2" name="id_pegawai" id="id_pegawai" required>
                            @foreach($karyawans as $karyawan)
                                <option value="{{ $karyawan->id }}">{{ $karyawan->nama }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="nik" class="col-form-label">NIK</label>
                        <input type="text" class="form-control" name="nik" id="nik" autocomplete="off" readonly>
                    </div>

                    <div class="form-group">
                        <label for="departemen" class="col-form-label">Departemen</label>
                        <input type="text" class="form-control" name="departemen" id="departemen" autocomplete="off" readonly>
                    </div>
                    <div class="form-group" hidden>
                        <label for="partner" class="col-form-label" hidden>Partner</label>
                        <input type="text" class="form-control" name="partner" id="partner" hidden>
                    </div>
                    <div class="form-group">
                        <label for="noid" class="col-form-label">No ID</label>
                        <select class="form-control" name="noid" id="noid" required>
                            <option value="">Pilih User</option>
                            @foreach ($user_mesin as $user)
                                @if ($user->partner == Auth::user()->partner || Auth::user()->role == 5)
                                    <option value="{{ $user->PIN }}">{{ $user->Name }} (ID: {{ $user->PIN }})</option>
                                @endif
                            @endforeach
                        </select>
                    </div>


                    {{-- <div class="form-group">
                        <label for="noid" class="col-form-label">No ID 2</label>
                        <input type="text" class="form-control" name="noid2" id="noid2" value="{{ old('noid2') }}" autocomplete="off"
                            placeholder="Masukkan No ID 2 / PIN2">
                            @error('noid2')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                    </div> --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger waves-effect" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-sm btn-success waves-effect waves-light" name="submit" value="save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
