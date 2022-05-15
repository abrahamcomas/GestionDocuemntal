@extends('App')
@section('content') 
<br>
<div class="container-fluid">  
	<div class="row"> 
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
            <div class="col">
                <div class="card bg-light mb-3">
                    <div class="text-muted">
                        <br> 
                        <h1><center><strong>RESULTADO</strong></center></h1>
                        <hr>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            @if($sessiones)
                            <center><h5><strong>Borrado correctamente </strong></h5></center> 
                            @else
                            <center><h5><strong>Error, al borrar </strong></h5></center> 
                            @endif
                        </div>
                    </div>
                    <div class="card-footer text-muted">

                    </div>	
                </div> 
            </div> 
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
	</div>
</div>
@endsection  