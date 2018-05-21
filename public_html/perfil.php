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
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
			<div class="main-content-search">
				<img src="../img/cabecera.jpg"/>
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
			$('#cities').load('ciudades.php',eventosCiudad);
            $('.left-menu-ul').load('mostrar_categorias_href.php',eventosCateg);
		}
        function eventosCiudad(){
            $('#cities').change(function(){
                var ciudad=$('#cities option:selected').text(); 
                $('.event-list').empty();
                $('.event-list2').empty();              
                console.log('pasa');
                $('.event-list').load('mostrar_destacados.php?ciudad='+encodeURI(ciudad));
                $('.event-list2').load('mostrar_recomendados.php?ciudad='+encodeURI(ciudad));
                console.log('pasa2');
            });
        }
        
        function eventosDest(){
            
        }
        
        function eventosRecom(){
            
        }
        
        function eventosCateg(){
            $('.menu-links').click(function(){
                var ciu=$('#cities option:selected').text();    
                var href=$(this).parent().attr('id');               
                var ciudad=ciu.replace(' ','-');
                
                href= href+'&ciudad='+ciudad;               
                window.location.href = href;
                
            });
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
                        $('#favorites-list').load('#favorites-list');
                    },
                    error: function(data){
                        alert(data);
                    }
                });
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
        function eventosCat(){
                        
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