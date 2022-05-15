<div> 
    <br>
    <div  id="MostrarFor" style="display:none">
        <div class="col">
            <div class="card bg-light mb-3" >
                <div class="card-body">
                    <center> 
                        <img src="{{URL::asset('Imagenes/12.gif')}}" width="220" height="220"/>
                        <h5><strong>Firmando archivo, espere por favor...</strong></h5>
                    </center>
                </div>
                <div class="card-footer text-muted">
                    GESTIÓN DOCUMENTAL
                </div>
            </div> 
        </div>  
    </div> 
    <div id="IngresoFirma" class="row">  
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">  
            <div class="col">  
            @include('messages')  
                <div class="card bg-light mb-3">
                    <div class="text-muted" >
                            <br> 
                            <h1><center><strong>FIRMAR ARCHIVO</strong></center></h1>
                            <hr>
                        </div>
                        <div class="card-body">
                            <strong>Por favor, haz click sobre el PDF para posicionar la firma electrónica.</strong>
                            <center>
                                <div id="coords"> 
                                    <div id="canvas_container">
                                        <canvas id="pdf_renderer"></canvas>
                                    </div>    
                                    <hr>   
                                    <div id="navigation_controls">
                                        <button onclick="Anterior()" class="btn btn-success active">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                                            </svg>
                                        </button>
                                        <input id="current_page" value="1" disabled>
                                        <button onclick="Siguiente()" class="btn btn-success active">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                            </svg>
                                        </button>
                                    </div>    
                                    <hr>      
                                </div>   
                            </center>      
                            <form id="F_prestamo" name="F_prestamo" method="POST" action="{{ route('FirmandoRecibidoIndiv') }}" accept-charset="UTF-8" enctype="multipart/form-data">
                                @csrf    
                                <input type="hidden" name="Ruta" value= "{{ session('Ruta') }}"> 
                                <input type="hidden" name="ID_DestinoDocumento" value= "{{ session('ID_DestinoDocumento') }}">
                                <input type="hidden" name="ID_Documento_T" value= "{{ session('ID_Documento_T') }}">
                                <input type="hidden" name="IPF_ID" value= "{{ session('IPF_ID') }}">
                                <input type="hidden" id="mousePosX" name="mousePosX">
                                <input type="hidden" id="mousePosY" name="mousePosY"> 
                                <input type="hidden" id="Pagina" name="Pagina">
                                <input type="hidden" id="Ancho" name="Ancho"> 
                                <input type="hidden" id="Alto" name="Alto">
                                <br>  
                                <label><strong>AGREGAR OBSERVACIÓN (OPCIONAL)</strong></label>
                                <div class="form-label-group"> 
                                    <textarea class=" form-control" name="ObservacionPortafolio"></textarea>
                                </div>
                                <strong>Por favor, Confirme su contraseña de usuario.</strong>
                                <div class="form-label-group">
                                    <input type="password" class="form-control" name="Contrasenia"  placeholder="Confirme Contraseña Usuario" autocomplete="off">
                                </div>
                            </div>
                                <div class="card-footer text-muted">
                                    <div class="btn-group" style=" width:100%;">
                                        <button type="submit" id="btnEnviar1" class="btn btn-success  btn-submit active">Continuar</button>
                                    </div>
                                </div>
                            </form> 
                        <div class="card-footer text-muted">
                            GESTIÓN DOCUMENTAL
                        </div>    
                    </div>      
                </div>
            </div>  
        </div> 
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
    </div>
    <div id="siguelo" 
        style="position: absolute; left: 100px; top: 50px; border-top-style: solid;
        border-right-style: solid;
        border-bottom-style: solid;
        border-left-style: solid;
        color: blue;
        width: 190;
        height: 150; 
        text-align: center; display:none;"><strong>Posición firma<br>Gestión documental</strong>
    </div>
</div>