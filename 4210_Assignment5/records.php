<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

function order_records() {
    $user = auth();
    htmlspecialchars($user);
    $output ='';

    $db = new PDO('sqlite:/var/www/cart.db');
    $db->query('PRAGMA foreign_keys = ON;');
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $sql = $db->prepare("SELECT * FROM orders WHERE email = (?) ORDER BY ORDER_ID DESC");
    $sql->bindParam(1, $user);
    $sql->execute();

    $j=5;
    
    while($r = $sql->fetch()) {
        if($j > 0) 
            $j--;
        else 
            break;

        //for one entry
        // $data = json_decode($r['LIST']);
        $data = unserialize($r['LIST']);
        $length = count($data);
        $output .= 
        '<tr>
            <td>'.$r['ORDER_ID'].'</td>
            <td>
        ';
        //list contains name and quantity, but with multiple names and quantity
        //for one list
        for($i=0; $i < count($data); $i++) {
            //$list['name']
            //$list['quantity']
            $output .= '<div>'.$data[$i]['name'].'</div>';
        }
        $output .= '</td><td>';
        for($i=0; $i < count($data); $i++) {
            $output .= '<div>'.$data[$i]['quantity'].'</div>';
        }
        $time = $r["TIME"];
        $output .=
        '</td><td>'.$r["TIME"].'</td>
        </tr>';
    }

    return $output;
}

function admin_order_history() {
    $db = new PDO('sqlite:/var/www/cart.db');
    $db->query('PRAGMA foreign_keys = ON;');
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $sql = $db->prepare("SELECT * FROM payments;");
    $sql->execute();

    $output ='';
    while($r = $sql->fetch()) {
        $data = unserialize($r['payment_details']);
        $length = count($data);
       

        $output .= 
        '<tr>
            <td>'.$r['id'].'</td>
            <td>'.$r['txnid'].'</td>
            <td>'.$r['payment_status'].'</td>
            <td>
        ';
        for($i=0; $i < count($data); $i++) {
        //     //$list['name']
        //     //$list['quantity']
            $q = $db->prepare("SELECT * FROM products WHERE pid = (?);");
            $q->bindParam(1, $data[$i]['pid']);
            $q->execute();
            $result = $q->fetch();
            $output .= '<div>'.$result['NAME'].'</div>';
        }
        $output .= '</td><td>';
        for($i=0; $i < count($data); $i++) {
            $output .= '<div>'.$data[$i]['quantity'].'</div>';
        }
        $output .= '</td><td>'.$r['created_time'].'</td></tr>';
    }
    return $output;
}
?>