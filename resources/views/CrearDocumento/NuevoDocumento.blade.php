@extends('App')

<style>
		

			textarea {
          	resize:none;
          	}
		</style>


@section('content')
	<div class="container-fluid">    
		<br>                                   

                    <div class="form-label-group"> 
                        <select class="form-control"  id="Plantilla" name="Plantilla">
                            <option value="0" selected>---SELECCIONAR---</option>
                            @foreach($plantillas as $post)
                                <option value="{{ $post->id_plantillas  }}">{{ $post->nombre_plantilla }}</option>
                            @endforeach
                        </select> 
                    </div> 	 

                    <br> 
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">	
                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
                        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                            <div id="textareaprincipal">
                                <center>
                                    <div>
                                        <textarea id="TextArea" name="TextArea">
                                        </textarea>
                                    </div>
                                </center> 
                            </div>
                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
                        </div> 
                    </div>

                    <center>

                    <input class="form-control" type="text" name="N_plantilla" id="N_plantilla" placeholder="Nombre Plantilla">
		              			
                    
                    
                    
                    <button type="button" class="btn btn-primary ingresarplantilla" >Agregar plantilla y continuar</button>
		              		</center>	

























	</div>  
@endsection  
@section('scripts')
<script type="text/javascript">

$(document).ready(function() {
	         CKEDITOR.replace('TextArea');
      
                $("#Plantilla").change(function () {
                    $("#Plantilla option:selected").each(function () {
                        id_plantillas = $(this).val(); 
                        $.ajax({
                            
                            url: "{{ route('MostrarPlantillas')}}",
                            data: {
                                "id_plantillas": id_plantillas,
                                "_token": "{{ csrf_token() }}"
                            },
                            method: "POST",

                                success: function(data) 
                                {
                                    
                                    CKEDITOR.instances['TextArea'].setData(data)

                                },

                              
                        });
                     
                    }); 
                });

                $(document).on('click', '.ingresarplantilla', function(){
                    N_plantilla=document.getElementsByName("N_plantilla")[0].value;	
                

                    TextArea = CKEDITOR.instances['TextArea'].getData();
                    $.ajax({ 
                        
                        url: "{{ route('GuardarPlantillas')}}",
                        data: {

                            "N_plantilla": N_plantilla,
                            "TextArea": TextArea,
                            "_token": "{{ csrf_token() }}"
                        },
                        method: "POST",

                            success: function(data) 
                            {
                                
                               

                            },

                            
                    });
                    
                });
                
              
 		
            }); 		

</script>
@endsection