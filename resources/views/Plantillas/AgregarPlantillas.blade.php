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
                        <h4><strong>PLANTILLAS</strong></h4> 
                    </div>
                    <div class="card-body">  
                        <table table class="table table-hover"> 
                            <thead> 
                                <tr>
                                    <th>NOMBRE</th>
                                    <th>DESCARGAR</th>
                                    <th>ELIMINAR</th>
                                </tr>
                            </thead>    
                            <tbody> 
                        @foreach($plantillas as $post)  
                                <tr>
                                    <td> 
                                        {{$post->nombre_plantilla }}
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ route('DescargarPlantillas') }}" enctype="multipart/form-data">
                                            @csrf  
                                            <input type="hidden" name="id_plantillas" value="{{ $post->id_plantillas  }}">
                                            <div class="btn-group" style=" width:100%;">	
                                                <button type="submit" class="btn btn-info active" style="background: #31A877;">DESCARGAR</button>
                                            </div>	
                                        </form> 
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ route('EliminarPlantillas') }}" enctype="multipart/form-data">
                                            @csrf  
                                            <input type="hidden" name="id_plantillas" value="{{ $post->id_plantillas  }}">
                                            <div class="btn-group" style=" width:100%;">	
                                                <button type="submit" class="btn btn-danger active" >ELIMINAR</button>
                                            </div>	
                                        </form>
                                    </td>
                                </tr>
                        @endforeach   
                            </tbody> 
                        </table>
                    </div> 
                    <div class="card-footer text-muted">
                        <form method="POST" action="{{ route('IngresarPlantillas') }}" enctype="multipart/form-data">
                            @csrf  
                            <div class="form-group">
                                <h6>AGREGAR ARCHIVO/S*</h6> 
                                <div class="form-label-group"> 
                                    <input type="file" class="form-control" name="word" accept="application/word">
                                </div> 
                            </div>
                            <div class="btn-group" style=" width:100%;">	
                                <button type="submit" class="btn btn-success active">INGRESAR</button>
                            </div>	
                        </form>
                    </div>
                    <div class="card-footer text-muted">
                        GESTION DOCUMENTAL      
                    </div>
                </div>
            </div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
	</div>
</div> 
@endsection  