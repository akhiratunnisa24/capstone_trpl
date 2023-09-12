<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<div class="modal fade bs-example-modal-lg" id="editPekerjaan{{$rpekerjaan->id}}" tabindex="-1" role="dialog" aria-labelledby="editIdentitas" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">Edit Data Riwayat Pengalaman Bekerja</h4>
            </div>
            <div class="modal-body">
                <form id="formModaleditcuti" action="/updatePekerjaan/{{$rpekerjaan->id}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 m-t-10">
                            <input type="hidden" name="id_pekerjaan" value="{{$rpekerjaan->id}}">
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Nama Perusahaan</label>
                                    <input type="text" name="namaPerusahaan" autocomplete="off"
                                    class="form-control" value="{{$rpekerjaan->nama_perusahaan}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Alamat Perusahaan</label>
                                    <input type="text" name="alamatPerusahaan" autocomplete="off"
                                    class="form-control" value="{{$rpekerjaan->alamat}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label class="form-label">Lama Kerja</label>
                                    <div>
                                        <div class="input-group">
                                            <input id="datepicker-autoclose-format-i" type="text" class="form-control" placeholder="mm/yyyy" 
                                                name="tglmulai" autocomplete="off"  rows="10"  value="{{$rpekerjaan->tgl_mulai}}">
                                            <span class="input-group-addon bg-primary text-white b-0">To</span>
                                            <input id="datepicker-autoclose-format-j" type="text" class="form-control" placeholder="mm/yyyy" 
                                                name="tglselesai" autocomplete="off"  rows="10" value="{{$rpekerjaan->tgl_selesai}}">
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="form-group">
                                <div class="mb-3">
                                    <label>Jabatan</label>
                                    <input type="text" name="jabatan" class="form-control" autocomplete="off"
                                    value="{{$rpekerjaan->jabatan}}">
                                </div>
                            </div>
                            </div>
                        </div>

                        <!-- baris sebelah kanan  -->
                        <div class="col-md-6 m-t-10">
                            
                            <div class="form-group">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label"> Level/Pangkat/Golongan</label>
                                    <input type="text" name="levelRpekerjaan" class="form-control"
                                        id="exampleInputEmail1" aria-describedby="emailHelp"
                                        placeholder="Masukkan Jabatan" autocomplete="off" value="{{$rpekerjaan->level}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Gaji</label>
                                    <input type="text" name="gajiRpekerjaan" id="gaji" autocomplete="off"
                                    class="form-control" value="{{$rpekerjaan->gaji}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Alasan Berhenti</label>
                                    <input type="text" name="alasanBerhenti" autocomplete="off"
                                    class="form-control" value="{{$rpekerjaan->alasan_berhenti}}">
                                </div>
                            </div>
                        </div>
                    </div>
            
                    <div class="modal-footer">
                        <input type="hidden" name="id" id="id">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/pages/form-advanced.js"></script>

    <script>
        var rupiah = document.getElementById('gaji');
        rupiah.addEventListener('keyup', function(e){
            // tambahkan 'Rp.' pada saat form di ketik
            // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
            rupiah.value = formatRupiah(this.value);
        });
        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix){
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split   		= number_string.split(','),
            sisa     		= split[0].length % 3,
            rupiah     		= split[0].substr(0, sisa),
            ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if(ribuan){
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
        }
    </script>