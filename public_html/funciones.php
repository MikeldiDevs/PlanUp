<?php
include 'Mobile_Detect.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'acceso.php';

function mostrar_destacados($ciudad){

	$conexion=mysqli_connect(SERVIDOR,USUARIO,CLAVE,BBDD);
	if(!$conexion){
		print "<p>ERROR DE CONEXION DE BBDD. Error nº ".mysqli_connect_errno($conexion).":".mysqli_connect_error($conexion)."</p>\n";
		return false;
	}
	mysqli_set_charset ( $conexion , 'utf8' );
	/**************************************************************/
	$sql = "select nombre,precio,ciudad,id,img from eventos 
			where ciudad = '$ciudad'
			ORDER BY `eventos`.`prioridad` DESC,`eventos`.`visitas` DESC
			LIMIT 6";
			
			
	//print $sql;
	/***********************************************************/
	if(!($resultado=mysqli_query($conexion ,$sql))){
		print "<p>ERROR ".mysqli_errno($conexion).":".mysqli_error($conexion)."</p>";
		return false;
	}
	/***********************************************************/
	$movil = 0;
	$detect = new Mobile_Detect();
	if ($detect->isMobile())
	{
		$movil = 1;
	}
	session_start();
		while($resul=mysqli_fetch_array($resultado)){
			$id= $resul['id'];
			echo "<div class=\"featured-event\">";
			if ($movil)
			{
				echo "	<img class='image' src='$resul[img]' onclick=\"eventoModal('".$id."')\"/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo 	"</span>";
			}
			else
			{
				echo "	<img class='image' src='$resul[img]'/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo	"<span class=\"middle\" id='vermas'><a class='text'><button onclick=\"eventoModal('".$id."')\">Ver más</button></a>";
				echo 	"</span>";
			}
			if(isset($_SESSION['nombre']) && !empty($_SESSION['nombre']))
			{
				$query = sprintf("select id from favoritos where email='%s' and id='%s'", mysqli_real_escape_string($conexion, $_SESSION['email']), mysqli_real_escape_string($conexion, $id));
				$resultado2 = mysqli_query($conexion, $query);
				if (mysqli_num_rows($resultado2))
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star favourite_icon\" onclick=\"changeStarFill(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
				else
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
			}
			else
			{
				echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
			}
			
			echo "</div>";
		}
			

	/***********************************************************/
	mysqli_free_result($resultado);
	mysqli_close($conexion);
	return true;
}

function mostrar_recomendados($ciudad){


	$conexion=mysqli_connect(SERVIDOR,USUARIO,CLAVE,BBDD);
	if(!$conexion){
		print "<p>ERROR DE CONEXION DE BBDD. Error nº ".mysqli_connect_errno($conexion).":".mysqli_connect_error($conexion)."</p>\n";
		return false;
	}
	mysqli_set_charset ( $conexion , 'utf8' );
	/**************************************************************/
	$sql = "SELECT nombre,precio,ciudad,id,img FROM eventos 
			where ciudad = '$ciudad' and recomendado = 'si'
			LIMIT 6";
	// print $sql;
	/***********************************************************/
	if(!($resultado=mysqli_query($conexion ,$sql))){
		print "<p>ERROR ".mysqli_errno($conexion).":".mysqli_error($conexion)."</p>";
		return false;
	}
	/***********************************************************/
	$movil = 0;
	$detect = new Mobile_Detect();
	if ($detect->isMobile())
	{
		$movil = 1;
	}
	session_start();
		
		while($resul=mysqli_fetch_array($resultado)){
			$id= $resul['id'];
			echo "<div class=\"featured-event\">";
			if ($movil)
			{
				echo "	<img class='image' src='$resul[img]' onclick=\"eventoModal('".$id."')\"/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo 	"</span>";
			}
			else
			{
				echo "	<img class='image' src='$resul[img]'/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo	"<span class=\"middle\" id='vermas'><a class='text'><button onclick=\"eventoModal('".$id."')\">Ver más</button></a>";
				echo 	"</span>";
			}
			if(isset($_SESSION['nombre']) && !empty($_SESSION['nombre']))
			{
				$query = sprintf("select id from favoritos where email='%s' and id='%s'", mysqli_real_escape_string($conexion, $_SESSION['email']), mysqli_real_escape_string($conexion, $id));
				$resultado2 = mysqli_query($conexion, $query);
				if (mysqli_num_rows($resultado2))
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star favourite_icon\" onclick=\"changeStarFill(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
				else
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
			}
			else
			{
				echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
			}
			echo "</div>";
		}
			

	/***********************************************************/
	mysqli_free_result($resultado);
	mysqli_close($conexion);
	return true;
}

function mostrar_ciudades(){
	$conexion=mysqli_connect(SERVIDOR,USUARIO,CLAVE,BBDD);
	if(!$conexion){
		print "<p>ERROR DE CONEXION DE BBDD. Error nº ".mysqli_connect_errno($conexion).":".mysqli_connect_error($conexion)."</p>\n";
		return false;
	}
	mysqli_set_charset ( $conexion , 'utf8' );
	/**************************************************************/
	$sql = "select DISTINCT ciudad from eventos";
	//print $sql;
	/***********************************************************/
	if(!($resultado=mysqli_query($conexion ,$sql))){
		print "<p>ERROR ".mysqli_errno($conexion).":".mysqli_error($conexion)."</p>";
		return false;
	}
	/***********************************************************/

		
		while($resul=mysqli_fetch_array($resultado)){
			echo "<option class='option-city' value='$resul[ciudad]'>$resul[ciudad]</option>";
		}
			

	/***********************************************************/
	mysqli_free_result($resultado);
	mysqli_close($conexion);
	return true;
}

function mostrar_descripcion($id){


	$conexion=mysqli_connect(SERVIDOR,USUARIO,CLAVE,BBDD);
	if(!$conexion){
		print "<p>ERROR DE CONEXION DE BBDD. Error nº ".mysqli_connect_errno($conexion).":".mysqli_connect_error($conexion)."</p>\n";
		return false;
	}
	mysqli_set_charset ( $conexion , 'utf8' );
	/**************************************************************/
	$sql = "select descripcion
			from eventos 
			where id='$id'";
	//print $sql;
	/***********************************************************/
	if(!($resultado=mysqli_query($conexion ,$sql))){
		print "<p>ERROR ".mysqli_errno($conexion).":".mysqli_error($conexion)."</p>";
		return false;
	}
	/***********************************************************/
		
		while($resul=mysqli_fetch_array($resultado)){
			echo "<p>$resul[descripcion]</p>";
		}
			

	/***********************************************************/
	mysqli_free_result($resultado);
	mysqli_close($conexion);
	return true;
}

function mostrar_info($id){


	$conexion=mysqli_connect(SERVIDOR,USUARIO,CLAVE,BBDD);
	if(!$conexion){
		print "<p>ERROR DE CONEXION DE BBDD. Error nº ".mysqli_connect_errno($conexion).":".mysqli_connect_error($conexion)."</p>\n";
		return false;
	}
	mysqli_set_charset ( $conexion , 'utf8' );
	/**************************************************************/
	$sql = "select fecha,hora,ciudad,precio,enlace
			from eventos 
			where id='$id'";
	//print $sql;
	/***********************************************************/
	if(!($resultado=mysqli_query($conexion ,$sql))){
		print "<p>ERROR ".mysqli_errno($conexion).":".mysqli_error($conexion)."</p>";
		return false;
	}
	/***********************************************************/
		
		while($resul=mysqli_fetch_array($resultado)){
		echo "<div class='events-info-margined'>";
		echo	"<div class='event-place'>$resul[ciudad]</div>";
		echo	"<div class='event-date'>$resul[fecha]</div>";
		echo	"<div class='event-hour'>$resul[hora]</div>";
		echo	"<div class='event-price'>$resul[precio]€</div>";
		echo    "</div>";
		echo "<div style='padding: 1% 4%; margin-top: 2%;'>";
		echo	"<button id='modal_button'><div class='event-buy-button' id='$resul[enlace]' style=cursor:pointer>Comprar</div></button>";
		echo "</div>";
		}
			

	/***********************************************************/
	mysqli_free_result($resultado);
	mysqli_close($conexion);
	return true;
}

