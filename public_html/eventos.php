<!DOCTYPE html>
<script>
// Get the modal
var modal = document.getElementById('id01');
var modal2 = document.getElementById('id02');
var modal3 = document.getElementById('id03');
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
    else if (event.target == modal3) 
    {
        modal3.style.display = "none";
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
		<link rel="icon" type="image/png" href="../img/favicon.ico">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <?php  
        session_start();
        $movil = 0;
        include 'Mobile_Detect.php';
        $detect = new Mobile_Detect();
        if ($detect->isMobile())
        {
        	$movil = 1;
     		echo '<style type="text/css">
                .modal-content {
                    margin: 0 0 0;
                    margin-left: 1%;
                    margin-bottom: 1%;
                    width: 98%;
                }
                </style>';
        }
        ?>
	</head>
	
	
    <body> 
    <img onclick="topFunction()" id="myBtn" title="Go to top" src="../img/scroll_back2.png"></img>
		<?php
    if (!$movil)
    {
        echo '<div class="top-menu">
                <div class="top-menu-logo">
                <a href="index.php"><img src="../img/index.png"></a>
                </div>
                <div class="top-menu-user">
            <ul>';
        if(isset($_SESSION['nombre']) && !empty($_SESSION['nombre'])) 
        {
            echo '<li><a href="https://planup.ddns.net/perfil.php" style="text-transform: capitalize;">'.$_SESSION["nombre"].'</a></li>';
            echo " <li><a href='https://planup.ddns.net/logout.php'>Cerrar sesión</a></li>";
        }
        else
        {
            echo "
            <li><a onclick=\"document.getElementById('id01').style.display='block'\">Iniciar sesión</a></li>
            <li><a onclick=\"document.getElementById('id02').style.display='block'\">Registrarse</a></li>
            ";
        }
        echo '</ul>
            </div>
    </div>';
    }
    ?>
	
	<div class="w3-sidebar w3-bar-block w3-collapse w3-card w3-animate-right" style="width:200px;left:0;" id="mySidebar">
    	<button class="w3-bar-item w3-button w3-xlarge w3-hide-large" onclick="w3_close()">&times;</button>
        <div class="top-menu-select">
            <select class="select-city" id="cities">
            </select>
        </div>
        
        <ul class="left-menu-ul">
        </ul>
        <?php
			if ($movil) 
			{
				echo '<a href="downloads/PlanUp.apk"><img src="/../img/downloads/android.png" id="android-app" title="Descargar  aplicacion para Android."></a>';
			}
			else
			{
				echo '<a href="downloads/PlanUp.exe"><img src="/../img/downloads/windows.png" id="windows-app" title="Descargar  aplicacion para Windows."></a>
		<a href="downloads/PlanUp.tar.xz"><img src="/../img/downloads/linux.png" id="linux-app" title="Descargar  aplicacion para Linux."></a>';
			}
		?>
    </div>
        <div class="w3-main" style="margin-left:200px">
    <div class="w3-red">
    <button class="w3-button w3-red w3-xlarge w3-left w3-hide-large" onclick="w3_open()">&#9776;</button>
    <?php
  	if ($movil)
    {
    	echo "<a href='index.php'><img src='../img/index.png' id='img_movil' class='w3-left w3-hide-large'></img></a>";
    }
    ?>
    </div>
        
		<div class="main-content">
			<div class="category-box">
			<?php
				$v1=$_GET['categoria'];
				$v2=$_GET['ciudad'];
			?>
			<div class="category-tag-image"></div>
				<div class="category-tag"></div>
			</div>
			
			<div class="category-description">
				
			</div>
			<div class="search-filter-box">
				<table id="filter-table">
                    <caption>Filtrar por: </caption>
					<tr>
						<td id="table-h3">
							<h3>Filtrar por: </h3>
						</td>
						<td id="positioned-td">
							<div class="search-filter-1">
							    <select name="fechas" id="styled-select1">
								    <option value="all" id="filter-date-1" class="styled-filter">Todas las fechas</option>
								    <option value="today" id="filter-date-2" class="styled-filter">Hoy</option>
								    <option value="week" id="filter-date-3" class="styled-filter">Esta semana</option>
								    <option value="month" id="filter-date-4" class="styled-filter">Este mes</option>
								</select>
							</div>
						</td>
						<td id="select-order" >
							<div class="search-filter-2">	
								<div class="search-order-box">
								    <span id="order" style="display: none;">Ordenar por </span>
									<select name="orden" id="styled-select2">
									    <option value="precioup" class="styled-filter">Precio &uarr;</option>
									    <option value="preciodown" class="styled-filter">Precio &darr;</option>
									    <option value="fecha" class="styled-filter">Fecha</option>
									</select>
								</div>
							</div>
						</td>
					</tr>
				</table>
			</div>
			
			
			
			<div class="category-events">
				
			</div>
			
		</div>
		
		<script>
			$(document).ready(inicio);
			
			function inicio(){
				var cat='<?php echo $v1; ?>';
				var ciudad='<?php echo $v2; ?>';
				// var ciudad= ciu.replace('-',' ');
				// alert(ciudad);
				// var ciudad=$('#cities option:selected').text();
				$(".select-city").val(ciudad);
				
				$('#cities').load('ciudades.php',eventosCiudad);
				$('.left-menu-ul').load('mostrar_categorias_href.php',eventosCat);
				// $('.category-events').load('mostrar_todos.php?ciudad='+ciudad+'&categoria='+cat);
				
				$('.category-box').load('img_categoria.php?categoria='+cat);
				$('.category-description').load('desc_categoria.php?categoria='+cat);
			}
			
			
			function eventosCat(){
				var cat='<?php echo $v1; ?>';
				var ciudad='<?php echo $v2; ?>';
				ciudad= ciudad.replace('-',' ');
				$('.category-events').load('orden_eventos.php?ciudad='+encodeURI(ciudad)+'&categoria='+cat+'&orden=&filtro=');
				var ref='eventos.php?';
				// $('.w3-bar-item').click(function(){
					// $('.category-events').empty();
					// var cat=$(this).text();					
					// var ciudad=$('#cities option:selected').text();
					// var url=ref+'categoria='+cat+'&ciudad='+ciudad;
					// $('.category-events').load('mostrar_eventos.php?categoria='+cat+'&ciudad='+encodeURI(ciudad));
					// console.log(ciudad);
					
				// });
				$('.menu-links').click(function(){
					var ciu=$('#cities option:selected').text();	
					var href=$(this).parent().attr('id');
					
					var ciudad=ciu.replace(' ','-');
					href= href+'&ciudad='+ciudad;
					
					window.location.href = href;
				
					});
			}
			
			function eventosCiudad(){
				var ciudad='<?php echo $v2; ?>';
				ciudad= ciudad.replace('-',' ');
				$(".select-city").val(ciudad);
				// console.log($(".select-city").val(ciudad));
				$('select[name=fechas]').change(function() {
					var orden= $('select[name=orden]').val();
					var ciudad=$('#cities option:selected').text();
					var filtro=$('select[name=fechas]').val();
					var categoria='<?php echo $v1; ?>';
					console.log(ciudad);
					console.log(filtro);
					console.log(orden);
					console.log(categoria);
					$('.category-events').empty();
					$('.category-events').load('orden_eventos.php?orden='+orden+'&filtro='+filtro+'&ciudad='+encodeURI(ciudad)+'&categoria='+categoria);
						
				});
				
				$('select[name=orden]').change(function() {				
					var orden= this.value;
					var filtro=$('select[name=fechas]').val();
					var ciudad=$('#cities option:selected').text();
					var categoria='<?php echo $v1; ?>';
					console.log(ciudad);
					console.log(filtro);
					console.log(orden);
					console.log(categoria);
					$('.category-events').empty();
					$('.category-events').load('orden_eventos.php?orden='+orden+'&filtro='+filtro+'&ciudad='+encodeURI(ciudad)+'&categoria='+categoria);
				});
				
				$('.select-city').change(function() {				
					var ciudad= this.value;
					var filtro=$('select[name=fechas]').val();
					var orden=$('select[name=orden]').val();
					var categoria='<?php echo $v1; ?>';
					console.log(ciudad);
					console.log(filtro);
					console.log(orden);
					console.log(categoria);
					$('.category-events').empty();
					$('.category-events').load('orden_eventos.php?orden='+orden+'&filtro='+filtro+'&ciudad='+encodeURI(ciudad)+'&categoria='+categoria);
				});
				
				
				
				
			}

			function eventosFav(id) 
			{
				var cookie = '<?php echo $_SESSION['email'];?>';
				if (cookie)
				{
					var getdata = 'email='+cookie+'&id='+id;
					$.ajax({
			        	url: "add_favoritos.php",
			        	type: "GET",
			        	data: getdata,
			        	success: function(data){
			        		//alert(data);
			        	},
			        	error: function(data){
			        		//alert(data);
			        	}
			    	});
				}
				else
				{
					document.getElementById('id01').style.display='block';
				}
			}
			function changeStarFill(icon)
			{
				var cookie = '<?php echo $_SESSION['email'];?>';
				if (!cookie)
				{
					document.getElementById('id01').style.display='block';
				}
				else
				{
					icon.classList.toggle('fa-star-o');
				}
				
			}
			function changeStarEmpty(icon)
			{
				var cookie = '<?php echo $_SESSION['email'];?>';
				if (!cookie)
				{
					document.getElementById('id01').style.display='block';
				}
				else
				{
					if (icon.classList.contains('fa-star-o'))
					{
						icon.classList.remove('fa-star-o');
						icon.classList.toggle('fa-star');
					}
					else
					{
						icon.classList.toggle('fa-star');
						icon.classList.add('fa-star-o');
					}
				}
			}
            $(document).ready(function () {
	            $('#registerform').on('submit', function(e) {
	                e.preventDefault();
	                $.ajax({
	                    url : $(this).attr('action') || window.location.pathname,
	                    type: "POST",
	                    data: $(this).serialize(),
	                    success: function (res) {
	                        $('.error').html(res);
	                    },
	                    error: function (jXHR, textStatus, errorThrown) {
	                        alert(errorThrown);
	                    }
	                });
	            });

	            $('#loginform').on('submit', function(e) {
	                e.preventDefault();
	                $.ajax({
	                    url : $(this).attr('action') || window.location.pathname,
	                    type: "POST",
	                    data: $(this).serialize(),
	                    success: function (res) {
	                        $('.error').html(res);
	                    },
	                    error: function (jXHR, textStatus, errorThrown) {
	                        alert(errorThrown);
	                    }
	                });
	            });
	        });

            function w3_open() {
            document.getElementById("mySidebar").style.display = "block";
            }
            function w3_close() {
                document.getElementById("mySidebar").style.display = "none";
            }

            window.onscroll = function() {scrollFunction()};

			function scrollFunction() {
			    if (document.body.scrollTop > 90 || document.documentElement.scrollTop > 90) {
			        document.getElementById("myBtn").style.display = "block";
			    } else {
			        document.getElementById("myBtn").style.display = "none";
			    }
			}

			// When the user clicks on the button, scroll to the top of the document
			function topFunction() {
			    document.body.scrollTop = 0; // For Safari
			    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
			} 
            function eventosInfo(){
            $('.event-buy-button').click(function(){
                window.open(
                  $(this).attr('id'),
                  '_blank'
                );
            });
            }
            function sleep(milliseconds) {
              var start = new Date().getTime();
              for (var i = 0; i < 1e7; i++) {
                if ((new Date().getTime() - start) > milliseconds){
                  break;
                }
              }
            }
            function eventoModal(id)
            {
                $('.event-detail-info').load('mostrar_descripcion.php?id='+id);
                $('.modal-info-box1').load('mostrar_info.php?id='+id,eventosInfo);
                $('.modal-banner').load('mostrar_banner.php?id='+id,eventosCat);
                sleep(200);
                document.getElementById("id03").style.display = "block";
                document.getElementById("myBtn").style.display = "none";
            }
		</script>

<!-- The Modal -->
<div id="id01" class="modal">
    <!-- Modal Content -->
    <form class="modal-content animate" method="post" action="login.php" id="loginform">
        <div class="imgcontainer">
            <!--<img src="img_avatar2.png" alt="Avatar" class="avatar">-->
            <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">×</span>
        </div>
        <div class="container">
        <div class="error">
                </div>
                <label for="email"><b>Correo electronico</b></label>
                <input type="email" name="email" required/>
                <label for="pass"><b>Contraseña</b></label>
                <input type="password" placeholder="" name="pass" required/>
                <button type="submit" id="modal_button">Iniciar sesión</button>
                
        </div>
  </form>
</div>
<div id="id02" class="modal">
    <form class="modal-content animate" id="registerform" method="post" action="submit.php">
        <div class="imgcontainer">
            <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">×</span>
        </div>

        <div class="container">
        <div class="error">
                </div>
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

    </form>
    </table>
</div>
<div id="id03" class="modal-event">
    <div class="modal-info-box modal-content animate">
        <!--
        <div class="imgcontainer">
            <span onclick="document.getElementById('id03').style.display='none'" class="close-eventmodal" title="Close Modal">×</span>
        </div>
    -->
        <div class="modal-banner"></div>
        <div class="event-detail-info"></div>
        <h3 style="text-align: center; margin-top: 5%; font-size: 1.3vw;">Información</h3>
        <div id="campos_info">
            <p>Ciudad</p>
            <p>Fecha</p>
            <p>Hora</p>
            <p>Precio</p>
        </div>
        <div class="modal-info-box1"></div>
    </div>
    <span onclick="document.getElementById('id03').style.display='none'; document.getElementById('myBtn').style.display='block';" class="close-eventmodal" title="Cerrar ventana"><img src="/../img/close.png"></img></span>
</div>
    </body>
</html>