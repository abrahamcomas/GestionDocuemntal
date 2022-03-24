@extends('App')
@section('content')
	<div class="container-fluid">  
		@livewire('root.subir-imagen-firma')   
	</div>  
@endsection     
@section('scripts')
<script type="text/javascript">
 
        function Capturar(){
        html2canvas(document.querySelector('.specific'), {
            onrendered: function(canvas) {
            // document.body.appendChild(canvas);
            return Canvas2Image.saveAsPNG(canvas);
            }
        });
        }
        
        //DIBUJO SOBRE PLATAFORMA
        const canvas = document.getElementById("canvas");
        const ctx = canvas.getContext("2d");
        let cw = canvas.width = 700;
        let ch = canvas.height = 200;

        function oMousePosScaleCSS(canvas, evt) {
            let ClientRect = canvas.getBoundingClientRect(), 
                scaleX = canvas.width / ClientRect.width,
                scaleY = canvas.height / ClientRect.height; 
                return {
                x: (evt.clientX - ClientRect.left) * scaleX, 
                y: (evt.clientY - ClientRect.top) * scaleY 
            }
        } 

        let last = {}

        canvas.addEventListener("mousedown", (e)=>{
            m = oMousePosScaleCSS(canvas, e)

            last.x = m.x;
            last.y = m.y;
            
        });

        
        function Siguiente(){
            ctx.clearRect(0,0,cw,ch);
        }
 
        canvas.addEventListener("mouseup", (e)=>{
            last={}

        });

        canvas.addEventListener("mousemove", (e)=>{
            if(last.x){
            m = oMousePosScaleCSS(canvas, e)
            
                
                ctx.beginPath();
                ctx.moveTo(last.x,last.y);
                ctx.lineTo(m.x,m.y);
                ctx.stroke();
                
                last.x = m.x;
                last.y = m.y;
            
            }

        })
        //FIN DIBUJO SOBRE PLATAFORMA
</script>
@endsection  