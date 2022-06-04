@extends('App')
@section('content')
	<div class="container-fluid">   
		@livewire('portafolio.recibidos')  
	</div>  
@endsection  
@section('scripts')
<script type="text/javascript"> 
    $(document).ready(function(){
            $("#boton").click(function(event){
                event.preventDefault();
            $("#boton").prop('disabled',true)
             
            return false;
            })
        })
</script> 
@endsection 