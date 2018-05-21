<?php
$link = mysqli_connect('localhost','phpmyadmin', 'Proyecto@01') or die ("No conecta con el servidor");
if (!mysqli_select_db($link,"planup"))
{
    $query = "CREATE DATABASE `planup`;";
    if (!mysqli_query($link, $query))
    {
        printf("Error: %s\n", mysqli_error($link));
    }
}
if (mysqli_select_db($link,"planup"))
{
    printf("Conexion establecida\n");
}
else
{
    printf("Fallo en la conexion con la base de datos");
}
$query = "CREATE TABLE `eventos` (
        `id` int(2) NOT NULL auto_increment,
        `nombre` varchar(100) NOT NULL,
        `categoria` varchar(100) NOT NULL,
        `fecha` varchar(20) NOT NULL,
        `hora` varchar(20),
        `ciudad` varchar(100) NOT NULL,
        `descripcion` text NOT NULL,
        `precio` int(10) UNSIGNED,
        `img` varchar(200),
        `prioridad` varchar(1) NOT NULL DEFAULT '0',
        `visitas` int(20) UNSIGNED NOT NULL DEFAULT '0',
        'recomendado' text, 
        'enlace' text NOT NULL,
        PRIMARY KEY  (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24;";

if (!mysqli_query($link, $query))
{
    printf("Error: %s\n", mysqli_error($link));
}

$query = "CREATE TABLE `usuarios` (
    `id` int(4) NOT NULL auto_increment,
    `name` varchar(100) NOT NULL,
    `email` varchar(100) NOT NULL,
    `password` varchar(80) NOT NULL,
    UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;";

if (!mysqli_query($link, $query))
{
    printf("Error: %s\n", mysqli_error($link));
}

$query = "CREATE TABLE `favoritos` (
    `id` int(11) NOT NULL,
    `email` varchar(100) NOT NULL,
    UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;";

if (!mysqli_query($link, $query))
{
    printf("Error: %s\n", mysqli_error($link));
}

$query = "CREATE TABLE `categorias` (
    `id` int(11) NOT NULL auto_increment,
    `nombre` varchar(40) NOT NULL,
    `descripcion` varchar(200) NOT NULL,
    `img` varchar(200) NOT NULL,
    UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;";

if (!mysqli_query($link, $query))
{
    printf("Error: %s\n", mysqli_error($link));
}


mysqli_close($link);
?>
