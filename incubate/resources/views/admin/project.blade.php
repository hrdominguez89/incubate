@extends('layouts.template')
@section('content')
<div class="content-area">
   <div class="breadcrumb-bar">
      <div class="page-title">
         <h1><i class="ti-briefcase"></i> Proyectos</h1>
      </div>
      <ul class="admin-breadcrumb">
         <li><a href="{{url('dashboard')}}" title="Escritorio"><i class="ti-desktop"></i> Escritorio</a></li>
         <li>Proyectos</li>
      </ul>
   </div>
   <!-- Breadcrumb Bar -->
     <div class="widgets-wrapper" ng-app="myApp" ng-controller="project">
      {!! Form::open(['route' => 'project.store','method' => 'POST']) !!}
      <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
      <div class="row">
         <div class="masonary">
            <div class="col s12">
               <div class="col s12">
                  <div class="widget z-depth-1">
                     <div class="widget-title">
                        <h3><i class="ti-pencil"></i> Ingresá el contenido de tu proyecto aquí</h3>
                     </div>
                     <div class="widget-content">

                        <div class="input-field col s12">
                           <label class="active">Seleccione la categoría para su proyecto: <small style="color: #fd2923">*</small></label>
                           @foreach($categories as $rs)
                           <div class="demo">
                              <input type="checkbox" id="c-<?php echo $rs->id;?>" name="categories[]" value="<?php echo $rs->id;?>">
                              <label for="c-<?php echo $rs->id;?>"><span></span><?php echo $rs->name;?></label>
                           </div>
                           @endforeach
                        </div>


                        <ul class="nav nav-tabs">
                           <li  class="active"><a data-toggle="tab" href="#img-1"><img src="{{url('/')}}/uploads/backend/es.png" style="width:25px;float:none" /> Español</a></li>
                           <li><a data-toggle="tab" href="#img-2"><img src="{{url('/')}}/uploads/backend/en.png" style="width:25px;float:none" /> Inglés</a></li>
                        </ul>
                        <div class="tab-content">
                           <div id="img-1" class="tab-pane fade in active">
                              <div class="input-field col s12" style="clear: both;"><br>
                                 <label class="active">Título en Español<small style="color: #fd2923">*</small></label>                     {!!Form::text('title',null,['class' => 'md-input'])!!}
                              </div>
                              <div class="input-field col s12">
                                 <label class="active">Resumen en Español<small style="color: #fd2923">*</small> (Máx 200 Caracteres)</label>
                                 {!! Form::textarea('resume',null,['id'=>'resume','maxlength'=>'200','cols'=>'2','rows'=>'2','class'=>'form-control']) !!}
                              </div>
                              <div class="input-field col s12">
                                 <label>Descripción en Español<small style="color: #fd2923">*</small><br></label> 
                                 <br>
                              </div>
                              <div class="input-field col s12"> 
                                 {!! Form::textarea('content',null,['class'=>"materialize-textarea",'cols'=>'5','rows'=>'5','id'=>'editor1']) !!}
                              </div>
                           </div>
                           <div id="img-2" class="tab-pane fade">
                              <div class="input-field col s12" style="clear: both;"><br>
                                 <label class="active">Título en Inglés<small style="color: #fd2923">*</small></label>                     {!!Form::text('title_en',null,['class' => 'md-input'])!!}
                              </div>
                              <div class="input-field col s12">
                                 <label class="active">Resumen en Inglés<small style="color: #fd2923">*</small> (Máx 200 Caracteres)</label>
                                 {!! Form::textarea('resume_en',null,['id'=>'resume','maxlength'=>'200','cols'=>'2','rows'=>'2','class'=>'form-control']) !!}
                              </div>
                              <div class="input-field col s12">
                                 <label>Descripción en Inglés<small style="color: #fd2923">*</small><br></label> 
                                 <br>
                              </div>
                              <div class="input-field col s12"> 
                                 {!! Form::textarea('content_en',null,['class'=>"materialize-textarea",'cols'=>'5','rows'=>'5','id'=>'editor2']) !!}
                              </div>
                           </div>
                        </div>
                        <div class="input-field col s6">
                           <label class="active"><i class="ti-user"></i> Mentor </label>                     {!!Form::text('mentor',null,['class' => 'md-input'])!!}
                        </div>
                        <div class="input-field col s6">
                           <label class="active"><i class="ti-word"></i> Sitio Web </label>                     {!!Form::text('website',null,['class' => 'md-input'])!!}
                        </div>
                        <div class="input-field col s6">
                           <label class="active"><i class="fa fa-enveloper-o"></i> Email </label>                     {!!Form::text('email',null,['class' => 'md-input'])!!}
                        </div>
                        <div class="input-field col s12">
                           <hr>
                           <p>Ingresá  aqui las url de las redes sociales de tu proyecto:</p>
                        </div>
                        <div class="input-field col s3" style="clear: both;">
                           <label class="active"><i class="fa fa-linkedin "></i> Linkedin </label>                     {!!Form::text('linkedin',null,['class' => 'md-input'])!!}
                        </div>
                        <div class="input-field col s3">
                           <label class="active"><i class="fa fa-facebook "></i> Facebook </label>                     {!!Form::text('facebook',null,['class' => 'md-input'])!!}
                        </div>
                        <div class="input-field col s3">
                           <label class="active"><i class="fa fa-twitter"></i> Twitter </label>                     {!!Form::text('twitter',null,['class' => 'md-input'])!!}
                        </div>
                        <div class="input-field col s3">
                           <label class="active"><i class="fa fa-flickr"></i> Flickr </label>                     {!!Form::text('flickr',null,['class' => 'md-input'])!!}
                        </div>
                        <div class="input-field col s3">
                           <label class="active"><i class="fa fa-youtube"></i> Youtube </label>                     {!!Form::text('youtube',null,['class' => 'md-input'])!!}
                        </div>
                        <div class="input-field col s3">
                           <label class="active"><i class="fa fa-instagram"></i> Instagram </label>                     {!!Form::text('instagram',null,['class' => 'md-input'])!!}
                        </div>
                        
                        <div class="input-field col s12" style="clear: both;">
                           <label style="color: #fd2923!important">Campos requeridos (*)</label><br>
                        </div>
                     </div>
                  </div>
                  <div class="widget z-depth-1">
                     <div class="widget-title">
                        <h3><i class="ti-image"></i> Galería</h3>
                     </div>
                     <div class="widget-content">
                        <div class="input-field col s12 sect-video" style="clear: both;"><br>
                           <label class="active">URL del video</label>                     
                           {!!Form::text('video',null,['class' => 'form-control'])!!}
                        </div>
                        <div class="input-field col s12 sect-image">
                           <p>Imágenes (740px x 480px)</p>
                           <input name="image" id="image" value="" type="hidden">
                           <div id="dropzone-thumb" class="dropzone"></div>
                        </div>
                     </div>
                  </div>
                  <div class="widget z-depth-1">
                     <div class="widget-title">
                        <h3><i class="ti-clip"></i> Archivo adjunto</h3>
                     </div>
                     <div class="input-field col s12 text-right">
                        <span class="controls" style="clear: both;">
                        <a class="edituser blue"  ng-click="openModal()" style="padding: 8px;"><i class="fa fa-plus"></i>  Agregá nuevo archivo</a>
                        </span>
                     </div>
                     <div class="col-md-12" ng-show="totalItemsArchives!=0">
                        <br>
                        <div class="projects-table">
                           <table width="100%" class="table">
                              <thead>
                                 <tr>
                                    <th style="width: 35%">Archivo</th>
                                    <th style="width: 10%">Tamaño</th>
                                    <th style="width: 35%">Descargar</th>
                                    <th style="width: 20%"></th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <tr ng-repeat="row in list_archives">
                                    <td style="vertical-align: middle;">
                                       @{{row.name}}
                                    </td>
                                    <td style="vertical-align: middle; text-transform: uppercase;">
                                       @{{row.file_size}}
                                    </td>
                                    <td style="vertical-align: middle;">
                                       <a href="<?php echo url('/');?>/descargar/@{{row.archive}}" target="_blank">@{{row.archive}}</a>
                                    </td>
                                    <td style="vertical-align: middle;">
                                       <span class="controls">
                                       <a ng-click="asignarValorArchive(row.id, row.name, row.name_en, row.file_size, row.archive)" class="edituser blue" style="padding: 6px;
                                          font-size: 9px;"><i class="ti-pencil-alt"></i> Editar</a>
                                       <a  ng-click="borrar_archive(row.id);" class="deleteuser red" style="padding: 6px;
                                          font-size: 9px;"><i class="ti-trash"></i> Eliminar</a>
                                       </span>
                                    </td>
                                 </tr>
                              </tbody>
                           </table>
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
         @include('modal.posts') 
      </div>
      {!! Form::close() !!}
   </div>
