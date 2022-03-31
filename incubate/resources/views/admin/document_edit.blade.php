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
   <div class="widgets-wrapper" ng-app="myApp" ng-controller="paginas">
      {!!Form::model($document,['route'=>['documents.update',$document],'method'=>'PUT'])!!}
      <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
      <div class="row">
         <div class="masonary">
            <div class="col s12">
               <div class="col s12">
                  <div class="widget z-depth-1">
                     <div class="widget-title">
                        <h3><i class="ti-pencil"></i> Actualizá el contenido de tu documento aquí</h3>
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
                           {!!Form::select('type', ['1'=>'Imagenes/Documento','2'=>'Video'], $document->type,['placeholder' => 'Seleccionar el tipo de banner','class' => 'browser-default','id'=>'type'])!!}
                        </div>
                        
                        <div class="input-field col s12 sect-video" style="clear: both; @if($document->type!="2") display:  none; @endif"><br>
                           <label class="active">URL del video<small style="color: #fd2923">*</small></label>                     {!!Form::text('video',$document->video,['class' => 'form-control'])!!}
                        </div>
                        <div class="input-field col s12 sect-image" style="clear: both; @if($document->type!="1") display:  none; @endif" >
                           <input name="archive" id="image" value="{{$document->image}}" type="hidden">
                           <div id="dropzone-thumb" class="dropzone"></div>
                        </div>
                        <br>
                        <div class="col s3 sect-image" ng-repeat="archive in data">
                         <br>
                         <img src="{{url('/')}}/uploads/icons/archive.png" alt="Photo" style="width: 80px">
                         <p>@{{photo.nombre}}</p>
                         <a style="cursor:pointer;font-size: 13px;" ng-click="borrar(photo.nombre)" class="red-text"><i class="fa fa-times red-text"></i> Eliminar</a>
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
   var app = angular.module('myApp', []);
   app.controller('paginas', function($scope, $http) {
     $scope.rows = function() {
       $scope.data = [];
       $http.post("{{url('/')}}/lists-archive-document", {
         'id': <?=$document->id;?>
       })
       .then(function successCallback(response)  {
         $scope.data = response.data;
       });
     }
     $scope.rows();
     $scope.borrar = function(name) {
       swal({
        title: "Confirmá que querés eliminar este registro",
        text: "",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#fd2923',
        confirmButtonText: 'Si eliminá',
        cancelButtonText: 'Cancelar',
        closeOnConfirm: true
      },
      function() {
       var route = "{{url('delete-archive-document')}}";
       var token = $("#token").val();
       var image = $("#image").val();
       var patron = "," + name;
       image = image.replace(patron, '');
       $("#image").val(image);
       $.ajax({
         url: route,
         headers: {
           'X-CSRF-TOKEN': token
         },
         type: 'POST',
         dataType: 'json',
         data: {
           archive: image,
           id: '<?=$document->id;?>'
         },
         success: function() {
          $.growl.error({ title: "<i class='fa fa-exclamation-circle'></i> Atención", message: "Registro eliminado"});
          $scope.rows();
        }
      });
     });
     }
     
   });
   $( "#enviar" ).click(function() {
  $("#enviar").prop('disabled', true);
  $("form").submit();
});
</script>
@stop