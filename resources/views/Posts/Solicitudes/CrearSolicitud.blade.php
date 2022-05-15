@extends('App')
@section('content')
	<div class="container-fluid">   
        @livewire('solicitudes.crear-solicitud')  
	</div>  
@endsection  
@section('scripts')
<script type="text/javascript">
            function Capturar(){
                html2canvas(document.querySelector('.specific'), {
                    onrendered: function(canvas) {
                        document.getElementById("Firma").value = canvas.toDataURL();
                    }
                }); 
            }
        </script>
@endsection