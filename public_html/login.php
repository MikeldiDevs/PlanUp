<?php
session_start();
include ("config.php");
$email = htmlspecialchars(trim($_POST['email']));
$pass = sha1(md5(trim($_POST['pass'])));
$link = mysqli_connect($datos[0],$datos[1],$datos[2]);
mysqli_select_db($link,$datos[3]);
$query = sprintf("SELECT name, email, password FROM usuarios WHERE email='%s'and password='%s'", mysqli_real_escape_string($link, $email), mysqli_real_escape_string($link, $pass));
$result = mysqli_query($link, $query);
if ($result)
{
	if (mysqli_num_rows($result))
	{
		$array = mysqli_fetch_array($result);
		$_SESSION["email"] = $array["email"];
		$_SESSION["nombre"] = $array["name"];
		echo '<script>window.location.replace("index.php")</script>';
	}
	else
	{
		$string = "<p>Email o contraseña incorrectos.</p>";
  		echo $string;
	}
}
else 
{
	echo "\nError: ".mysqli_error($link);
}
mysqli_close($link);
?>