@extends('layouts.template')
@section('content')
<div class="content-area">
   <div class="breadcrumb-bar">
      <div class="page-title">
         <h1><i class="ti-user"></i> Mentores</h1>
      </div>
      <ul class="admin-breadcrumb">
         <li><a href="{{url('dashboard')}}" title="Escritorio"><i class="ti-desktop"></i> Escritorio</a></li>
         <li>Mentores</li>
      </ul>
   </div>
   <!-- Breadcrumb Bar -->
   <div class="widgets-wrapper" ng-app="myApp" ng-controller="event">
      {!!Form::model($mentor,['route'=>['mentor.update',$mentor],'method'=>'PUT'])!!}
      <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
      <div class="row">
         <div class="masonary">
            <div class="col s12">
               <div class="col s12">
                  <div class="widget z-depth-1">
                     <div class="widget-title">
                        <h3><i class="ti-pencil"></i> Actualizá la información de tu mentor aquí</h3>
                     </div>
                     <div class="widget-content">
                        <div class="input-field col s12">
                           <label class="active">Seleccione la categoría para su mentor: <small style="color: #fd2923">*</small></label>
                           @foreach($categories as $rs)
                           <div class="demo">
                             <input type="checkbox" id="c-<?php echo $rs->id;?>" name="categories[]" @if(strpos($mentor->categories,",".$rs->id)!== false) checked="checked" @endif value="<?php echo $rs->id;?>">
                              <label for="c-<?php echo $rs->id;?>"><span></span><?php echo $rs->name;?></label>
                           </div>
                           @endforeach
                        </div>
                        <div class="input-field col s12" style="clear: both;"><br>
                           <label class="active">Nombre<small style="color: #fd2923">*</small></label>                     
                            {!!Form::text('name_mentor',$mentor->name,['class' => 'md-input'])!!}
                        </div>
                        <div class="input-field col s12">
                           <label class="active">Resumen en Español<small style="color: #fd2923">*</small> (Máx 400 Caracteres)</label>
                           {!! Form::textarea('content',null,['class' => 'form-control','maxlength'=>'400','cols'=>'3','rows'=>'3']) !!}
                        </div>
                        <div class="input-field col s12">
                           <label class="active">Resumen en Inglés<small style="color: #fd2923">*</small> (Máx 400 Caracteres)</label>
                           {!! Form::textarea('content_en',null,['class' => 'form-control','maxlength'=>'400','cols'=>'3','rows'=>'3']) !!}
                        </div>
                        <div class="input-field col s12">
                           <label class="active"><i class="fa fa-linkedin "></i> Linkedin </label>                     
                           {!!Form::text('linkedin',null,['class' => 'md-input'])!!}
                        </div>
                        <div class="input-field col s12">
                           <label class="active"><i class="fa fa-instagram"></i> Instagram </label>
                           {!!Form::text('instagram',null,['class' => 'md-input'])!!}
                        </div>
                        <div class="input-field col s12">
                           <label style="color: #fd2923!important">Campos requeridos (*)</label><br>
                        </div>
                     </div>
                  </div>
                  <div class="widget z-depth-1">
                     <div class="widget-title">
                        <h3><i class="ti-image"></i> Galería (200px x 200px)</h3>
                     </div>
                     <div class="widget-content">
                        <div class="input-field col s12 sect-image">
                           <p>Imágen</p>
                           <input name="image" id="image" value="{{$mentor->image}}" type="hidden">
                           <div id="dropzone" class="dropzone"></div>
                           <br>
                        <div class="col s3" ng-repeat="photo in data">
                           <br>
                           <img src="<?php echo url('/');?>/images/@{{photo.nombre}}" alt="Photo" style='width: 100%;auto;display: block;padding: 3px;border: 0.5px solid #ddd;'>
                           <a style="cursor:pointer;font-size: 13px;" ng-click="borrar(photo.nombre)" class="red-text"><i class="fa fa-times red-text"></i> Eliminar</a>
                        </div>
                        </div>
                     </div>
                  </div>
                  <div style="width: 100%; text-align: center;"><br><br>
                     <button  class="btn waves-effect waves-light orange" id="enviar"><i class="fa fa-paper-plane" aria-hidden="true"></i> Guardar</button> 
                     <br><br>
                  </div>
               </div>
            </div>
         </div>
         @include('modal.posts') 
      </div>
      {!! Form::close() !!}
   </div>
</div>
<!-- Content Area -->
<script type="text/javascript">
   var app = angular.module('myApp', []);
   app.controller('event', function($scope, $http) {
     $scope.rows = function() {
       $scope.data = [];
       $http.post("{{url('/')}}/lists-photo-mentor", {
         'id': <?=$mentor->id;?>
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
          confirmButtonColor: '#CE0505',
          confirmButtonText: 'Si eliminá',
          cancelButtonText: 'Cancelar',
          closeOnConfirm: true
       },
       function() {
         var route = "{{url('delete-photo-mentor')}}";
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
             id: '<?=$mentor->id;?>'
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