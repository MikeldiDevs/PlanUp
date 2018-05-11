<?php
require_once 'funciones.php';
if (isset($_GET['categoria']) && isset ($_GET['ciudad'])){	
	mostrar_eventos($_GET['categoria'],$_GET['ciudad']);
}else if(isset ($_GET['categoria'])) {
	mostrar_eventos($_GET['categoria']);
}else{
mostrar_eventos();
}
?>