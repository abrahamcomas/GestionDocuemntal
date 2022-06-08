@extends('App')
@section('content') 
<br>
<div class="container-fluid">  
	<div class="row"> 
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col">
                <div class="card bg-light mb-3">
                    <div class="text-muted">
                        <h1><center><strong>DISPOSITIVOS VINCULADOS</strong></center></h1>
                        <hr>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table table class="table table-hover table-sm table-bordered"> 
                                <thead>
                                    <tr> 
                                        <th><center>DISPOSITIVOS</center></th>
                                        <th><center>IP</center></th>
                                        <th><center>ÚLTIMA ACTIVIDAD</center></th>
                                        <th><center>ELIMINAR</center></th>
                                    </tr> 
                                </thead>
                                <tbody>  
                                    @foreach($sessiones as $post)
                                    <tr>
                                        <td><center>{{ $post->user_agent }}</center></td>
                                        <td><center>{{ $post->ip_address  }}</center></td>
                                        <td><center> {{ \Carbon\Carbon::createFromTimeStamp($post->last_activity)->diffForhumans() }} </center></td>
                                        <td><form method="POST" action="{{ route('EliminarVinculo') }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $post->id }}" >
                                            <center><button type="submit" class="btn btn-danger active btn-info">ELIMINAR</button></center>
                                        </form></td>
                                    </tr>
                                    @endforeach 
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-muted"> 
                        SGD
                    </div>
                </div> 
            </div> 
		</div>
	</div>
</div>
@endsection  