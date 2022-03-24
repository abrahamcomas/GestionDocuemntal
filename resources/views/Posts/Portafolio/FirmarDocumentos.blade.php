@extends('App')
@section('content')
	<div class="container-fluid">   
		@livewire('portafolio.firmar-documentos')  
	</div>  
@endsection   
@section('scripts')
<script type="text/javascript">
$(document).ready(function(){               
	$(document).on('click', '#btnEnviar1', function(){ 
		$("#MostrarFor").show(); 
		$("#IngresoFirma").hide();      
	});
        
    $(document).on('click', '#MostrarMensaje', function(){
        setTimeout(function() {
            $(".content2").fadeIn(1000);
        },500);
        setTimeout(function() {
            $(".content2").fadeOut(1000);
        },5000);   

    }); 
}); 
</script> 
@endsection   