</div>
<!-- Content Area -->
<script type="text/javascript">
   var app = angular.module('myApp', ['ui.bootstrap']);
app.controller('project', function($scope, $http, $window) {
    $scope.titulo = "Nuevo Archivo";
    $scope.btn = "Guardar";
    $scope.name_file='';
    $scope.rows_archives = function() {
        $http.get('<?php echo url('/');?>/projects_archives_lists/0').then(function successCallback(response) {
            $scope.list_archives = response.data;
            $scope.totalItemsArchives = $scope.list_archives.length;
        });
    }
    $scope.rows_archives();
    $scope.guardar = function() {
        var id = $("#id").val();
        var name = $('#name').val();
        var name_en = $('#name_en').val();
        var archive = $("#archive").val();
        var file_size = $("#file_size").val();
        if (name == "") {
            $.growl.error({
                title: "<i class='fa fa-exclamation-circle'></i> Atención",
                message: "Ingresá el nombre en español"
            });
            $('#name').focus();
            return (false);
        } else if (name_en == "") {
            $.growl.error({
                title: "<i class='fa fa-exclamation-circle'></i> Atención",
                message: "Ingresá el nombre en inglés"
            });
            $('#name_en').focus();
            return (false);
        } else if (archive == "") {
            $.growl.error({
                title: "<i class='fa fa-exclamation-circle'></i> Atención",
                message: "Ingresá un archivo"
            });
            return (false);
        } else {
            if (id == "") {
                $.ajax({
                    url: "<?php echo url('projects-archives');?>",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        name: name,
                        name_en: name_en,
                        file_size: file_size,
                        archive: archive,
                        project:'0'
                    },
                    success: function(data) {
                        $("#name").val('');
                        $("#name_en").val('');
                        $("#id").val('');
                        $("#archive").val('');
                        $("#file_size").val('');
                        $.growl.notice({
                            title: "<i class='fa fa-exclamation-circle'></i> Atención",
                            message: "Registro exitoso"
                        });
                        $('#docs-modal').modal('close');
                        $scope.rows_archives();
                    },
                    error: function(msj) {
                        $.growl.error({
                            title: "<i class='fa fa-exclamation-circle'></i> Atención",
                            message: "" + msj.responseJSON.name + ""
                        });
                    }
                });
            } else {
                $.ajax({
                    url: "<?php echo url('/');?>/projects-archives/" + id + "",
                    type: 'PUT',
                    dataType: 'json',
                    data: {
                        name: name,
                        name_en: name_en,
                        file_size: file_size,
                        archive: archive,
                        project:'0'
                    },
                    success: function(data) {
                        $("#name").val('');
                        $("#name_en").val('');
                        $("#id").val('');
                        $("#archive").val('');
                        $("#file_size").val('');
                        $.growl.warning({
                            title: "<i class='fa fa-exclamation-circle'></i> Atención",
                            message: "Datos Actualizados"
                        });
                        $('#docs-modal').modal('close');
                        $scope.rows_archives();
                        $scope.titulo = "Nuevo Archivo";
                        $scope.btn = "Guardar";
                    },
                    error: function(msj) {
                        $.growl.error({
                            title: "<i class='fa fa-exclamation-circle'></i> Atención",
                            message: "" + msj.responseJSON.name + ""
                        });
                    }
                });
            }
        }
    }
    $scope.borrar_archive = function(id) {
        swal({
                title: "Confirmá que querés eliminar este registro",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#fd2923',
                confirmButtonText: 'Si eliminá',
                cancelButtonText: 'Cancelar',
                closeOnConfirm: true,
            },
            function() {
                // Url 
                var route = "<?php echo url('/');?>/projects-archives/" + id + "";
                var token = $("#token").val();
                //Enviar Datos
                $.ajax({
                    url: route,
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    type: 'DELETE',
                    dataType: 'json',
                    success: function() {
                        $.growl.error({
                            title: "<i class='fa fa-exclamation-circle'></i> Atención",
                            message: "Registro eliminado"
                        });
                        $scope.rows_archives();
                    },
                    error: function(msj) {
                        $.growl.error({
                            title: "<i class='fa fa-exclamation-circle'></i> Error",
                            message: 'Ha ocurrido un error por favor intentá más tarde'
                        });
                    }
                });
            });
    }
    $scope.openModal= function(){
      var Dropzone1 = Dropzone.forElement("#dropzone-doc");
      Dropzone1.removeAllFiles(true);
      $("#name").val('');
      $("#name_en").val('');
      $("#id").val('');
      $("#archive").val('');
      $("#file_size").val('');
      $scope.name_file='';
      $('#docs-modal').modal('open');

   }
    $scope.closeModal= function(){

      $("#name").val('');
      $("#name_en").val('');
      $("#id").val('');
      $("#archive").val('');
      $("#file_size").val('');
      $scope.name_file='';
      $('#docs-modal').modal('close');

   }
    $scope.asignarValorArchive = function(id, name, name_en, file_size, archive) {
        $("#id").val(id);
        $("#name").val(name);
        $("#name_en").val(name_en);
        $("#file_size").val(file_size);
        $("#archive").val(archive);
        $scope.titulo = "Actualizá tu archivo";
        $scope.btn = "Guardar";
        $scope.name_file=archive;
         var Dropzone1 = Dropzone.forElement("#dropzone-doc");
      Dropzone1.removeAllFiles(true);
      $('#docs-modal').modal('open');
    }
}); 
$( "#enviar" ).click(function() {
  $("#enviar").prop('disabled', true);
  $("form").submit();
});
</script>
@stop