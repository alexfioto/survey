<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $message = "Post method detected";
} else {
    $message = "Post method NOT detected";
}

$name = $_POST["name"];
$email = $_POST["email"];
$favorite_color = $_POST["color"];
$lucky_number = $_POST['lucky_number'];
?>

<html>
    <h1>Here are your results:</h1>
    <h2>Name: <?=$name;?></h2>
    <h2>Email: <?=$email;?></h2>
    <h2>Favorite Color: <?=$favorite_color;?></h2>
    <h2>Lucky Number: <?=$lucky_number;?></h2>
    <h3><?=$message;?></h3>
    <a href='index.php'>Reset</a>
</html>