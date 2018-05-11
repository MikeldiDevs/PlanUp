<?php
include("config.php");
$nombre = htmlspecialchars(trim($_POST['name']));
$email = htmlspecialchars(trim($_POST['email']));
$pass1 = trim($_POST['pass1']);
$pass2 = trim($_POST['pass2']);
$link = mysqli_connect($datos[0],$datos[1], $datos[2]) or die ("No se pudo conectar a la base de datos");
mysqli_select_db($link,$datos[3]);
$query = sprintf("SELECT email FROM usuarios WHERE usuarios.email='%s'", mysqli_real_escape_string($link, $email));
$result = mysqli_query($link, $query);
if (mysqli_num_rows($result))
{
  $string = "Ya existe una cuenta con ese correo electronico.";
  header("Location: index.php?Message=".urlencode($string));
} 
else 
{
  mysqli_free_result($result);
  if ($pass1 != $pass2)
  {
    $string = "Las contraseñas deben coincidir, por favor inténtalo de nuevo.";
  	header("Location: index.php?Message=".urlencode($string));
  } 
  else 
  {
    $pass1 = sha1(md5($pass1));
    $query = sprintf("INSERT INTO usuarios (name, email, password) VALUES ('%s', '%s','%s')",
    mysqli_real_escape_string($link, $nombre), mysqli_real_escape_string($link, $email) , mysqli_real_escape_string($link, $pass1));
    $result = mysqli_query($link, $query);
    if ($result)
    {
      if (mysqli_affected_rows($link))
      {
          echo '
          <form method="post" action="login.php" id="formID">
            <input type="hidden" placeholder="Nombre" name="email" required value='.$email.'>
            <input type="hidden" placeholder="" name="pass" required value='.$_POST['pass1'].'>
          </form>
          <script>
          document.getElementById("formID").submit();
          </script>
              ';
      }
    }
    else 
    {
      echo mysqli_error($link);
    }
  }
}
mysqli_close($link);
?>