{{-- FORM TAMBAH JOBS --}}
<div class="modal fade" id="addJob" tabindex="-1" role="dialog" aria-labelledby="addJob" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel">Tambah Master Baru</h4>
            </div>
            <div class="modal-body">
                {{-- {{route ('job.store')}} --}}
                <form action=" {{route ('master.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-group col-sm">
                        <label for="" class="col-form-label">Departemen</label>
                        <select class="form-control selectpicker" name="id_departemen" id="id_departemen" autocomplete="off" data-live-search="true">
                            <option value="">Pilih Departemen</option>
                            @foreach ($departemen as $dep)
                                <option value="{{ $dep->id }}">{{ $dep->nama_departemen }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm">
                        <label for="" class="col-form-label">Nama Master</label>
                        <input type="text" class="form-control" name="nama_master" id="nama_master" autocomplete="off"
                            placeholder="Masukkan Master Baru" required>
                    </div>
                    {{-- <div class="form-group col-sm">
                        <label for="" class="col-form-label">Bobot ( % )</label>
                        <input type="text" class="form-control" name="bobot" id="bobot" autocomplete="off" placeholder="Masukkan Bobot" required>
                    </div>
                    <div class="form-group col-sm">
                        <label for="" class="col-form-label">Target</label>
                        <input type="text" class="form-control" name="target" id="target" autocomplete="off" placeholder="Masukkan Target" required>
                    </div> --}}

                    <div class="row">
                        <div class="col-sm-6 col-xs-12">
                            <div class="m-t-10">
                                    <div class="form-group">
                                        <label for="tgl_mulai" class="form-label">Tanggal Aktif</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="dd/mm/yyyy" id="datepicker-autoclosej" name="tglaktif"  autocomplete="off" rows="10" required readonly>
                                            <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                        </div>
                                    </div>

                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="m-t-10">
                                    <div class="form-group">
                                        <label for="tgl_selesai" class="form-label">Tanggal Berakhir</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="dd/mm/yyyy" id="datepicker-autoclosek" name="tglberakhir"  autocomplete="off" rows="10" required readonly>
                                            <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                        </div>
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
<!-- jQuery  -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="assets/pages/form-advanced.js"></script>
