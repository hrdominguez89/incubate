@extends('layouts.template')
@section('content')
<div class="content-area">
   <div class="breadcrumb-bar">
      <div class="page-title">
         <h1><i class="ti-settings"></i> Banner</h1>
      </div>
      <ul class="admin-breadcrumb">
         <li><a href="{{url('dashboard')}}" title="Escritorio"><i class="ti-desktop"></i> Escritorio</a></li>
         <li>Banner</li>
      </ul>
   </div>
   <!-- Breadcrumb Bar -->
   <div class="widgets-wrapper" ng-app="myApp" ng-controller="paginas">
      {!!Form::model($banner,['route'=>['banners.update',$banner],'method'=>'PUT'])!!}
      <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
      <div class="row">
         <div class="masonary">
            <div class="col s12">
               <div class="col s12">
                  <div class="widget z-depth-1">
                     <div class="widget-title">
                        <h3><i class="ti-pencil"></i> Actualizá el contenido de tu banner aquí</h3>
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
                              <div class="input-field col s12">
                                 <label class="active">Subtítulo en Español </label>
                                 {!! Form::textarea('subtitle',null,['class' => 'form-control','id'=>'resume','maxlength'=>'200','cols'=>'2','rows'=>'2']) !!}
                              </div>
                              <div class="input-field col s6" style="clear: both;">
                                 <label class="active">Nombre del Botón en Español </label>                     
                                 {!!Form::text('name_boton',null,['class' => 'form-control'])!!}
                              </div>
                              <div class="input-field col s6">
                                 <label class="active">Url del Botón en Español </label>
                                 {!!Form::text('url_boton',null,['class' => 'form-control'])!!}
                              </div>
                           </div>
                           <div id="img-2" class="tab-pane fade">
                              <div class="input-field col s12" style="clear: both;">
                                 <label class="active">Título en Inglés<small style="color: #fd2923">*</small></label>                     {!!Form::text('title_en',null,['class' => 'form-control'])!!}
                              </div>
                              <div class="input-field col s12">
                                 <label class="active">Subtítulo en Inglés</label>
                                 {!! Form::textarea('subtitle_en',null,['class' => 'form-control','id'=>'resume','maxlength'=>'200','cols'=>'2','rows'=>'2']) !!}
                              </div>
                              <div class="input-field col s6" style="clear: both;">
                                 <label class="active">Nombre del Botón en Inglés </label>                     
                                 {!!Form::text('name_boton_en',null,['class' => 'form-control'])!!}
                              </div>
                              <div class="input-field col s6">
                                 <label class="active">Url del Botón en Inglés </label>
                                 {!!Form::text('url_boton_en',null,['class' => 'form-control'])!!}
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
                        <h3><i class="ti-image"></i> Imagen/ Video</h3>
                     </div>
                     <div class="widget-content">
                        <div class="input-field col s12">
                           <label>Tipo de Banner <small style="color: #fd2923">*</small></label>
                           {!!Form::select('type', ['1'=>'Banner con imágenes','2'=>'Banner con video'], $banner->type,['placeholder' => 'Seleccionar el tipo de banner','class' => 'browser-default','id'=>'type'])!!}
                        </div>

                        
                        <div class="input-field col s12 sect-video" style="clear: both; @if($banner->type=="1") display:  none; @endif"><br>
                           <label class="active">URL del video<small style="color: #fd2923">*</small></label>                     {!!Form::text('video',$banner->video,['class' => 'form-control'])!!}
                        </div>
                        <div class="input-field col s12 sect-image" style="clear: both; @if($banner->type=="2") display:  none; @endif" >
                           <input name="image" id="image" value="{{$banner->image}}" type="hidden">
                           <div id="dropzone-thumb" class="dropzone"></div>
                        </div>
                        <br>
                        <div class="col s3 sect-image" ng-repeat="photo in data" @if($banner->type=="2") style="display:  none;" @endif>
                           <br>
                           <img src="<?php echo url('/');?>/images/@{{photo.nombre}}" alt="Photo" style='height: 120px;width: 100%;auto;display: block;padding: 3px;border: 0.5px solid #ddd;'>
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
       $http.post("{{url('/')}}/lists-photo-banner", {
         'id': <?=$banner->id;?>
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
       var route = "{{url('delete-photo-banner')}}";
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
           image: image,
           id: '<?=$banner->id;?>'
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