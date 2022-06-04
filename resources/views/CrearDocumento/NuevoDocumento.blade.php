@extends('App')
@section('content')
<br>
<div class="row">  
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
        <div class="col">
            <div class="card bg-light mb-3"> 
                <div class="card-header"> 
                    <h4><strong>UTILIZAR PLANTILLAS</strong></h4> 
                </div>
                <div class="card-body table-responsive">
                    <table table class="table table-hover"> 
                        <form method="POST" action="{{ route('PDFPlantilla') }}">   
                            @csrf
                            <textarea name="text_plantilla" id="editor">
                                {{ $id_plantillas }}
                            </textarea>
                            <div class="btn-group" style=" width:100%;">	
                                <button type="submit" class="btn btn-success active" formtarget="_blank">Imprimir Multa</button>
                            </div>
                        </form> 
                    </table>
                </div>
                <div class="card-footer text-muted"> 
                    SGD
                </div>
            </div>
        </div>
    </div> 
</div>   
@endsection  
@section('scripts') 
<script type="text/javascript">

        class MyUploadAdapter {
            constructor( loader ) {
       
                this.loader = loader;
            }

            upload() {
                return this.loader.file
                    .then( file => new Promise( ( resolve, reject ) => {
                        this._initRequest();
                        this._initListeners( resolve, reject, file );
                        this._sendRequest( file );
                    } ) );
            }


            abort() {
                if ( this.xhr ) {
                    this.xhr.abort();
                }
            }

            _initRequest() {
                const xhr = this.xhr = new XMLHttpRequest();
                xhr.open( 'POST', "{{ route('images.upload')}}", true );
                xhr.setRequestHeader('X-CSRF-TOKEN', "{{ csrf_token() }}");
                xhr.responseType = 'json';
            }

            _initListeners( resolve, reject, file ) {
                const xhr = this.xhr;
                const loader = this.loader;
                const genericErrorText = `Couldn't upload file: ${ file.name }.`;

                xhr.addEventListener( 'error', () => reject( genericErrorText ) );
                xhr.addEventListener( 'abort', () => reject() );
                xhr.addEventListener( 'load', () => {
                    const response = xhr.response;

                    if ( !response || response.error ) {
                        return reject( response && response.error ? response.error.message : genericErrorText );
                    }

                    resolve( {
                        default: response.url
                    } );
                } );

                if ( xhr.upload ) {
                    xhr.upload.addEventListener( 'progress', evt => {
                        if ( evt.lengthComputable ) {
                            loader.uploadTotal = evt.total;
                            loader.uploaded = evt.loaded;
                        }
                    } );
                }
            } 

            _sendRequest( file ) {

                const data = new FormData();

                data.append( 'upload', file );

                this.xhr.send( data );
            }
        }

        function MyCustomUploadAdapterPlugin( editor ) {
            editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
                // Configure the URL to the upload script in your back-end here!
                return new MyUploadAdapter( loader );
            };
        }

    
    
        

        ClassicEditor
            .create( document.querySelector( '#editor' ),{
            extraPlugins: [ MyCustomUploadAdapterPlugin ],
       

        } )
            .then( editor => {
                const toolbarContainer = document.querySelector( '#toolbar-container' );

            } )
            .catch( error => {
                console.error( error );
            } );
    
</script>
@endsection 