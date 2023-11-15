<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Error</title>

	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/sweetalert2.css">
	<link rel="stylesheet" href="css/material2.min.css">
	<link rel="stylesheet" href="css/material-design-iconic-font.min.css">
	<link rel="stylesheet" href="css/jquery.mCustomScrollbar.css">
	<link rel="stylesheet" href="css/main.css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script>
		window.jQuery || document.write('<script src="js/jquery-1.11.2.min.js"><\/script>')
	</script>
	<script src="js/material.min.js"></script>
	<script src="js/sweetalert2.min.js"></script>
	<script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
	<script src="js/main.js"></script>
</head>

<body>
	<div class="login-wrap cover">
		<div class="container-login">
			<p class="text-center" style="font-size: 80px;">
				<i class="zmdi zmdi-mood-bad"></i>
			</p>
			<!-- Cambiado para usar el elemento con id "comentario" -->
			<p id="comentario" class="text-center text-condensedLight">Usuario o Contraseña son incorrectos</p>
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<label class="mdl-textfield__label"></label>
				<div style="text-align:center">
					<a class="back-link" href="javascript:history.back()">Volver atrás</a>
				</div>
			</div>
			<!-- Nuevo elemento para mostrar el comentario -->
			<p id="comentario" class="text-center text-condensedLight"></p>
		</div>
	</div>

	<script>
		// Función para obtener parámetros de la URL
		function obtenerParametroUrl(nombre) {
			const urlParams = new URLSearchParams(window.location.search);
			return urlParams.get(nombre);
		}

		// Función para mostrar el comentario en el elemento con id "comentario"
		function mostrarComentario() {
			const comentario = obtenerParametroUrl('comentario');
			if (comentario) {
				// Si hay un comentario, mostrarlo en el elemento con id "comentario"
				const elementoComentario = document.getElementById('comentario');
				if (elementoComentario) {
					elementoComentario.textContent = comentario;
				}
			}
		}

		// Llama a la función al cargar la página
		window.onload = mostrarComentario;
	</script>
</body>

</html>