<?php
if(isset($_POST['data'])) {
$name = __DIR__ . '/upload/'.time().'.png';
    $img = $_POST['data'];
    file_put_contents($name, base64_decode($img));
    echo $name;
echo '<a class="cart-image" href="#"><img src="'.$name.'" alt="logo"></a>';
}