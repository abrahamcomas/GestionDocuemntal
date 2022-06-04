@extends('App')
@section('content') 
<div class="container-fluid">  
	<div class="row"> 
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
        <br>
            <div class="col">
                <div class="card bg-light mb-3">
                <div class="text-muted" >
                        <br> 
                        <h1><center><strong>ARCHIVO</strong></center></h1>
                         <hr>
                    </div>
                    <div class="card-body"> 
                        @if($status=='OK') 
                            <h5><strong><center>ARCHIVOS FIRMADO CORRECTAMENTE.</center></strong></h5>
                            <hr>
                            <form method="POST" action="{{ route('MostrarPDFExterno') }}">   
                                @csrf              
                                <input type="hidden" name="nombreArchivo" value="{{ $nombreArchivo }}">
                                <div class="btn-group" style=" width:100%;">	
                                    <button type="submit" class="btn btn-primary active" formtarget="_blank">DESCARGAR</button>
                                </div>
                            </form>
                        @else  
                        <div class="card-body">
                            <h3><strong><center>ERROR EN FIRMA DIGITAL.<br></center></strong></h3>
                            <br>
                            <h5>
                            Por favor complete el siguiente formulario. <br>
                            
                            <a href="https://forms.gle/d4ke6fWhvaPnSr217" target="_blank"> Completar formulario </a><br>
                            <hr>
                            <strong>O contacte con Nelson Arturo Sepúlveda Manzo<br> Encargado Firma Digital Avanzada.</strong>
                            <hr>
                                nelson.sepulveda@curico.cl<br>
                                Anexo 755<br>
                                Teléfono +569-76212407
                            </h5>
                        </div> 
                        @endif
				    </div>
			    </div>  
            </div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
	</div> 
       <!-- <h3><strong><center><u>Tutorial como descomprimir un archivo 7z descargado.</u><br></center></strong></h3>
        <center><img src="{{URL::asset('Imagenes/TutorialZip.JPG')}}" width="1200" height="800" class="img-fluid" alt="Responsive image"/></center>-->
</div> 
@endsection  
