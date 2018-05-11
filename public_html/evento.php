<!DOCTYPE html>
<html>
    <head>
        <title>Plan Up!</title>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<meta http-equiv="Content-Language" content="es">		
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="No te quedes sin planes">
		<meta name="keywords" content="entradas, entrada, venta, Bilbao, eventos, evento, musica, deportes, cultura, ticket, tickets, concierto, conciertos">
		<link rel="stylesheet" type="text/css" href="css/style.css"/>
		<link rel="icon" type="image/png" href="img/favicon.ico">
	</head>
	
	
    <body> 
		<div class="top-menu">
			
			
			<a href='index.php'><div class="top-menu-logo">
				<img src="/img/planup.png">
			</div></a>
		
			
			<div class="top-menu-user">
				Registro | Entrar
			</div>
		</div>
	
		<div class="left-menu">
			<div class="top-menu-select">
				<select class="select-city" id="cities">
					
				</select>
			</div>
			
			<ul class="left-menu-ul">
				
			</ul>
		</div>
		
		<div class="main-content">
			<div class="event-banner">
				
			</div>
			
			<div class="event-short-info-box">
				
				<div class="event-buy-button"></div>
			</div>
			
			<div class="event-detail-info">
				<p> ifiwqefiqwe feqwof nepqw fnqepwofn eqwne ekw ekenkñwenkñewnof ngwwkien fbwie bnfewiklf </p>
			</div>
			
			<div class="related-events">
				<div class="featured-event">
						<a href="http://www.google.com"><img src="http://www.google.com/intl/en_ALL/images/logo.gif"/></a>
						<span class="event-info"><p>Precio : </p></span>
						<span class="event-info"><p>Lugar : </p></span>
						<span class="event-info"><p>Ver más</p></span>
				</div>
			</div>
			
		</div>
	
	
	<?php
		
		$v1=$_GET['id'];
	
	?>
	
	
	<script>
		$(document).ready(inicio);
		function inicio(){
			var id='<?php echo $v1; ?>';
			
			
			$('.event-detail-info').load('mostrar_descripcion.php?id='+id);
			$('.event-short-info-box').load('mostrar_info.php?id='+id,eventosInfo);
			$('#cities').load('ciudades.php');
			$('.left-menu-ul').load('mostrar_categorias_href.php',eventosCat);
			$('.event-banner').load('mostrar_banner.php?id='+id,eventosCat);
			
			
		}
		
		function eventosInfo(){
			$('.event-buy-button').click(function(){
				window.open(
				  $(this).attr('id'),
				  '_blank'
				);
			});
			
			
		}
		
		function eventosCat(){
						
		}
		
	</script>
	
    </body>
</html>