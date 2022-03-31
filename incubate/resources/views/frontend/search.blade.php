@extends('layouts.template_frontend_inside')
@section('content')
<?php echo Html::style('frontend/css/materialize.css?v='.time())?>
<section class="bg-section-1 clearfix" ng-app="myApp" ng-controller="post">
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <p style="display: none;" id="p-result" ><br> <?php echo ($lang == 'es') ? 'Se encontraron':'Were found';?>  @{{totalItems}} <?php echo ($lang == 'es') ? 'resultados para:' : 'results for:' ;?> <?php echo $search;?></p>
            <div class="panel-search">
               <div class="input-group">
                  <input class="form-control input-xl" id="search-1" name="search-1" type="text" placeholder="<?php echo ($lang == 'es') ? '¿Qué estás buscando?..' : 'What are you looking for? ..' ;?>">
                  <span class="input-group-btn">
                  <button class="btn btn-xl btn-default" type="button" id="btn-search-1" ><span class="icon glyphicon glyphicon-refresh" aria-hidden="true"></span></button>
                  </span>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="container mtop2 bg-preload">
      <div class="row">
         <div  class="col-md-12 content-spinner" >
            <div class="spinner">
               <div class="double-bounce1"></div>
               <div class="double-bounce2"></div>
            </div>
         </div>
      </div>
   </div>
   <div class="container mtop2 bg-list" style="display: none;">
      <div class="col-md-3 col-sm-3 no-padding" >
         <div id="div-filters" ng-show="filter_content!=''|| filter_date!='' ">
            <h3><?php echo ($lang == 'es') ? 'Filtros activos' : 'Filters Active' ;?></h3>
            <ul class="page-sidebar sidebar-remove">
               <li ng-show="filter_content!=''" ng-click="removeContent()"><a>@{{filter_content}}<span class="glyphicon glyphicon-remove"></span></a></li>
               <li ng-show="filter_date!=''" ng-click="removeDate()"><a>@{{filter_date}}<span class="glyphicon glyphicon-remove"></span></a></li>
            </ul>
            <hr>
         </div>
         <div id="div-content" ng-show="filter_content=='' && filteredItems != 0">
            <h3><?php echo ($lang == 'es') ? 'Contenidos' : 'Content' ;?></h3>
            <ul class="list-group">
               <li class="list-group-item list-group-search item-search" ng-repeat="row in content" ng-click="filterContent(row.title,row.id)">
                  <span class="badge">@{{row.total}}</span><span class="glyphicon glyphicon-globe"></span> @{{row.title}}
               </li>
            </ul>
            <hr>
         </div>
         <div id="div-date" ng-show="filter_date=='' && filteredItems != 0" class="hidden-xs">
            <h3><?php echo ($lang == 'es') ? 'Fecha' : 'Date' ;?></h3>
            <div class="input-group">
               <input class="form-control form-datepicker datepicker" id="datepicker" type="text" placeholder="<?php echo ($lang == 'es') ? 'Seleccionar Fecha' : 'Select Date' ;?>">
               <span class="input-group-btn ">
               <button class="btn btn-default input-group-s" type="button" onclick="bsfecha()"><i class="glyphicon glyphicon-search"></i></button>
               </span>
            </div>
         </div>
      </div>
      <div class="col-md-9 col-sm-9 list-search">
         <div ng-show="filteredItems <= 0" class="col-md-12 noresult text-center">
            <img src="<?php echo url('/');?>/uploads/icons/noresult.png" alt="No hay resultados">
            <p><?php echo ($lang == 'es') ? 'No hay resultados disponibles en este momento': 'No results availables at this time';?></p>
         </div>
         <a ng-repeat="row in filtered = (items | filter:search | orderBy : predicate :reverse) | startFrom:(currentPage-1)*entryLimit | limitTo:entryLimit" href="<?php echo url('/');?>/@{{row.url}}" class="list-group-item" >
            <h4>@{{row.title}}</h4>
            <p></p>
            <p>@{{row.content}}</p>
            <p></p>
         </a>
         <div class="row">
            <div class="col-md-12 pagination-wrapper no-padding" ng-show="filteredItems > 0" style="clear: both;">
               <ul class="pagination">
                  <li  pagination="" page="currentPage" on-select-page="setPage(page)" total-items="filteredItems" items-per-page="entryLimit" class="page-item" previous-text="" next-text=""></li>
               </ul>
            </div>
         </div>
      </div>
   </div>
   </div>
</section>
<input type="hidden" name="q" id="q" value="<?php echo $search;?>">
<input type="hidden" name="type" id="type" value="all">
<input type="hidden" name="date" id="date" value="0">
<input type="hidden" name="url" id="url" value="<?php echo url('/');?>">
<input type="hidden" name="lang" id="lang" value="<?php echo $lang;?>">
<?php echo Html::script('frontend/js/search.js?v='.time())?>
@stop