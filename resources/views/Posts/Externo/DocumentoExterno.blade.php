@extends('App')
@section('content')
	<div class="container-fluid">  
		@livewire('documento-externo.documento-externo' , ['Ruta' => session('Ruta'),'cuantos' =>  session('cuantos'), 'nuevaHora' => session('nuevaHora')])   
	</div>   
@endsection      
@section('scripts') 
    <script type="text/javascript">

            document.addEventListener("DOMContentLoaded", function() {
                    document.getElementById("F_prestamo").addEventListener('submit', validarFormulario); 
            });

            function validarFormulario(evento) {
                evento.preventDefault();
                var mousePosX = document.getElementById('mousePosX').value;
                if(mousePosX.length == 0) {
                    alert('Por favor seleccione el lugar en donde ira la firma digital.');
                    return;
                }

                var Contrasenia = document.getElementById('Contrasenia').value;
                if(Contrasenia.length == 0) {
                    alert('El campo Contraseña es obligatorio.');
                    return;
                }

                $("#IngresoFirma").hide();     
                $("#siguelo").hide();  
                $("#errors").hide(); 
                $("#MostrarFor").show(); 
                this.submit();
            }
 

        //MOSTRAR PDF//////////
        var myState = { 
            pdf: null, 
            currentPage: 1,
            zoom: 1
        } 
            
        pdfjsLib.getDocument('{{ 'ImagenPDF/'.session('Ruta') }}').then((pdf) => {

            myState.pdf = pdf;
            render();

        });

        function render() {
            myState.pdf.getPage(myState.currentPage).then((page) => {
                var canvas = document.getElementById("pdf_renderer");

           


                var ctx = canvas.getContext('2d');
                var viewport = page.getViewport(myState.zoom);
                canvas.width = viewport.width;
                canvas.height = viewport.height;
                page.render({
                        canvasContext: ctx,
                        viewport: viewport
                });
            }); 
        }

        function Siguiente(){
            if(myState.pdf == null || myState.currentPage == myState.pdf._pdfInfo.numPages) return;          
                myState.currentPage += 1;
                document.getElementById("current_page").value = myState.currentPage;
                    document.getElementById("Pagina").value = myState.currentPage;
                render();
        }
            
        function Anterior(){
            if(myState.pdf == null|| myState.currentPage == 1) return;
                myState.currentPage -= 1;
                document.getElementById("current_page").value = myState.currentPage;
                document.getElementById("Pagina").value = myState.currentPage;
                render();
        }     	
        //FIN MOSTRAR PDF//////////
    
    //CORDENADAS
        $(document).ready(function(){
            var Firma = 0;
            var canvas = document.getElementById("pdf_renderer");
            var ctx = canvas.getContext("2d");
            var image = document.getElementById('source');
            if (canvas && canvas.getContext) {
            if (ctx) {
                canvas.addEventListener("mousedown",function(evt){

                    //if(Firma<1){
                        mousePos = oMousePos(canvas, evt);
                        document.getElementById("mousePosX").value = mousePos.x;
                        document.getElementById("mousePosY").value = mousePos.y;
                        document.getElementById("Ancho").value = canvas.clientWidth;
                        document.getElementById("Alto").value = canvas.clientHeight; 
                        Firma=Firma+1;
                        $("#siguelo").show();
                    //}  
                });
                canvas.addEventListener("mousedown", function(evt) {
                   
                        
                        //$("#siguelo").show(); 
                        
                        var x = window.event.pageX + 1;
                        var y = window.event.pageY + 1;

                        document.getElementById("siguelo").style.left = x + "px";
                        document.getElementById("siguelo").style.top = y + "px";
                        
                      
                });
            }
            } 

            function oMousePos(canvas, evt) {
                var ClientRect = canvas.getBoundingClientRect();
                return { //objeto
                    x: Math.round(evt.clientX - ClientRect.left),
                    y: Math.round(evt.clientY - ClientRect.top)
                    
                }
            }
    });   
    </script>	
@endsection 
