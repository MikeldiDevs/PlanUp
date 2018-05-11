<!DOCTYPE html>
<script>
// Get the modal
var modal = document.getElementById('id01');
var modal2 = document.getElementById('id02');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) 
    {
        modal.style.display = "none";
    }
    else if (event.target == modal2) 
    {
        modal2.style.display = "none";
    }
}
</script> 
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
		<link rel="stylesheet" type="text/css" href="css/modal.css"/>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="icon" type="image/png" href="img/favicon.ico">
	</head>
	
	
    <body> 
    
		<div class="top-menu">
			
			
			<a href='index.php'><div class="top-menu-logo">
				<a href="index.php"><img src="img/planup.png"></a>
			</div></a>
		
			
			<div class="top-menu-user">
			<ul>
			<?php
			session_start();
			if(isset($_SESSION['nombre']) && !empty($_SESSION['nombre'])) 
			{
				echo '<li><a href="https://planup.ddns.net/perfil.php">'.$_SESSION["nombre"].'</a></li>';
				echo " <li><a href='https://planup.ddns.net/logout.php'\">Cerrar sesión</a></li>";
			}
			else
			{
				echo "
				<li><a onclick=\"document.getElementById('id01').style.display='block'\">Iniciar sesión</a></li>
                <li><a onclick=\"document.getElementById('id02').style.display='block'\">Registrarse</a></li>
                ";
			}
            ?>
            </ul>
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
			<div class="main-content-search">
				<img src="img/cabecera.jpg"/>
				<div class="search-bar-box">
					<input type="text" class="search-bar" placeholder="Buscar evento"></input>
				</div>
			</div>
				<div class="featured-events">
					<span class="featured-events-title">Destacados</span>
					<div class="event-list" id="featured-list">	
						
					</div>
				</div>
			
				<div class="recommended-events">
					<span class="recommended-events-title">Recomendados</span>
					<div class="event-list" id="recommended-list">	
						
						
					</div>
				</div>

		</div>
		<script>
		$(document).ready(inicio);

		function inicio(){
			var ciudad='Bilbao';	
			$('#featured-list').load('mostrar_destacados.php?ciudad='+ciudad,eventosDest);
			$('#recommended-list').load('mostrar_recomendados.php?ciudad='+ciudad,eventosRecom);
			$('#cities').load('ciudades.php',eventosCiudad);
			$('.left-menu-ul').load('mostrar_categorias_href.php',eventosCateg);
			
			var ciudad='';
			
			
			
			$('#cities').change(function(){
				ciudad=$('#cities option:selected').text();		
				console.log(ciudad);
			});			
			
			
		}
		
		function eventosCiudad(){
			$('#cities').change(function(){
				var ciudad=$('#cities option:selected').text();	
				$('.event-list').empty();
				console.log('pasa');
				$('.event-list').load('mostrar_destacados.php?ciudad='+encodeURI(ciudad));
				console.log('pasa2');
			});
		}
		
		
		function eventosDest(){
			
		}
		
		function eventosRecom(){
			
		}
		
		function eventosCateg(){
			
		}
		
		function eventosFav(id) 
		{
			$(".favourite_icon").click(function(){
 $(this).css({"color": "yellow"}).removeClass('fa-star-o').addClass('fa-star');
});
			var cookie = '<?php echo $_SESSION['email'];?>';
			if (cookie)
			{
				var getdata = 'email='+cookie+'&id='+id;
				$.ajax({
		        	url: "add_favoritos.php",
		        	type: "GET",
		        	data: getdata,
		        	success: function(data){
		        		alert(data);
		        	},
		        	error: function(data){
		        		alert(data);
		        	}
		    	});
			}
			else
			{
				document.getElementById('id01').style.display='block';
			}
		}
		</script>

<!-- The Modal -->
<div id="id01" class="modal">
    <!-- Modal Content -->
    <form class="modal-content animate" method="post" action="login.php">
        <div class="imgcontainer">
            <!--<img src="img_avatar2.png" alt="Avatar" class="avatar">-->
            <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">×</span>
        </div>
        <div class="container">
                <label for="email"><b>Correo electronico</b></label>
                <input type="email" name="email" required/>
                <label for="pass"><b>Contraseña</b></label>
                <input type="password" placeholder="" name="pass" required/>
                <button type="submit" id="modal_button">Iniciar sesión</button>
                <label>
                    <input type="checkbox" checked="checked" name="remember"> Recuerdame
                </label>
        </div>

        <div class="container" style="background-color:#f1f1f1">
            <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn" id="modal_button">Cancelar</button>
            <span class="psw">Has olvidado la <a href="#">contraseña?</a></span>
        </div>
  </form>
</div>
<div id="id02" class="modal">
    <form class="modal-content animate"  method="post" action="submit.php">
        <div class="imgcontainer">
            <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">×</span>
        </div>

        <div class="container">
                <label for="name"><b>Nombre</b></label>
                <input type="text" placeholder="" name="name" required/>
                <label for="email"><b>Correo electronico</b></label>
                <input type="email" name="email" required/>

                <label for="pass1"><b>Contraseña</b></label>
                <input type="password" name="pass1" required/>
                <label for="pass2"><b>Repite la contraseña</b></label>
                <input type="password" placeholder="" name="pass2" required/>

                <button type="submit" value="Ingresar" id="modal_button">Registrarse</button>
        </div>

        <div class="container" style="background-color:#f1f1f1">
            <button type="button" onclick="document.getElementById('id02').style.display='none'" id="modal_button" class="cancelbtn" >Cancelar</button>
        </div>

    </form>
    </table>
</div>
    </body>
</html>