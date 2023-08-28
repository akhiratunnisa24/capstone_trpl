<div class="modal fade" id="showModal{{ $salaryStructure->id }}" tabindex="-1" role="dialog" aria-labelledby="ModalShowSalary">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center" id="ModalShowSalary">Detail Struktur Penggajian</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                           
                                <div class="mb-3">
                                    <div class="row">
                                        <label class="form-label col-sm-5 text-end">Nama Struktur</label>
                                        <div class="col-sm-7">
                                            : {{ $salaryStructure->nama }}
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <label class="form-label col-sm-5 text-end">Level Jabatan</label>
                                        <div class="col-sm-7">
                                            : {{ $salaryStructure->level_jabatans->nama_level }}
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <label class="form-label col-sm-5 text-end">Jenis Status Karyawan</label>
                                        <div class="col-sm-7">
                                            : {{ $salaryStructure->status_karyawan }}
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <label class="form-label col-sm-4 text-end">Komponen Gaji</label>
                                        <div class="col-sm-6">
                                            <ul style="margin-left:20px">
                                                @foreach ($salaryStructure->detail_salary as $detail)
                                                    <li>{{ $detail->benefit->nama_benefit }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