function mostrar_banner($id){


	$conexion=mysqli_connect(SERVIDOR,USUARIO,CLAVE,BBDD);
	if(!$conexion){
		print "<p>ERROR DE CONEXION DE BBDD. Error nº ".mysqli_connect_errno($conexion).":".mysqli_connect_error($conexion)."</p>\n";
		return false;
	}
	mysqli_set_charset ( $conexion , 'utf8' );
	/**************************************************************/
	$sql = "select img
			from eventos 
			where id='$id'";
	//print $sql;
	/***********************************************************/
	if(!($resultado=mysqli_query($conexion ,$sql))){
		print "<p>ERROR ".mysqli_errno($conexion).":".mysqli_error($conexion)."</p>";
		return false;
	}
	/***********************************************************/
		
		while($resul=mysqli_fetch_array($resultado)){
			echo "<img src='$resul[img]' class='event-banner-img'></img>";		
		}
			

	/***********************************************************/
	mysqli_free_result($resultado);
	mysqli_close($conexion);
	return true;
}

function mostrar_categorias(){


	$conexion=mysqli_connect(SERVIDOR,USUARIO,CLAVE,BBDD);
	if(!$conexion){
		print "<p>ERROR DE CONEXION DE BBDD. Error nº ".mysqli_connect_errno($conexion).":".mysqli_connect_error($conexion)."</p>\n";
		return false;
	}
	mysqli_set_charset ( $conexion , 'utf8' );
	/**************************************************************/
	$sql = "SELECT distinct categoria FROM `eventos`";
	//print $sql;
	/***********************************************************/
	if(!($resultado=mysqli_query($conexion ,$sql))){
		print "<p>ERROR ".mysqli_errno($conexion).":".mysqli_error($conexion)."</p>";
		return false;
	}
	/***********************************************************/
	$detect = new Mobile_Detect();
	if ($detect->isMobile())
	{
		echo "<div class='sidebar-login'>";
			session_start();
			if(isset($_SESSION['nombre']) && !empty($_SESSION['nombre'])) 
			{
				echo "<a href=\"https://planup.ddns.net/perfil.php\"><li class='w3-bar-item w3-button w3-hover-red' style=\"text-transform: capitalize;\">".$_SESSION["nombre"]."</li></a>";
				echo "<a href='https://planup.ddns.net/logout.php'\"><li class='w3-bar-item w3-button w3-hover-red'>Cerrar sesión</li></a>";
			}
			else
			{
				echo "
				<a class='w3-bar-item w3-button w3-hover-red' onclick=\"document.getElementById('id01').style.display='block'\"><li>Iniciar sesión</li></a>
                <a class='w3-bar-item w3-button w3-hover-red' onclick=\"document.getElementById('id02').style.display='block'\"><li>Registrarse</li></a>
                ";
			}
		echo "</div>";
	}
		while($resul=mysqli_fetch_array($resultado)){
			echo "<li class='menu-links w3-bar-item w3-button w3-hover-red' style='cursor:pointer'>$resul[categoria]</li>";				
		}
			

	/***********************************************************/
	mysqli_free_result($resultado);
	mysqli_close($conexion);
	return true;
}

function mostrar_categorias_href(){

	$conexion=mysqli_connect(SERVIDOR,USUARIO,CLAVE,BBDD);
	if(!$conexion){
		print "<p>ERROR DE CONEXION DE BBDD. Error nº ".mysqli_connect_errno($conexion).":".mysqli_connect_error($conexion)."</p>\n";
		return false;
	}
	mysqli_set_charset ( $conexion , 'utf8' );
	/**************************************************************/
	$sql = "SELECT distinct categoria FROM `eventos`";
	//print $sql;
	/***********************************************************/
	if(!($resultado=mysqli_query($conexion ,$sql))){
		print "<p>ERROR ".mysqli_errno($conexion).":".mysqli_error($conexion)."</p>";
		return false;
	}
	/***********************************************************/
	$detect = new Mobile_Detect();
	if ($detect->isMobile())
	{
		echo "<div class='sidebar-login'>";
			session_start();
			if(isset($_SESSION['nombre']) && !empty($_SESSION['nombre'])) 
			{
				echo "<a href=\"https://planup.ddns.net/perfil.php\"><li class='w3-bar-item w3-button w3-hover-red' style=\"text-transform: capitalize;\">".$_SESSION["nombre"]."</li></a>";
				echo "<a href='https://planup.ddns.net/logout.php'\"><li class='w3-bar-item w3-button w3-hover-red'>Cerrar sesión</li></a>";
			}
			else
			{
				echo "
				<a class='w3-bar-item w3-button w3-hover-red' onclick=\"document.getElementById('id01').style.display='block'\"><li>Iniciar sesión</li></a>
                <a class='w3-bar-item w3-button w3-hover-red' onclick=\"document.getElementById('id02').style.display='block'\"><li>Registrarse</li></a>
                ";
			}
		echo "</div>";
	}
		while($resul=mysqli_fetch_array($resultado)){
			$categoria=$resul['categoria'];
			echo "<a id='eventos.php?categoria=".$categoria."' ><li class='menu-links w3-bar-item w3-button w3-hover-red' >$resul[categoria]</li></a>";		
		}
			

	/***********************************************************/
	mysqli_free_result($resultado);
	mysqli_close($conexion);
	return true;
}

function mostrar_categorias_href2(){

	$conexion=mysqli_connect(SERVIDOR,USUARIO,CLAVE,BBDD);
	if(!$conexion){
		print "<p>ERROR DE CONEXION DE BBDD. Error nº ".mysqli_connect_errno($conexion).":".mysqli_connect_error($conexion)."</p>\n";
		return false;
	}
	mysqli_set_charset ( $conexion , 'utf8' );
	/**************************************************************/
	$sql = "SELECT distinct categoria FROM `eventos`";
	//print $sql;
	/***********************************************************/
	if(!($resultado=mysqli_query($conexion ,$sql))){
		print "<p>ERROR ".mysqli_errno($conexion).":".mysqli_error($conexion)."</p>";
		return false;
	}
	/***********************************************************/
	$detect = new Mobile_Detect();
	if ($detect->isMobile())
	{
		echo "<div class='sidebar-login'>";
			session_start();
			if(isset($_SESSION['nombre']) && !empty($_SESSION['nombre'])) 
			{
				echo "<a href=\"https://planup.ddns.net/perfil.php\"><li class='w3-bar-item w3-button w3-hover-red' style=\"text-transform: capitalize;\">".$_SESSION["nombre"]."</li></a>";
				echo "<a href='https://planup.ddns.net/logout.php'\"><li class='w3-bar-item w3-button w3-hover-red'>Cerrar sesión</li></a>";
			}
			else
			{
				echo "
				<a class='w3-bar-item w3-button w3-hover-red' onclick=\"document.getElementById('id01').style.display='block'\"><li>Iniciar sesión</li></a>
                <a class='w3-bar-item w3-button w3-hover-red' onclick=\"document.getElementById('id02').style.display='block'\"><li>Registrarse</li></a>
                ";
			}
		echo "</div>";
	}
		while($resul=mysqli_fetch_array($resultado)){
			$categoria=$resul['categoria'];
			echo "<a href='eventos.php?categoria=".$categoria."' ><li class='menu-links w3-bar-item w3-button w3-hover-red' >$resul[categoria]</li></a>";		
		}
			

	/***********************************************************/
	mysqli_free_result($resultado);
	mysqli_close($conexion);
	return true;
}

function mostrar_relacionados($categoria){


	$conexion=mysqli_connect(SERVIDOR,USUARIO,CLAVE,BBDD);
	if(!$conexion){
		print "<p>ERROR DE CONEXION DE BBDD. Error nº ".mysqli_connect_errno($conexion).":".mysqli_connect_error($conexion)."</p>\n";
		return false;
	}
	mysqli_set_charset ( $conexion , 'utf8' );
	/**************************************************************/
	$sql = "SELECT distinct categoria FROM `eventos`";
	//print $sql;
	/***********************************************************/
	if(!($resultado=mysqli_query($conexion ,$sql))){
		print "<p>ERROR ".mysqli_errno($conexion).":".mysqli_error($conexion)."</p>";
		return false;
	}
	/***********************************************************/
		
		while($resul=mysqli_fetch_array($resultado)){
			echo "<li class='left-menu-ul-li'>$resul[categoria]</li>";		
		}
			

	/***********************************************************/
	mysqli_free_result($resultado);
	mysqli_close($conexion);
	return true;
}

