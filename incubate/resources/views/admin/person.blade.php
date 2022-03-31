@extends('layouts.template')
@section('content')
<div class="content-area">
   <div class="breadcrumb-bar">
      <div class="page-title">
         <h1><i class="ti-briefcase"></i> Tipo de personas</h1>
      </div>
      <ul class="admin-breadcrumb">
         <li><a href="{{url('dashboard')}}" title="Escritorio"><i class="ti-desktop"></i> Escritorio</a></li>
         <li>Tipo de personas</li>
      </ul>
   </div>
   <!-- Breadcrumb Bar -->
   <div class="widgets-wrapper" ng-app="myApp" ng-controller="species">
      <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
      <input type="hidden" name="id" value="" id="id">
      <div class="row">
         <div class="masonary">
            <div class="col s12">
               <div class="col s4">
                  <div class="widget z-depth-1">
                     <div class="loader"></div>
                     <div class="widget-title">
                        <h3><i class="ti-pencil"></i>  @{{titulo}}</h3>
                     </div>
                     <div class="widget-content">
                      <div class="input-field">
                        <label>Nombre en Español<small style="color: #fd2923">*</small></label>
                        {!!Form::text('name',null,['id'=>'name'])!!}
                        <span class="md-input-bar "></span>
                      </div>
                      <div class="input-field">
                        <label>Nombre en Inglés<small style="color: #fd2923">*</small></label>
                        {!!Form::text('name_en',null,['id'=>'name_en'])!!}
                        <span class="md-input-bar "></span>
                      </div>
                      <div class="input-field">
                        <label style="color: #fd2923!important">Campos requeridos (*)</label><br>
                      </div>
                        <div class="input-field">
                           <button class="btn waves-effect waves-light orange " ng-click="guardar()" style="width: 100%"><i class="fa fa-paper-plane" aria-hidden="true"></i>  @{{btn}}</button>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col s8">
                  <div class="widget z-depth-1">
                     <div class="loader"></div>
                     <div class="widget-title">
                        <h3>Tipo de personas</h3>
                     </div>
                     <div class="widget-content">
                        <div class="projects-table">
                           <table width="100%" class="table">
                              <thead>
                                 <tr>
                                  <th></th>
                                   <th>
                                      <div class="text-center">#</div>
                                   </th>
                                   <th>
                                      <div class="text-center">Nombre</div>
                                   </th>
                                    <th>
                                       <div class="text-center">Registro</div>
                                    </th>
                                    <th></th>
                                 </tr>
                              </thead>
                              <tbody id="navsm">
                                 <tr ng-repeat="row in filtered = (list | filter:search | orderBy : predicate :reverse) | startFrom:(currentPage-1)*entryLimit | limitTo:entryLimit"  id="item_@{{row.id}}">
                                    <td  class="text-center" style="vertical-align: middle;"> <i class="fa fa-arrows" aria-hidden="true"></i></td>
                                    <td  class="text-center" style="vertical-align: middle;"> @{{$index+1}}</td>
                                    <td  class="text-center" style="vertical-align: middle;" > @{{row.name_res}} </td>
                                    <td  class="text-center" style="vertical-align: middle;">  @{{row.created_at | date : MM/dd/yyyy }} </td>
                                    <td  class="text-center" style="vertical-align: middle;">
                                       <span class="controls">
                                       <a ng-click="asignarValor(row.id,row.name,row.name_en)"  title="Edit" class="edituser blue"><i class="ti-pencil-alt"></i> Editar </a>
                                       <a  ng-click="borrar(row.id);" class="deleteuser red"><i class="ti-trash"></i> Eliminar</a>
                                       </span>
                                    </td>
                                 </tr>
                                 <tr ng-show="filteredItems == 0" >
                                    <td colspan="5">
                                       <p class="text-italic"><i class="ti-info-alt"></i> No hay resultados para mostrar</p>
                                    </td>
                                 </tr>
                              </tbody>
                           </table>
                        </div>
                        <ul class="pagination" class="col-md-12" ng-show="filteredItems > 0">
                           <li  pagination="" page="currentPage" on-select-page="setPage(page)"  total-items="filteredItems" items-per-page="entryLimit" class="page-item" previous-text="&laquo;" next-text="&raquo;"></li>
                        </ul>
                         <p ng-show="filteredItems != 0" ><br>@{{totalItems}} Registro(s) encontrado(s)</p>
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
  var app = angular.module('myApp', ['ui.bootstrap']);
  app.filter('startFrom', function() {
    return function(input, start) {
      if (input) {
        start = +start;
        return input.slice(start);
      }
      return [];
    }
  });
  app.controller('species', function($scope, $http, $window) {
    $scope.titulo = "Nuevo tipo de persona";
    $scope.btn = "Guardar";
    $scope.rows = function() {
      $http.get('{{url("persons_lists")}}').then(function successCallback(response)   {
        $scope.list = response.data;
        $scope.currentPage = 1;
        $scope.entryLimit = 100;
        $scope.filteredItems = $scope.list.length;
        $scope.totalItems = $scope.list.length;
              $("#mask").hide();
      });
    }
    $scope.rows();
    $scope.setPage = function(pageNo) {
      $scope.currentPage = pageNo;
    };
    $scope.filter = function() {
      $scope.filteredItems = $scope.filtered.length;
      $scope.totalItems = $scope.filtered.length
    };
    $scope.sort_by = function(predicate) {
      $scope.predicate = predicate;
      $scope.reverse = !$scope.reverse;
    };
    $scope.guardar = function() {
      var id = $("#id").val();
      var name = $('#name').val();
      var name_en = $('#name_en').val();
      var token = $("#token").val();
      if (name == "") {
        $.growl.error({ title: "<i class='fa fa-exclamation-circle'></i> Atención", message: "Ingresá el nombre en español"});
        $('#name').focus();
        return (false);
      }
      else if (name_en == "") {
        $.growl.error({ title: "<i class='fa fa-exclamation-circle'></i> Atención", message: "Ingresá el nombre en inglés"});
        $('#name_en').focus();
        return (false);
      } else {
        if (id == "") {
          $.ajax({
            url: "{{url('persons')}}",
            headers: {
              'X-CSRF-TOKEN': token
            },
            type: 'POST',
            dataType: 'json',
            data: {
              name: name,
              name_en: name_en
            },
            success: function(data) {
              $("#name").val('');
              $("#name_en").val('');
                $.growl.notice({ title: "<i class='fa fa-exclamation-circle'></i> Atención", message:"Registro exitoso"});
              $scope.rows();
            },
            error: function(msj) {
              $.growl.error({ title: "<i class='fa fa-exclamation-circle'></i> Atención", message: ""+msj.responseJSON.name+""});
            }
          });
        } else {
          $.ajax({
            url: "{{url('/')}}/persons/" + id + "",
            headers: {
              'X-CSRF-TOKEN': token
            },
            type: 'PUT',
            dataType: 'json',
            data: {
              name: name,
              name_en: name_en
            },
            success: function(data) {
              $("#name").val('');
              $("#name_en").val('');
              $("#id").val('');
                     $.growl.warning({ title: "<i class='fa fa-exclamation-circle'></i> Atención", message:"Datos Actualizados"});
                     $scope.rows();
                     $scope.titulo = "Nuevo tipo de persona";
                     $scope.btn = "Guardar";
                  },
                  error: function(msj) {
                    $.growl.error({ title: "<i class='fa fa-exclamation-circle'></i> Atención", message: ""+msj.responseJSON.name+""});
                 }
          });
        }
      }
    }

    $scope.borrar = function(id) {
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
            var route = "{{url('/')}}/persons/" + id + "";
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
                  $.growl.error({ title: "<i class='fa fa-exclamation-circle'></i> Atención", message: "Registro eliminado"});
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
    $scope.asignarValor = function(id,name,name_en) {
      $("#id").val(id);
      $("#name").val(name);
      $("#name_en").val(name_en);
      $scope.titulo = "Actualizá tu tipo de persona";
      $scope.btn = "Guardar";
    }
  });
  $('#navsm').sortable({
        revert: true,
        opaitem: 0.6,
        cursor: 'move',
        update: function() {
            var order = $('#navsm').sortable("serialize") + '&action=orderState';
            $.post("{{url('move-persons')}}", order, function(theResponse) {
                window.location.reload();
            });
        }
    });
</script>


@stop