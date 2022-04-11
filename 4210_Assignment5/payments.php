<?php
require('functions.php');
include_once('auth.php');


// For test payments we want to enable the sandbox mode. If you want to put live
// payments through then this setting needs changing to `false`.
$enableSandbox = true;

// PayPal settings. Change these to your account details and the relevant URLs
// for your site.
$paypalConfig = [
    //'email' => 'user@example.com',
    'return_url' => 'http://52.205.222.173/payment-success.php',
    'cancel_url' => 'http://52.205.222.173/payment-cancelled.php',
    'notify_url' => 'http://52.205.222.173/payments.php'
];

$paypalUrl = $enableSandbox ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';

// Check if paypal request or response
if (!isset($_POST["txn_id"]) && !isset($_POST["txn_type"])) {

    // Grab the post data so that we can set up the query string for PayPal.
    // Ideally we'd use a whitelist here to check nothing is being injected into
    // our post data.
    $data = [];
    foreach ($_POST as $key => $value) {
        $data[$key] = stripslashes($value);
    }

    $data['return'] = stripslashes($paypalConfig['return_url']);
    $data['cancel_return'] = stripslashes($paypalConfig['cancel_url']);
    $data['notify_url'] = stripslashes($paypalConfig['notify_url']);
    $queryString = http_build_query($data);

    // Redirect to paypal IPN
    header('location:' . $paypalUrl . '?' . $queryString);
    exit();

} else {
    $db = new PDO('sqlite:/var/www/cart.db');
    $db->query('PRAGMA foreign_keys = ON;');
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $results = $db->query('SELECT * FROM payments WHERE txnid = (?)');
    $results->bindParam(1, $_POST['txn_id']);
    $results->execute();
    $re = $results->fetch();

    if (verifyTransaction($_POST) && !$re) {

        
    // Handle the PayPal response.

    // Create a connection to the database.
    //$db = new mysqli($dbConfig['host'], $dbConfig['username'], $dbConfig['password'], $dbConfig['name']);
    
    // Assign posted variables to local data array.

    // Add all the item numbers, quantities and prices to the above array variables
    $total = 0;
    $total_prod = array();
    $sortlist = array();
    $i = 0;
    $max =0;
    for ($i = 0; $i < ($_POST['num_cart_items']); $i++) {
       
        $total_prod[$i]["pid"] = $_POST['item_number' . ($i+1)];
        $total_prod[$i]["quantity"] = $_POST['quantity' .($i+1)];
        $total_prod[$i]["price"] = $_POST['mc_gross_' .($i+1)];
    }

    //sort list to rearrange it
    $key =0;
    $tmp1 =0;
    $tmp2 =0;
    $j =0;
    for ($i = 1; $i < ($_POST['num_cart_items']); $i++){
        $key =  $total_prod[$i]["pid"];
        $tmp1 =  $total_prod[$i]["quantity"];
        $tmp2 = $total_prod[$i]["price"];
        $j = $i -1;
        while($j >= 0 && $total_prod[$j]["pid"] > $key){
            $total_prod[$j + 1]["pid"] = $total_prod[$j]["pid"];
            $total_prod[$j + 1]["quantity"] =  $total_prod[$j]["quantity"];
            $total_prod[$j + 1]["price"] = $total_prod[$j]["price"];
            $j = $j -1;
        }
        $total_prod[$j + 1]["pid"] = $key;
        $total_prod[$j + 1]["quantity"] = $tmp1;
        $total_prod[$j + 1]["price"] = $tmp2;
    }

    $orderid =  $_POST['custom'];

 
    $sql = $db->prepare("SELECT * from ORDERS where ORDER_ID = ?");
    $sql->bindParam(1,  $orderid);
    $sql->execute();
    $r = $sql->fetch();
    $salt = $r['SALT'];
    $item_array['currency'] =  $_POST['mc_currency'];
    $item_array['email'] =  $_POST['receiver_email'];
    $item_array['cart'] = serialize($total_prod); //include pid and quantity
    $item_array['price'] = $_POST['mc_gross'];
    $txnid =  $_POST['txn_id'];

    $digest = hash_hmac('sha256', serialize($item_array), $salt);
//     $fp = fopen("realsam.txt", "a+");
//     fwrite($fp, "$digest\r\n");
// fclose($fp);


    // $fp = fopen("text.txt", "w+");
    //     foreach($_POST as $key => $value)
    //         fwrite($fp, "$key => $value \r\n");

    //check if same as db digest
    if($digest == $r['DIGEST']){
        $query = $db->prepare("INSERT INTO PAYMENTS (txnid, payment_amount, payment_status, payment_details, created_time) VALUES (?, ?, ?, ?, ?)");
        $query->bindParam(1, $_POST['txn_id']);
        $query->bindParam(2, $_POST['mc_gross']);
        $query->bindParam(3, $_POST['payment_status']);
        $query->bindParam(4, $item_array['cart']);
        $query->bindParam(5, date('Y-m-d H:i:s'));
        $query->execute();

    }

    // Database settings. Change these for your database configuration.
    // $db = new PDO('sqlite:/var/www/cart.db');
    // $db->query('PRAGMA foreign_keys = ON;');
    // $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    // $sql = $db->prepare("SELECT salt, FROM ORDERS WHERE ORDER_ID = (?)");
    // $sql->bindParam(1, $_POST['custom']);
    // $sql->execute();
    // $r = $sql->fetch();
    
    //Regenerate the digest 



    //Verify by compareing the digest from db, prvious Txn_id records and the transaction of paypal
    // )&&checkTxnid($txnid)&& verifydigest($hash))

       
    }else{
        //Payment failed
        header('Location: payment-cancelled.html');
        exit();
    }
}
?>
