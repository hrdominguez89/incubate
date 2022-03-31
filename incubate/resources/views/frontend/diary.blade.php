@extends('layouts.template_frontend')
@section('content')
<?php 
   function nameMonth($month, $lang) {
           switch ($month) {
               case 1:
    $month = ($lang == 'es') ? 'Enero' : 'January';
    break;
    case 2:
    $month = ($lang == 'es') ? 'Febrero' : 'February';
    break;
    case 3:
    $month = ($lang == 'es') ? 'Marzo' : 'March';
    break;
    case 4:
    $month = ($lang == 'es') ? 'Abril' : 'April';
    break;
    case 5:
    $month = ($lang == 'es') ? 'Mayo' : 'May';
    break;
    case 6:
    $month = ($lang == 'es') ? 'Junio' : 'June';
    break;
    case 7:
    $month = ($lang == 'es') ? 'Julio' : 'July';
    break;
    case 8:
    $month = ($lang == 'es') ? 'Agosto' : 'August';
    break;
    case 9:
    $month = ($lang == 'es') ? 'Septiembre' : 'September';
    break;
    case 10:
    $month = ($lang == 'es') ? 'Octubre' : 'October';
    break;
    case 11:
    $month = ($lang == 'es') ? 'Noviembre' : 'November';
    break;
    case 12:
    $month = ($lang == 'es') ? 'Diciembre' : 'December';
    break;
   
           }
           return $month;
       }
   
   function nameDay($day, $lang) {
   
           switch ($day) {
               case 0:
               $day = ($lang == 'es') ? 'Dom' : 'Sun';
               break;
               case 1:
               $day = ($lang == 'es') ? 'Lun' : 'Mon';
               break;
               case 2:
               $day = ($lang == 'es') ? 'Mar' : 'Tue';
               break;
               case 3:
               $day = ($lang == 'es') ? 'Mie' : 'Wed';
               break;
               case 4:
               $day = ($lang == 'es') ? 'Jue' : 'Thu';
               break;
               case 5:
               $day = ($lang == 'es') ? 'Vie' : 'Fri';
               break;
               case 6:
               $day = ($lang == 'es') ? 'Sab' : 'Sat';
               break;
           }
           return $day;
       }
   ?>
