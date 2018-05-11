<?php 
//error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
include ("config.php");
if (isset($_POST["submit"]))
{
	$link = mysqli_connect($datos[0],$datos[1],$datos[2]) or die ("No se pudo conectar a la base de datos");
	mysqli_select_db($link,$datos[3]);

	$nombre= $_POST['nombre'];
    $categoria= $_POST['categoria'];
    $descripcion= $_POST['descripcion'];
    $ciudad= $_POST['ciudad'];
    $fecha= $_POST['fecha'];
    $hora= $_POST['hora'];
    $precio= $_POST['precio'];

    $query = sprintf("INSERT INTO eventos(nombre, categoria, descripcion, fecha, ciudad) values ('%s', '%s', '%s', '%s', '%s')", mysqli_real_escape_string($link, $nombre), mysqli_real_escape_string($link, $categoria), mysqli_real_escape_string($link, $descripcion), mysqli_real_escape_string($link, $fecha), mysqli_real_escape_string($link, $ciudad));
    echo $query;
	$main_result = mysqli_query($link, $query);
	if (!$main_result)
	{
		echo "\nError: ".mysqli_error($link);
	}
	if ($hora)
	{
		$match = preg_match("/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/", $hora);
		if ($match)
		{
			echo "<br/>".$hora."<br/>";
			$query = sprintf("UPDATE eventos set hora='%s' where nombre='%s'", mysqli_real_escape_string($link, $hora), mysqli_real_escape_string($link, $nombre));
			$result = mysqli_query($link, $query);
			if (!$result)
			{
				echo "\nError: ".mysqli_error($link);
			}
		}
		else
		{
			echo "Formato de hora invalido";
		}
		
	}
	if ($precio)
	{
		
		$query = sprintf("UPDATE eventos set precio='%s' where nombre='%s'", mysqli_real_escape_string($link, $precio), mysqli_real_escape_string($link, $nombre));
		$result = mysqli_query($link, $query);
		if (!$query)
		{
			echo "\nError: ".mysqli_error($link);
		}
	}
	
	if ($_FILES['imagen']['size'] == 0 && $_FILES['imagen']['error'] == 0)
	{
    	echo "No image selected";
	}
	else
	{
		$dir = "../images/";
		if ( !file_exists($dir) ) 
		{
		    $oldmask = umask(0);  
		    mkdir ($dir, 0744);
		}
		$file = $dir.basename($_FILES["imagen"]["name"]);
		echo $file;
		$filename=$_FILES["imagen"]["name"];
		$extension=end(explode(".", $filename));
		$newfilename= uniqid().".".$extension;
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($file, PATHINFO_EXTENSION));
		$check = getimagesize($_FILES["imagen"]["tmp_name"]);
		if ($check)
		{
			echo "File is an image - ".$check["mime"].".";
			if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) 
			{
			    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			    $uploadOk = 0;
			}
			if ($_FILES["imagen"]["size"] > 500000000)
			{
			    echo "Sorry, your file is too large.";
			    $uploadOk = 0;
			}
			if ($uploadOk == 0)
			{
			    echo "Sorry, your file was not uploaded.";
			} 
			else
			{
			    if (move_uploaded_file($_FILES["imagen"]["tmp_name"],$dir.basename($newfilename)))
			    {
			        echo "The file ". basename( $_FILES["imagen"]["name"]). " has been uploaded.";
					$query = sprintf("UPDATE eventos set img='%s' WHERE nombre='%s'", mysqli_real_escape_string($link, $newfilename),mysqli_real_escape_string($link, $nombre));
					$result = mysqli_query($link, $query);
					if (!$result)
					{
						echo "\nError: ".mysqli_error($link);
					}
			    } 
			    else 
			    {
			        echo "Sorry, there was an error uploading your file.";
			    }
			}
		}
		else 
		{
			echo "File is not an image.";
		}
	}
	if ($main_result)
	{
		header("Location: eventos.php");
	}
	mysqli_close($link);
}
?>