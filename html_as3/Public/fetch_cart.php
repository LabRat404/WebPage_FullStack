<?php

//fetch_cart.php

session_start();

$total_price = 0;
$total_item = 0;

$output = '
<div class="table-responsive" id="order_table">
	<table class="table table-bordered table-striped">
		<tr>  
		<th width="35%">Product Name</th>  
		<th width="19%">Quantity</th>  
		<th width="22%">Price</th>  
		<th width="22%">Total</th>  
		<th width="2%"></th>  
        </tr>
';
if(!empty($_SESSION["shopping_cart"]))
{
	foreach($_SESSION["shopping_cart"] as $keys => $values)
	{
		$output .= '

	    <tr id = "tr'.$values["pid"].'">
		
		<input hidden type="text" id="quantity'.$values["pid"].'" value="1" />
		<input hidden type="text"  id="name'.$values["pid"].'" value = "'.$values["name"].'"/>
		<input hidden type="text" id="price'.$values["pid"].'" value = "'.$values["price"].'" />
		
	   <td>'.$values["name"].'</td>

	   <td>
	   <button class="btn btn-danger btn-quantity bi bi-caret-up-fill text-center add_to_cart" id="'. $values["pid"].'"></button>
	   '.$values["quantity"].'
	   <button class="btn btn-danger btn-quantity bi bi-caret-down-fill text-center minus" id="'. $values["pid"].'"></button>
	   </td>
	   <td align="right">$ '.$values["price"].'</td>
	   <td align="right">$ '.number_format($values["quantity"] * $values["price"], 2).'</td>
	   <td><button class="btn btn-danger btn-close" id="'. $values["pid"].'"></button></td>
   </tr>
   ';
   $total_price = $total_price + ($values["quantity"] * $values["price"]);
   $total_item = $total_item + 1;
	}
	$output .= '
	<tr>  
        <td colspan="3" align="right">Total</td>  
        <td align="right">$ '.number_format($total_price, 2).'</td>  
        <td></td>  
    </tr>
	';
}
else
{
	$output .= '
    <tr>
    	<td colspan="5" align="center">
    		Your Cart is Empty!
    	</td>
    </tr>
    ';
}
$output .= '</table></div>';
$data = array(
	'cart_details'		=>	$output,
	'total_price'		=>	'$' . number_format($total_price, 2),
	'total_item'		=>	$total_item
);	

echo json_encode($data);


?>