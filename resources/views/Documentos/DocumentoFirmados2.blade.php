@extends('App') 
@section('content')
<br>
<div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3"></div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                <div class="col">
                    <div class="card bg-light mb-3" > 
                    <div class="card-header">DOCUMENTO</div>  
                        <div class="card-body">
                            @if($status=='OK')
                                <h5><strong><center>Documento firmado correctamente.</center></strong></h5>
                            @else
                                <h5><strong><center>Error, en firma digital.</center></strong></h5>
                                <h5><strong><center>{{ $status }}</center></strong></h5>
                            @endif
                            <form method="POST" action="{{ route('DocumentosDeEntrada') }}">
                                @csrf
                                <center>
                                <div class="btn-group" style=" width:50%;">
                                    <button type="submit" class="btn btn-primary active">
                                        CONTINUAR
                                    </button> 
                                </div></center>
                            </form>
                            <div class="card-footer text-muted">
                                GESTION DOCUMENTAL
                            </div>
                        </div>
                    </div>
                </div>	
            </div>	
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3"></div>				
        </div>
@endsection   