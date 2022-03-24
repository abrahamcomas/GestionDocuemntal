<meta charset="utf-8">
<title>GestionDocumental</title>
<head>
	<meta name="viewport" content="width=device-width"/>
	<link href="{{ asset ('css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset ('ManuLateral/simple-sidebar.css ') }}" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
	<!--Para que funione el ajax-->
	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" ></script>
	<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <!--PDF JAVASCRIP-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.943/pdf.min.js"></script>

    <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    

    <!--PARA CONVERTIR DIV EN IMAGEN-->
    <script src="https://superal.github.io/canvas2image/canvas2image.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>


    
	<style type="text/css">
 
		#h {  

	        height:auto;
	        background: #31A877;
	        background: -moz-radial-gradient(0% 100%, ellipse cover, rgba(76, 25, 88,.1) 10%,rgba(138,114,76,0) 40%),-moz-linear-gradient(top,  rgba(255, 255, 255,.25) 0%, rgba(0, 0, 0,.1) 100%), -moz-linear-gradient(-45deg,  #31A877 0%, #31A877 100%);
	        background: -webkit-radial-gradient(0% 100%, ellipse cover, rgba(76, 25, 88,.4) 10%,rgba(138,114,76,0) 40%), -webkit-linear-gradient(top,  rgba(255, 255, 255,.25) 0%,rgba(76, 25, 88) 100%), -webkit-linear-gradient(-45deg,  #31A877 0%,#31A877 100%);
	        background: -o-radial-gradient(0% 100%, ellipse cover, rgba(76, 25, 88,.4) 10%,rgba(138,114,76,0) 40%), -o-linear-gradient(top,  rgba(255, 255, 255,.25) 0%,rgba(76, 25, 88) 100%), -o-linear-gradient(-45deg,  #31A877 0%,#31A877 100%);
	        background: -ms-radial-gradient(0% 100%, ellipse cover, rgba(76, 25, 88,.4) 10%,rgba(138,114,76,0) 40%), -ms-linear-gradient(top,  rgba(255, 255, 255,.25) 0%,rgba(76, 25, 88) 100%), -ms-linear-gradient(-45deg,  #1B67AE 0%,#1B67AE 100%);
	        background: -webkit-radial-gradient(0% 100%, ellipse cover, rgba(76, 25, 88,.4) 10%,rgba(138,114,76,0) 40%), linear-gradient(to bottom,  rgba(255, 255, 255,.25) 0%,rgba(76, 25, 88) 100%), linear-gradient(135deg,  #31A877 0%,#31A877 100%);

	    }

		.card-header { 
			color: white !important;
			background-color: #31A877 !important;
		}

        .btn-primary{
			background: #31A877 !important;
		}

		.btn-warning{
			color: #FFFFFF !important;
		}
	</style> 

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="h">
		<div class="top-right link">	 
			<a class="navbar-brand" href="#" style="color: white; font-size:16px;"><STRONG>GESTIÓN DOCUMENTAL</STRONG></a>		
		</div>
	</nav>  
</head>
<body>
    <div class="card-header">
        <h4><strong><center>PORTAFOLIO RECIBIDO</center></strong></h4>
    </div>
    <div class="card-body">
        <center>   
            <h4>
                El Funcionario/a {{ $DatosEmisor->Nombres}} {{ $DatosEmisor->Apellidos}} le ha enviado un portafolio.
            </h4>
        </center>
        <div class="card-header">
        <center>   
            <a href="{{ 'http://sgd.municipalidadcurico.cl' }}" style="color: white;" class="btn btn-primary active">
		      	REVISAR
            </div>
        </center>
    </div>
    <div>		
        <div>
            <center>
                © {{ date("Y") }} Dep. de informática V0.1<br>
                Municipalidad de Curicó<br>
                GESTIÓN DOCUMENTAL
            </center>
        </div>
    </div> 
</body>