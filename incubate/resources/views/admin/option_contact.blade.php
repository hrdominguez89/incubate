@extends('layouts.template')
@section('content')
<div class="content-area">
   <div class="breadcrumb-bar">
      <div class="page-title">
         <h1><i class="ti-settings"></i> Información de Contacto</h1>
      </div>
      <ul class="admin-breadcrumb">
         <li><a href="{{url('dashboard')}}" title="Escritorio"><i class="ti-desktop"></i> Escritorio</a></li>
         <li>Información de Contacto</li>
      </ul>
   </div>
   <!-- Breadcrumb Bar -->
   <div class="widgets-wrapper" ng-app="myApp"  ng-controller="opciones">
      <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
      <div class="row">
         <div class="masonary">
            <div class="col s12">
               <div class="col s12">
                  <div class="col s6">
                     <div class="widget z-depth-1">
                        <div class="widget-title">
                           <h3><i class="ti-pencil"></i> Actualizá aquí tu información de contacto </h3>
                        </div>
                        <div class="widget-content">
                           <?php $site = DB::table('site')->where('id', '1')->first();  ?> 
                           
                           <div class="input-field col s12">
                              <label class="active"><i class="fa fa-envelope-o"></i> Correo electrónico <small style="color: #fd2923">*</small></label>
                              <input  type="text" id="email" value="{{$site->email}}" >
                           </div>
                          
                           <div class="input-field col s12">
                              <label class="active"><i class="fa fa-phone"></i> Emergencias </label>
                              <input  type="text" id="phone_emergencia" value="{{$site->phone_emergencia}}" >
                           </div>
                           <div class="input-field col s12">
                              <label class="active"><i class="fa fa-phone"></i> SAME </label>
                              <input  type="text" id="phone_same" value="{{$site->phone_same}}" >
                           </div>
                           <div class="input-field col s12">
                              <label class="active"><i class="fa fa-phone"></i> Línea Social</label>
                              <input  type="text" id="phone_social" value="{{$site->phone_social}}" >
                           </div>
                           <div class="input-field col s12">
                              <label class="active"><i class="fa fa-phone"></i> Atención Ciudadana</label>
                              <input  type="text" id="phone_ciudadano" value="{{$site->phone_ciudadano}}" >
                           </div>
                           <div class="input-field col s12">
                              <label style="color: #fd2923!important">Campos requeridos (*)</label><br>
                           </div>
                           <div class="input-field col s12">
                              <a class="btn waves-effect waves-light orange" ng-click="updatecontact()"><i class="fa fa-paper-plane" aria-hidden="true"></i> Guardar</a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col s6">
                     <div class="widget z-depth-1">
                        <div class="widget-title">
                           <h3><i class="ti-pencil"></i> Actualizá aquí tus redes sociales</h3>
                        </div>
                        <div class="widget-content">
                           <?php $site = DB::table('site')->where('id', '1')->first();  ?> 
                           <div class="input-field col s12">
                              <label class="active"><i class="fa fa-facebook "></i> Facebook </label>
                              <input name="facebook" type="text" id="facebook" value="{{$site->facebook}}" >
                           </div>
                           <div class="input-field col s12">
                              <label class="active"><i class="fa fa-twitter "></i> Twitter </label>
                              <input name="twitter" type="text" id="twitter" value="{{$site->twitter}}" >
                           </div>
                           <div class="input-field col s12">
                              <label class="active"><i class="fa fa-youtube "></i> Youtube </label>
                              <input name="youtube" type="text" id="youtube" value="{{$site->youtube}}" >
                           </div>
                           <div class="input-field col s12">
                              <label class="active"><i class="fa fa-instagram "></i> Instagram </label>
                              <input name="instagram" type="text" id="instagram" value="{{$site->instagram}}" >
                           </div>
                           <div class="input-field col s12">
                              <a class="btn waves-effect waves-light orange" ng-click="updatesocial()"><i class="fa fa-paper-plane" aria-hidden="true"></i> Guardar</a>
                           </div>
                        </div>
                     </div>
                     <!--<div class="widget z-depth-1">
                        <div class="widget-title">
                           <h3><i class="ti-pencil"></i> Actualizá aquí su configuración de mailchimp</h3>
                        </div>
                        <div class="widget-content">
                           <?php $site = DB::table('site')->where('id', '1')->first();  ?> 
                           <div class="input-field col s12">
                              <label class="active">Api Key <small style="color: #fd2923">*</small></label>
                              <input  type="text" id="api_key" value="{{$site->api_key}}" >
                           </div>
                           <div class="input-field col s12">
                              <label class="active">ID lista <small style="color: #fd2923">*</small></label>
                              <input  type="text" id="list_mailchimp" value="{{$site->list_mailchimp}}" >
                           </div>
                           <div class="input-field col s12">
                              <label style="color: #fd2923!important">Campos requeridos (*)</label><br>
                           </div>
                           <div class="input-field col s12">
                              <a class="btn orange " ng-click="updatemailchimp()"><i class="fa fa-paper-plane" aria-hidden="true"></i> Guardar</a>
                           </div>
                        </div>
                     </div>--->
                  </div>
                  
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
</div>
<script type="text/javascript">
   var app = angular.module('myApp', []);
   app.controller('opciones', function($scope, $http, $window) {
    
    $scope.updatesocial = function() {
           //Validar facebook
           
              //Obtener Datos 
              var facebook = $("#facebook").val();
              var twitter = $("#twitter").val();
              var instagram = $("#instagram").val();
              var youtube =$("#youtube").val();
              var route ="{{url('update_options')}}";
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
                facebook: facebook,
                instagram: instagram,
                youtube: youtube,
                twitter: twitter,
                type: 'network'
              },
              success: function(data) {
                $.growl.warning({
                  title: "<i class='fa fa-exclamation-circle'></i> Atención",
                  message: "Datos Actualizados"
                });
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
            
            
            $scope.updatecontact = function() {
             
              if ($('#email').val() == "") {
                $.growl.error({
                  title: "<i class='fa fa-exclamation-circle'></i> Error",
                  message: "Ingresá el correo electrónico"
                });
                $('#email').focus();
                return (false);
              }else if ($('#address').val() == "") {
                $.growl.error({
                  title: "<i class='fa fa-exclamation-circle'></i> Error",
                  message: "Ingresá la dirección"
                });
                $('#address').focus();
                return (false);
              } else {
              //Obtener Datos
              var email = $('#email').val();
              var phone_emergencia = $('#phone_emergencia').val();
              var phone_same = $('#phone_same').val();
              var phone_social = $('#phone_social').val();
              var phone_ciudadano = $('#phone_ciudadano').val();
              var route = "{{url('update_options')}}";
              var token = $("#token").val();
              $.ajax({
                url: route,
                headers: {
                  'X-CSRF-TOKEN': token
                },
                type: 'POST',
                dataType: 'json',
                data: {
                  email: email,
                  phone_ciudadano: phone_ciudadano,
                  phone_social: phone_social,
                  phone_same: phone_same,
                  phone_emergencia: phone_emergencia,
                  type: 'contact'
                },
                success: function(data) {
                  $.growl.warning({
                    title: "<i class='fa fa-exclamation-circle'></i> Atención",
                    message: "Datos Actualizados"
                  });
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
          $scope.updatemailchimp = function() {
          //validar que el nombre este lleno
          if ($('#api_key').val() == "") {
            $.growl.error({
              title: "<i class='fa fa-exclamation-circle'></i> Atención",
              message: "Ingresá el api key"
            });
            $('#api_key').focus();
            return (false);
          }else if ($('#list_mailchimp').val() == "") {
            $.growl.error({
              title: "<i class='fa fa-exclamation-circle'></i> Atención",
              message: "Ingresá el id de tu lista"
            });
            $('#list_mailchimp').focus();
            return (false);
          } else {
              //Obtener Datos
              var api_key = $('#api_key').val();
              var list_mailchimp = $('#list_mailchimp').val();
              var route = "{{url('update_options')}}";
              var token = $("#token").val();
              $.ajax({
                url: route,
                headers: {
                  'X-CSRF-TOKEN': token
                },
                type: 'POST',
                dataType: 'json',
                data: {
                  api_key: api_key,
                  list_mailchimp: list_mailchimp,
                  type: 'mailchimp'
                },
                success: function(data) {
                  $.growl.warning({
                    title: "<i class='fa fa-exclamation-circle'></i> Atención",
                    message: "Datos Actualizados"
                  });
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