@extends('App')
@section('content')
	<div class="container-fluid">  
		@livewire('documento-externo.descargar' , ['status' => $status, 'file' => $file])   
	</div>  
@endsection    
@section('scripts')
	
@endsection 

 