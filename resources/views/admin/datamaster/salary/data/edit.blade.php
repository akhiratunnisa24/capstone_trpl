<div class="modal fade" id="edit{{ $salaryStructure->id }}" tabindex="-1" role="dialog" aria-labelledby="Modaleditsalary"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="Modaleditsalary">Edit Struktur Penggajian</h4>
            </div>
            <div class="modal-body">
                <form id="formModaleditsalary" action="{{ route('salary.update', $salaryStructure->id) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group col-xs">
                                    <label class="form-label">Nama Struktur Penggajian</label>
                                    <input type="text" class="form-control" name="nama" value="{{ $salaryStructure->nama }}"
                                        required>
                                </div>

                                <div class="form-group col-xs">
                                    <label for="level_jabatan">Level Jabatan</label>
                                    <select class="form-control" name="level_jabatan" required>
                                        {{-- <option value="" disabled selected>Pilih Level Jabatan</option> --}}
                                        @foreach ($levelJabatanOptions as $value => $label)
                                            <option value="{{ $value }}"
                                                {{ $value == $salaryStructure->id_level_jabatan ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-xs">
                                    <label for="status_karyawan">Jenis Status Karyawan</label>
                                    <select class="form-control" name="status_karyawan" required>
                                        @foreach ($statusKaryawanOptions as $value => $label)
                                            <option value="{{ $value }}"
                                                {{ $value == $salaryStructure->status_karyawan ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group col-xs">
                                    <label for="benefits">Komponen Penggajian</label>
                                    @foreach ($benefits as $benefit)
                                        <div class="checkbox checkbox-success">
                                            <input type="checkbox" id="checkbox{{ $benefit->id }}" class="form-check-input"
                                                name="benefits[]" value="{{ $benefit->id }}"
                                                {{ in_array($benefit->id, $selectedBenefits) || $salaryStructure->benefits->contains($benefit->id) ? 'checked' : '' }}
                                                {{ in_array($benefit->id, $selectedBenefits) ? 'disabled' : '' }}>
                                            <label for="checkbox{{ $benefit->id }}">
                                                {{ $benefit->nama_benefit }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group m-t-20">
                        <div class="col-xs">
                            <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Tutup</button>
                            <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