function mostrar_eventos($categoria,$ciudad){

	
	$conexion=mysqli_connect(SERVIDOR,USUARIO,CLAVE,BBDD);
	if(!$conexion){
		print "<p>ERROR DE CONEXION DE BBDD. Error nº ".mysqli_connect_errno($conexion).":".mysqli_connect_error($conexion)."</p>\n";
		return false;
	}
	mysqli_set_charset ( $conexion , 'utf8' );
	/**************************************************************/
	if($categoria && $ciudad){
		$sql = "SELECT nombre,precio,ciudad,id,img FROM eventos
			where categoria = '$categoria' and ciudad = '$ciudad'
			ORDER BY `eventos`.`prioridad` DESC,`eventos`.`visitas` DESC
			LIMIT 6";
	}else if($categoria){
		$sql = "SELECT nombre,precio,ciudad,id,categoria,img FROM eventos
			where categoria = '$categoria'
			ORDER BY `eventos`.`prioridad` DESC,`eventos`.`visitas` DESC
			LIMIT 6";
	}else{
		$sql = "SELECT nombre,precio,ciudad,id,img FROM eventos
			ORDER BY `eventos`.`prioridad` DESC,`eventos`.`visitas` DESC
			LIMIT 6";
	}
	//print $sql;
	/***********************************************************/
	if(!($resultado=mysqli_query($conexion ,$sql))){
		print "<p>ERROR ".mysqli_errno($conexion).":".mysqli_error($conexion)."</p>";
		return false;
	}
	/***********************************************************/
	$movil = 0;
	$detect = new Mobile_Detect();
	if ($detect->isMobile())
	{
		$movil = 1;
	}
	session_start();
		while($resul=mysqli_fetch_array($resultado)){
			$id= $resul['id'];
			echo "<div class=\"featured-event\">";
			if ($movil)
			{
				echo "	<img class='image' src='$resul[img]' onclick=\"eventoModal('".$id."')\"/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo 	"</span>";
			}
			else
			{
				echo "	<img class='image' src='$resul[img]'/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo	"<span class=\"middle\" id='vermas'><a class='text'><button onclick=\"eventoModal('".$id."')\">Ver más</button></a>";
				echo 	"</span>";
			}
			if(isset($_SESSION['nombre']) && !empty($_SESSION['nombre']))
			{
				$query = sprintf("select id from favoritos where email='%s' and id='%s'", mysqli_real_escape_string($conexion, $_SESSION['email']), mysqli_real_escape_string($conexion, $id));
				$resultado2 = mysqli_query($conexion, $query);
				if (mysqli_num_rows($resultado2))
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star favourite_icon\" onclick=\"changeStarFill(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
				else
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
			}
			else
			{
				echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
			}
			echo "</div>";	
		}
			

	/***********************************************************/
	mysqli_free_result($resultado);
	mysqli_close($conexion);
	return true;
}

function mostrar_todos($categoria,$ciudad){

	
	$conexion=mysqli_connect(SERVIDOR,USUARIO,CLAVE,BBDD);
	if(!$conexion){
		print "<p>ERROR DE CONEXION DE BBDD. Error nº ".mysqli_connect_errno($conexion).":".mysqli_connect_error($conexion)."</p>\n";
		return false;
	}
	mysqli_set_charset ( $conexion , 'utf8' );
	/**************************************************************/
	if($categoria && $ciudad){
		$sql = "SELECT nombre,precio,ciudad,id,img FROM eventos
				WHERE categoria = '$categoria' AND 	ciudad='$ciudad'
				ORDER BY `eventos`.`prioridad` DESC,`eventos`.`visitas` DESC
				";
	}else if($categoria){
		$sql = "SELECT nombre,precio,ciudad,id,img FROM eventos
				WHERE categoria = '$categoria'
				ORDER BY `eventos`.`prioridad` DESC,`eventos`.`visitas` DESC
				";
	}
	// print $sql;
	/***********************************************************/
	if(!($resultado=mysqli_query($conexion ,$sql))){
		print "<p>ERROR ".mysqli_errno($conexion).":".mysqli_error($conexion)."</p>";
		return false;
	}
	/***********************************************************/
	$movil = 0;
	$detect = new Mobile_Detect();
	if ($detect->isMobile())
	{
		$movil = 1;
	}
	session_start();
		while($resul=mysqli_fetch_array($resultado)){
			$id= $resul['id'];
			echo "<div class=\"featured-event\">";
			if ($movil)
			{
				echo "	<img class='image' src='$resul[img]' onclick=\"eventoModal('".$id."')\"/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo 	"</span>";
			}
			else
			{
				echo "	<img class='image' src='$resul[img]'/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo	"<span class=\"middle\" id='vermas'><a class='text'><button onclick=\"eventoModal('".$id."')\">Ver más</button></a>";
				echo 	"</span>";
			}
			if(isset($_SESSION['nombre']) && !empty($_SESSION['nombre']))
			{
				$query = sprintf("select id from favoritos where email='%s' and id='%s'", mysqli_real_escape_string($conexion, $_SESSION['email']), mysqli_real_escape_string($conexion, $id));
				$resultado2 = mysqli_query($conexion, $query);
				if (mysqli_num_rows($resultado2))
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star favourite_icon\" onclick=\"changeStarFill(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
				else
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
			}
			else
			{
				echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
			}
			echo "</div>";	
		}
			

	/***********************************************************/
	mysqli_free_result($resultado);
	mysqli_close($conexion);
	return true;
}

function mostrar_favoritos($email){

	$conexion=mysqli_connect(SERVIDOR,USUARIO,CLAVE,BBDD);
	if(!$conexion){
		print "<p>ERROR DE CONEXION DE BBDD. Error nº ".mysqli_connect_errno($conexion).":".mysqli_connect_error($conexion)."</p>\n";
		return false;
	}
	mysqli_set_charset ( $conexion , 'utf8' );
	/**************************************************************/
	$sql = "select nombre,precio,ciudad,eventos.id,img from eventos, favoritos
			where favoritos.email = '$email' and favoritos.id = eventos.id";
			
			
	//print $sql;
	/***********************************************************/
	if(!($resultado=mysqli_query($conexion ,$sql))){
		print "<p>ERROR ".mysqli_errno($conexion).":".mysqli_error($conexion)."</p>";
		return false;
	}
	/***********************************************************/

	$movil = 0;
	$detect = new Mobile_Detect();
	if ($detect->isMobile())
	{
		$movil = 1;
	}
	while($resul=mysqli_fetch_array($resultado)){
		$id= $resul['id'];
		$id= $resul['id'];
		echo "<div class=\"featured-event\">";
		if ($movil)
		{
			echo "	<img class='image' src='$resul[img]' onclick=\"eventoModal('".$id."')\"/>";
			echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
			echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
			echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
		}
		else
		{
			echo "	<img class='image' src='$resul[img]'/>";
			echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
			echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
			echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
			echo	"<span class=\"middle\" id='vermas'><a class='text'><button onclick=\"eventoModal('".$id."')\">Ver más</button></a>";
		}
		echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'>Eliminar</a>";
		echo 	"</span>";
		echo "</div>";
	}
			

	/***********************************************************/
	mysqli_free_result($resultado);
	mysqli_close($conexion);
	return true;
}

function add_favoritos($email, $id){
	$conexion=mysqli_connect(SERVIDOR,USUARIO,CLAVE,BBDD);
	if(!$conexion){
		print "<p>ERROR DE CONEXION DE BBDD. Error nº ".mysqli_connect_errno($conexion).":".mysqli_connect_error($conexion)."</p>\n";
		return false;
	}
	mysqli_set_charset ( $conexion , 'utf8' );

	$query = sprintf("SELECT id FROM favoritos WHERE id='%s' and email='%s'", mysqli_real_escape_string($conexion, $id), mysqli_real_escape_string($conexion, $email));
	$result = mysqli_query($conexion, $query);
	if (mysqli_num_rows($result))
	{
		$query = sprintf("delete from favoritos WHERE id='%s' and email='%s'", mysqli_real_escape_string($conexion, $id), mysqli_real_escape_string($conexion, $email));
		$result = mysqli_query($conexion, $query);
		if (!$result)
		{
			echo "\nError: ".mysqli_error($conexion);
		}
		else
		{
			print('Evento eliminado de favoritos. (Mensaje de beta)');
		}
	 	mysqli_close($conexion);
	 	return false;
	} 
	else
	{
		$query = sprintf("insert into favoritos(id, email) values ('%s', '%s')", mysqli_real_escape_string($conexion, $id), mysqli_real_escape_string($conexion, $email));
		$result = mysqli_query($conexion, $query);
		if (!$result)
		{
			echo "\nError: ".mysqli_error($conexion);
		}
		else
		{
			print("Evento añadido a favoritos. (Mensaje de beta)");
		}
		mysqli_close($conexion);
		return true;
	}
}

