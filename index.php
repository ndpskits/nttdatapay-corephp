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
    $merchTxnId = uniqId();
    $amount = 10.00;
      
    require_once 'AtomAES.php';
     
    $atomenc = new AtomAES();
 
    $curl = curl_init();
      
    $jsondata = '{
	  "payInstrument": {
            "headDetails": {
              "version": "OTSv1.1",      
              "api": "AUTH",  
              "platform": "FLASH"	
            },
            "merchDetails": {
              "merchId": "8952",
              "userId": "",
              "password": "Test@123",
              "merchTxnId": "'. $merchTxnId .'",      
              "merchTxnDate": "2021-09-04 20:46:00"
            },
            "payDetails": {
              "amount":  "'. $amount .'",
              "product": "NSE",
              "custAccNo": "213232323",
              "txnCurrency": "INR"
            },	
            "custDetails": {
              "custEmail": "sagar.gopale@atomtech.in",
              "custMobile": "8976286911"
            },
            "extras": {
              "udf1":"",
              "udf2":"",
              "udf3":"",
              "udf4":"",
              "udf5":""
            }
	     }  
	   }';
      
   $encData = $atomenc->encrypt($jsondata, 'A4476C2062FFA58980DC8F79EB6A799E', 'A4476C2062FFA58980DC8F79EB6A799E');
        
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://caller.atomtech.in/ots/aipay/auth",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_SSL_VERIFYHOST => 2,
      CURLOPT_SSL_VERIFYPEER => 1,
      CURLOPT_CAINFO => getcwd() . '/cacert.pem',
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "encData=".$encData."&merchId=8952",
      CURLOPT_HTTPHEADER => array(
        "Content-Type: application/x-www-form-urlencoded"
      ),
    ));
   
    $atomTokenId = null;
    $response = curl_exec($curl);   

    $getresp = explode("&", $response); 

    $encresp = substr($getresp[1], strpos($getresp[1], "=") + 1);       
    //echo $encresp;

    $decData = $atomenc->decrypt($encresp, '75AEF0FA1B94B3C10D4F5B268F757F11', '75AEF0FA1B94B3C10D4F5B268F757F11');

    //echo $decData;      

    if(curl_errno($curl)) {
        $error_msg = curl_error($curl);
        echo "error = ".$error_msg;
    }      

    if(isset($error_msg)) {
        // TODO - Handle cURL error accordingly
        echo "error = ".$error_msg;
    }   
      
    curl_close($curl);

    $res = json_decode($decData, true);   

    if($res){
      if($res['responseDetails']['txnStatusCode'] == 'OTS0000'){
        $atomTokenId = $res['atomTokenId'];
      }else{
        echo "Error getting data";
         $atomTokenId = null;
      }
    }
    ?>
    <div class="container my-5">
      <h3 class="">Merchant Shop</h3>
      <p>Transaction Id: <?= $merchTxnId ?></p>
      <p>Atom Token Id: <?= $atomTokenId ? $atomTokenId : "No Token" ?></p>
      <p>Pay Rs. <?= $amount ?></p>
      <a name="" id="" class="btn btn-primary" href="javascript:openPay()" role="button">Pay Now</a>
    </div>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

   <script src="https://pgtest.atomtech.in/staticdata/ots/js/atomcheckout.js"></script> 
<!--    <script src="https://psa.atomtech.in/staticdata/ots/js/atomcheckout.js"></script>  for production-->
    <script>
    function openPay(){
        console.log('openPay called');
        const options = {
          "atomTokenId": "<?= $atomTokenId ?>",
          "merchId": "8952",
          "custEmail": "sagar.gopale@atomtech.in",
          "custMobile": "8976286911",
          "returnUrl":"http://localhost/atominstapay3-COREPHP/response.php"
        }
        let atom = new AtomPaynetz(options,'uat');
    }

    </script>
   <!-- END -->
  </body>
</html>