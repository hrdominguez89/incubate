@extends('layouts.template')
@section('content')
<div class="content-area">
   <div class="breadcrumb-bar">
      <div class="page-title">
         <h1><i class="ti-settings"></i> Documentos</h1>
      </div>
      <ul class="admin-breadcrumb">
         <li><a href="{{url('dashboard')}}" title="Escritorio"><i class="ti-desktop"></i> Escritorio</a></li>
         <li>Documentos</li>
      </ul>
   </div>
   <!-- Breadcrumb Bar -->
   <div class="widgets-wrapper">
      {!! Form::open(['route' => 'documents.store','method' => 'POST']) !!}
      <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
      <div class="row">
         <div class="masonary">
            <div class="col s12">
               <div class="col s12">
                  <div class="widget z-depth-1">
                     <div class="widget-title">
                        <h3><i class="ti-pencil"></i> Ingresá el contenido de tu documento aquí</h3>
                     </div>
                     <div class="widget-content">
                        <ul class="nav nav-tabs">
                           <li  class="active"><a data-toggle="tab" href="#img-1"><img src="{{url('/')}}/uploads/backend/es.png" style="width:25px;float:none" /> Español</a></li>
                           <li><a data-toggle="tab" href="#img-2"><img src="{{url('/')}}/uploads/backend/en.png" style="width:25px;float:none" /> Inglés</a></li>
                        </ul>
                        <div class="tab-content">
                           <div id="img-1" class="tab-pane fade in active">
                              <div class="input-field col s12" style="clear: both;"><br>
                                 <label class="active">Título en Español<small style="color: #fd2923">*</small></label>                     {!!Form::text('title',null,['class' => 'form-control'])!!}
                              </div>
  
                           </div>
                           <div id="img-2" class="tab-pane fade">
                              <div class="input-field col s12" style="clear: both;"><br>
                                 <label class="active">Título en Inglés<small style="color: #fd2923">*</small></label>                     {!!Form::text('title_en',null,['class' => 'form-control'])!!}
                              </div>
                
                           </div>
                        </div>
                        <div class="input-field col s12">
                           <label style="color: #fd2923!important">Campos requeridos (*)</label><br>
                        </div>
                     </div>
                  </div>
                  <div class="widget z-depth-1">
                     <div class="widget-title">
                        <h3><i class="ti-image"></i> Instructivo</h3>
                     </div>
                     <div class="widget-content">
                        
                         <div class="input-field col s12">
                           <label>Tipo de Instructivo <small style="color: #fd2923">*</small></label>
                           {!!Form::select('type', ['1'=>'Imagenes/Documento','2'=>'Video'], 1,['placeholder' => 'Seleccionar el tipo de galería','class' => 'browser-default','id'=>'type'])!!}
                        </div>
                        <div class="input-field col s12 sect-video" style="clear: both;display: none;"><br>
                           <label class="active">URL del video<small style="color: #fd2923">*</small></label>                     {!!Form::text('video',null,['class' => 'form-control'])!!}
                        </div>
                        <div class="input-field col s12 sect-image">
                           <input name="image" id="image" value="" type="hidden">
                           <div id="dropzone" class="dropzone"></div>
                        </div>

                        <div class="input-field col s12">
                           <label style="color: #fd2923!important">Campos requeridos (*)</label><br>
                        </div>
                        
                     </div>
                  </div>
                  <div style="width: 100%; text-align: center;"><br><br>
                     <button  class="btn orange" id="enviar"><i class="fa fa-paper-plane" aria-hidden="true"></i> Guardar</button> 
                     <br><br>
                  </div>
               </div>
            </div>
         </div>
      </div>
      {!! Form::close() !!}
   </div>
</div>
<!-- Content Area -->
<script type="text/javascript">
   $('#type').change(function() {
    if($("#type").val()=='2'){
     $(".sect-video").show();
     $(".sect-image").hide();
   }else{
$(".sect-video").hide();
     $(".sect-image").show();
   }
 });
   $( "#enviar" ).click(function() {
  $("#enviar").prop('disabled', true);
  $("form").submit();
});
</script>
@stop