function quitar_favorito($email, $id){
	$conexion=mysqli_connect(SERVIDOR,USUARIO,CLAVE,BBDD);
	if(!$conexion){
		print "<p>ERROR DE CONEXION DE BBDD. Error nº ".mysqli_connect_errno($conexion).":".mysqli_connect_error($conexion)."</p>\n";
		return false;
	}
	mysqli_set_charset ( $conexion , 'utf8' );

	$query = sprintf("delete from favoritos WHERE id='%s' and email='%s'", mysqli_real_escape_string($conexion, $id), mysqli_real_escape_string($conexion, $email));
	$result = mysqli_query($conexion, $query);
	if (!$result)
	{
		echo "\nError: ".mysqli_error($conexion);
	}
	else
	{
		print('Evento eliminado de favoritos. (Mensaje de beta)');
	}
 	mysqli_close($conexion);
	
}

function filtro_semana(){
	
	$conexion=mysqli_connect(SERVIDOR,USUARIO,CLAVE,BBDD);
	if(!$conexion){
		print "<p>ERROR DE CONEXION DE BBDD. Error nº ".mysqli_connect_errno($conexion).":".mysqli_connect_error($conexion)."</p>\n";
		return false;
	}
	mysqli_set_charset ( $conexion , 'utf8' );
	/**************************************************************/
	$sql = "SELECT nombre,precio,ciudad,id,img 
			FROM eventos 
			WHERE YEARWEEK(`fecha`, 1) = YEARWEEK(CURDATE(), 1)";
	// print $sql;
	/***********************************************************/
	if(!($resultado=mysqli_query($conexion ,$sql))){
		print "<p>ERROR ".mysqli_errno($conexion).":".mysqli_error($conexion)."</p>";
		return false;
	}
	/***********************************************************/
	$movil = 0;
	$detect = new Mobile_Detect();
	if ($detect->isMobile())
	{
		$movil = 1;
	}
	session_start();
		while($resul=mysqli_fetch_array($resultado)){
			$id= $resul['id'];
			echo "<div class=\"featured-event\">";
			if ($movil)
			{
				echo "	<img class='image' src='$resul[img]' onclick=\"eventoModal('".$id."')\"/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo 	"</span>";
			}
			else
			{
				echo "	<img class='image' src='$resul[img]'/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo	"<span class=\"middle\" id='vermas'><a class='text'><button onclick=\"eventoModal('".$id."')\">Ver más</button></a>";
				echo 	"</span>";
			}
			if(isset($_SESSION['nombre']) && !empty($_SESSION['nombre']))
			{
				$query = sprintf("select id from favoritos where email='%s' and id='%s'", mysqli_real_escape_string($conexion, $_SESSION['email']), mysqli_real_escape_string($conexion, $id));
				$resultado2 = mysqli_query($conexion, $query);
				if (mysqli_num_rows($resultado2))
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star favourite_icon\" onclick=\"changeStarFill(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
				else
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
			}
			else
			{
				echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
			}
			echo "</div>";	
		}
			

	/***********************************************************/
	mysqli_free_result($resultado);
	mysqli_close($conexion);
	return true;
	
	
}

function filtro_mes(){
	
	$conexion=mysqli_connect(SERVIDOR,USUARIO,CLAVE,BBDD);
	if(!$conexion){
		print "<p>ERROR DE CONEXION DE BBDD. Error nº ".mysqli_connect_errno($conexion).":".mysqli_connect_error($conexion)."</p>\n";
		return false;
	}
	mysqli_set_charset ( $conexion , 'utf8' );
	/**************************************************************/
	$sql = "SELECT nombre,precio,ciudad,id,img 
			FROM eventos 
			WHERE month(fecha) = month(curdate())";
	// print $sql;
	/***********************************************************/
	if(!($resultado=mysqli_query($conexion ,$sql))){
		print "<p>ERROR ".mysqli_errno($conexion).":".mysqli_error($conexion)."</p>";
		return false;
	}
	/***********************************************************/
	$movil = 0;
	$detect = new Mobile_Detect();
	if ($detect->isMobile())
	{
		$movil = 1;
	}
	session_start();
		while($resul=mysqli_fetch_array($resultado)){
			$id= $resul['id'];
			echo "<div class=\"featured-event\">";
			if ($movil)
			{
				echo "	<img class='image' src='$resul[img]' onclick=\"eventoModal('".$id."')\"/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo 	"</span>";
			}
			else
			{
				echo "	<img class='image' src='$resul[img]'/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo	"<span class=\"middle\" id='vermas'><a class='text'><button onclick=\"eventoModal('".$id."')\">Ver más</button></a>";
				echo 	"</span>";
			}
			if(isset($_SESSION['nombre']) && !empty($_SESSION['nombre']))
			{
				$query = sprintf("select id from favoritos where email='%s' and id='%s'", mysqli_real_escape_string($conexion, $_SESSION['email']), mysqli_real_escape_string($conexion, $id));
				$resultado2 = mysqli_query($conexion, $query);
				if (mysqli_num_rows($resultado2))
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star favourite_icon\" onclick=\"changeStarFill(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
				else
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
			}
			else
			{
				echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
			}
			echo "</div>";	
		}
			

	/***********************************************************/
	mysqli_free_result($resultado);
	mysqli_close($conexion);
	return true;
	
	
}

function filtro_hoy(){
	$conexion=mysqli_connect(SERVIDOR,USUARIO,CLAVE,BBDD);
	if(!$conexion){
		print "<p>ERROR DE CONEXION DE BBDD. Error nº ".mysqli_connect_errno($conexion).":".mysqli_connect_error($conexion)."</p>\n";
		return false;
	}
	mysqli_set_charset ( $conexion , 'utf8' );
	/**************************************************************/
	$sql = "SELECT nombre,precio,ciudad,id,img 
			FROM eventos 
			WHERE day(fecha) = day(curdate())";
	// print $sql;
	/***********************************************************/
	if(!($resultado=mysqli_query($conexion ,$sql))){
		print "<p>ERROR ".mysqli_errno($conexion).":".mysqli_error($conexion)."</p>";
		return false;
	}
	/***********************************************************/
	$movil = 0;
	$detect = new Mobile_Detect();
	if ($detect->isMobile())
	{
		$movil = 1;
	}
	session_start();
		while($resul=mysqli_fetch_array($resultado)){
			$id= $resul['id'];
			echo "<div class=\"featured-event\">";
			if ($movil)
			{
				echo "	<img class='image' src='$resul[img]' onclick=\"eventoModal('".$id."')\"/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo 	"</span>";
			}
			else
			{
				echo "	<img class='image' src='$resul[img]'/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo	"<span class=\"middle\" id='vermas'><a class='text'><button onclick=\"eventoModal('".$id."')\">Ver más</button></a>";
				echo 	"</span>";
			}
			if(isset($_SESSION['nombre']) && !empty($_SESSION['nombre']))
			{
				$query = sprintf("select id from favoritos where email='%s' and id='%s'", mysqli_real_escape_string($conexion, $_SESSION['email']), mysqli_real_escape_string($conexion, $id));
				$resultado2 = mysqli_query($conexion, $query);
				if (mysqli_num_rows($resultado2))
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star favourite_icon\" onclick=\"changeStarFill(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
				else
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
			}
			else
			{
				echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
			}
			echo "</div>";	
		}
			

	/***********************************************************/
	mysqli_free_result($resultado);
	mysqli_close($conexion);
	return true;
}

