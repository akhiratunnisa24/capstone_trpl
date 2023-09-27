<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Lamaran Berhasil Diterima</title>
    <style>
      .container {
        background-color: #f2f2f2;
        padding: 50px;
        border-radius: 10px;
        box-shadow: 0 0 10px #ccc;
        text-align: center;
      }
      
      h1 {
        color: #0073ff;
        font-size: 36px;
        margin-top: 50px;
      }
      
      p {
        color: #5e5e5e;
        font-size: 18px;
        margin-top: 20px;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <h1>Terima kasih!</h1>
      <p>Lamaran Anda telah berhasil diterima.</p>
      <p>Kami akan segera menghubungi Anda untuk proses selanjutnya.</p>
    </div>
    
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog">
      
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Lamaran Berhasil Diterima</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <p>Terima kasih! Lamaran Anda telah berhasil diterima.</p>
            <p>Kami akan segera menghubungi Anda untuk proses selanjutnya.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Tutup</button>
          </div>
        </div>
        
      </div>
    </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
      $(document).ready(function(){
        $("#myModal").mod
