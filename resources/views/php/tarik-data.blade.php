@extends('layouts.default')

@section('content')
<link rel="stylesheet" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.css">
<link rel="stylesheet" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">
<!-- Header -->
    {{-- <H3>Download Log Data</H3> --}}

    <!-- <php
    $IP=$HTTP_GET_VARS["ip"];
    $Key=$HTTP_GET_VARS["key"];
    if($IP=="") $IP="192.168.1.201";
    if($Key=="") $Key="0";
    ?> -->

    @php
        $IP = "192.168.100.51";
        $Key = "0";
        if($IP == "") $IP = "192.168.100.51";
        if($Key== "") $Key="0";
    @endphp

    <div class="row">
        <div class="col-sm-12">

            <div class="page-header-title">
                <h4 class="pull-left page-title">Download Log Data</h4>

                <ol class="breadcrumb pull-right">
                    <li>Human Resources Management System</li>
                    <li class="active">Download Log Data</li>
                </ol>

                <div class="clearfix">
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <form method="POST" action="{{ route('tarikdata.download') }}">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-5 m-t-5">
                                        <label for="ip">IP Address:</label>
                                        <input type="text" name="ip" id="ip" value="{{ $IP }}" class="form-control" size="15">
                                    </div>
                    
                                    <div class="form-group col-md-5 m-t-5">
                                        <label for="key">Comm Key:</label>
                                        <input type="text" name="key" id="key" class="form-control" size="5" value="{{ $Key }}">
                                    </div>
                                    <div class="form-group col-md-2 align-self-center m-t-30">
                                        <input type="submit" value="Download" class="btn btn-primary btn-sm" style="margin-right:0px; height:36px;">
                                    </div>
                                </div>
                            </form>

                            {{-- @if ($IP != "")  --}}
                            @if(isset($logData))
                                <table  id="datatable-responsive40" class="table table-striped table-bordered m-t-20" cellspacing="0" width="100%">
                                    <thead>
                                        <tr align="center">
                                            <td><B>UserID</B></td>
                                            <td width="200"><B>Tanggal & Jam</B></td>
                                            <td><B>Verifikasi</B></td>
                                            <td><B>Status</B></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($logData as $data)
                                            <tr align="center">
                                                <td>{{ $data['PIN'] }}</td>
                                                <td>{{ $data['DateTime'] }}</td>
                                                <td>{{ $data['Verified'] }}</td>
                                                <td>{{ $data['Status'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                            
                                    {{-- <php
                                    $Connect = fsockopen($IP, "80", $errno, $errstr, 1);
                                    if ($Connect) {
                                        $soap_request = "<GetAttLog><ArgComKey xsi:type=\"xsd:integer\">" . $Key . "</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetAttLog>";
                                        $newLine = "\r\n";
                                        fputs($Connect, "POST /iWsService HTTP/1.0" . $newLine);
                                        fputs($Connect, "Content-Type: text/xml" . $newLine);
                                        fputs($Connect, "Content-Length: " . strlen($soap_request) . $newLine . $newLine);
                                        fputs($Connect, $soap_request . $newLine);
                                        $buffer = "";
                                        while ($Response = fgets($Connect, 1024)) {
                                            $buffer = $buffer . $Response;
                                        }
                                    } else {
                                        echo "Koneksi Gagal";
                                    }
                        
                                    // include("parse.php");
                                    include(app_path('Helpers/parse.php'));
                                    $buffer = Parse_Data($buffer, "<GetAttLogResponse>", "</GetAttLogResponse>");
                                    $buffer = explode("\r\n", $buffer);
                                    for ($a = 0; $a < count($buffer); $a++) {
                                        $data = Parse_Data($buffer[$a], "<Row>", "</Row>");
                                        $PIN = Parse_Data($data, "<PIN>", "</PIN>");
                                        $DateTime = Parse_Data($data, "<DateTime>", "</DateTime>");
                                        $Verified = Parse_Data($data, "<Verified>", "</Verified>");
                                        $Status = Parse_Data($data, "<Status>", "</Status>");
                                    ?> --}}
                                     {{-- <tbody>
                                        <tr align="center">
                                            <td><php echo $PIN; ?></td>
                                            <td><php echo $DateTime; ?></td>
                                            <td><php echo $Verified; ?></td>
                                            <td><php echo $Status; ?></td>
                                        </tr>
                                     </tbody>
                                        
                                    <php } ?> --}}
                                </table>
                            {{-- <php } ?> --}}
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <!-- jangan lupa menambahkan script js sweet alert di bawah ini  -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.js"></script>
    @if(Session::has('pesan'))
        <script>
            swal("Selamat","{{ Session::get('pesan')}}", 'success', {
                button:true,
                button:"OK",
            });
        </script>
    @endif

    @if(Session::has('gagal'))
        <script>
            swal("Mohon Maaf","{{ Session::get('gagal')}}", 'error', {
                button:true,
                button:"OK",
            });
        </script>
    @endif

@endsection

