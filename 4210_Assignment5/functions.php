<?php
include_once('auth.php');

function ierg4210_DB() {
	// connect to the database
	// TODO: change the following path if needed
	// Warning: NEVER put your db in a publicly accessible location
	$db = new PDO('sqlite:/var/www/cart.db');

	// enable foreign key support
	$db->query('PRAGMA foreign_keys = ON;');

	// FETCH_ASSOC:
	// Specifies that the fetch method shall return each row as an
	// array indexed by column name as returned in the corresponding
	// result set. If the result set contains multiple columns with
	// the same name, PDO::FETCH_ASSOC returns only a single value
	// per column name.
	$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

	return $db;
}

function checkTxnid($txnid) {
  
//     $db = new PDO('sqlite:/var/www/cart.db');
//     $db->query('PRAGMA foreign_keys = ON;');
//     $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
//     $sql = $db->prepare("SELECT TXNID FROM PAYMENTS");
//     $sql->execute();
//     if(!empty($sql)){
//     foreach($sql as $check){
//         if($check == $txnid){
//         $fp = fopen("abcddde.txt", "w+");
//         fwrite($fp, "failed");
//      fclose($fp);
//             return false;
//          } else{
//             $fp = fopen("abcddde.txt", "w+");
//             fwrite($fp, "success");
//          fclose($fp);
//             return true;
//          }
//     }
// }else{
//         $fp = fopen("abcddde.txt", "w+");
//         fwrite($fp, "success");
//      fclose($fp);

//     return true;
//     }

}

function addPayment($DATA) {
    // global $db;
    // $db = ierg4210_DB();



    // $db = new PDO('sqlite:/var/www/cart.db');
    // $db->query('PRAGMA foreign_keys = ON;');
    // $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    // $email = $DATA['receiver_email'];
    // $price = $DATA['mc_gross'];
    // $date = $DATA['payment_date'];

    // $txnid =  $DATA['txn_id'];

    // for ($i = 1; $i < ($DATA['num_cart_items']+1); $i++) {

    //     $total_prod[$i]["pid"] = $DATA['item_number' . $i];
    //     $total_prod[$i]["name"] = $DATA['item_name' . $i];
    //     $total_prod[$i]["quantity"] = $DATA['quantity' . $i];
    //     $total_prod[$i]["price"] = $DATA['mc_gross_' . $i];
    // }

    // $jsons =  json_encode($total_prod);
    
    // $sql="INSERT INTO PAYMENTS (, name, price, quantities, description) VALUES (?, ?, ?, ?, ?);";
    // $q = $db->prepare($sql);
    // $q->bindParam(1, $catid);
    // $q->bindParam(2, $name);
    // $q->bindParam(3, $price);
    // $q->bindParam(4, $quantities);
    // $q->bindParam(5, $desc);
    // $q->execute();








    // return true;
}


function verifyTransaction($data) {
    global $paypalUrl;
      
    
    $req = 'cmd=_notify-validate';
    foreach ($data as $key => $value) {
        $value = urlencode(stripslashes($value));
        $value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i', '${1}%0D%0A${3}', $value); // IPN fix
        $req .= "&$key=$value";
    }

    $ch = curl_init($paypalUrl);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
    curl_setopt($ch, CURLOPT_SSLVERSION, 6);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
    $res = curl_exec($ch);

    if (!$res) {
        $errno = curl_errno($ch);
        $errstr = curl_error($ch);
        curl_close($ch);
        throw new Exception("cURL error: [$errno] $errstr");
    }

    $info = curl_getinfo($ch);

    // Check the http response
    $httpCode = $info['http_code'];
    if ($httpCode != 200) {
        throw new Exception("PayPal responded with http code $httpCode");
    }

    curl_close($ch);

  
 ;
    return true;;
}


?>