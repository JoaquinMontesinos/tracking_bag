{*Toda la codificacion de las páginas es 'universal' (no escrito) de acuerdo a UTF-8*}
<meta charset="utf-8">

{*Autor de la web y desarrollador activo
<meta name="author" content="Alexis Sánchez Sanz <alexis@alexissanchezsanz.es>">*}

{*Para asegurar el último tipo de renderización en Internet Explorer (ya está puesto en el .htacces)*}
<meta http-equiv="X-UA-Compatible" content="IE=edge">
{*Para que se adapte y se vea bien en móviles*}
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

{*Iconos de distintos tamaños y distintas extensiones
<link rel="shortcut icon" 		type="image/x-icon" href="assets/images/icons/favicon.ico" >*}
{assign var='img_path' value='assets/images/icons/apple-touch-icon-'}
<link rel="shortcut icon" 		type="image/png" 		href="{$img_path}180x180.png" >
<link rel="icon" 							type="image/png" 		href="{$img_path}180x180.png">
<link rel="apple-touch-icon" 	sizes="60x60"			  href="{$img_path}60x60.png" >
<link rel="apple-touch-icon"  sizes="76x76" 			href="{$img_path}76x76.png">		
<link rel="apple-touch-icon"  sizes="120x120" 		href="{$img_path}120x120.png"> 
<link rel="apple-touch-icon"  sizes="152x152" 		href="{$img_path}152x152.png">	
<link rel="apple-touch-icon"  sizes="167x167" 		href="{$img_path}167x167.png">
<link rel="apple-touch-icon"  sizes="180x180" 		href="{$img_path}180x180.png">

{*Título de la página*}
<title>{$title}</title>

{*Base para todos los link relativos*}
<base href="http{if isset($smarty.server.HTTPS) and ($smarty.server.HTTPS ==='on')}s{/if}://{$smarty.server.SERVER_NAME}:{$smarty.server.SERVER_PORT}/">

{*Bootstrap theme*}
<link
	rel="stylesheet"
	href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
	integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
	crossorigin="anonymous"
>

<script src="https://kit.fontawesome.com/a0ff3ac186.js" crossorigin="anonymous" integrity="sha384-TDhFdBCp6zkFoOxFg2XaOsN4rWmrP4Tbzzaz0VKFgnk4mENBCgpW6mG7kamM0Yvy"></script>
{*<script
  async
  defer
  src="https://use.fontawesome.com/releases/v5.8.0/js/all.js"
  integrity="sha384-ukiibbYjFS/1dhODSWD+PrZ6+CGCgf8VbyUH7bQQNUulL+2r59uGYToovytTf4Xm"
  crossorigin="anonymous"></script>*}

{*jQuery*}
<script
	src="https://code.jquery.com/jquery-3.3.1.min.js"
	integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
	crossorigin="anonymous"></script>