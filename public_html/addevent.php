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
			
			
			<div class="top-menu-logo">
				hola
			</div>
		
			
			<div class="top-menu-user">
				Registro | Entrar
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
			Registro
			<div class="register-box">
				<form class="modal-content animate"  method="post" action="add.php" enctype="multipart/form-data">
					<table>
					    <tr>
					        <td> Selecciona la foto a subir:</td>  
					        <td> <input type="file" name="imagen" id="imagen"></td>
					    </tr>
					    <tr>
					        <td>Nombre</td>
					        <td><input type="text" name="nombre" required></td>
					    </tr>
					    <tr>
					        <td>Categoria</td>
					        <td><input type="text" name="categoria" required></td>
					    </tr>
					    <tr>
					        <td>Fecha</td>
					        <td><input type="date" name="fecha" required></td>
					    </tr>
					    <tr>
					        <td>Hora</td>
					        <td><input type="text" name="hora" size="3" maxlength="5" placeholder="00:00"></td>
					    </tr>
					    <tr>
					        <td>Ciudad</td>
					        <td><input type="text" name="ciudad" required></td>
					    </tr>
					    <tr>
					        <td>Descripcion</td>
					        <td><input type="text" name="descripcion" required></td>
					    </tr>
					    <tr>
					        <td>Precio</td>
					        <td><input type="text" name="precio"></td>
					    </tr>
					    <tr>
					        <td> <input type="submit" name="submit" value="Subir"/> </td>
					    </tr>
					</table>
				</form>
			</div>
		</div>
  </div>
	
    </body>
</html>