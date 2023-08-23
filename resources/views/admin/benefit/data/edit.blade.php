<div class="modal fade" id="edit{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="Modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel">Edit Data Benefit</h4>
            </div>
            <div class="modal-body">
                <form action="/benefi/update/{{$data->id}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group col-sm">
                                    <label class="col-form-label">Nama</label>
                                    <input type="text" class="form-control" value="{{$data->nama_benefit}}" name="nama_benefit" placeholder="Masukkan Nama Benefit"  autocomplete="off">
                                </div>
                                <div class="form-group col-sm">
                                    <label class="col-form-label">Kode</label>
                                    <input type="text" class="form-control" name="kode" value="{{$data->kode}}" placeholder="Masukkan Kode" autocomplete="off">
                                </div>
                                <div class="form-group col-sm" id="kategori_benefits">
                                    <label  class="col-form-label">Kategori Benefit</label>
                                    <select name="id_kategori" id="id_kategori" class="form-control" data-live-search="true">
                                        <option>-- Pilih Kategori Benefit --</option>
                                        @foreach ($kategori as $kategoriData)
                                            <option value="{{ $kategoriData->id }}" @if($data->id_kategori == $kategoriData->id) selected @endif>
                                                {{ $kategoriData->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select> 
                                </div>
                                
                                @if($data->id_kategori == 5)
                                    <div class="form-group col-sm" id="dibayarkan_olehh">
                                        <label class="col-form-label">Dibayar Oleh</label>
                                        <select name="dibayarkan_oleh" id="dibayarkan_oleh" class="form-control" data-live-search="true">
                                            <option value="">-- Pilih --</option>
                                            <option value="Perusahaan" @if($data->dibayarkan_oleh == 'Perusahaan') selected @endif>Perusahaan</option>
                                            <option value="Karyawan" @if($data->dibayarkan_oleh == 'Karyawan') selected @endif>Karyawan</option>
                                        </select>
                                    </div>
                                @endif

                                <div class="form-group col-sm">
                                    <div class="checkbox-group">
                                        <label class="col-form-label">Status</label>
                                        <div class="checkboxes">
                                            @if($data->aktif == "Aktif")
                                                <input type="checkbox" name="aktif" value="Aktif" style="margin-left:96px" @if($data->aktif) checked @endif> Aktif
                                            @else
                                                <input type="checkbox" name="aktif" value="" style="margin-left:96px"> Aktif
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-sm m-b-30">
                                    <div class="checkbox-group">
                                        <label class="col-form-label">Muncul Di Penggajian</label>
                                        <div class="checkboxes">
                                            @if($data->muncul_dipenggajian == "Ya")
                                            <input type="checkbox" name="muncul_dipenggajian" value="Ya" @if($data->muncul_dipenggajian) checked @endif> Ya
                                            @else 
                                                <input type="checkbox" name="muncul_dipenggajian" value="Ya" style="margin-left:35px"> Ya
                                            @endif
                                           
                                        </div>
                                    </div>
                                </div>  
                            </div>

                            <div class="col-md-6">
                            
                                {{-- <div class="form-group col-sm">
                                    <div class="checkbox-group">
                                        <label class="col-form-label">Dikenakan Pajak</label>
                                        <div class="checkboxes">
                                            @if($data->dikenakan_pajak == "Ya")
                                                <input type="checkbox" name="dikenakan_pajak" value="Ya" style="margin-left:35px" @if($data->dikenakan_pajak) checked @endif> Aktif
                                            @else 
                                                <input type="checkbox" name="dikenakan_pajak" value="Ya" style="margin-left:35px"> Ya
                                            @endif
                                           
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm">
                                    <label class="col-form-label">Kelas Pajak</label>
                                    <select name="kelas_pajak" class="form-control selectpicker" data-live-search="true">
                                        <option value="">-- Pilih Kelas Pajak --</option>
                                        <option value="Penghasilan Teratur" @if($data->kelas_pajak == 'Penghasilan Teratur') selected @endif>Penghasilan Teratur</option>
                                        <option value="Penghasilan Tidak Teratur" @if($data->kelas_pajak == 'Penghasilan Tidak Teratur') selected @endif>Penghasilan Tidak Teratur</option>
                                    </select>
                                </div> --}}
                                <div class="form-group col-sm" id="siklus_pembayarans">
                                    <label  class="col-form-label">Tipe Pembayaran</label>
                                    <select name="siklus_pembayaran" class="form-control" data-live-search="true">
                                        <option value="">-- Pilih Siklus --</option>
                                        <option value="Bulan" @if($data->siklus_pembayaran == 'Bulan') selected @endif>Bulan</option>
                                        <option value="Minggu" @if($data->siklus_pembayaran == 'Minggu') selected @endif>Minggu</option>
                                        <option value="Hari" @if($data->siklus_pembayaran == 'Hari') selected @endif>Hari</option>
                                        <option value="Jam" @if($data->siklus_pembayaran == 'Jam') selected @endif>Jam</option>
                                        <option value="THR" @if($data->siklus_pembayaran == 'THR') selected @endif>THR</option>
                                        <option value="Bonus" @if($data->siklus_pembayaran == 'Bonus') selected @endif>Bonus</option>
                                    </select>                                    
                                </div>
                                @if($data->siklus_pembayaran == 'Bulan')
                                    <div class="form-group col-sm" id="besaran_bulanans">
                                        <label class="col-form-label">Nominal / Bulan</label>
                                        <input type="text" class="form-control input-formats"  name="besaran_bulanan" value="{{ number_format($data->besaran_bulanan, 0, ',', '.') }}" placeholder="Masukkan Nominal" autocomplete="off">
                                    </div>
                                @endif
                                @if($data->siklus_pembayaran == 'Minggu' || $request->siklus_pembayaran == 'Minggu') 
                                    <div class="form-group col-sm" id="besaran_mingguans">
                                        <label class="col-form-label">Nominal / Minggu</label>
                                        <input type="text" class="form-control input-formats"  name="besaran_mingguan" value="{{number_format($data->besaran_mingguan, 0, ',', '.')}}" placeholder="Masukkan Nominal" autocomplete="off">
                                    </div>
                                @endif
                                @if($data->siklus_pembayaran == 'Hari')
                                    <div class="form-group col-sm"  id="besaran_harians">
                                        <label class="col-form-label">Nominal / Hari</label>
                                        <input type="text" class="form-control input-formats" name="besaran_harian" value="{{number_format($data->besaran_harian, 0, ',', '.')}}" placeholder="Masukkan Nominal" autocomplete="off">
                                    </div>
                                @endif
                                @if($data->siklus_pembayaran == 'Jam')
                                    <div class="form-group col-sm"  id="besaran_jams">
                                        <label class="col-form-label">Nominal / Jam</label>
                                        <input type="text" class="form-control input-formats" name="besaran_jam" value="{{number_format($data->besaran_jam, 0, ',', '.')}}" placeholder="Masukkan Nominal" autocomplete="off">
                                    </div>
                                @endif
                                @if($data->siklus_pembayaran == 'THR')
                                    <div class="form-group col-sm" id="besarans">
                                        <label class="col-form-label">Nominal </label>
                                        <input type="text" class="form-control input-formats"  name="besaran" value="{{number_format($data->besaran, 0, ',', '.')}}" placeholder="Masukkan Nominal" autocomplete="off">
                                    </div>
                                @endif

                                @if($data->siklus_pembayaran == 'Bonus')
                                    <div class="form-group col-sm" id="besarans">
                                        <label class="col-form-label">Nominal </label>
                                        <input type="text" class="form-control input-formats"  name="besaran" value="{{number_format($data->besaran, 0, ',', '.')}}" placeholder="Masukkan Nominal" autocomplete="off">
                                    </div>
                                @endif

                                <div class="form-group col-sm">
                                    <label  class="col-form-label">Jumlah</label>
                                    <input type="text" id="jumlah" class="form-control" name="jumlah" value="{{$data->jumlah}}" autocomplete="off" required>
                                </div>

                                <div class="form-group col-sm" id="tipe_kondisis">
                                    <label class="col-form-label">Tipe Kondisi</label>
                                    <select name="tipe" id="tipe_kondisi" class="form-control" data-live-search="true">
                                        <option value="">-- Pilih Tipe Kondisi --</option>
                                        <option value="Komponen Tetap" @if($data->tipe == 'Komponen Tetap') selected @endif>Komponen Tetap</option>
                                        <option value="Interval Gaji" @if($data->tipe == 'Interval Gaji') selected @endif>Interval Gaji</option>
                                    </select>
                                </div>

                                @if($data->tipe === "Interval Gaji")
                                    <div class="form-group col-sm" id="gaji_minimums">
                                        <label  class="col-form-label">Gaji Minimum</label>
                                        <input type="text" id="gaji_minimum" class="form-control input-format"  value="{{number_format($data->gaji_minimum, 0, ',', '.')}}" name="gaji_minimum" placeholder="Masukkan Nominal Gaji" autocomplete="off">
                                    </div>
                                    <div class="form-group col-sm" id="gajimaksimums">
                                        <label  class="col-form-label">Gaji Maksimum</label>
                                        <input type="text" id="gaji_maksimum" class="form-control input-format"  value="{{number_format($data->gaji_maksimum, 0, ',', '.')}}" name="gaji_maksimum" placeholder="Masukkan Nominal Gaji" autocomplete="off">
                                    </div>
                                @else

                                @endif

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


<script type="text/javascript">
    $(document).ready(function() 
    {
        $('#dibayarkan_olehh').prop("hidden", false);

        $('#kategori_benefits select').on('change', function() {
            var idkategori = this.value; 
            if (idkategori === '5') 
            {
                $('#dibayarkan_olehh').prop("hidden", false);
                $('#dibayarkan_olehh select').prop('required', true);
            } 
            else 
            {
                $('#dibayarkan_olehh').prop("hidden", true);
                $('#dibayarkan_olehh select').prop('required', false);
            }
        });

        //untuk tipe kemunculan interval gaji
        $('#gaji_minimums').prop("hidden", false);
        $('#gaji_maksimums').prop("hidden", false);

        $('#tipe_kondisis select').on('change', function()
        {
            var tipe = this.value;
            if (tipe === 'Interval Gaji') 
            {
                $('#gaji_minimums').prop("hidden", true);
                $('#gaji_maksimums').prop("hidden", false);
            }
            else
            {
                $('#gaji_minimums').prop("hidden", false);
                $('#gaji_maksimums').prop("hidden", true);
            }
        });
    });
</script>


<script type="text/javascript">
    $(document).ready(function()
    {
        $('#besaran_bulanans').prop("hidden", false);
        $('#besaran_mingguans').prop("hidden", false);
        $('#besaran_harians').prop("hidden", false);
        $('#besaran_jams').prop("hidden", false);
        $('#besarans').prop("hidden", false);

        $('#siklus_pembayarans select').on('change', function() 
        {
            var siklus = this.value;

            $('#besaran_bulanans').toggle(siklus === "Bulan");
            $('#besaran_mingguans').toggle(siklus === "Minggu");
            $('#besaran_harians').toggle(siklus === "Hari");
            $('#besaran_jams').toggle(siklus === "Jam");
            $('#besarans').toggle(siklus === "THR" || siklus === "Bonus");
        });
    })
</script>


{{-- <script type="text/javascript">
    $(document).ready(function()
    {

        $('#besaran_bulanans').prop("hidden", false);
        $('#besaran_mingguans').prop("hidden", false);
        $('#besaran_harians').prop("hidden", false);
        $('#besaran_jams').prop("hidden", false);
        $('#besarans').prop("hidden", false);

        $('#siklus_pembayarans select').on('change', function() 
        {
            var siklus = this.value; // Menggunakan this.value
            console.log("siklus selected:", siklus);
            if (siklus == "Bulan") 
            {
                $('#besaran_bulanans').prop("hidden", false);
                $('#besaran_mingguans').prop("hidden", true);
                $('#besaran_harians').prop("hidden", true);
                $('#besaran_jams').prop("hidden", true);
                $('#besarans').prop("hidden", true);

            } 
            else if (siklus == "Minggu") 
            {
                $('#besaran_bulanans').prop("hidden", true);
                $('#besaran_mingguans').prop("hidden", false);
                $('#besaran_harians').prop("hidden", true);
                $('#besaran_jams').prop("hidden", true);
                $('#besarans').prop("hidden", true);

            } 
            else if (siklus == "Hari") 
            {
                $('#besaran_bulanans').prop("hidden", true);
                $('#besaran_mingguans').prop("hidden", true);
                $('#besaran_harians').prop("hidden", false);
                $('#besaran_jams').prop("hidden", true);
                $('#besarans').prop("hidden", true);

            }
            else if (siklus == "Jam") 
            {
                $('#besaran_bulanans').prop("hidden", true);
                $('#besaran_mingguans').prop("hidden", true);
                $('#besaran_harians').prop("hidden", true);
                $('#besaran_jams').prop("hidden", false);
                $('#besarans').prop("hidden", true);

            }  
            else if (siklus == "THR") 
            {
                $('#besaran_bulanans').prop("hidden", true);
                $('#besaran_mingguans').prop("hidden", true);
                $('#besaran_harians').prop("hidden", true);
                $('#besaran_jams').prop("hidden", true);
                $('#besarans').prop("hidden", false);

            }
            else 
            {
                $('#besaran_bulanans').prop("hidden", true);
                $('#besaran_mingguans').prop("hidden", true);
                $('#besaran_harians').prop("hidden", true);
                $('#besaran_jams').prop("hidden", true);
                $('#besarans').prop("hidden", false);

            }
        });
    })
</script> --}}