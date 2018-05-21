<?php
require_once 'funciones.php';
$orden=$_GET['orden'];
$filtro=$_GET['filtro'];
$ciudad=$_GET['ciudad'];
$categoria=$_GET['categoria'];

if($filtro == 'all' && $orden =='precioup'){
	orden_all_asc($ciudad,$categoria);
}else if($filtro == 'all' && $orden =='preciodown'){
	orden_all_desc($ciudad,$categoria);
}else if($filtro == 'all' && $orden =='fecha'){
	orden_all_fecha($ciudad,$categoria);
}else if($filtro == 'today' && $orden =='precioup'){
	orden_hoy_asc($ciudad,$categoria);
}else if($filtro == 'today' && $orden =='preciodown'){
	orden_hoy_desc($ciudad,$categoria);
}else if($filtro == 'today' && $orden =='fecha'){
	orden_hoy_fecha($ciudad,$categoria);
}else if($filtro == 'week' && $orden =='precioup'){
	orden_sem_asc($ciudad,$categoria);
}else if($filtro == 'week' && $orden =='preciodown'){
	orden_sem_desc($ciudad,$categoria);
}else if($filtro == 'week' && $orden =='fecha'){
	orden_sem_fecha($ciudad,$categoria);
}else if($filtro == 'month' && $orden =='precioup'){
	orden_mes_asc($ciudad,$categoria);
}else if($filtro == 'month' && $orden =='preciodown'){
	orden_mes_desc($ciudad,$categoria);
}else if($filtro == 'month' && $orden =='fecha'){
	orden_mes_fecha($ciudad,$categoria);
}else{
	orden_all_asc($ciudad,$categoria);	 
}

?>