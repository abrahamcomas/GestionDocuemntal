<div> 
    <br>
    <div id="IngresoFirma" class="row">  
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-2"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">  
            <div class="col"> 
            @include('messages')  
                <div class="card bg-light mb-3">
                        <div class="text-muted">
                            <br> 
                            <h1><center><strong>ACTA DE ENTREGA</strong></center></h1>
                            <hr>
                        </div>
                        <div class="card-body">
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
                            <form method="POST" action="{{ route('Solicitudes') }}">
                                @csrf
                                <div class="btn-group" style=" width:100%;">
                                        <button type="submit" id="btnEnviar1" class="btn btn-danger  btn-submit active">VOLVER</button>
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