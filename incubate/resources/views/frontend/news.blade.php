@extends('layouts.template_frontend')
@section('content')
<?php  $banner = DB::table('banners')->where('id', '3')->first();
   $image='';
   $vide0='';
   if($banner->image!='' && strpos($banner->image, ',') !== false ){
      $image=explode(",",$banner->image);
      $image=$image[1];
   }
   
   if($banner->video!="" && strpos($banner->video, '=') !== false){
      $video=explode("=",$banner->video);
      $video=$video[1];
   }
   ?>
@if($banner->type=='1' && $image!='')
<section class="block block-system clearfix hidden-xs">
   <div class="pane-content">
      <div class="jumbotron jumbotron-main jumbotron-small area-header" style="background-image: url('<?php echo url('/');?>/images/<?php echo $image;?>');">
         <div class="area-video-container">
            <div class="jumbotron-overlay">
               <div class="container">
                  <nav role="navigation">
                     <ol class="breadcrumb">
                        <li><a href="<?php echo ($lang == 'es') ? url('/') : url('en'); ?>"><?php echo ($lang == 'es') ? 'Inicio' : 'Home' ;?></a></li>
                        <li class="active"><?php echo $tab;?></li>
                     </ol>
                  </nav>
               </div>
            </div>
            <div class="container">
               <div class="area-title">
                  <h1><?php echo ($lang == 'es') ? $banner->title : $banner->title_en ;?></h1>
                  <p class="lead"><?php echo ($lang == 'es') ? $banner->subtitle : $banner->subtitle_en ;?></p>
                  @if($banner->name_boton!="" && $lang=='es')
                  <a href="<?php echo url($banner->url_boton);?>" class="btn btn-lg btn-primary btn-section"><?php echo $banner->name_boton;?></a>
                  @endif
                  @if($banner->name_boton_en!="" && $lang=='en')
                  <a href="<?php echo url($banner->url_boton_en);?>" class="btn btn-lg btn-primary btn-section"><?php echo $banner->name_boton_en;?></a>
                  @endif
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
@endif
@if($banner->type=='2' && $video!='')
<section class="block block-system clearfix hidden-xs" id="youtube-bg" data-video="<?php echo $video;?>">
   <div class="jumbotron jumbotron-main jumbotron-small">
      <div class="area-video-container">
         <div class="jumbotron-overlay">
            <div class="container">
               <nav role="navigation">
                  <ol class="breadcrumb">
                     <li><a href="<?php echo ($lang == 'es') ? url('/') : url('en'); ?>"><?php echo ($lang == 'es') ? 'Inicio' : 'Home' ;?></a></li>
                     <li class="active"><?php echo $tab;?></li>
                  </ol>
               </nav>
            </div>
         </div>
      </div>
      <div class="container">
         <div class="area-title">
            <h1><?php echo ($lang == 'es') ? $banner->title : $banner->title_en ;?></h1>
            <p class="lead"><?php echo ($lang == 'es') ? $banner->subtitle : $banner->subtitle_en ;?></p>
            @if($banner->name_boton!="" && $lang=='es')
            <a href="<?php echo url($banner->url_boton);?>" class="btn btn-lg btn-primary btn-section"><?php echo $banner->name_boton;?></a>
            @endif
            @if($banner->name_boton_en!="" && $lang=='en')
            <a href="<?php echo url($banner->url_boton_en);?>" class="btn btn-lg btn-primary btn-section"><?php echo $banner->name_boton_en;?></a>
            @endif
         </div>
      </div>
   </div>
</section>
@endif
<?php $section = DB::table('sections')->where('id', '7')->first(); ?>
@if($section->status==1)
<section class="bg-section" ng-app="myApp" ng-controller="post">
   @if($section->status_content==1)
   <div class="container">
      <div class="row">
         <div  class="col-md-12">
            <h2><?php echo ($lang == 'es') ? $section->title : $section->title_en ;?></h2>
            @if($section->content!="" && $lang=='es')
            <?php echo $section->content;?>
            @endif
            @if($section->content_en!="" && $lang=='en')
            <?php echo $section->content_en;?>
            @endif
         </div>
      </div>
   </div>
   @endif
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
   <div class="container bg-list" style="display: none;">
      <div class="row" ng-show="filteredItems <= 0">
         <div ng-show="filteredItems <= 0" class="col-md-12 noresult text-center">
            <img src="<?php echo url('/');?>/uploads/icons/noresult.png" alt="No hay resultados">
            <p><?php echo ($lang == 'es') ? 'No hay noticias disponible en este momento': 'No news available at this time';?></p>
         </div>
      </div>
      <div class="row list-group list-group-content search-list">
         <div class="views-row views-row-1 views-row-odd views-row-first col-md-6 col-sm-6  no-image" ng-repeat="row in filtered = (list | filter:search | orderBy : predicate :reverse) | startFrom:(currentPage-1)*entryLimit | limitTo:entryLimit">
            <a  class="list-group-item list-group-new list-thumb" href="javascript:;">
               <div class="thmb-img" ng-click="goToNews(row.url)" style="background-image:url('<?php echo url('/');?>/images/@{{row.image}}');"></div>
               <div class="thmb-content">
                  <h4 ng-click="goToNews(row.url)">@{{row.title}}</h4>
                  <p ng-click="goToNews(row.url)">@{{row.copy}}</p>
                  <p class="list-small p-date-nw">@{{row.date_format}}</p>
                  <p><span class="label label-default" ng-repeat="category in row.categories" ng-click="goToCategory(category.url)">@{{category.name}}</span></p>
               </div>
            </a>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12 pagination-wrapper no-padding" ng-show="filteredItems > 0" style="clear: both;">
            <ul class="pagination">
               <li  pagination="" page="currentPage" on-select-page="setPage(page)" total-items="filteredItems" items-per-page="entryLimit" class="page-item" previous-text="" next-text=""></li>
            </ul>
         </div>
      </div>
   </div>
   <div class="container">
      <div class="row">
         <div class="col-md-12 text-center">
            @if($section->name_boton!="" && $lang=='es')
            <a href="<?php echo url($section->url_boton);?>" class="btn btn-xl btn-primary btn-section"><?php echo $section->name_boton;?></a>
            @endif
            @if($section->name_boton_en!="" && $lang=='en')
            <a href="<?php echo url($section->url_boton_en);?>" class="btn btn-xl btn-primary btn-section"><?php echo $section->name_boton_en;?></a>
            @endif
         </div>
      </div>
   </div>
</section>
@endif
<input type="hidden" name="url" id="url" value="<?php echo url('/');?>">
<input type="hidden" name="lang" id="lang" value="<?php echo $lang;?>">
<?php echo Html::script('frontend/js/news.js?v='.time())?>
@stop