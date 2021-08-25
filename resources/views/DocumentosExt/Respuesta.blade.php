@extends('App')
@section('content') 
<div class="container-fluid">  
	<div class="row"> 
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
        <br>
            <div class="col">
                <div class="card bg-light mb-3">
                    <div class="card-body">





                        @if($status=='OK')
                            <h5><strong><center>Documento firmado correctamente.</center></strong></h5>
                        @else
                            <h5><strong><center>Error, en firma digital.</center></strong></h5>
                            <h5><strong><center>{{ $status }}</center></strong></h5>
                        @endif
				    </div>
			    </div> 
            </div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4"></div>
	</div> 
</div> 
@endsection  
