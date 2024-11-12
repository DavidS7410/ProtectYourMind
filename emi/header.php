<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"https://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="nl" lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="description" content="A short description." />
	<meta name="keywords" content="put, keywords, here" />
	<title>Foro</title>
	<link rel="stylesheet" href="foro.css" type="text/css">
</head>
<body>
<h1>Foro </h1>
	<div id="wrapper">
	    <div id="menu">
		    <a class="item" href="index.php">Inicio</a> -
		    <a class="item" href="crea_topico.php">Crea topico</a> -
		    <a class="item" href="crea_categoria.php">Crea categor&iaccute;a</a>
		    
		    
            <div id="userbar">
			<?php	
		    if($_SESSION['signed_in'])
 			{
 	 			echo 'Hola'. $_SESSION['user_name'] . '. No eres tu? <a href="salir.php">Salir</a>';
 			}
 			else
 			{
 				echo '<a href="Ingreso.php">Ingresar</a> o <a href="registro.php">crear cuenta</a>.';
 			}
			?>	
			</div>
	    </div>
		<div id="content">