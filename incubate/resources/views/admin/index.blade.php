@extends('layouts.template')
@section('content')
<div class="content-area">
<div class="breadcrumb-bar">
   <div class="page-title">
      <h1>Bienvenido {{Auth::guard('admin')->User()->name}}</h1>
   </div>
   <ul class="admin-breadcrumb">
      <li>&nbsp;</li>
   </ul>
</div>
<!-- Breadcrumb Bar -->
<div class="widgets-wrapper" ng-app="myApp" ng-controller="paginado">
	@if(Auth::guard('admin')->User()->level=='1')
<div class="row" style="    height: 40px;">
   <div class="col s12" >
      <ul class="nav nav-tabs" style="border-bottom: none; padding-left: 0px!important">
         <li class="active"><a  href="{{url('/')}}/dashboard"><i class="ti-settings"></i> General</a></li>
         <li><a href="{{url('/')}}/analytics"><i class="fa fa-line-chart" aria-hidden="true"></i> Analytics</a></li>
      </ul>
   </div>
   <br><br>
</div>
@endif
<div class="row">
<div class="masonary">
	<div class="col s12"><br></div>
	</div>
</div>
<div class="row">
@if(Auth::guard('admin')->User()->level=='1')
<div class="masonary">
<div class="col s4">
   <a href="{{url('/')}}/project" >
      <div class="widget purple lighten-3">
         <div class="widget-title light">
            <h3>Proyectos</h3>
            <p>Ingrese, actualice y elimine información de su proyecto</p>
         </div>
         <div class="widget-content">
            <div class="main-counter">
               <span><i class="ti-briefcase"></i></span>
            </div>
         </div>
      </div>
      <!-- Widget -->
   </a>
</div>
<div class="col s4">
   <div class="widget blue  lighten-2">
      <a href="{{url('/')}}/post" >
         <div class="widget-title light">
            <h3>Noticias</h3>
            <p>Ingrese, actualice y elimine información de su noticia</p>
         </div>
         <div class="widget-content">
            <div class="main-counter">
               <span><i class="ti-gallery"></i></span>
            </div>
         </div>
   </div>
   <!-- Widget -->
   </a>
</div>
<div class="col s4">
   <div class="widget red lighten-3">
      <a href="{{url('/')}}/event" >
         <div class="widget-title light">
            <h3>Agenda</h3>
            <p>Ingrese, actualice y elimine información de su evento</p>
         </div>
         <div class="widget-content">
            <div class="main-counter">
               <span><i class="ti-calendar"></i></span>
            </div>
         </div>
   </div>
   <!-- Widget -->
   </a>
</div>
<div class="col s12">
         <div class="masonary">
            <div class="widget z-depth-1">
               <div class="widget-title"><h3> <i class="ti-notepad"></i> Mensajes de contacto </h3></div>
                <div class="widget-content">
               <div class="projects-table">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                  <table width="100%" class="table">
                     <thead>
                        <tr>
                           <th style="width: 20%">Nombre y Apellido</th>
                           <th style="width: 50%">Mensaje</th>
                           <th style="width: 15%">Fecha</th>
                           <th style="width: 15%"></th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr ng-repeat="row in list" >
                           <td style="vertical-align: middle;">
                              <div class="uk-text-semibold "><strong>@{{row.name}} @{{row.last_name}}</strong></div>
                              <div class="uk-text-semibold ">@{{row.email}} </div> 
                           </td>
                           <td style="vertical-align: middle;">  @{{row.message}} </td>
                           <td style="vertical-align: middle;"> @{{row.created_at | date : MM/dd/yyyy }}</td>
                           <td style="vertical-align: middle;">
                              <span class="controls">
                              <a  ng-click="borrar(row.id);" class="deleteuser red"><i class="ti-trash"></i> Eliminar</a>
                              </span>
                           </td>
                        </tr>
                        <tr ng-show="filteredItems == 0" >
                           <td colspan="7">
                              <p class="text-italic text-center"><i class="ti-info-alt"></i> No hay resultados para mostrar</p>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
               <br>
               <ul class="pagination" class="col-md-12" ng-show="filteredItems > 0">
                  <li  pagination="" page="currentPage" on-select-page="setPage(page)"total-items="filteredItems" items-per-page="entryLimit" class="page-item" previous-text="&laquo;" next-text="&raquo;"></li>
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
   @endif
</div>
<script type="text/javascript">
  $(function() {
    $('#fecha_inicial').datetimepicker({
      format: 'DD-MM-YYYY'
    });
    $('#fecha_final').datetimepicker({
      format: 'DD-MM-YYYY'
    });
  });
  history.pushState(null, null, null);
window.addEventListener('popstate', function() {
    history.pushState(null, null, null);
});
(function(global) {
    if (typeof(global) === "undefined") {
        throw new Error("window is undefined");
    }
    var _hash = "!";
    var noBackPlease = function() {
        global.location.href += "#";
        global.setTimeout(function() {
            global.location.href += "!";
        }, 50);
    };
    global.onhashchange = function() {
        if (global.location.hash !== _hash) {
            global.location.hash = _hash;
        }
    };
    global.onload = function() {
        noBackPlease();
        document.body.onkeydown = function(e) {
            var elm = e.target.nodeName.toLowerCase();
            if (e.which === 8 && (elm !== 'input' && elm !== 'textarea')) {
                e.preventDefault();
            }
            e.stopPropagation();
        };
    };
})(window);
$("#mask").show();
  var app=angular.module('myApp',['ui.bootstrap']);

  
  app.controller('paginado', function($scope,$http,$window){

    $scope.rows=function() {
      $scope.list=[];
      $http.get("{{url('comments_lists')}}").then(function successCallback(response)  {
        $scope.list = response.data;
        $scope.currentPage = 1; 
        $scope.entryLimit = 100; 
        $scope.filteredItems = $scope.list.length; 
        $scope.totalItems = $scope.list.length;
        $("#mask").hide();
      });
    }
    $scope.rows();

   
      $scope.borrar = function(id, code) {
      swal({
          title: "Confirmá que querés eliminar este registro",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#CE0505',
            confirmButtonText: 'Si eliminá',
            cancelButtonText: 'Cancelar',
            closeOnConfirm: true,
        },
        function() {
          // Url 
          var route = "{{url('/')}}/comments/" + id + "";
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
          var url="<?php echo url('/');?>/excel/messages/"+fecha_inicial+"/"+fecha_final;
          window.open(url);
        }
      }
    
    
  });
</script>
@stop