function filtro_todos(){
	$conexion=mysqli_connect(SERVIDOR,USUARIO,CLAVE,BBDD);
	if(!$conexion){
		print "<p>ERROR DE CONEXION DE BBDD. Error nº ".mysqli_connect_errno($conexion).":".mysqli_connect_error($conexion)."</p>\n";
		return false;
	}
	mysqli_set_charset ( $conexion , 'utf8' );
	/**************************************************************/
	$sql = "SELECT nombre,precio,ciudad,id,img 
			FROM eventos ";
	// print $sql;
	/***********************************************************/
	if(!($resultado=mysqli_query($conexion ,$sql))){
		print "<p>ERROR ".mysqli_errno($conexion).":".mysqli_error($conexion)."</p>";
		return false;
	}
	/***********************************************************/
	$movil = 0;
	$detect = new Mobile_Detect();
	if ($detect->isMobile())
	{
		$movil = 1;
	}
	session_start();
		while($resul=mysqli_fetch_array($resultado)){
			$id= $resul['id'];
			echo "<div class=\"featured-event\">";
			if ($movil)
			{
				echo "	<img class='image' src='$resul[img]' onclick=\"eventoModal('".$id."')\"/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo 	"</span>";
			}
			else
			{
				echo "	<img class='image' src='$resul[img]'/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo	"<span class=\"middle\" id='vermas'><a class='text'><button onclick=\"eventoModal('".$id."')\">Ver más</button></a>";
				echo 	"</span>";
			}
			if(isset($_SESSION['nombre']) && !empty($_SESSION['nombre']))
			{
				$query = sprintf("select id from favoritos where email='%s' and id='%s'", mysqli_real_escape_string($conexion, $_SESSION['email']), mysqli_real_escape_string($conexion, $id));
				$resultado2 = mysqli_query($conexion, $query);
				if (mysqli_num_rows($resultado2))
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star favourite_icon\" onclick=\"changeStarFill(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
				else
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
			}
			else
			{
				echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
			}
			echo "</div>";	
		}
			

	/***********************************************************/
	mysqli_free_result($resultado);
	mysqli_close($conexion);
	return true;
}

function orden_all_asc($ciudad,$categoria){
	$conexion=mysqli_connect(SERVIDOR,USUARIO,CLAVE,BBDD);
	if(!$conexion){
		print "<p>ERROR DE CONEXION DE BBDD. Error nº ".mysqli_connect_errno($conexion).":".mysqli_connect_error($conexion)."</p>\n";
		return false;
	}
	mysqli_set_charset ( $conexion , 'utf8' );
	/**************************************************************/
	$sql = "SELECT nombre,precio,ciudad,id,img 
			FROM eventos
			WHERE ciudad = '$ciudad' AND categoria = '$categoria'
			ORDER BY precio asc";
	// print $sql;
	/***********************************************************/
	if(!($resultado=mysqli_query($conexion ,$sql))){
		print "<p>ERROR ".mysqli_errno($conexion).":".mysqli_error($conexion)."</p>";
		return false;
	}
	/***********************************************************/
	$movil = 0;
	$detect = new Mobile_Detect();
	if ($detect->isMobile())
	{
		$movil = 1;
	}
	session_start();
		while($resul=mysqli_fetch_array($resultado)){
			$id= $resul['id'];
			echo "<div class=\"featured-event\">";
			if ($movil)
			{
				echo "	<img class='image' src='$resul[img]' onclick=\"eventoModal('".$id."')\"/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo 	"</span>";
			}
			else
			{
				echo "	<img class='image' src='$resul[img]'/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo	"<span class=\"middle\" id='vermas'><a class='text'><button onclick=\"eventoModal('".$id."')\">Ver más</button></a>";
				echo 	"</span>";
			}
			if(isset($_SESSION['nombre']) && !empty($_SESSION['nombre']))
			{
				$query = sprintf("select id from favoritos where email='%s' and id='%s'", mysqli_real_escape_string($conexion, $_SESSION['email']), mysqli_real_escape_string($conexion, $id));
				$resultado2 = mysqli_query($conexion, $query);
				if (mysqli_num_rows($resultado2))
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star favourite_icon\" onclick=\"changeStarFill(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
				else
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
			}
			else
			{
				echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
			}
			echo "</div>";	
		}
			

	/***********************************************************/
	mysqli_free_result($resultado);
	mysqli_close($conexion);
	return true;
}
function orden_all_desc($ciudad,$categoria){
	$conexion=mysqli_connect(SERVIDOR,USUARIO,CLAVE,BBDD);
	if(!$conexion){
		print "<p>ERROR DE CONEXION DE BBDD. Error nº ".mysqli_connect_errno($conexion).":".mysqli_connect_error($conexion)."</p>\n";
		return false;
	}
	mysqli_set_charset ( $conexion , 'utf8' );
	/**************************************************************/
	$sql = "SELECT nombre,precio,ciudad,id,img 
			FROM eventos 
			WHERE ciudad = '$ciudad' AND categoria = '$categoria'
			ORDER BY precio desc";
	// print $sql;
	/***********************************************************/
	if(!($resultado=mysqli_query($conexion ,$sql))){
		print "<p>ERROR ".mysqli_errno($conexion).":".mysqli_error($conexion)."</p>";
		return false;
	}
	/***********************************************************/
	$movil = 0;
	$detect = new Mobile_Detect();
	if ($detect->isMobile())
	{
		$movil = 1;
	}
	session_start();
		while($resul=mysqli_fetch_array($resultado)){
			$id= $resul['id'];
			echo "<div class=\"featured-event\">";
			if ($movil)
			{
				echo "	<img class='image' src='$resul[img]' onclick=\"eventoModal('".$id."')\"/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo 	"</span>";
			}
			else
			{
				echo "	<img class='image' src='$resul[img]'/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo	"<span class=\"middle\" id='vermas'><a class='text'><button onclick=\"eventoModal('".$id."')\">Ver más</button></a>";
				echo 	"</span>";
			}
			if(isset($_SESSION['nombre']) && !empty($_SESSION['nombre']))
			{
				$query = sprintf("select id from favoritos where email='%s' and id='%s'", mysqli_real_escape_string($conexion, $_SESSION['email']), mysqli_real_escape_string($conexion, $id));
				$resultado2 = mysqli_query($conexion, $query);
				if (mysqli_num_rows($resultado2))
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star favourite_icon\" onclick=\"changeStarFill(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
				else
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
			}
			else
			{
				echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
			}
			echo "</div>";	
		}
			

	/***********************************************************/
	mysqli_free_result($resultado);
	mysqli_close($conexion);
	return true;
}
function orden_all_fecha($ciudad,$categoria){
	$conexion=mysqli_connect(SERVIDOR,USUARIO,CLAVE,BBDD);
	if(!$conexion){
		print "<p>ERROR DE CONEXION DE BBDD. Error nº ".mysqli_connect_errno($conexion).":".mysqli_connect_error($conexion)."</p>\n";
		return false;
	}
	mysqli_set_charset ( $conexion , 'utf8' );
	/**************************************************************/
	$sql = "SELECT nombre,precio,ciudad,id,img 
			FROM eventos 
			WHERE ciudad = '$ciudad' AND categoria = '$categoria'
			ORDER BY fecha";
	// print $sql;
	/***********************************************************/
	if(!($resultado=mysqli_query($conexion ,$sql))){
		print "<p>ERROR ".mysqli_errno($conexion).":".mysqli_error($conexion)."</p>";
		return false;
	}
	/***********************************************************/
	$movil = 0;
	$detect = new Mobile_Detect();
	if ($detect->isMobile())
	{
		$movil = 1;
	}
	session_start();
		while($resul=mysqli_fetch_array($resultado)){
			$id= $resul['id'];
			echo "<div class=\"featured-event\">";
			if ($movil)
			{
				echo "	<img class='image' src='$resul[img]' onclick=\"eventoModal('".$id."')\"/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo 	"</span>";
			}
			else
			{
				echo "	<img class='image' src='$resul[img]'/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo	"<span class=\"middle\" id='vermas'><a class='text'><button onclick=\"eventoModal('".$id."')\">Ver más</button></a>";
				echo 	"</span>";
			}
			if(isset($_SESSION['nombre']) && !empty($_SESSION['nombre']))
			{
				$query = sprintf("select id from favoritos where email='%s' and id='%s'", mysqli_real_escape_string($conexion, $_SESSION['email']), mysqli_real_escape_string($conexion, $id));
				$resultado2 = mysqli_query($conexion, $query);
				if (mysqli_num_rows($resultado2))
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star favourite_icon\" onclick=\"changeStarFill(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
				else
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
			}
			else
			{
				echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
			}
			echo "</div>";	
		}
			

	/***********************************************************/
	mysqli_free_result($resultado);
	mysqli_close($conexion);
	return true;
}

