<!DOCTYPE html>
<meta charset="utf-8">
<title>GestionDocumental</title>
<head>
    <html lang="es">
    <meta name="description" content="SGD">
	<meta name="viewport" content="width=device-width"/>
    <meta name="theme-color" content="#317EFB"/>
    <link rel="manifest" href="/manifest.json">
	<link href="{{ asset ('css/bootstrap.min.css') }}" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <!--ICONOS-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">

	<script type="text/javascript">
		function checkRut(rut){
			    var valor = rut.value.replace('.','');
			    valor = valor.replace('-','');
			    cuerpo = valor.slice(0,-1);
			    dv = valor.slice(-1).toUpperCase(); 
			    rut.value = cuerpo + '-'+ dv
			    if(cuerpo.length < 7) { rut.setCustomValidity("RUT Incompleto"); return false;}
			    suma = 0;
			    multiplo = 2;
			    for(i=1;i<=cuerpo.length;i++) {
			        index = multiplo * valor.charAt(cuerpo.length - i);
			        suma = suma + index;
			        if(multiplo < 7) { multiplo = multiplo + 1; } else { multiplo = 2; }
			    }
			    dvEsperado = 11 - (suma % 11);
			    dv = (dv == 'K')?10:dv;
			    dv = (dv == 0)?11:dv;
			    if(dvEsperado != dv) { rut.setCustomValidity("RUT Inválido"); return false; }
			    rut.setCustomValidity('');
		} 
    </script>
    <style type="text/css">
        

        a:hover { font-size: 16pt; }
        .cuerpo { font-size:12pt; }

        
        body {
            background-image:url('{{ asset ("Imagenes/fondo2.jpg") }}');
            /*background: -webkit-radial-gradient(0% 100%, ellipse cover, rgba(76, 25, 88,.4) 10%,rgba(138,114,76,0) 40%), 
            -webkit-linear-gradient(top,  rgba(255, 255, 255,.25) 0%,rgba(0, 0, 0) 100%), -webkit-linear-gradient(-45deg,  #2AADB8 0%,#2AADB8 100%);*/
            background-position:center;
            background-size:cover;
            background-attachment: fixed;
        
        } 

        .container {
            padding-top: 5px;
        }
        ::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
            color: #ffffff!important;
            opacity: 1; /* Firefox */
            font-size:18px!important;
        }
        .form-login {
            background-color: rgba(0,0,0,0.70);
            padding-top: 20px;
            padding-bottom: 20px;
            padding-left: 20px;
            padding-right: 20px;
            border-radius: 20px;
            border-color:#d2d2d2;
            border-width: 5px;
            color:white;
            /*box-shadow:0 3px 0 #7A7A7A;*/
        }
        .form-control{
            background:transparent!important;
            color:white!important;
            font-size: 18px!important;
        }
        .footer p{
            font-size: 50px;
        }

        .input-group input:focus{ 
            border-color: blue;
            border-bottom:3px solid blue;	
        }

        .input-group input:hover{ 
            border-color: blue;
            border-bottom:3px solid blue;	
        
        }

        /* ANIMATIONS 


        .fadeInDown {
        -webkit-animation-name: fadeInDown;
        animation-name: fadeInDown;
        -webkit-animation-duration: 1s;
        animation-duration: 1s;
        -webkit-animation-fill-mode: both;
        animation-fill-mode: both;
        }
*/
        @keyframes fadeInDown {
            0% {
                opacity: 0;
                -webkit-transform: translate3d(0, -100%, 0);
                transform: translate3d(0, -100%, 0);
            }
        }


        /*Fondo animado*/
		section{
			width: 100%;
			color: #fff;
			background: linear-gradient(45deg,red,blue,green,black);
			background-size: 400% 400%;
			position: relative;
			animation: cambiar 7s ease-in-out infinite;
            border-radius: 20px;
            opacity: 0.9;
		}

		@keyframes cambiar{
			0%{background-position: 0 50%;}
			50%{background-position: 100% 50%;}
			100%{background-position: 0 50%;}
		}
    </style> 
		@livewireStyles  
        @laravelPWA 
</head> 
<body> 	
    <div id="page-content-wrapper">
        <div class="wrapper fadeInDown">
            @yield("content")
        </div>
            @livewireScripts
            @yield('scripts')
            @yield("foot")
    </div>
</body>