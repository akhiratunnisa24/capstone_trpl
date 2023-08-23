<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="Modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel">Tambah Data Benefit</h4>
            </div>
            <div class="modal-body">
                <form action="{{route ('benefit.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group col-sm">
                                    <label class="col-form-label">Nama</label>
                                    <input type="text" class="form-control" name="nama_benefit" placeholder="Masukkan Nama Benefit"  autocomplete="off">
                                </div>
                                <div class="form-group col-sm">
                                    <label class="col-form-label">Kode</label>
                                    <input type="text" class="form-control" name="kode" placeholder="Masukkan Kode" autocomplete="off" required>
                                </div>
                                <div class="form-group col-sm m-t-5" id="kategori_benefit">
                                    <label class="col-form-label">Kategori Benefit</label>
                                    <select name="id_kategori" id="id_kategori" style="height: 100px;" class="form-control selectpicker" data-live-search="true" required>
                                        <option>-- Pilih Kategori Benefit --</option>
                                        @foreach ($kategori as $data)
                                            <option value="{{ $data->id }}">
                                                {{ $data->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm" id="dibayarkanoleh">
                                    <label class="col-form-label">Dibayar Oleh</label>
                                    <select name="dibayarkan_oleh" class="form-control selectpicker" data-live-search="true">
                                        <option value="">-- Pilih --</option>
                                        <option value="Perusahaan">Perusahaan</option>
                                        <option value="Karyawan">Karyawan</option>
                                    </select>
                                </div>
                                {{-- <div class="form-group col-sm">
                                    <label for=""  class="col-form-label">Urutan</label>
                                    <input type="text" id="urutan" class="form-control" name="urutan" autocomplete="off" readonly>
                                </div> --}}
                                <div class="form-group col-sm">
                                    <div class="checkbox-group">
                                        <label class="col-form-label">Status</label>
                                        <div class="checkboxes">
                                            <input type="checkbox" name="aktif" value="Aktif" style="margin-left:100px"> Aktif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm">
                                    <div class="checkbox-group">
                                        <label class="col-form-label">Muncul Di Penggajian</label>
                                        <div class="checkboxes">
                                            <input type="checkbox" name="muncul_dipenggajian" value="Ya" style="margin-left:5px"> Ya
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group col-sm" id="siklus_pembayaran">
                                    <label  class="col-form-label">Tipe Pembayaran</label>
                                    <select name="siklus_pembayaran" class="form-control selectpicker" data-live-search="true" required>
                                        <option value="">-- Pilih Siklus --</option>
                                        <option value="Bulan">Bulan</option>
                                        <option value="Minggu">Minggu</option>
                                        <option value="Hari">Hari</option>
                                        <option value="Jam">Jam</option>
                                        <option value="THR">THR</option>
                                        <option value="Bonus">Bonus</option>
                                    </select> 
                                </div>
                                <div class="form-group col-sm" id="besaran_bulanan">
                                    <label   class="col-form-label">Nominal / Bulan</label>
                                    <input type="text" class="form-control input-format"  name="besaran_bulanan" placeholder="Masukkan Nominal" autocomplete="off">
                                </div>
                                <div class="form-group col-sm" id="besaran_mingguan">
                                    <label  class="col-form-label">Nominal / Minggu</label>
                                    <input type="text" class="form-control input-format"  name="besaran_mingguan" placeholder="Masukkan Nominal" autocomplete="off">
                                </div>
                                <div class="form-group col-sm"  id="besaran_harian">
                                    <label  class="col-form-label">Nominal / Hari</label>
                                    <input type="text" class="form-control input-format" name="besaran_harian" placeholder="Masukkan Nominal" autocomplete="off">
                                </div>
                                <div class="form-group col-sm"  id="besaran_jam">
                                    <label class="col-form-label">Nominal / Jam</label>
                                    <input type="text" class="form-control input-format" name="besaran_jam" placeholder="Masukkan Nominal" autocomplete="off">
                                </div>
                                <div class="form-group col-sm" id="besaran">
                                    <label class="col-form-label">Nominal </label>
                                    <input type="text" class="form-control input-format"  name="besaran" placeholder="Masukkan Nominal" autocomplete="off">
                                </div>
                                <div class="form-group col-sm">
                                    <label  class="col-form-label">Jumlah</label>
                                    <input type="text" id="jumlah" class="form-control" name="jumlah" autocomplete="off" required>
                                </div>
                                {{-- <div class="form-group col-sm">
                                    <div class="checkbox-group">
                                        <label for=""  class="col-form-label">Dikenakan Pajak </label>
                                        <div class="checkboxes">
                                            <input type="checkbox" name="dikenakan_pajak" value="Ya" style="margin-left:35px"> Ya
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm">
                                    <label  class="col-form-label">Kelas Pajak </label>
                                    <select name="kelas_pajak" class="form-control selectpicker" data-live-search="true">
                                        <option value="">-- Pilih Kelas Pajak --</option>
                                        <option value="Penghasilan Teratur">Penghasilan Teratur</option>
                                        <option value="Penghasilan Tidak Teratur">Penghasilan Tidak Teratur</option>
                                    </select> 
                                </div> --}}
                                <div class="form-group col-sm" id="tipekondisi">
                                    <label class="col-form-label">Tipe Kondisi</label>
                                    <select name="tipe" class="form-control selectpicker" data-live-search="true">
                                        <option value="">-- Pilih Tipe Kondisi --</option>
                                        <option value="Komponen Tetap">Komponen Tetap</option>
                                        <option value="Interval Gaji">Interval Gaji</option>
                                    </select> 
                                </div>

                                <div class="form-group col-sm" id="gajiminimum">
                                    <label  class="col-form-label">Gaji Minimum</label>
                                    <input type="text" class="form-control input-format"  name="gaji_minimum" placeholder="Masukkan Nominal Gaji" autocomplete="off">
                                </div>
                                <div class="form-group col-sm" id="gajimaksimum">
                                    <label  class="col-form-label">Gaji Maksimum</label>
                                    <input type="text" class="form-control input-format"  name="gaji_maksimum" placeholder="Masukkan Nominal Gaji" autocomplete="off">
                                </div>
                            </div>

                            <input id="partner" type="hidden" class="form-control" name="partner" value="{{Auth::user()->partner}}" autocomplete="off" >
                            
                        </div>
                        
                    </div>
                    <div class="modal-footer m-t-30">
                            <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-success waves-effect waves-light" name="submit"
                                value="save">Simpan</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/jquery.min.js"></script>

{{-- <script type="text/javascript">
   $('#id_kategori').on('change', function(k) {
        var id_kategori = k.target.value;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: '{{ route('getUrutanPotongan') }}',
            data: {
                'id_kategori': id_kategori
            },
            success: function(data) {
                $('#urutan').val(data.urutan);
            }
        });
    });
</script> --}}

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        const inputFormats = document.querySelectorAll('.input-format');
    
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

