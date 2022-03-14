<?php
require __DIR__.'/admin/lib/db.inc.php';
$res = ierg4210_cat_fetchall();

$products = '<ul>';

foreach ($res as $value){
    $products .= '<li><a href = "'.$value["FILE"].'"> '.$value["NAME"].'</a></li>';
}

$products .= '</ul>';

echo '<div id = "maincontent">
<div id = "products">'.$products.'
</div>
</div>';

?>
