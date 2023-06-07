@extends('layouts.default')

@section('content')
    <div class="container">
        <h3>Download Sidik Jari</h3>

        @php
            $IP = isset($_GET['ip']) ? $_GET['ip'] : '192.168.1.201';
            $Key = isset($_GET['key']) ? $_GET['key'] : '0';
            $id = isset($_GET['id']) ? $_GET['id'] : '1';
            $fn = isset($_GET['fn']) ? $_GET['fn'] : '0';
        @endphp

        <form action="/download-sidik-jari">
            IP Address: <input type="Text" name="ip" value="{{ $IP }}" size=15><br>
            Comm Key: <input type="Text" name="key" size="5" value="{{ $Key }}"><br><br>

            UserID: <input type="Text" name="id" size="5" value="{{ $id }}"><br>
            Finger No: <input type="Text" name="fn" size="1" value="{{ $fn }}"><br><br>

            <input type="submit" value="Download">
        </form>
        <br>

        @if (isset($_GET["ip"]) && $_GET["ip"] != "")
            <table cellspacing="2" cellpadding="2" border="1">
                <tr align="center">
                    <td><b>UserID</b></td>
                    <td width="200"><b>FingerID</b></td>
                    <td><b>Size</b></td>
                    <td><b>Valid</b></td>
                    <td align="left"><b>Template</b></td>
                </tr>

                @php
                    $Connect = fsockopen($IP, "80", $errno, $errstr, 1);
                    if ($Connect) {
                        $soap_request = "<GetUserTemplate><ArgComKey xsi:type=\"xsd:integer\">" . $Key . "</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">" . $id . "</PIN><FingerID xsi:type=\"xsd:integer\">" . $fn . "</FingerID></Arg></GetUserTemplate>";
                        $newLine = "\r\n";
                        fputs($Connect, "POST /iWsService HTTP/1.0" . $newLine);
                        fputs($Connect, "Content-Type: text/xml" . $newLine);
                        fputs($Connect, "Content-Length: " . strlen($soap_request) . $newLine . $newLine);
                        fputs($Connect, $soap_request . $newLine);
                        $buffer = "";
                        while ($Response = fgets($Connect, 1024)) {
                            $buffer = $buffer . $Response;
                        }
                        fclose($Connect); // Tambahkan fclose untuk menutup koneksi
                    } else {
                        $buffer = "Koneksi Gagal"; // Ganti return dengan assignment ke buffer
                    }

                    include("parse.php");
                    $buffer = Parse_Data($buffer, "<GetUserTemplateResponse>", "</GetUserTemplateResponse>");
                    $buffer = explode("\r\n", $buffer);
                @endphp

                    @foreach ($buffer as $row)
                        @php
                            $data = Parse_Data($row, "<Row>", "</Row>");
                            $PIN = Parse_Data($data, "<PIN>", "</PIN>");
                            $FingerID = Parse_Data($data, "<FingerID>", "</FingerID>");
                            $Size = Parse_Data($data, "<Size>", "</Size>");
                            $Valid = Parse_Data($data, "<Valid>", "</Valid>");
                            $Template = Parse_Data($data, "<Template>", "</Template>");
                        @endphp
                    <tr align="center">
                        <td>{{ $PIN }}</td>
                        <td>{{ $FingerID }}</td>
                        <td>{{ $Size }}</td>
                        <td>{{ $Valid }}</td>
                        <td>{{ $Template }}</td>
                    </tr>
                    @endforeach

            </table>
        @endif
    </div>
@endsection
