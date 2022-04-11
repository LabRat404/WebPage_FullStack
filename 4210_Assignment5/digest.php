<?php 

include_once('/Admin_Panel/lib/db.inc.php');
include_once('auth.php');
session_start();
// header('Content-type: application/json; charset=UTF-8');

$salt = mt_rand().mt_rand();
$currency = "HKD";
$email = "sb-3gm7i15627234@business.example.com"; //merchant address
$total = 0;
$total_prod = array();
$i = 0;

$db = new PDO('sqlite:/var/www/cart.db');
$db->query('PRAGMA foreign_keys = ON;');
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

foreach($_POST["cart"] as $keys => $values){
    $pid = $keys;
    $quantity = $values;
    $sql = $db->prepare("SELECT * FROM products WHERE pid = (?)");
    $sql->bindParam(1, $pid);
    $sql->execute();
    $r = $sql->fetch();


    $total += $quantity * $r['PRICE']; //dec
    $total_prod[$i]["pid"] = $pid;
    $total_prod[$i]["quantity"] = $quantity;
    $pricess = $r['PRICE']* $quantity;
    $total_prod[$i]["price"] = (string)$pricess;
    $list[$i]['name'] = $r['NAME'];
    $list[$i]['quantity'] = $quantity;
    
    $i++;
}

$item_array['currency'] = $currency;
$item_array['email'] = $email;
$item_array['cart'] = serialize($total_prod); //include pid and quantity
$item_array['price'] = (string) $total;

//generate digest
//digest include pid + quantity but excludes name + quantity
//file_put_contents("text.txt", serialize($item_array));
$digest = hash_hmac('sha256', serialize($item_array), $salt);
// $fp = fopen("text.txt", "a+");
//     fwrite($fp, "$digest\r\n");
// fclose($fp);

//user email
if(!empty($_SESSION["auth"])){
    $user = auth();
} else{
    $user = 'guest';
}
//insert digest to db
$query = $db->prepare("INSERT INTO orders (email, salt, digest, list, time) VALUES (?, ?, ?, ?, ?)");
$query->bindParam(1, $user);
$query->bindParam(2, $salt);
$query->bindParam(3, $digest);
$query->bindParam(4, serialize($list));
$query->bindParam(5, date('Y-m-d'));
$query->execute();

//return custom = order, invoice = digest
//custom
$lastId = $db->lastInsertId();

$data = array(
    'lastId' => $lastId,
    'digest' => $digest,
);

header('Content-Type: application/json');
ob_clean();
echo json_encode($data);
?>