<!DOCTYPE html>
<html>
<?php
	session_start();
	if(!( isset($_SESSION['nombre']) && !empty($_SESSION['nombre']) )) 
	{
		header("Location:index.php");
	}
?>
    <head>
        <title>Plan Up!</title>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<meta http-equiv="Content-Language" content="es">		
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="No te quedes sin planes">
		<meta name="keywords" content="entradas, entrada, venta, Bilbao, eventos, evento, musica, deportes, cultura, ticket, tickets, concierto, conciertos">
		<link rel="stylesheet" type="text/css" href="css/style.css"/>
		<link rel="stylesheet" type="text/css" href="css/modal.css"/>
		<link rel="icon" type="image/png" href="img/favicon.ico">
	</head>
	
	
    <body> 
		<div class="top-menu">
			
			
			<div class="top-menu-logo">
				<a href="index.php"><img src="img/planup.png"></a>
			</div>
		
			
			<div class="top-menu-user">
				<ul>
					<?php
					echo '<li><a href="https://planup.ddns.net/perfil.php">'.$_SESSION["nombre"].'</a></li>';
					echo " <li><a href='https://planup.ddns.net/logout.php'\">Cerrar sesión</a></li>";
					?>
				</ul>
			</div>
		</div>
	
		<div class="left-menu">
			<div class="top-menu-select">
				<select class="select-city">
					<option class="option-city">bilbao</option>
					<option class="option-city">madrid</option>
					<option class="option-city">barcelona</option>
				</select>
			</div>
			
			<ul class="left-menu-ul">
				<li class="left-menu-ul-li">Musica</li>
				<li class="left-menu-ul-li">Cine</li>
				<li class="left-menu-ul-li">Deporte</li>
			</ul>
		</div>

		<div class="main-content">
			<div class="main-content-search">
				<img src="img/cabecera.jpg"/>
				<div class="search-bar-box">
					<input type="text" class="search-bar" placeholder="Buscar evento"></input>
				</div>
			</div>
			
			<div class="featured-events">
				<span class="featured-events-title">Favoritos</span>
				<div class="event-list" id="favorites-list">	
				
					
				</div>
			</div>

		</div>
		
		<script>
		$(document).ready(inicio);
		function inicio(){
			var email="<?php echo $_SESSION['email']; ?>";	
			$('#favorites-list').load('mostrar_favoritos.php?email='+email);
		}

		function eventosFav(id) 
		{
			var cookie = '<?php echo $_SESSION['email'];?>';
			if (cookie)
			{
				var getdata = 'email='+cookie+'&id='+id;
				$.ajax({
		        	url: "quitar_favorito.php",
		        	type: "GET",
		        	data: getdata,
		        	success: function(data){
		        		//alert(data);
		        		$('#favorites-list').load('#favorites-list');
		        	},
		        	error: function(data){
		        		alert(data);
		        	}
		    	});
			}
		}

		</script>
		<!--
		<div class="main-content">
			
			<div class="user-panel">
				<span>Nombre user</span>
				<span>Editar</span>
				<span>mis eventos</span>
				<span>Logout</span>
			</div>
			
			<div class="my-events">
				<div class="my-event">
					<img src="xx" class="my-event-img"></img>
					<span>nombre evento</span>
				</div>
			</div>
			hacer cada una de las pestañas
		</div>
		-->
	
    </body>
</html>