<?php echo Html::style('frontend/css/materialize.css?v='.time())?>
<?php  $banner = DB::table('banners')->where('id', '4')->first();
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
<?php $section = DB::table('sections')->where('id', '8')->first(); ?>
@if($section->status==1)
<section class="bg-section" ng-app="myApp" ng-controller="post">
   <div class="container">
      <div class="row">
         @if($section->status_content==1)
         <div  class="col-md-12">
            <h2><?php echo ($lang == 'es') ? $section->title : $section->title_en ;?></h2>
            @if($section->content!="" && $lang=='es')
            <?php echo $section->content;?>
            @endif
            @if($section->content_en!="" && $lang=='en')
            <?php echo $section->content_en;?>
            @endif
         </div>
         @endif

         <div class="col-md-12 hidden-lg hidden-md hidden-sm">
          <br>
            <select class="form-control" onchange="GoEventCategory()" id="select-category" >
            <?php $i=0; ?>
            @foreach($categories as $rs)
            <?php $i=$i+1; ?>
            <?php if($i==1){ $id_category=$rs->id; } ?>
            <option value="<?php echo ($lang == 'es') ? $rs->url : $rs->url_en ;?>" @if($i==1) selected="selected" @endif><?php echo ($lang == 'es') ? $rs->name : $rs->name_en ;?></option>
            @endforeach
            </select>
         </div>
         <div  class="col-md-12 hidden-xs">
          <br>
            <?php $i=0; ?>
            @foreach($categories as $rs)
            <?php $i=$i+1; ?>
            <?php if($i==1){ $id_category=$rs->id; } ?>
            <button type="button" class="btn btn-lg @if($i==1) btn-info @else btn-default @endif btn-category" onclick="gotoCategoryEvent('<?php echo ($lang == 'es') ? $rs->url : $rs->url_en ;?>')"><?php echo ($lang == 'es') ? $rs->name : $rs->name_en ;?></button>
            @endforeach
         </div>
         <div class="col-md-12 hidden-xs">
            <div class="pull-left form-inline">
               <div class="btn-group">
                  <button class="btn btn-primary btn-diary" onclick="openDays()" id="day"><?php echo ($lang == 'es') ? 'Días':'Days';?></button>
                  <button class="btn btn-default btn-diary" onclick="openMonth()" id="month"><?php echo ($lang == 'es') ? 'Mes':'Month';?></button>
               </div>
            </div>
         </div>
          @if(count($dates)!=0)
         <div class="col-md-12 hidden-xs" id="nav-date">
            <ul class="nav nav-tabs nav-date">
               <?php $i=0; ?>
               @foreach($dates as $rs)
               <?php $i=$i+1; ?>
               <?php if($i==1){ $date=$rs->date; } ?>
               <li @if($i==1) class="active" @endif onclick="searchDate('<?php echo $rs->date;?>')"><a data-toggle="tab"><?php echo date("d",strtotime($rs->date));?> <?php echo nameDay(date("w",strtotime($rs->date)),$lang);?> / <?php echo nameMonth(date("m",strtotime($rs->date)),$lang);?></a></li>
               @endforeach
            </ul>
         </div>
         @endif

         <div class="col-md-12 mtop2 hidden-lg hidden-md hidden-sm"  style="clear: both;">
            <br>
            <ul class="nav nav-tabs nav-date">
               <li class="active"><a id="tab-lists"  data-toggle="tab" onclick="openDays()"><?php echo ($lang == 'es') ? 'Días':'Days';?></a></li>
               <li><a data-toggle="tab" onclick="openMonth()"><?php echo ($lang == 'es') ? 'Mes':'Month';?></a></li>
            </ul>
            <br>
          </div>

      </div>
   </div>
   @if(count($dates)==0)
   <div class="container mtop2 bg-list">
      <div class="row">
         <div  class="col-md-12 noresult text-center">
            <img src="<?php echo url('/');?>/uploads/icons/noresult.png" alt="No hay resultados">
            <p><?php echo ($lang == 'es') ? 'No hay eventos disponible en este momento': 'No events available at this time';?></p>
         </div>
      </div>
   </div>
   @else
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
      <div class="row">
         <div ng-show="filteredItems <= 0" class="col-md-12 noresult text-center">
            <img src="<?php echo url('/');?>/uploads/icons/noresult.png" alt="No hay resultados">
            <p><?php echo ($lang == 'es') ? 'No hay eventos disponible en este momento': 'No events available at this time';?></p>
         </div>
         <div class="col-md-12 clearfix"></div>
         <div class="col-md-4 col-sm-4" ng-repeat="row in filtered = (list | filter:search | orderBy : predicate :reverse) | startFrom:(currentPage-1)*entryLimit | limitTo:entryLimit">
            <div class="thumbnail card-chica" ng-click="goToEvents(row.url)">
               <img class="img-rounded" src="<?php echo url('/');?>/images/@{{row.image}}" alt="@{{row.title}}">
               <div class="post-caption">
                  <h3>@{{row.title}}</h3>
                  <div class="text-left mmb1">
                     <span class="label label-danger">@{{row.date}}</span>
                     <span class="label label-success">@{{row.place}}</span><br>
                  </div>
                  <p class="pcc">@{{row.resume}}</p>
                  <div class="text-left">
                     <a ng-click="goToEvents(row.url)" class="btn  btn-primary"> <?php echo ($lang == 'es') ? 'Leer más' : 'Read more' ;?></a>
                  </div>
               </div>
            </div>
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
   @endif
   <div class="container">
      <div class="row">
         <div class="col-md-12 text-center mbs1">
            @if($section->name_boton!="" && $lang=='es')
            <a href="<?php echo url($section->url_boton);?>" class="btn btn-xl btn-primary btn-section"><?php echo $section->name_boton;?></a>
            @endif
            @if($section->name_boton_en!="" && $lang=='en')
            <a href="<?php echo url($section->url_boton_en);?>" class="btn btn-xl btn-primary btn-section"><?php echo $section->name_boton_en;?></a>
            @endif
         </div>
      </div>
   </div>
   <input class="form-control-date datepicker" id="datepicker">
</section>
  @if(count($dates)!=0)
<input type="hidden" name="category" id="category" value="<?php echo $id_category;?>">
<input type="hidden" name="date" id="date" value="<?php echo $date;?>">
<input type="hidden" name="firts_date" id="firts_date" value="<?php echo $date;?>">
@endif
<input type="hidden" name="url" id="url" value="<?php echo url('/');?>">
<input type="hidden" name="lang" id="lang" value="<?php echo $lang;?>">
<?php echo Html::script('frontend/js/events.js?v='.time())?>
@endif
@stop