function orden_hoy_asc($ciudad,$categoria){
	$conexion=mysqli_connect(SERVIDOR,USUARIO,CLAVE,BBDD);
	if(!$conexion){
		print "<p>ERROR DE CONEXION DE BBDD. Error nº ".mysqli_connect_errno($conexion).":".mysqli_connect_error($conexion)."</p>\n";
		return false;
	}
	mysqli_set_charset ( $conexion , 'utf8' );
	/**************************************************************/
	$sql = "SELECT nombre,precio,ciudad,id,img 
			FROM eventos 
			WHERE day(fecha) = day(curdate())
			AND ciudad = '$ciudad' AND categoria = '$categoria'
			order by precio asc";
	// print $sql;
	/***********************************************************/
	if(!($resultado=mysqli_query($conexion ,$sql))){
		print "<p>ERROR ".mysqli_errno($conexion).":".mysqli_error($conexion)."</p>";
		return false;
	}
	/***********************************************************/
	$movil = 0;
	$detect = new Mobile_Detect();
	if ($detect->isMobile())
	{
		$movil = 1;
	}
	session_start();
		while($resul=mysqli_fetch_array($resultado)){
			$id= $resul['id'];
			echo "<div class=\"featured-event\">";
			if ($movil)
			{
				echo "	<img class='image' src='$resul[img]' onclick=\"eventoModal('".$id."')\"/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo 	"</span>";
			}
			else
			{
				echo "	<img class='image' src='$resul[img]'/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo	"<span class=\"middle\" id='vermas'><a class='text'><button onclick=\"eventoModal('".$id."')\">Ver más</button></a>";
				echo 	"</span>";
			}
			if(isset($_SESSION['nombre']) && !empty($_SESSION['nombre']))
			{
				$query = sprintf("select id from favoritos where email='%s' and id='%s'", mysqli_real_escape_string($conexion, $_SESSION['email']), mysqli_real_escape_string($conexion, $id));
				$resultado2 = mysqli_query($conexion, $query);
				if (mysqli_num_rows($resultado2))
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star favourite_icon\" onclick=\"changeStarFill(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
				else
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
			}
			else
			{
				echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
			}
			echo "</div>";	
		}
			

	/***********************************************************/
	mysqli_free_result($resultado);
	mysqli_close($conexion);
	return true;
}
function orden_hoy_desc($ciudad,$categoria){
	$conexion=mysqli_connect(SERVIDOR,USUARIO,CLAVE,BBDD);
	if(!$conexion){
		print "<p>ERROR DE CONEXION DE BBDD. Error nº ".mysqli_connect_errno($conexion).":".mysqli_connect_error($conexion)."</p>\n";
		return false;
	}
	mysqli_set_charset ( $conexion , 'utf8' );
	/**************************************************************/
	$sql = "SELECT nombre,precio,ciudad,id,img 
			FROM eventos 
			WHERE day(fecha) = day(curdate())
			AND ciudad = '$ciudad' AND categoria = '$categoria'
			order by precio desc";
	// print $sql;
	/***********************************************************/
	if(!($resultado=mysqli_query($conexion ,$sql))){
		print "<p>ERROR ".mysqli_errno($conexion).":".mysqli_error($conexion)."</p>";
		return false;
	}
	/***********************************************************/
	$movil = 0;
	$detect = new Mobile_Detect();
	if ($detect->isMobile())
	{
		$movil = 1;
	}
	session_start();
		while($resul=mysqli_fetch_array($resultado)){
			$id= $resul['id'];
			echo "<div class=\"featured-event\">";
			if ($movil)
			{
				echo "	<img class='image' src='$resul[img]' onclick=\"eventoModal('".$id."')\"/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo 	"</span>";
			}
			else
			{
				echo "	<img class='image' src='$resul[img]'/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo	"<span class=\"middle\" id='vermas'><a class='text'><button onclick=\"eventoModal('".$id."')\">Ver más</button></a>";
				echo 	"</span>";
			}
			if(isset($_SESSION['nombre']) && !empty($_SESSION['nombre']))
			{
				$query = sprintf("select id from favoritos where email='%s' and id='%s'", mysqli_real_escape_string($conexion, $_SESSION['email']), mysqli_real_escape_string($conexion, $id));
				$resultado2 = mysqli_query($conexion, $query);
				if (mysqli_num_rows($resultado2))
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star favourite_icon\" onclick=\"changeStarFill(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
				else
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
			}
			else
			{
				echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
			}
			echo "</div>";	
		}
			

	/***********************************************************/
	mysqli_free_result($resultado);
	mysqli_close($conexion);
	return true;
}
function orden_hoy_fecha($ciudad,$categoria){
	$conexion=mysqli_connect(SERVIDOR,USUARIO,CLAVE,BBDD);
	if(!$conexion){
		print "<p>ERROR DE CONEXION DE BBDD. Error nº ".mysqli_connect_errno($conexion).":".mysqli_connect_error($conexion)."</p>\n";
		return false;
	}
	mysqli_set_charset ( $conexion , 'utf8' );
	/**************************************************************/
	$sql = "SELECT nombre,precio,ciudad,id,img 
			FROM eventos 
			WHERE day(fecha) = day(curdate())
			AND ciudad = '$ciudad' AND categoria = '$categoria'
			order by fecha";
	// print $sql;
	/***********************************************************/
	if(!($resultado=mysqli_query($conexion ,$sql))){
		print "<p>ERROR ".mysqli_errno($conexion).":".mysqli_error($conexion)."</p>";
		return false;
	}
	/***********************************************************/
	$movil = 0;
	$detect = new Mobile_Detect();
	if ($detect->isMobile())
	{
		$movil = 1;
	}
	session_start();
		while($resul=mysqli_fetch_array($resultado)){
			$id= $resul['id'];
			echo "<div class=\"featured-event\">";
			if ($movil)
			{
				echo "	<img class='image' src='$resul[img]' onclick=\"eventoModal('".$id."')\"/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo 	"</span>";
			}
			else
			{
				echo "	<img class='image' src='$resul[img]'/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo	"<span class=\"middle\" id='vermas'><a class='text'><button onclick=\"eventoModal('".$id."')\">Ver más</button></a>";
				echo 	"</span>";
			}
			if(isset($_SESSION['nombre']) && !empty($_SESSION['nombre']))
			{
				$query = sprintf("select id from favoritos where email='%s' and id='%s'", mysqli_real_escape_string($conexion, $_SESSION['email']), mysqli_real_escape_string($conexion, $id));
				$resultado2 = mysqli_query($conexion, $query);
				if (mysqli_num_rows($resultado2))
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star favourite_icon\" onclick=\"changeStarFill(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
				else
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
			}
			else
			{
				echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
			}
			echo "</div>";	
		}
			

	/***********************************************************/
	mysqli_free_result($resultado);
	mysqli_close($conexion);
	return true;
}

