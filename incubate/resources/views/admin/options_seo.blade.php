@extends('layouts.template')
@section('content')
<div class="content-area">
   <div class="breadcrumb-bar">
      <div class="page-title">
         <h1><i class="ti-setings"></i> Actualizá SEO</h1>
      </div>
      <ul class="admin-breadcrumb">
         <li><a href="{{url('dashboard')}}" title="Escritorio"><i class="ti-desktop"></i> Escritorio</a></li>
         <li>SEO</li>
      </ul>
   </div>
   <!-- Breadcrumb Bar -->
   <div class="widgets-wrapper" ng-app="myApp"  ng-controller="opciones">
      <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
      <div class="row">
         <div class="masonary">
            <div class="col s12">
               <div class="col s12">
                  <div class="widget z-depth-1">
                     <div class="widget-title">
                        <h3><i class="ti-pencil"></i> Actualizá SEO</h3>
                     </div>
                     <div class="widget-content">
                        <?php $site = DB::table('site')->where('id', '1')->first();  ?> 
                        <ul class="nav nav-tabs">
                           <li  class="active"><a data-toggle="tab" href="#img-1"><img src="{{url('/')}}/uploads/backend/es.png" style="width:25px;float:none" /> Español</a></li>
                           <li><a data-toggle="tab" href="#img-2"><img src="{{url('/')}}/uploads/backend/en.png" style="width:25px;float:none" /> Inglés</a></li>
                        </ul>
                        <div class="tab-content">
                           <div id="img-1" class="tab-pane fade in active">
                               <div class="input-field col s12">
                                 <label class="active">Descripcion en Español<small style="color: #fd2923">*</small></label> 
                                 <textarea class="form-control" style="height: 100px"name="description" id="description" >{{$site->description}}</textarea>   
                              </div>
                               <div class="input-field col s12">
                                 <label class="active">Keywords en Español<small style="color: #fd2923">*</small></label> 
                                 <textarea class="form-control" style="height: 100px"name="keywords" id="keywords" >{{$site->keywords}}</textarea>  
                              </div>
                           </div>
                           <div id="img-2" class="tab-pane fade">
                               <div class="input-field col s12">
                                 <label class="active">Descripcion en Inglés<small style="color: #fd2923">*</small></label> 
                                 <textarea class="form-control" style="height: 100px" name="description_en" id="description_en" >{{$site->description_en}}</textarea>   
                              </div>
                               <div class="input-field col s12">
                                 <label class="active">Keywords en Inglés<small style="color: #fd2923">*</small></label> 
                                 <textarea class="form-control" style="height: 100px"name="keywords_en" id="keywords_en" >{{$site->keywords_en}}</textarea>  
                              </div>
                           </div>
                        </div>
                        
                         <div class="input-field col s12">
                           <label style="color: #fd2923!important">Campos requeridos (*)</label><br>
                        </div>
                         <div class="input-field col s12">
                           <a class="btn waves-effect waves-light orange" ng-click="updateseo()"><i class="fa fa-paper-plane" aria-hidden="true"></i> Guardar</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Content Area -->
<script type="text/javascript">
   var app = angular.module('myApp', []);
   app.controller('opciones', function($scope, $http, $window) {
      //Update Email 
      $scope.updateseo = function() {
         //Validar Descrpcion
         if ($('#description').val() == "") {
            $.growl.error({ title: "<i class='fa fa-exclamation-circle'></i> Atención", message: "Ingresá la  descripción en español"});
            $('#description').focus();
            return (false);
         }
         // validar keywords
         else if ($('#keywords').val() == "") {
            $.growl.error({ title: "<i class='fa fa-exclamation-circle'></i> Atención", message: "Ingresá el keywords en español"});
            $('#keywords').focus();
            return (false);
         }
         if ($('#description_en').val() == "") {
            $.growl.error({ title: "<i class='fa fa-exclamation-circle'></i> Atención", message: "Ingresá la  descripción en inglés"});
            $('#description_en').focus();
            return (false);
         }
         // validar keywords
         else if ($('#keywords_en').val() == "") {
            $.growl.error({ title: "<i class='fa fa-exclamation-circle'></i> Atención", message: "Ingresá el keywords en inglés"});
            $('#keywords_en').focus();
            return (false);
         }
         
         else {
            //Obtener Datos de los Campos
            var description = $('#description').val();
            var keywords = $('#keywords').val();
            var description_en = $('#description_en').val();
            var keywords_en = $('#keywords_en').val();
            var route = "{{url('update_options')}}";
            var token = $("#token").val();
            //Enviar Datos
            $.ajax({
               url: route,
               headers: {
                  'X-CSRF-TOKEN': token
               },
               type: 'POST',
               dataType: 'json',
               data: {
                  description: description,
                  keywords: keywords,
                  description_en: description_en,
                  keywords_en: keywords_en,
                  type: 'seo'
               },
               success: function(data) {
                 $.growl.warning({ title: "<i class='fa fa-exclamation-circle'></i> Atención", message:"Datos Actualizados"});
                 location.reload();
               },
                error: function(msj) {
                    $.growl.error({
                        title: "<i class='fa fa-exclamation-circle'></i> Error",
                        message: 'Ha ocurrido un error por favor intentá más tarde'
                    });
                }
            });
         }
      }
   });
</script>
@stop