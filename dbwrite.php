<?php
    $host = 'localhost';
	 $username = 'root';
	 $pass = "";//{$_POST['pwd']}");
	 $dbname= 'sales';

$conn = new mysqli($host, $username, $pass, $dbname);


//Check if connection established successfully
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

else { echo "Connected to mysql database. "; }

   
// Get date and time variables
    date_default_timezone_set('Africa/Nairobi');  // for other timezones, refer:- https://www.php.net/manual/en/timezones.asia.php
    $d = date("Y-m-d");
    $t = date("H:i:s");
    
// If values send by NodeMCU are not empty then insert into MySQL database table

	// $phone = $_POST['sendval'];
    //             $cost = $_POST['sendval2'];
              //  echo "$_POST";
  if(!empty($_POST['sendval']) && !empty($_POST['sendval2']) )
    {
		$phone = $_POST['sendval'];
        $cost = $_POST['sendval2'];
     echo "here";

// Update your tablename here
	        $sql = "INSERT INTO dispenser1 (date, phone, cost, time) VALUES ('".$d."','".$phone."','".$cost."','".$t."')"; 
 


		if ($conn->query($sql) === TRUE) {
		    echo "ok";
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}



require_once __DIR__ .'/api.php';
$api = new API();

// $orderData = file_get_contents("php://input");
// $order = json_decode($orderData);
 $orderid = uniqid();
// $amount = ceil($order->total);

$payload = array (
    "BusinessShortCode" => $BusinessShortCode,
    "Password" => $Password,
    "Timestamp" => $Timestamp,
    "TransactionType" => "CustomerPayBillOnline",
    "Amount" => $cost,
    "PartyA" => $phone,
    "PartyB" =>  $BusinessShortCode,
    "PhoneNumber" => $phone,
    "CallBackURL" => LNMO_CALLBACK_URL . $orderid,
    "AccountReference" => $orderid,
    "TransactionDesc" => "Payment of X" 
);


$url  = "https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest";

$response = $api->lipa_na_mpesa_online($url, json_encode($payload));

$data = [
    'orderid' => $orderid,
    'order' => $orderid,
    'stkreqres' => json_decode($response, true) 
];

$ord = fopen("orders/". $orderid.".json", "a");
fwrite($ord, json_encode($data));
fclose($ord);

echo json_encode($data);


	}


// Close MySQL connection
$conn->close();



?>