function orden_sem_asc($ciudad,$categoria){
	$conexion=mysqli_connect(SERVIDOR,USUARIO,CLAVE,BBDD);
	if(!$conexion){
		print "<p>ERROR DE CONEXION DE BBDD. Error nº ".mysqli_connect_errno($conexion).":".mysqli_connect_error($conexion)."</p>\n";
		return false;
	}
	mysqli_set_charset ( $conexion , 'utf8' );
	/**************************************************************/
	$sql = "SELECT nombre,precio,ciudad,id,img 
			FROM eventos 
			WHERE YEARWEEK(`fecha`, 1) = YEARWEEK(CURDATE(), 1)
			AND ciudad = '$ciudad' AND categoria = '$categoria'
			order by precio asc";
	// print $sql;
	/***********************************************************/
	if(!($resultado=mysqli_query($conexion ,$sql))){
		print "<p>ERROR ".mysqli_errno($conexion).":".mysqli_error($conexion)."</p>";
		return false;
	}
	/***********************************************************/
	$movil = 0;
	$detect = new Mobile_Detect();
	if ($detect->isMobile())
	{
		$movil = 1;
	}
	session_start();
		while($resul=mysqli_fetch_array($resultado)){
			$id= $resul['id'];
			echo "<div class=\"featured-event\">";
			if ($movil)
			{
				echo "	<img class='image' src='$resul[img]' onclick=\"eventoModal('".$id."')\"/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo 	"</span>";
			}
			else
			{
				echo "	<img class='image' src='$resul[img]'/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo	"<span class=\"middle\" id='vermas'><a class='text'><button onclick=\"eventoModal('".$id."')\">Ver más</button></a>";
				echo 	"</span>";
			}
			if(isset($_SESSION['nombre']) && !empty($_SESSION['nombre']))
			{
				$query = sprintf("select id from favoritos where email='%s' and id='%s'", mysqli_real_escape_string($conexion, $_SESSION['email']), mysqli_real_escape_string($conexion, $id));
				$resultado2 = mysqli_query($conexion, $query);
				if (mysqli_num_rows($resultado2))
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star favourite_icon\" onclick=\"changeStarFill(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
				else
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
			}
			else
			{
				echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
			}
			echo "</div>";	
		}
			

	/***********************************************************/
	mysqli_free_result($resultado);
	mysqli_close($conexion);
	return true;
}
function orden_sem_desc($ciudad,$categoria){
	$conexion=mysqli_connect(SERVIDOR,USUARIO,CLAVE,BBDD);
	if(!$conexion){
		print "<p>ERROR DE CONEXION DE BBDD. Error nº ".mysqli_connect_errno($conexion).":".mysqli_connect_error($conexion)."</p>\n";
		return false;
	}
	mysqli_set_charset ( $conexion , 'utf8' );
	/**************************************************************/
	$sql = "SELECT nombre,precio,ciudad,id,img 
			FROM eventos 
			WHERE YEARWEEK(`fecha`, 1) = YEARWEEK(CURDATE(), 1)
			AND ciudad = '$ciudad' AND categoria = '$categoria'
			order by precio desc";
	// print $sql;
	/***********************************************************/
	if(!($resultado=mysqli_query($conexion ,$sql))){
		print "<p>ERROR ".mysqli_errno($conexion).":".mysqli_error($conexion)."</p>";
		return false;
	}
	/***********************************************************/
	$movil = 0;
	$detect = new Mobile_Detect();
	if ($detect->isMobile())
	{
		$movil = 1;
	}
	session_start();
		while($resul=mysqli_fetch_array($resultado)){
			$id= $resul['id'];
			echo "<div class=\"featured-event\">";
			if ($movil)
			{
				echo "	<img class='image' src='$resul[img]' onclick=\"eventoModal('".$id."')\"/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo 	"</span>";
			}
			else
			{
				echo "	<img class='image' src='$resul[img]'/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo	"<span class=\"middle\" id='vermas'><a class='text'><button onclick=\"eventoModal('".$id."')\">Ver más</button></a>";
				echo 	"</span>";
			}
			if(isset($_SESSION['nombre']) && !empty($_SESSION['nombre']))
			{
				$query = sprintf("select id from favoritos where email='%s' and id='%s'", mysqli_real_escape_string($conexion, $_SESSION['email']), mysqli_real_escape_string($conexion, $id));
				$resultado2 = mysqli_query($conexion, $query);
				if (mysqli_num_rows($resultado2))
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star favourite_icon\" onclick=\"changeStarFill(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
				else
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
			}
			else
			{
				echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
			}
			echo "</div>";	
		}
			

	/***********************************************************/
	mysqli_free_result($resultado);
	mysqli_close($conexion);
	return true;
}
function orden_sem_fecha($ciudad,$categoria){
	$conexion=mysqli_connect(SERVIDOR,USUARIO,CLAVE,BBDD);
	if(!$conexion){
		print "<p>ERROR DE CONEXION DE BBDD. Error nº ".mysqli_connect_errno($conexion).":".mysqli_connect_error($conexion)."</p>\n";
		return false;
	}
	mysqli_set_charset ( $conexion , 'utf8' );
	/**************************************************************/
	$sql = "SELECT nombre,precio,ciudad,id,img 
			FROM eventos 
			WHERE YEARWEEK(`fecha`, 1) = YEARWEEK(CURDATE(), 1)
			AND ciudad = '$ciudad' AND categoria = '$categoria'
			order by fecha";
	// print $sql;
	/***********************************************************/
	if(!($resultado=mysqli_query($conexion ,$sql))){
		print "<p>ERROR ".mysqli_errno($conexion).":".mysqli_error($conexion)."</p>";
		return false;
	}
	/***********************************************************/
	$movil = 0;
	$detect = new Mobile_Detect();
	if ($detect->isMobile())
	{
		$movil = 1;
	}
	session_start();
		while($resul=mysqli_fetch_array($resultado)){
			$id= $resul['id'];
			echo "<div class=\"featured-event\">";
			if ($movil)
			{
				echo "	<img class='image' src='$resul[img]' onclick=\"eventoModal('".$id."')\"/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo 	"</span>";
			}
			else
			{
				echo "	<img class='image' src='$resul[img]'/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo	"<span class=\"middle\" id='vermas'><a class='text'><button onclick=\"eventoModal('".$id."')\">Ver más</button></a>";
				echo 	"</span>";
			}
			if(isset($_SESSION['nombre']) && !empty($_SESSION['nombre']))
			{
				$query = sprintf("select id from favoritos where email='%s' and id='%s'", mysqli_real_escape_string($conexion, $_SESSION['email']), mysqli_real_escape_string($conexion, $id));
				$resultado2 = mysqli_query($conexion, $query);
				if (mysqli_num_rows($resultado2))
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star favourite_icon\" onclick=\"changeStarFill(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
				else
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
			}
			else
			{
				echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
			}
			echo "</div>";	
		}
			

	/***********************************************************/
	mysqli_free_result($resultado);
	mysqli_close($conexion);
	return true;
}

