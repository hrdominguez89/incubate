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
   <div class="widgets-wrapper" ng-app="myApp" ng-controller="paginado">
      <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
      <input type="hidden" name="id" value="" id="id">
      <div class="row">
         <div class="masonary">
            <div class="col s12">
               <div class="widget z-depth-1">
                 <div class="widget-bar"> 
                  <div class="col s4">
                     <a class="btn orange" href="{{url('project/create')}}"> <i class="fa fa-plus-circle" aria-hidden="true"></i> Nuevo Proyecto </a>
                  </div>
                  <div class="col s8">
                     <form class="search-admin">
                        <input type="text" ng-model="search" ng-change="filter()" placeholder="Buscar...." >
                        <button><i class="ti-search"></i></button>
                     </form>
                  </div>
                  </div>
                   <div class="widget-content"> 
                  <div class="projects-table">
                     <table width="100%" class="table">
                         <thead>
                           <tr>
                              <th style="width: 1%">
                                 <div >ID</div>
                              </th>
                              <th style="width: 12%">
                                 <div >Título</div>
                              </th>
                              <th style="width: 20%">
                                 <div class="text-center">Categoría</div>
                              </th>
                              <th style="width: 10%">
                                 <div class="text-center">Registro</div>
                              </th>
                              <th style="width: 25%"></th>
                           </tr>
                        </thead>
                      
                           <tbody id="navsm">
                           <tr ng-repeat="row in filtered = (list | filter:search | orderBy : predicate :reverse) | startFrom:(currentPage-1)*entryLimit | limitTo:entryLimit" id="item_@{{row.id}}">
                              <td style="vertical-align: middle;"> @{{$index+1}}</td>
                              <td style="vertical-align: middle;"> @{{row.title}} </td>
                              <td style="vertical-align: middle; text-align: center;"> @{{row.categories}} </td>
                              <td style="vertical-align: middle; text-align: center;">  @{{row.created_at | date : MM/dd/yyyy }} </td>
                              <td style="vertical-align: middle;">
                              <span class="controls">
                                  <a class="edituser purple lighten-2" style="cursor:move" ><i class="ti-move"></i> Mover</a>
                                <a href="{{url('/')}}/project/@{{row.id}}/edit" class="edituser blue"><i class="ti-pencil-alt"></i> Editar</a>
                                 <a  ng-click="borrar(row.id);" class="deleteuser red"><i class="ti-trash"></i> Eliminar</a>
                              </span>
                            </div>
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
                     <li  pagination="" page="currentPage" on-select-page="setPage(page)" total-items="filteredItems" items-per-page="entryLimit" class="page-item" previous-text="&laquo;" next-text="&raquo;"></li>
                  </ul>
                   <p ng-show="filteredItems != 0" ><br>@{{totalItems}} Registro(s) encontrado(s)</p>
                   <br>
                   @if(Auth::guard('admin')->User()->level=='1')
                  <div class="row" ng-show="filteredItems != 0" style="border-top: 1px solid #ddd">
                        <div class="col s12">
                           <p style="margin-bottom: 10px; margin-top: 10px">Seleccioná un rango de fechas y exportá tus registros:</p>

                        </div>
                        <div class="col s3" style="clear: both;"> 
                           <input type='text' id='fecha_inicial' class="form-control" style="background-color: #fafafa;border:1px solid rgba(0, 0, 0, .12);padding: 8px;" value="01-<?php echo date('m');?>-<?php echo date("Y");?>" placeholder="Desde" />
                        </div>
                        <div class="col s3">
                           <input type='text' id='fecha_final' class="form-control" style="background-color: #fafafa;border:1px solid rgba(0, 0, 0, .12);padding: 8px;" value="<?php echo date('d-m-Y');?>" placeholder="Hasta" />
                        </div>
                        <div class="col s3">
                           <a  class="btn orange" ng-click="buscar_fecha()"  style="height: 45px;line-height: 50px; border-radius: 0.3rem;background-color: #33b56a!important;"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Descargá  Excel</a>
                        </div>
                        <div class="input-field col s12">
                           <label style="color: #fd2923!important">Se exportarán los primeros 5000 registros en el rango de fecha seleccionado.</label><br>
                        </div>
                        
                  </div>
                  @endif
                   
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
  $(function() {
    $('#fecha_inicial').datetimepicker({
      format: 'DD-MM-YYYY'
    });
    $('#fecha_final').datetimepicker({
      format: 'DD-MM-YYYY'
    });
  });
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
app.controller('paginado', function($scope, $http, $window) {
    //Listar Paginas 
    $scope.rows = function() {
        $http.get("{{url('projects_lists')}}").then(function successCallback(response)  {
            $scope.list = response.data;
            $scope.currentPage = 1;
            $scope.entryLimit = 100;
            $scope.filteredItems = $scope.list.length;
            $scope.totalItems = $scope.list.length;
                  $("#mask").hide();
        });
    }
    $scope.rows();
    //cambiar numero de pagina
    $scope.setPage = function(pageNo) {
        $scope.currentPage = pageNo;
    };
    // filtrar paginas
    $scope.filter = function() {
        $scope.filteredItems = $scope.filtered.length;
        $scope.totalItems = $scope.filtered.length
    };
    $scope.sort_by = function(predicate) {
        $scope.predicate = predicate;
        $scope.reverse = !$scope.reverse;
    };
    //borrar página
    $scope.borrar = function(id) {
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
                // Url 
                var route = "{{url('/')}}/project/" + id + "";
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
                        $scope.rows();
                    },
                    error: function(msj) {
                        $.growl.error({
                            title: "<i class='fa fa-exclamation-circle'></i> Error",
                            message: 'Ha ocurrido un error por favor intente más tarde'
                        });
                    }
                });
            });
    }
     $scope.buscar_fecha= function(){
          if ($('#fecha_inicial').val() == "") {
            $.growl.error({
                title: "<i class='fa fa-exclamation-circle'></i> Error",
                message: "Seleccioná una fecha"
            });
            $('#fecha_inicial').focus();
            return (false);
        }
        if ($('#fecha_final').val() == "") {
            $.growl.error({
                title: "<i class='fa fa-exclamation-circle'></i> Error",
                message: "Seleccioná una fecha"
            });
            $('#fecha_final').focus();
            return (false);
        }else{
          var fecha_inicial =document.getElementById("fecha_inicial").value;
          var fecha_final =document.getElementById("fecha_final").value;
          var url="<?php echo url('/');?>/excel/projects/"+fecha_inicial+"/"+fecha_final;
          window.open(url);
        }
      }
});
$('#navsm').sortable({
    revert: true,
    opaitem: 0.6,
    cursor: 'move',
    update: function() {
        var order = $('#navsm').sortable("serialize") + '&action=orderState';
        $.post("{{url('move-project')}}", order, function(theResponse) {
            window.location.reload();
        });
    }
});
 </script>
 @stop