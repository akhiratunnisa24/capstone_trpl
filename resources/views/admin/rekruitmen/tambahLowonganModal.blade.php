<!-- MODAL BEGIN -->

<!-- sample modal content -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title text-center" id="myModalLabel">Tambah Lowongan Pekerjaan</h4>


            <div class="modal-body">

                <form method="POST" action="{{ url('store_rekrutmen') }}" onsubmit="return validateForm()">
                    @csrf
                    @method('POST')

                    <div class="form-group col-xs-12">
                        <label class="form-label">Posisi</label>
                        <input type="text" class="form-control" name="posisi" placeholder="Masukkan posisi"
                            required>
                    </div>

                    <div class="form-group col-xs-12">
                        <label for="roles">Pilih Tahapan</label>
                        @foreach ($metode as $m)
                            <div class="checkbox checkbox-success">
                                <input type="checkbox" name="checkbox[]" value="1">
                                <input type="checkbox" id="checkbox{{ $loop->iteration }}" class="form-check-input"
                                    name="tahapan[]" value="{{ $m->id }}">
                                <label for="checkbox{{ $loop->iteration }}">
                                    {{ $m->nama_tahapan }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    {{-- <div class="form-group col-xs-12">
                        <label for="roles">Pilih Tahapan</label>
                        <label for="urutan" class="pull-right">Urutan</label>
                        <div class="clearfix"></div>
                        @foreach ($metode as $m)    
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p>{{ $m->nama_tahapan }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        @if ($m->id == 1)
                                            <input type="text" id="tahapan{{ $m->id }}" class="form-control" name="tahapan[{{ $m->id }}]" value="{{ $m->id == 1 ? 1 : '' }}" readonly>
                                        @else
                                            <input type="number" id="tahapan{{ $m->id }}" class="form-control" name="tahapan[{{ $m->id }}]">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div> --}}


                    <div class="form-group col-xs-12">
                        <label class="form-label">Jumlah Dibutuhkan</label>
                        <input type="number" class="form-control " name="jumlah_dibutuhkan"
                            placeholder="Masukkan jumlah dibutuhkan" required>
                    </div>

                    <div class="form-group col-xs-12">
                        <label class="form-label">Periode Lamaran</label>
                        <div>
                            <div class="input-daterange input-group" id="date-range">
                                <input type="text" class="form-control" name="tglmulai" autocomplete="off" required/>
                                <span class="input-group-addon bg-primary text-white b-0">To</span>
                                <input type="text" class="form-control" name="tglselesai" autocomplete="off" required/>
                            </div>
                        </div>
                    </div>


                    <div class="form-group col-xs-12">
                        <label class="form-label">Persyaratan</label>
                        <textarea type="text" class="form-control " rows="9" name="persyaratan" placeholder="Masukkan Persyaratan"
                            required></textarea>
                        <input type="hidden" class="form-control " name="partner" value="{{Auth::user()->partner}}">
                    </div>




                    {{-- {{-- <div class="form-group"> --}}
                    <div class="col-xs-12">
                        <div class="checkbox checkbox-primary">

                        </div>
                    </div>

                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Simpan</button>
                        </div>
                    </div>

                </form>


                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button> --}}
                    <!-- <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Register</button> -->
                </div>

            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<script>
    function validateForm() {
        var checkboxes = document.getElementsByName('tahapan[]');
        var checkboxChecked = false;

        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                checkboxChecked = true;
                break;
            }
        }

        // if (!checkboxChecked) {
        //     alert('Harus memilih minimal 1 tahapan');
        //     return false;
        // }

        return true;
    }
</script>

<!-- END MODAL -->
