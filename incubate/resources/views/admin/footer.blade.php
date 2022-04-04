@extends('layouts.template')
@section('content')
<div class="content-area">
   <div class="breadcrumb-bar">
      <div class="page-title">
         <h1><i class="ti-settings"></i>  Menú Footer</h1>
      </div>
      <ul class="admin-breadcrumb">
         <li><a href="{{url('dashboard')}}" title="Escritorio"><i class="ti-desktop"></i> Escritorio</a></li>
         <li>Menú Footer</li>
      </ul>
   </div>
   <!-- Breadcrumb Bar -->
   <div class="widgets-wrapper" ng-app="myApp" ng-controller="menu">
      <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
      <input type="hidden" name="id" value="" id="id">
      <div class="row">
         <div class="masonary">
            <div class="col s12">
               <div class="col s4">
                  <div class="widget z-depth-1">
                     <div class="widget-title">
                        <h3><i class="ti-pencil"></i> Configurá los elementos en tu menú aquí</h3>
                     </div>
                     <div class="widget-content">
                        <div class="input-field col s12">
                           <label class="active">Url en Español<small style="color: #fd2923">*</small></label>
                           {!!Form::text('url',null,['id'=>'url'])!!}
                        </div>
                        <div class="input-field col s12">
                           <label class="active">Nombre en Español<small style="color: #fd2923">*</small></label>
                           {!!Form::text('title',null,['id'=>'title'])!!}
                        </div>
                        <div class="input-field col s12">
                           <label class="active">Url en Inglés<small style="color: #fd2923">*</small></label>
                           {!!Form::text('url_en',null,['id'=>'url_en'])!!}
                        </div>
                        <div class="input-field col s12">
                           <label class="active">Nombre en Inglés<small style="color: #fd2923">*</small></label>
                           {!!Form::text('title_em',null,['id'=>'title_en'])!!}
                        </div>
                         <div class="input-field col s12">
                        <label style="color: #fd2923!important">Campos requeridos (*)</label><br>
                      </div>
                        <div class="input-field col s12">
                           <button class="btn waves-effect waves-light orange" ng-click="guardarurl()" style="width: 100%"><i class="fa fa-paper-plane" aria-hidden="true"></i> Guardar</button>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col s8">
                  <div class="widget z-depth-1">
                     <div class="widget-title">
                        <h3><i class="ti-layers"></i> Items del menú</h3>
                     </div>
                     <div class="widget-content">
                        <div class="sortable-style">
                           <ul class="exclude list" id="navsm">
                              <li id="item_@{{row.id}}" class="uk-nestable-item" ng-repeat="row in data" style="border: 1px solid #f2f2f2;    border-radius: 0.3rem;">
                                 <div class="col s5">
                                    <p style="font-weight: 300; font-size: 16px; margin-bottom: 0px">@{{ row.title }}</p>
                                 </div>
                                 <div class="col s7">
                                    <span class="controls">
                                    <a class="edituser purple lighten-2" style="cursor:move;    padding: 6px 16px;" ><i class="ti-move"></i> Mover</a>
                                    <a  href="{{url('/')}}/menu-footer/@{{row.id}}/edit"  class="edituser blue" style="    padding: 6px 16px;" ><i class="ti-pencil-alt"></i> Editar</a>
                                   <a  ng-click="desactivar(row.id)"  ng-show="row.status=='1'" class="edituser red" style="    padding: 6px 16px;"> Desactivar</a>
                                    <a  ng-click="activar(row.id)" ng-show="row.status=='2'" class="edituser green" style="    padding: 6px 16px;"> Activar</a>
                                    </span>
                                 </div>
                              </li>
                           </ul>
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
        $("#mask").show();
    var app = angular.module('myApp', []);
app.controller('menu', function($scope, $http, $window) {
    //Listar Menu
    $scope.rows = function() {
        $scope.data = [];
        $http.get("{{url('menu_footer_lists')}}").then(function successCallback(response)  {
            $scope.data = response.data;
                  $("#mask").hide();
        });
    }
    $scope.rows();
    // Guardar urls
    $scope.guardarurl = function() {
        var title = $("#title").val();
        var url = $("#url").val();
        var title_en = $("#title_en").val();
        var url_en = $("#url_en").val();
        var token = $("#token").val();
        var route = "{{url('/')}}/menu-footer";
        //validar que titulo Not este vacio
        if (url == "") {
            $.growl.error({
                title: "<i class='fa fa-exclamation-circle'></i> Atención",
                message: "Ingresá el url en español"
            });
            $('#url').focus();
            return (false);
        } else if (title == "") {
            $.growl.error({
                title: "<i class='fa fa-exclamation-circle'></i> Atención",
                message: "Ingresá el nombre en español"
            });
            $('#title').focus();
            return (false);
        }
        if (url_en == "") {
            $.growl.error({
                title: "<i class='fa fa-exclamation-circle'></i> Atención",
                message: "Ingresá el url en inglés"
            });
            $('#url_en').focus();
            return (false);
        } else if (title_en == "") {
            $.growl.error({
                title: "<i class='fa fa-exclamation-circle'></i> Atención",
                message: "Ingresá el nombre en inglés"
            });
            $('#title_en').focus();
            return (false);
        } else {
            //Enviar Datos
            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'POST',
                dataType: 'json',
                data: {
                    title: title,
                    url: url,
                    title_en: title_en,
                    url_en: url_en,
                    type: '2'
                },
                success: function(data) {
                    $("#title").val('');
                    $("#url").val('');
                    $("#title_en").val('');
                    $("#url_en").val('');
                    $.growl.notice({
                        title: "<i class='fa fa-exclamation-circle'></i> Atención",
                        message: "Registro exitoso"
                    });
                    $scope.rows();
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
    //Boorar Item Menu
    $scope.desactivar = function(id) {
        swal({
                title: "Confirmá que querés desactivar este item del menú",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#CE0505',
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
                closeOnConfirm: true,
            },
            function() {
                //Obtener Datos
                var route = "{{url('up-status-footer')}}";
                var token = $("#token").val();
                $.ajax({
                    url: route,
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        status: '2',
                        id: id
                    },
                    success: function() {
                        $.growl.error({
                            title: "<i class='fa fa-exclamation-circle'></i> Atención",
                            message: "El estatus del item ha sido actualizado"
                        });
                        $scope.rows();
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
    $scope.activar = function(id) {
        swal({
                title: "Confirmá que querés activar este item del menú",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#CE0505',
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
                closeOnConfirm: true,
            },
            function() {
                //Obtener Datos
                var route = "{{url('up-status-footer')}}";
                var token = $("#token").val();
                $.ajax({
                    url: route,
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        status: '1',
                        id: id
                    },
                    success: function() {
                        $.growl.warning({
                            title: "<i class='fa fa-exclamation-circle'></i> Atención",
                            message: "El estatus del item ha sido actualizado"
                        });
                        $scope.rows();
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
});
$('#navsm').sortable({
    revert: true,
    opaitem: 0.6,
    cursor: 'move',
    update: function() {
        var order = $('#navsm').sortable("serialize") + '&action=orderState';
        $.post("{{url('move-menu-footer')}}", order, function(theResponse) {
            window.location.reload();
        });
    }
});
</script>
@stop