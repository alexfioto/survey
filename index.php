<?php

// echo 'PHP version: ' . phpversion();

include 'credentials.php';

$name_error = "";
$email_error = "";
$lucky_number_error = "";
$message = "";
$lucky_options = array(
  "options" => ["min_range" =>1, "max_range" =>1000]
);

// TEST PDO CONNECTION 
// try {
//   $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
//   // set the PDO error mode to exception
//   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//   echo "Connected successfully";
// } catch(PDOException $e) {
//   echo "Connection failed: " . $e->getMessage();
// }

function validateName(&$error) 
{
  $input = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
  if (strlen($input) > 30) {
    $error = "*** Your name is too long";
    return FALSE;
  } else {
    return TRUE;
  }
}

function validateEmail(&$error)
{
  $input = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
  if (!$input) {
    $error = "*** Invalid Email";
    return FALSE;
  } else {
    return TRUE;
  }
}

function validateLuckyNumber(&$error, $options)
{
  $input = filter_var($_POST["lucky_number"], FILTER_VALIDATE_INT, $options);
  if (!$input) {
    $error = '*** Invalid Number. Must be an integer between 1-1000';
    return FALSE;
  } else {
    return TRUE;
  }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = validateName($name_error);
    $email = validateEmail($email_error);
    $lucky_number = validateLuckyNumber($lucky_number_error, $lucky_options);
    
    if ($name && $email && $lucky_number) {
      try {
          // Variable Names
        $name = $_POST["name"];
        $email = $_POST["email"];
        $favorite_color = $_POST["color"];
        $lucky_number = (int)$_POST['lucky_number'];
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO test_survey (name, email, favorite_color, lucky_number)
        VALUES ('${name}', '${email}', '${favorite_color}', '${lucky_number}')";
        // use exec() because no results are returned
        $conn->exec($sql);
        // echo "New record created successfully";
      } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
      }
      
      $conn = null;
      header("Location: results.php");
      exit;
    }

}
?>
<html>
<h1>Survey</h1>
<form method='POST' action=''>
  <label for="name">Name</label><br>
  <input type="text" id="name" name="name" value='<?= $_POST["name"];?>'>
  <span class='error'><?=$name_error;?></span><br>
  <label for="email">Email Address</label><br>
  <input type="text" id="email" name="email" value='<?= $_POST["email"];?>'>
  <span class='error'><?=$email_error;?></span><br>
  <label for="favorite_color">Favorite Color?</label><br>
  <select id="favorite_color" name="color">
    <option value='blue'>Blue</option>
    <option value='green'>Green</option>
    <option value='red'>Red</option>
    <option value='yellow'>Yellow</option>
    <option value='pink'>Pink</option>
  </select><br>
  <label for='lucky_number'>What is your lucky number?</label><br>
  <input type='text' id='lucky_number' name='lucky_number' value='<?= $_POST["lucky_number"];?>'>
  <span class='error'><?=$lucky_number_error;?></span><br>
<br>
  <input class='submit' type="submit" value='Submit Form'>
</form>
<span class='message'><?= $message;?></span>