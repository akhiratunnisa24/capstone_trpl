@extends('layouts.default')

@section('content')
    {{-- <H3>Download Log Data</H3> --}}

    <!-- <php
    $IP=$HTTP_GET_VARS["ip"];
    $Key=$HTTP_GET_VARS["key"];
    if($IP=="") $IP="192.168.1.201";
    if($Key=="") $Key="0";
    ?> -->

    @php
        $IP = "192.168.10.217";
        $Key = "10";
        if($IP == "") $IP = "192.168.10.217";
        if($Key== "") $Key="10";
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
                            <form action="{{ route('tarikdata') }}">
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

                            <?php if ($IP != "") { ?>
                                <table  id="datatable-responsive40" class="table table-striped table-bordered m-t-20" cellspacing="0" width="100%">
                                    <thead>
                                        <tr align="center">
                                            <td><B>UserID</B></td>
                                            <td width="200"><B>Tanggal & Jam</B></td>
                                            <td><B>Verifikasi</B></td>
                                            <td><B>Status</B></td>
                                        </tr>
                                    </thead>
                                    <?php
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
                                    ?>
                                     <tbody>
                                        <tr align="center">
                                            <td><?php echo $PIN; ?></td>
                                            <td><?php echo $DateTime; ?></td>
                                            <td><?php echo $Verified; ?></td>
                                            <td><?php echo $Status; ?></td>
                                        </tr>
                                     </tbody>
                                        
                                    <?php } ?>
                                </table>
                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

