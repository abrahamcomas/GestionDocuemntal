@extends('App')
@section('content') 
<div class="container-fluid">  
	<div class="row"> 
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
            <br>
            <div class="col">
                <div class="card bg-light mb-3">
                    <div class="card-header">
                        <h4><strong>ARCHIVO</center></strong></h4> 
                    </div>
                    <div class="card-body"> 
                        <h4><strong> {{ $Resultado }} </center></strong></h4> 
				    </div>
			    </div> 
            </div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
	</div>
</div> 
@endsection  