<?php
  require_once 'AtomAES.php'; 
  $atomenc = new AtomAES();
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Atom Paynetz</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  </head>
  <body>
      <?php
      
              $data = $_POST['encData'];
          
              $decrypted = $atomenc->decrypt($data, '75AEF0FA1B94B3C10D4F5B268F757F11', '75AEF0FA1B94B3C10D4F5B268F757F11');
              echo $decrypted;

              $jsonData = json_decode($decrypted, true);
      
      ?>
      
      <div class="row pt-5">
         <div class="col-md-3"></div>
         <div class="col-md-3"><strong>Transaction result :</strong></div>
         <div class="col-md-3"><strong><?= $jsonData['payInstrument']['responseDetails']['message'] ?></strong></div>
         <div class="col-md-3"></div>
      </div>
      
       <div class="row pt-4">
         <div class="col-md-3"></div>
         <div class="col-md-3"><strong>Merchant transaction ID :</strong></div>
           <div class="col-md-3"><strong><?= $jsonData['payInstrument']['merchDetails']['merchTxnId'] ?></strong></div>
         <div class="col-md-3"></div>
      </div>
      
       <div class="row pt-4">
         <div class="col-md-3"></div>
         <div class="col-md-3"><strong>Transaction date :</strong></div>
           <div class="col-md-3"><strong><?= $jsonData['payInstrument']['merchDetails']['merchTxnDate'] ?></strong></div>
         <div class="col-md-3"></div>
      </div>
      
       <div class="row pt-4">
         <div class="col-md-3"></div>
           <div class="col-md-3"><strong>Bank transaction ID :</strong></div>
           <div class="col-md-3"><strong><?= $jsonData['payInstrument']['payModeSpecificData']['bankDetails']['bankTxnId'] ?></strong></div>
         <div class="col-md-3"></div>
      </div>
  
    </body>
</html>