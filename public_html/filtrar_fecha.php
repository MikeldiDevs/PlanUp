<?php
require_once 'funciones.php';
if($_GET['valor'] == 'all'){
	filtro_todos();
}else if($_GET['valor'] == 'today'){
	filtro_hoy();
}else if($_GET['valor'] == 'week'){
	filtro_semana();
}else if($_GET['valor'] == 'month'){
	filtro_mes();
} 
?>