<script type="text/javascript">
    $(document).ready(function()
    {
        $('#gajiminimum').prop("hidden", true);
        $('#gajimaksimum').prop("hidden", true);

        $('#tipekondisi').on('change', function(d)
        {
            if (d.target.value == "Interval Gaji") 
            {
                $('#gajiminimum').prop("hidden", false);
                $('#gajimaksimum').prop("hidden", false);

                $('#gajiminimum input').prop("required", true);
                $('#gajimaksimum input').prop("required", true);
            }
            else
            {
                $('#gajiminimum').prop("hidden", true);
                $('#gajimaksimum').prop("hidden", true);

                $('#gajiminimum input').prop("required", false);
                $('#gajimaksimum input').prop("required", false);
            }
        });
    });

</script>

<script type="text/javascript">
    $(document).ready(function() 
    {
        $('#dibayarkanoleh').prop("hidden", true);

        $('#kategori_benefit select').on('change', function() {
            var id_kategori = this.value; 

            if (id_kategori === '5') 
            {
                $('#dibayarkanoleh').prop("hidden", false);
                $('#dibayarkanoleh select').prop('required', true);
            } 
            else 
            {
                $('#dibayarkanoleh').prop("hidden", true);
                $('#dibayarkanoleh select').prop('required', false);
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#besaran_bulanan').prop("hidden", true);
        $('#besaran_mingguan').prop("hidden", true);
        $('#besaran_harian').prop("hidden", true);
        $('#besaran_jam').prop("hidden", true);
        $('#besaran').prop("hidden", true);

        $('#siklus_pembayaran').on('change', function(e) 
        {
            if (e.target.value == "Bulan") 
            {
                $('#besaran_bulanan').prop("hidden", false);
                $('#besaran_mingguan').prop("hidden", true);
                $('#besaran_harian').prop("hidden", true);
                $('#besaran_jam').prop("hidden", true);
                $('#besaran').prop("hidden", true);

                $('#besaran_bulanan input').prop("required", true);
                $('#besaran_mingguan input').prop("required", false);
                $('#besaran_harian input').prop("required", false);
                $('#besaran_jam input').prop("required", false);
                $('#besaran input').prop("required", false);
            } 
            else if (e.target.value == "Minggu") 
            {
                $('#besaran_bulanan').prop("hidden", true);
                $('#besaran_mingguan').prop("hidden", false);
                $('#besaran_harian').prop("hidden", true);
                $('#besaran_jam').prop("hidden", true);
                $('#besaran').prop("hidden", true);

                $('#besaran_bulanan input').prop("required", false);
                $('#besaran_mingguan input').prop("required", true);
                $('#besaran_harian input').prop("required", false);
                $('#besaran_jam input').prop("required", false);
                $('#besaran input').prop("required", false);
            } 
            else if (e.target.value == "Hari") 
            {
                $('#besaran_bulanan').prop("hidden", true);
                $('#besaran_mingguan').prop("hidden", true);
                $('#besaran_harian').prop("hidden", false);
                $('#besaran_jam').prop("hidden", true);
                $('#besaran').prop("hidden", true);

                $('#besaran_bulanan input').prop("required", false);
                $('#besaran_mingguan input').prop("required", false);
                $('#besaran_harian input').prop("required", true);
                $('#besaran_jam input').prop("required", false);
                $('#besaran input').prop("required", false);
            }
            else if (e.target.value == "Jam") 
            {
                $('#besaran_bulanan').prop("hidden", true);
                $('#besaran_mingguan').prop("hidden", true);
                $('#besaran_harian').prop("hidden", true);
                $('#besaran_jam').prop("hidden", false);
                $('#besaran').prop("hidden", true);

                $('#besaran_bulanan input').prop("required", false);
                $('#besaran_mingguan input').prop("required", false);
                $('#besaran_harian input').prop("required", false);
                $('#besaran_jam input').prop("required", true);
                $('#besaran input').prop("required", false);
            }  
            else 
            {
                $('#besaran_bulanan').prop("hidden", true);
                $('#besaran_mingguan').prop("hidden", true);
                $('#besaran_harian').prop("hidden", true);
                $('#besaran_jam').prop("hidden", true);
                $('#besaran').prop("hidden", false);

                $('#besaran_bulanan input').prop("required", false);
                $('#besaran_mingguan input').prop("required", false);
                $('#besaran_harian input').prop("required", false);
                $('#besaran_jam input').prop("required", false);
                $('#besaran input').prop("required", true);
            }
        });
    });
</script>