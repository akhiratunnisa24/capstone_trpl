<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use PhpXmlRpc\Client;
use PhpXmlRpc\Request;
use PhpXmlRpc\Value;
use App\Helpers\AbsensiHelper;
 
class AbsensiRequest extends Controller
{
    public function xmlRpcRequest($IP, $Key)
    {
        $client = new Client('http://' . $IP . '/xmlrpc-endpoint');
        // $client = new Client('http://example.com/xml-rpc-endpoint');

        // Mempersiapkan nama metode dan parameter
        $methodName = 'sample_method';  //nama method berasal dari klien
        $params = [
            new Value('parameter1', 'string'),
            new Value(2, 'int'),
            new Value(true, 'boolean'),
        ];

        // Membuat permintaan XML-RPC
        $request = new Request($methodName, $params);

        // Mengirim permintaan XML-RPC
        $response = $client->send($request);

        // Memproses respons XML-RPC
        if ($response->faultCode()) {
            // Menangani kesalahan XML-RPC
            $errorCode = $response->faultCode();
            $errorMessage = $response->faultString();

            // Lakukan penanganan kesalahan atau pencatatan
            // ...

            return response()->json([
                'error' => 'XML-RPC Error: ' . $errorCode . ' - ' . $errorMessage,
            ], 500);
            // $result = null;
            // $error = 'XML-RPC Error: ' . $errorCode . ' - ' . $errorMessage;
        } else {
            // Menangani kesuksesan XML-RPC
            $result = $response->value();
            $error = null;
        }

        return [
            'error' => $error,
            'result' => $result
        ];
    }
    // public function xmlRpcRequest($IP, $Key)
    // {
    //     $client = new \Zend\XmlRpc\Client('http://' . $IP . '/xmlrpc-endpoint');

    //     $methodName = 'sample_method';
    //     $params = [
    //         new \Zend\XmlRpc\Value('parameter1'),
    //         new \Zend\XmlRpc\Value(2),
    //         new \Zend\XmlRpc\Value(true),
    //     ];

    //     try {
    //         $response = $client->call($methodName, $params);
    //         // Process the XML-RPC response
    //         // ...
    //         $result = $response->getArray();
    //         $error = null;
    //     } catch (\Zend\XmlRpc\Exception\FaultException $e) {
    //         // Handle XML-RPC error
    //         $errorCode = $e->getCode();
    //         $errorMessage = $e->getMessage();
    //         // Perform error handling or logging
    //         // ...
    //         $result = null;
    //         $error = 'XML-RPC Error: ' . $errorCode . ' - ' . $errorMessage;
    //     }

    //     return [
    //         'error' => $error,
    //         'result' => $result
    //     ];
    // }

    // public function xmlRpcRequest($IP, $Key)
    // {
    //     $Connect = fsockopen($IP, "80", $errno, $errstr, 1);

    //     if (!$Connect) {
    //         $response = [
    //             'error' => "Tidak dapat terhubung ke IP tersebut.",
    //             'result' => null
    //         ];
    //     } else {
    //         $soapRequest = "<GetAttLog><ArgComKey xsi:type=\"xsd:integer\">" . $Key . "</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetAttLog>";
    //         $newLine = "\r\n";

    //         fputs($Connect, "POST /iWsService HTTP/1.0" . $newLine);
    //         fputs($Connect, "Content-Type: text/xml" . $newLine);
    //         fputs($Connect, "Content-Length: " . strlen($soapRequest) . $newLine . $newLine);
    //         fputs($Connect, $soapRequest . $newLine);

    //         $buffer = "";
    //         while ($response = fgets($Connect, 1024)) {
    //             $buffer .= $response;
    //         }

    //         fclose($Connect);

    //         $responseData = Parse_Data($buffer, "<GetAttLogResponse>", "</GetAttLogResponse>");
    //         $responseData = explode("\r\n", $responseData);

    //         $logData = [];
    //         foreach ($responseData as $line) {
    //             $data = Parse_Data($line, "<Row>", "</Row>");
    //             $PIN = Parse_Data($data, "<PIN>", "</PIN>");
    //             $DateTime = Parse_Data($data, "<DateTime>", "</DateTime>");
    //             $Verified = Parse_Data($data, "<Verified>", "</Verified>");
    //             $Status = Parse_Data($data, "<Status>", "</Status>");

    //             $logData[] = [
    //                 'PIN' => $PIN,
    //                 'DateTime' => $DateTime,
    //                 'Verified' => $Verified,
    //                 'Status' => $Status
    //             ];
    //         }

    //         $response = [
    //             'error' => null,
    //             'result' => $logData
    //         ];
    //     }

    //     return $response;
    // }
    // public function xmlRpcRequest($IP, $Key)
    // {
    //     // Create a client to make the XML-RPC call
    //     $client = new Client('http://example.com/xml-rpc-endpoint');

    //     // Prepare the method name and parameters
    //     $methodName = 'sample_method';
    //     $params = [
    //         new Value('parameter1'),
    //         new Value(2),
    //         new Value(true),
    //     ];

    //     // Create an XML-RPC request
    //     $request = new Request($methodName, $params);

    //     // Send the XML-RPC request
    //     $response = $client->send($request);

    //     // Process the XML-RPC response
    //     if ($response->faultCode()) {
    //         // Handle XML-RPC error
    //         $errorCode = $response->faultCode();
    //         $errorMessage = $response->faultString();

    //         // Perform error handling or logging
    //         // ...

    //         // Return an error response if needed
    //         return response()->json([
    //             'error' => 'XML-RPC Error: ' . $errorCode . ' - ' . $errorMessage,
    //         ], 500);
    //     } else {
    //         // Handle XML-RPC success
    //         $result = $response->value();

    //         // Process the result or perform any other actions

    //         // Return a success response if needed
    //         return response()->json([
    //             'result' => $result,
    //         ], 200);
    //     }
    // }
    // public function xmlRpcRequest()
    // {
    //     // Create a client to make the XML-RPC call
    //     $client = new Client('http://example.com/xml-rpc-endpoint');

    //     // Prepare the method name and parameters
    //     $methodName = 'your_xmlrpc_method_name';
    //     $params = [
    //         new Value('parameter1'),
    //         new Value('parameter2'),
    //         // Add more parameters as needed
    //     ];

    //     // Create an XML-RPC request
    //     $request = new Request($methodName, $params);

    //     // Send the XML-RPC request
    //     $response = $client->send($request);

    //     // Process the XML-RPC response
    //     if ($response->faultCode()) {
    //         // Handle XML-RPC error
    //         $errorCode = $response->faultCode();
    //         $errorMessage = $response->faultString();
    //         // ...
    //     } else {
    //         // Handle XML-RPC success
    //         $result = $response->value();
    //         // ...
    //     }

    //     // Return the response or do something with the result
    //     // ...
    // }
}
