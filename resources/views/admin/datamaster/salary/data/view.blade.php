<div class="modal fade" id="showModal{{ $salaryStructure->id }}" tabindex="-1" role="dialog"
    aria-labelledby="ModalShowSalary">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center" id="ModalShowSalary">Detail Struktur Penggajian</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Nama Struktur Penggajian:</h5>
                            <p>{{ $salaryStructure->nama }}</p>

                            <h5>Level Jabatan:</h5>
                            <p>{{ $salaryStructure->level_jabatans->nama_level }}</p>

                            <h5>Jenis Status Karyawan:</h5>
                            <p>{{ $salaryStructure->status_karyawan }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Benefit:</h5>
                            <ul>
                                @foreach ($salaryStructure->detail_salary as $detail)
                                    <li>{{ $detail->benefit->nama_benefit }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal"></button> --}}
            </div>
        </div>
    </div>
</div>
