@extends('App')
@section('content')
	<div class="container-fluid">  
		@livewire('documento-externo.subir-documento')     
	</div>  
@endsection    
@section('scripts')
    <script type="text/javascript"> 
        $("#PDF").on("change", function() {
            if ($("#PDF")[0].files.length >= 11) {
                alert("Máximo 10 archivos.");
                document.getElementById("PDF").value = "";
            }
        });
    </script>	
@endsection   