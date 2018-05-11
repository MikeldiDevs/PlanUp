<?php
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

	
		
		while($resul=mysqli_fetch_array($resultado)){
			$id= $resul['id'];
			echo "<div class=\"featured-event\">";
			echo "	<img src='$resul[img]'/>";
			echo	"<span class=\"event-info\"><p>$resul[nombre]</p></span>";
			echo	"<span class=\"event-info\"><p>Precio : $resul[precio] €</p></span>";
			echo	"<span class=\"event-info\"><p id='$resul[ciudad]'>Lugar : $resul[ciudad]</p></span>";
			echo	"<span class=\"event-info\" id='vermas'><a href=\"evento.php?id=".$id."\">Ver más</a>";
			echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o favourite_icon\"></i></a>"; 
			echo 	"</span>";
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
			where ciudad ='Bilbao' and recomendado = 'si'
			LIMIT 6";
	//print $sql;
	/***********************************************************/
	if(!($resultado=mysqli_query($conexion ,$sql))){
		print "<p>ERROR ".mysqli_errno($conexion).":".mysqli_error($conexion)."</p>";
		return false;
	}
	/***********************************************************/

		
		while($resul=mysqli_fetch_array($resultado)){
			$id= $resul['id'];
			echo "<div class=\"recommended-event\">";
			echo "	<img src='$resul[img]'/>";
			echo	"<span class=\"event-info\"><p>$resul[nombre]</p></span>";
			echo	"<span class=\"event-info\"><p>Precio : $resul[precio] €</p></span>";
			echo	"<span class=\"event-info\"><p id='$resul[ciudad]'>Lugar : $resul[ciudad]</p></span>";
			echo	"<span class=\"event-info\" id='vermas'><a href=\"evento.php?id=".$id."\">Ver más</a>";
			echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o  favourite_icon\"></i></a>";  
			echo 	"</span>";
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
		echo	"<div class='event-place'>$resul[ciudad]</div>";
		echo	"<div class='event-date'>$resul[fecha]</div>";
		echo	"<div class='event-hour'>$resul[hora]</div>";
		echo	"<div class='event-price'>$resul[precio]€</div>";
		echo	"<a><div class='event-buy-button' id='$resul[enlace]' style=cursor:pointer>Comprar</div></a>";
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
		
		while($resul=mysqli_fetch_array($resultado)){
			echo "<li class='left-menu-ul-li' style='cursor:pointer'>$resul[categoria]</li>";		
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
		
		while($resul=mysqli_fetch_array($resultado)){
			$categoria=$resul['categoria'];
			echo "<a href='eventos.php?categoria=".$categoria."' ><li class='left-menu-ul-li' >$resul[categoria]</li></a>";		
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
		
		while($resul=mysqli_fetch_array($resultado)){
			$id= $resul['id'];
			echo "<div class=\"featured-event\">";
			echo 	"<img src='$resul[img]'/>";
			echo	"<span class=\"event-info\"><p>$resul[nombre]</p></span>";
			echo	"<span class=\"event-info\"><p>Precio : $resul[precio] €</p></span>";
			echo	"<span class=\"event-info\"><p id='$resul[ciudad]'>Lugar : $resul[ciudad]</p></span>";			
			echo	"<span class=\"event-info\" id='vermas'><a href=\"evento.php?id=".$id."\">Ver más</a>";
			echo    "   <a onclick=\"eventosFav('".$id."')\" id='favoritos'><i class=\"fa fa-fw fa-lg fa-star-o  favourite_icon\"></i></a>";  
			echo 	"</span>";
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
			where favoritos.email = '$email' and favoritos.id = eventos.id
			LIMIT 6";
			
			
	//print $sql;
	/***********************************************************/
	if(!($resultado=mysqli_query($conexion ,$sql))){
		print "<p>ERROR ".mysqli_errno($conexion).":".mysqli_error($conexion)."</p>";
		return false;
	}
	/***********************************************************/

	
		
		while($resul=mysqli_fetch_array($resultado)){
			$id= $resul['id'];
			echo "<div class=\"featured-event\">";
			echo "	<img src='$resul[img]'/>";
			echo	"<span class=\"event-info\"><p>$resul[nombre]</p></span>";
			echo	"<span class=\"event-info\"><p>Precio : $resul[precio] €</p></span>";
			echo	"<span class=\"event-info\"><p id='$resul[ciudad]'>Lugar : $resul[ciudad]</p></span>";
			echo	"<span class=\"event-info\" id='vermas'><a href=\"evento.php?id=".$id."\">Ver más</a>";
			echo    "   <a onclick=\"eventosFav('".$id."')\">Eliminar</a>"; 
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

function filtro_semana($dato){
	
	$conexion=mysqli_connect(SERVIDOR,USUARIO,CLAVE,BBDD);
	if(!$conexion){
		print "<p>ERROR DE CONEXION DE BBDD. Error nº ".mysqli_connect_errno($conexion).":".mysqli_connect_error($conexion)."</p>\n";
		return false;
	}
	mysqli_set_charset ( $conexion , 'utf8' );
	/**************************************************************/
	$sql = "SELECT * 
			FROM eventos 
			WHERE YEARWEEK(`fecha`, 1) = YEARWEEK(CURDATE(), 1)";
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
?>