function orden_mes_asc($ciudad,$categoria){
	$conexion=mysqli_connect(SERVIDOR,USUARIO,CLAVE,BBDD);
	if(!$conexion){
		print "<p>ERROR DE CONEXION DE BBDD. Error nº ".mysqli_connect_errno($conexion).":".mysqli_connect_error($conexion)."</p>\n";
		return false;
	}
	mysqli_set_charset ( $conexion , 'utf8' );
	/**************************************************************/
	$sql = "SELECT nombre,precio,ciudad,id,img 
			FROM eventos 
			WHERE month(fecha) = month(curdate())
			AND ciudad = '$ciudad' AND categoria = '$categoria'
			order by precio asc LIMIT 10";
	// print $sql;
	/***********************************************************/
	if(!($resultado=mysqli_query($conexion ,$sql))){
		print "<p>ERROR ".mysqli_errno($conexion).":".mysqli_error($conexion)."</p>";
		return false;
	}
	/***********************************************************/
	$movil = 0;
	$detect = new Mobile_Detect();
	if ($detect->isMobile())
	{
		$movil = 1;
	}
	session_start();
		while($resul=mysqli_fetch_array($resultado)){
			$id= $resul['id'];
			echo "<div class=\"featured-event\">";
			if ($movil)
			{
				echo "	<img class='image' src='$resul[img]' onclick=\"eventoModal('".$id."')\"/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo 	"</span>";
			}
			else
			{
				echo "	<img class='image' src='$resul[img]'/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo	"<span class=\"middle\" id='vermas'><a class='text'><button onclick=\"eventoModal('".$id."')\">Ver más</button></a>";
				echo 	"</span>";
			}
			if(isset($_SESSION['nombre']) && !empty($_SESSION['nombre']))
			{
				$query = sprintf("select id from favoritos where email='%s' and id='%s'", mysqli_real_escape_string($conexion, $_SESSION['email']), mysqli_real_escape_string($conexion, $id));
				$resultado2 = mysqli_query($conexion, $query);
				if (mysqli_num_rows($resultado2))
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star favourite_icon\" onclick=\"changeStarFill(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
				else
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
			}
			else
			{
				echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
			}
			echo "</div>";	
		}
			

	/***********************************************************/
	mysqli_free_result($resultado);
	mysqli_close($conexion);
	return true;
}
function orden_mes_desc($ciudad,$categoria){
	$conexion=mysqli_connect(SERVIDOR,USUARIO,CLAVE,BBDD);
	if(!$conexion){
		print "<p>ERROR DE CONEXION DE BBDD. Error nº ".mysqli_connect_errno($conexion).":".mysqli_connect_error($conexion)."</p>\n";
		return false;
	}
	mysqli_set_charset ( $conexion , 'utf8' );
	/**************************************************************/
	$sql = "SELECT nombre,precio,ciudad,id,img 
			FROM eventos 
			WHERE month(fecha) = month(curdate())
			AND ciudad = '$ciudad' AND categoria = '$categoria'
			order by precio desc LIMIT 10";
	// print $sql;
	/***********************************************************/
	if(!($resultado=mysqli_query($conexion ,$sql))){
		print "<p>ERROR ".mysqli_errno($conexion).":".mysqli_error($conexion)."</p>";
		return false;
	}
	/***********************************************************/
	$movil = 0;
	$detect = new Mobile_Detect();
	if ($detect->isMobile())
	{
		$movil = 1;
	}
	session_start();
		while($resul=mysqli_fetch_array($resultado)){
			$id= $resul['id'];
			echo "<div class=\"featured-event\">";
			if ($movil)
			{
				echo "	<img class='image' src='$resul[img]' onclick=\"eventoModal('".$id."')\"/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo 	"</span>";
			}
			else
			{
				echo "	<img class='image' src='$resul[img]'/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo	"<span class=\"middle\" id='vermas'><a class='text'><button onclick=\"eventoModal('".$id."')\">Ver más</button></a>";
				echo 	"</span>";
			}
			if(isset($_SESSION['nombre']) && !empty($_SESSION['nombre']))
			{
				$query = sprintf("select id from favoritos where email='%s' and id='%s'", mysqli_real_escape_string($conexion, $_SESSION['email']), mysqli_real_escape_string($conexion, $id));
				$resultado2 = mysqli_query($conexion, $query);
				if (mysqli_num_rows($resultado2))
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star favourite_icon\" onclick=\"changeStarFill(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
				else
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
			}
			else
			{
				echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
			}
			echo "</div>";	
		}
			

	/***********************************************************/
	mysqli_free_result($resultado);
	mysqli_close($conexion);
	return true;
}
function orden_mes_fecha($ciudad,$categoria){
	$conexion=mysqli_connect(SERVIDOR,USUARIO,CLAVE,BBDD);
	if(!$conexion){
		print "<p>ERROR DE CONEXION DE BBDD. Error nº ".mysqli_connect_errno($conexion).":".mysqli_connect_error($conexion)."</p>\n";
		return false;
	}
	mysqli_set_charset ( $conexion , 'utf8' );
	/**************************************************************/
	$sql = "SELECT nombre,precio,ciudad,id,img 
			FROM eventos 
			WHERE month(fecha) = month(curdate())
			AND ciudad = '$ciudad' AND categoria = '$categoria'
			order by fecha LIMIT 10";
	// print $sql;
	/***********************************************************/
	if(!($resultado=mysqli_query($conexion ,$sql))){
		print "<p>ERROR ".mysqli_errno($conexion).":".mysqli_error($conexion)."</p>";
		return false;
	}
	/***********************************************************/
	$movil = 0;
	$detect = new Mobile_Detect();
	if ($detect->isMobile())
	{
		$movil = 1;
	}
	session_start();
		while($resul=mysqli_fetch_array($resultado)){
			$id= $resul['id'];
			echo "<div class=\"featured-event\">";
			if ($movil)
			{
				echo "	<img class='image' src='$resul[img]' onclick=\"eventoModal('".$id."')\"/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo 	"</span>";
			}
			else
			{
				echo "	<img class='image' src='$resul[img]'/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo	"<span class=\"middle\" id='vermas'><a class='text'><button onclick=\"eventoModal('".$id."')\">Ver más</button></a>";
				echo 	"</span>";
			}
			if(isset($_SESSION['nombre']) && !empty($_SESSION['nombre']))
			{
				$query = sprintf("select id from favoritos where email='%s' and id='%s'", mysqli_real_escape_string($conexion, $_SESSION['email']), mysqli_real_escape_string($conexion, $id));
				$resultado2 = mysqli_query($conexion, $query);
				if (mysqli_num_rows($resultado2))
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star favourite_icon\" onclick=\"changeStarFill(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
				else
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
			}
			else
			{
				echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
			}
			echo "</div>";	
		}
			

	/***********************************************************/
	mysqli_free_result($resultado);
	mysqli_close($conexion);
	return true;
}

function buscador($cadena){
	$conexion=mysqli_connect(SERVIDOR,USUARIO,CLAVE,BBDD);
	if(!$conexion){
		print "<p>ERROR DE CONEXION DE BBDD. Error nº ".mysqli_connect_errno($conexion).":".mysqli_connect_error($conexion)."</p>\n";
		return false;
	}
	mysqli_set_charset ( $conexion , 'utf8' );
	/**************************************************************/
	$sql = "SELECT nombre,precio,ciudad,id,img 
			FROM eventos 
			WHERE nombre LIKE '%$cadena%'";
	// print $sql;
	/***********************************************************/
	if(!($resultado=mysqli_query($conexion ,$sql))){
		print "<p>ERROR ".mysqli_errno($conexion).":".mysqli_error($conexion)."</p>";
		return false;
	}
	/***********************************************************/
		echo "<span class=\"featured-events-title\">Búsqueda para: $cadena</span>";
	$movil = 0;
	$detect = new Mobile_Detect();
	if ($detect->isMobile())
	{
		$movil = 1;
	}
	session_start();
		while($resul=mysqli_fetch_array($resultado)){
			$id= $resul['id'];
			echo "<div class=\"featured-event\">";
			if ($movil)
			{
				echo "	<img class='image' src='$resul[img]' onclick=\"eventoModal('".$id."')\"/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo 	"</span>";
			}
			else
			{
				echo "	<img class='image' src='$resul[img]'/>";
				echo	"<span class=\"event-info bottom-left\"><p>$resul[nombre]</p></span>";
				echo	"<span class=\"event-info bottom-right\"><p>$resul[precio]€</p></span>";
				echo	"<span class=\"event-info bottom-left\"><p id='$resul[ciudad]'><i class='fa fa-map-marker'></i> $resul[ciudad]</p></span>";
				echo	"<span class=\"middle\" id='vermas'><a class='text'><button onclick=\"eventoModal('".$id."')\">Ver más</button></a>";
				echo 	"</span>";
			}
			if(isset($_SESSION['nombre']) && !empty($_SESSION['nombre']))
			{
				$query = sprintf("select id from favoritos where email='%s' and id='%s'", mysqli_real_escape_string($conexion, $_SESSION['email']), mysqli_real_escape_string($conexion, $id));
				$resultado2 = mysqli_query($conexion, $query);
				if (mysqli_num_rows($resultado2))
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star favourite_icon\" onclick=\"changeStarFill(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
				else
				{
					echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
				}
			}
			else
			{
				echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\" onclick=\"changeStarEmpty(this)\"><span class='tooltiptext'>Añadir a favoritos</span></i></a>"; 
			}
			echo "</div>";	
		}		
	
			

	/***********************************************************/
	mysqli_free_result($resultado);
	mysqli_close($conexion);
	return true;
}

function img_categoria($categoria){
	$conexion=mysqli_connect(SERVIDOR,USUARIO,CLAVE,BBDD);
	if(!$conexion){
		print "<p>ERROR DE CONEXION DE BBDD. Error nº ".mysqli_connect_errno($conexion).":".mysqli_connect_error($conexion)."</p>\n";
		return false;
	}
	mysqli_set_charset ( $conexion , 'utf8' );
	/**************************************************************/
	$sql = "SELECT img 
		FROM categorias
		WHERE nombre = '$categoria'";
			
			
	//print $sql;
	/***********************************************************/
	if(!($resultado=mysqli_query($conexion ,$sql))){
		print "<p>ERROR ".mysqli_errno($conexion).":".mysqli_error($conexion)."</p>";
		return false;
	}
	/***********************************************************/

	
		
		while($resul=mysqli_fetch_array($resultado)){
			echo "	<img style='width:100%;height:100%' src='$resul[img]'/>";			
		}
			

	/***********************************************************/
	mysqli_free_result($resultado);
	mysqli_close($conexion);
	return true;
}

function desc_categoria($categoria){
	$conexion=mysqli_connect(SERVIDOR,USUARIO,CLAVE,BBDD);
	if(!$conexion){
		print "<p>ERROR DE CONEXION DE BBDD. Error nº ".mysqli_connect_errno($conexion).":".mysqli_connect_error($conexion)."</p>\n";
		return false;
	}
	mysqli_set_charset ( $conexion , 'utf8' );
	/**************************************************************/
	$sql = "SELECT descripcion 
		FROM categorias
		WHERE nombre = '$categoria'";
			
			
	//print $sql;
	/***********************************************************/
	if(!($resultado=mysqli_query($conexion ,$sql))){
		print "<p>ERROR ".mysqli_errno($conexion).":".mysqli_error($conexion)."</p>";
		return false;
	}
	/***********************************************************/

	
		
		while($resul=mysqli_fetch_array($resultado)){
			echo "<p>$resul[descripcion]</p>	";			
		}
			

	/***********************************************************/
	mysqli_free_result($resultado);
	mysqli_close($conexion);
	return true;
}

?>