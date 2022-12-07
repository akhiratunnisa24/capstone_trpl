@extends('layouts.default')
@section('content')
<!-- Header -->
    <div class="row">
        <div class="col-lg-12">
            <ul class="nav nav-tabs navtab-bg">
                <li class="active">
                    <a id="tab1" href="#kategori_cuti" data-toggle="tab" aria-expanded="false">
                        <span class="visible-xs"><i class="fa fa-home"></i></span>
                        <span class="hidden-xs">Kategori Cuti</span>
                    </a>
                </li>
                <li class="">
                    <a id="tab2" href="#kategori_izin" data-toggle="tab" aria-expanded="true">
                        <span class="visible-xs"><i class="fa fa-user"></i></span>
                        <span class="hidden-xs">Kategori Izin</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                {{-- LIST CUTI --}}
                <div class="tab-pane active" id="kategori_cuti">
                    <!-- Start content -->
                    <div class="content">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <strong>Kategori Cuti</strong>
                                            <a href="" class="btn btn-sm btn-dark" data-toggle="modal" data-target="#Modal">Tambah Kategori Cuti</a>
                                        </div>
                                        {{-- MODALS TAMBAH KATEGORI CUTI --}}
                                        @include('admin.kategori.addcuti')
                                        <div class="panel-body m-b-5">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <table id="datatable-responsive" class="table dt-responsive nowrap table-striped table-bordered" cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">No.</th>
                                                                <th scope="col">Kategori Cuti</th>
                                                                <th scope="col">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($jeniscuti as $data)
                                                                <tr>
                                                                    <td>{{$loop->iteration}}</td>
                                                                    <td>{{$data->jenis_cuti}}</td>
                                                                    <td class="text-center" > 
                                                                        <form action="" method="POST"> 
                                                                            <a id="bs" class="btn btn-info btn-sm Modalshowcuti" data-toggle="modal" data-target="#Modalshowcuti{{$data->id}}">
                                                                                <i class="fa fa-eye"></i>
                                                                            </a> 
                                                                            <a id="bs" class="btn btn-success btn-sm Modaleditcuti" data-toggle="modal" data-target="#Modaleditcuti{{$data->id}}">
                                                                                <i class="fa fa-edit"></i>
                                                                            </a> 

                                                                            @csrf 
                                                                            @method('DELETE') 
                                                                            <button id="bs" type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                                                <i class="fa fa-trash"></i>
                                                                            </button> 
                                                                        </form> 
                                                                    </td> 
                                                                </tr>
                                                                {{-- modals show cuti --}}
                                                                @include('admin.kategori.showcuti')
                                                                {{-- modals update cuti --}}
                                                                @include('admin.kategori.editcuti')
                                                             @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- End Row -->
                        </div> <!-- container -->
                    </div> <!-- content -->
                </div>
                {{-- END CUTI --}}

                {{-- LIST IZIN --}}
                <div class="tab-pane" id="kategori_izin">
                    {{-- Start content --> --}}
                    <div class="content">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <strong>Kategori Izin</strong>
                                            <a href="" class="btn btn-sm btn-dark" data-toggle="modal" data-target="#smallModal">Tambah Kategori Izin</a>
                                            {{-- </div> --}}
                                        </div>
                                        {{-- MODALS TAMBAH KATEGORI IZIN --}}
                                        @include('admin.kategori.addizin')
                                        <div class="panel-body m-b-5">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <table id="datatable-responsive1" class="table dt-responsive nowrap table-striped table-bordered" cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">No.</th>
                                                                <th scope="col">Kategori Izin</th>
                                                                <th scope="col">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($jenisizin as $data)
                                                                <tr>
                                                                    <td>{{$loop->iteration}}</td>
                                                                    <td>{{$data->jenis_izin}}</td>
                                                                    <td class="text-center"> 
                                                                            {{-- {{ route('posts.edit',$post->id) }} --}}
                                                                        <form action="" method="POST" id="bs"> 
                                                                                <a id="bs" class="btn btn-info btn-sm Modalshowizin" data-toggle="modal" data-target="#Modalshowizin{{$data->id}}">
                                                                                    <i class="fa fa-eye"></i>
                                                                                </a> 
                                                                                <a id="bs" class="btn btn-sm btn-success Modaleditizin" data-toggle="modal" data-target="#Modaleditizin{{$data->id}}">
                                                                                    <i class="fa fa-edit"></i>
                                                                                </a> 
                                                                                @csrf 
                                                                                @method('DELETE') 
                                                                                <button id="bs" type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                                                    <i class="fa fa-trash"></i>
                                                                                </button> 
                                                                        </form> 
                                                                    </td> 
                                                                </tr>
                                                                {{-- modals show izin --}}
                                                                @include('admin.kategori.showizin')
                                                                {{-- modals update izin --}}
                                                                @include('admin.kategori.editizin')
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- End Row -->
                        </div> <!-- container -->
                    </div> <!-- content -->
                </div>
                {{-- END IZIN --}}
            </div>
        </div>
    </div>

    <!-- jQuery  -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/modernizr.min.js"></script>
    <script src="assets/js/detect.js"></script>
    <script src="assets/js/fastclick.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/jquery.blockUI.js"></script>
    <script src="assets/js/waves.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>

    <!-- Datatables-->
    <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.bootstrap.js"></script>
    <script src="assets/plugins/datatables/dataTables.buttons.min.js"></script>
    <script src="assets/plugins/datatables/buttons.bootstrap.min.js"></script>
    <script src="assets/plugins/datatables/jszip.min.js"></script>
    <script src="assets/plugins/datatables/pdfmake.min.js"></script>
    <script src="assets/plugins/datatables/vfs_fonts.js"></script>
    <script src="assets/plugins/datatables/buttons.html5.min.js"></script>
    <script src="assets/plugins/datatables/buttons.print.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.fixedHeader.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.keyTable.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.responsive.min.js"></script>
    <script src="assets/plugins/datatables/responsive.bootstrap.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.scroller.min.js"></script> 
    <!-- Datatable init js -->
    <script src="assets/pages/datatables.init.js"></script>
    <script src="assets/js/app.js"></script>
    <script src="{{ asset('public/assets/js/jquery-3.1.1.min.js') }}"></script>
    <!-- sweet alert -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <!-- jangan lupa menambahkan script js sweet alert di bawah ini  -->
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>


    {{-- Direct halaman tambah data --}}
    <script type="text/javascript">
        function cuti(id){
            swal.fire({
                title:"Apakah anda yakin?",
                text: "Data yang sudah terhapus tidak dapat dikembalikan kembali",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "Ya, hapus!",
                closeOnConfirm: false
            }).then((result) => {
                if (result.isConfirmed) {
                    swal.fire({
                        title : "Terhapus!",
                        text: "Data berhasil di hapus..",
                        icon: "success",
                        confirmButtonColor: '#3085d6',
                    })
                    location.href = '<?= "http://localhost:8000/kategoridelete" ?>' + id;
                }
            })
        }

        let tp = `{{$type}}`;
        if(tp == 1) {
            $('#tab1').click();
        } else {
            $('#tab2').click();
        }
    </script>
     <?php if(@$_SESSION['sukses']){ ?>
        <script>
            swal.fire("Good job!", "<?php echo $_SESSION['sukses']; ?>", "success");
        </script>
    <!-- jangan lupa untuk menambahkan unset agar sweet alert tidak muncul lagi saat di refresh -->
    
    <?php unset($_SESSION['sukses']); } ?>
                   
@endsection