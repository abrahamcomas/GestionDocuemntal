@extends('App')
@section('content')
	<div class="container-fluid">   
		@livewire('o-d-p.detenidos-o-d-p')   
	</div>   
@endsection  
@section('scripts')
<script type="text/javascript">
$(document).ready(function() {
    
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