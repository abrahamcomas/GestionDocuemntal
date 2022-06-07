@extends('App') 
@section('content')
<br>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3"></div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
        <div class="col">
            <div class="card bg-light mb-3" > 
                <div class="text-muted">
                    <h1><center><strong>RESULTADO</strong></center></h1>
                    <hr>
                </div>
                    <div class="card-body">
                        <h5><strong><center>{{ $resultado }}</center></strong></h5>
                    </div>
                <div class="card-footer text-muted">
                    SGD
                </div>
            </div>
        </div>	
    </div>	
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3"></div>				
</div>
@endsection 