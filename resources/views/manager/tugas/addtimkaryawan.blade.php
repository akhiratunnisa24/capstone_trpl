{{-- FORM TAMBAH KATEGORI CUTI --}}
<style>
    .col-form-label{
        -webkit-text-fill-color: black;
    }
</style>
<div class="modal fade" id="Modaltimk" tabindex="-1" role="dialog" aria-labelledby="Modal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel">Tambah Data Tim</h4>
            </div>
            <div class="modal-body">
                <form action="{{route ('timkaryawan.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-group col-sm">
                        <label for="id_tim" class="col-form-label">Nama Tim</label>
                        <select name="id_tim" id="id_tim" class="form-control" required>
                            <option>-- Pilih Tim --</option>
                            @foreach ($tim as $data)
                                    <option value="{{ $data->id}}">
                                       {{ $data->namatim }} 
                                    </option>
                            @endforeach
                        </select> 
                    </div>
                    <div class="form-group col-sm">
                        <label for="id_karyawan" class="col-form-label">Karyawan</label>
                        <select name="id_karyawan" id="id_karyawan" class="form-control" required>
                            <option>-- Pilih Karyawan--</option>
                            @foreach ($karyawan as $data)
                                    <option value="{{ $data->id}}">
                                       {{ $data->nama }} 
                                    </option>
                            @endforeach
                        </select> 
                    </div>
                    {{-- <div class="form-group col-sm">
                        <label for="nik" class="col-form-label">NIK Karyawan</label>
                        <input type="text" class="form-control" name="nik" id="niks" autocomplete="off" disabled>
                        <input type="hidden" class="form-control" name="nik" id="nik" autocomplete="off" required>
                    </div> --}}
                    <div class="form-group col-sm">
                        <label for="divisi" class="col-form-label">Departemen</label>
                        <input type="text" class="form-control" name="divisis" id="divisis" value="{{$departemen->nama_departemen}}" autocomplete="off" disabled>
                        <input type="hidden" class="form-control" name="divisi" id="divisi" value="{{$departemen->id}}" autocomplete="off" required>
                    </div>
        
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" name="submit" value="save" class="btn btn-success waves-effect waves-light">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    {{-- <script src="assets/js/jquery.min.js"></script>
    <script>
        $('#id_karyawan').on('change', function(e) {
            var id_karyawan = e.target.value;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                        .attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: '{{ route('get.nik') }}',
                data: {
                    'id_karyawan': id_karyawan
                },
                success: function(data) {
                    $('#nik').val(data.nip);
                    $('#niks').val(data.nip);
                }
            });
        });
    </script> --}}

