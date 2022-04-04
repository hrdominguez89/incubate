@extends('layouts.template_frontend_inside')
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
               $day = ($lang == 'es') ? 'Domingo' : 'Sunday';
               break;
               case 1:
               $day = ($lang == 'es') ? 'Lunes' : 'Monday';
               break;
               case 2:
               $day = ($lang == 'es') ? 'Martes' : 'Tuesday';
               break;
               case 3:
               $day = ($lang == 'es') ? 'Miércoles' : 'Wednesday';
               break;
               case 4:
               $day = ($lang == 'es') ? 'Jueves' : 'Thursday';
               break;
               case 5:
               $day = ($lang == 'es') ? 'Viernes' : 'Friday';
               break;
               case 6:
               $day = ($lang == 'es') ? 'Sábado' : 'Saturday';
               break;
           }
           return $day;
    }
   
    function clearArchive($archive){
   
      $value=preg_replace('/[^a-zA-Zá-źÁ-Ź[\s]/s', '', $archive);
      $value = str_replace('pdf', '', $value);
      $value = str_replace('png', '', $value);
      $value = str_replace('jpg', '', $value);
      $value = str_replace('jpeg', '', $value);
      $value = str_replace('doc', '', $value);
      $value = str_replace('docx', '', $value);
      $value = str_replace('-', ' ', $value);
      $value = str_replace('_', ' ', $value);
      $value=ucfirst ($value);
      return $value;
    }
   ?>
<section class="bg-section-2">
   <div class="container">
      <div class="row">
         <div class="col-md-12 hidden-xs">
          <ol class="breadcrumb breadcrumb-single">
           <li><a href="<?php echo ($lang == 'es') ? url('/') : url('en'); ?>"><?php echo ($lang == 'es') ? 'Inicio' : 'Home' ;?></a></li>
                        <li><a href="<?php echo $url_tab;?>"><?php echo $tab;?></a></li>
            <li class="active"><?php echo ($lang == 'es') ? $diary->title : $diary->title_en ;?></li>
          </ol>
        </div>
         <div  class="col-md-8 col-sm-8">

           @if($diary->image !="" && && strpos($diary->image, ',') !== false )
            <div id="carousel-example-generic" class="carousel slide hidden-lg hidden-md hidden-sm" data-ride="carousel">
               <div class="carousel-inner">
                  @for ($i=1;$i<=substr_count($diary->image, ',');$i++)
                  <?php  $image= explode(',',$diary->image);  ?>
                  <div class="item @if($i==1) active @endif">
                     <img src="<?php echo url('/');?>/images/<?php echo $image[$i];?>"  alt="<?php echo ($lang == 'es') ? $diary->title : $diary->title_en ;?>">
                  </div>
                  @endfor
               </div>
               <!-- Controls -->
               <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
               <span class="glyphicon glyphicon-chevron-left"></span>
               </a>
               <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
               <span class="glyphicon glyphicon-chevron-right"></span>
               </a>
            </div>
            @endif
            
            <div class="title-content">
               <h2>
                  <?php echo ($lang == 'es') ? $diary->title : $diary->title_en ;?>
               </h2>
               <p><?php echo ($lang == 'es') ? $diary->resume : $diary->resume_en ;?></p>
               <?php 
                  if($lang=='es'){
                  
                    $facebook='http://www.facebook.com/sharer.php?u='.url('/').$_SERVER['REQUEST_URI'];
                    $twitter='https://twitter.com/intent/tweet?text='.$diary->title.': '.url('/').$_SERVER['REQUEST_URI'];
                    $whatsapp='https://api.whatsapp.com/send?text='.$diary->title.': '.url('/').$_SERVER['REQUEST_URI'];
                     $linkedin='http://www.linkedin.com/shareArticle?url='.url('/').$_SERVER['REQUEST_URI'];
                  
                  
                  }else{
                  
                    $facebook='http://www.facebook.com/sharer.php?u='.url('/').$_SERVER['REQUEST_URI'];
                    $twitter='https://twitter.com/intent/tweet?text='.$diary->title_en.': '.url('/').$_SERVER['REQUEST_URI'];
                    $whatsapp='https://api.whatsapp.com/send?text='.$diary->title_en.': '.url('/').$_SERVER['REQUEST_URI'];
                     $linkedin='http://www.linkedin.com/shareArticle?url='.url('/').$_SERVER['REQUEST_URI'];
                  
                  
                  }
                  
                  ?>
               <ul class="mini-social">
                  <li><a href="javascript: void(0);" onclick="share('<?php echo $facebook;?>')"><div  class="m-icon facebook"></div></a></li>
                  <li><a href="javascript: void(0);" onclick="share('<?php echo $twitter;?>')"><div  class="m-icon twitter"></div></a></li>
                  <li><a href="javascript: void(0);" onclick="share('<?php echo $whatsapp;?>')"><div  class="m-icon whatsapp"></div></a></li>
                  <li><a href="javascript: void(0);" onclick="share('<?php echo $linkedin;?>')"><div  class="m-icon linkedin"></div></a></li>
               </ul>
               <ul class="items-projects">
                  <?php $type=DB::table('types')->where('id', $diary->type)->first(); ?>
                  <li><i class="fa fa-tag"></i> <?php echo ($lang == 'es') ? $type->name : $type->name_en ;?></li>
                  <li><i class="fa fa-calendar-o"></i> 
                     @if(date("Y-m-d",strtotime($diary->start_date))==date("Y-m-d",strtotime($diary->end_date)) )
                     <?php echo nameMonth(date("m",strtotime($diary->start_date)),$lang).' '.date("d",strtotime($diary->start_date)).', '.date("Y",strtotime($diary->start_date)); ?>
                     <i class="fa fa-clock-o"></i> <?php echo date("H:i",strtotime($diary->start_date)).' - '. date("H:i",strtotime($diary->end_date)); ?>
                     @else
                     <?php echo nameMonth(date("m",strtotime($diary->start_date)),$lang).' '.date("d",strtotime($diary->start_date)).', '.date("Y",strtotime($diary->start_date)); ?> -  <?php echo nameMonth(date("m",strtotime($diary->end_date)),$lang).' '.date("d",strtotime($diary->end_date)).', '.date("Y",strtotime($diary->end_date)); ?>
                     <i class="fa fa-clock-o"></i> <?php echo date("H:i",strtotime($diary->start_date)).' - '. date("H:i",strtotime($diary->end_date)); ?>
                     @endif
                  </li>
                  <li><i class="fa fa-map-marker"></i>  <?php echo $diary->place;?></li>
               </ul>
            </div>
            <div class="p-content">
               <?php echo ($lang == 'es') ? $diary->content : $diary->content_en ;?>
            </div>
            <?php $archives=DB::table('events_archives')->where('event',$diary->id)->get(); ?>
            @if(count($archives)!=0)
            <div class="p-archive hidden-xs" style="margin-top: 1vw; margin-bottom: 1vw">
               <h2><?php echo ($lang == 'es') ? 'Descargas:':'Downloads:';?></h2>
               <div class="table-responsive">
                  <table class="table table-hover">
                     <thead>
                        <tr>
                           <td style="width: 40%"><?php echo ($lang == 'es') ? 'Archivo' : 'Archive' ;?></td>
                           <td style="width: 20%"><?php echo ($lang == 'es') ? 'Tamaño' : 'Size' ;?></td>
                           <td style="width: 40%;text-align: right;"><?php echo ($lang == 'es') ? 'Descargar' : 'To Download' ;?></td>
                        </tr>
                     </thead>
                     <tbody>
                       @foreach($archives as $rs)
                        <tr>
                           <td style="vertical-align: middle;"><?php echo ($lang == 'es') ? $rs->name : $rs->name_en ;?></td>
                           <td style="vertical-align: middle;"><?php echo $rs->file_size;?></td>
                           <td  style="vertical-align: middle; text-align: right;">
                              <a class="btn btn-primary" target="_blank" href="<?php echo url('/');?>/descargar/<?php echo $rs->archive;?>">
                              <i class="fa fa-download" aria-hidden="true">
                              </i></a>
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
            @endif
         </div>
         <div class="col-md-4 col-sm-4">
            @if($diary->image !="" && strpos($rs->image, ',') !== false )
            <ul class="new-gallery hidden-xs">
               @for ($i=1;$i<=substr_count($diary->image, ',');$i++)
               <?php  $image= explode(',',$diary->image);  ?>
               <li>
                  <a href="<?php echo url('/');?>/images/<?php echo $image[$i];?>" data-lightbox="image-1" data-title="<?php echo ($lang == 'es') ? $diary->title : $diary->title_en ;?>">
                  <img src="<?php echo url('/');?>/images/<?php echo $image[$i];?>"  alt="<?php echo ($lang == 'es') ? $diary->title : $diary->title_en ;?>" style="cursor: pointer;" class="img-responsive">
                  </a>
               </li>
               @endfor
            </ul>
            @endif
            @if($diary->video!="" && strpos($diary->video, "=") !== false)
            <div class="video">
               <hr>
               <?php  $video= explode('=',$diary->video);  ?>
               <iframe src="https://www.youtube.com/embed/<?php echo $video[1];?>?rel=0&controls=0" allowfullscreen="" style="left:0px" ></iframe>
            </div>
            @endif
            <?php $archives=DB::table('events_archives')->where('event',$diary->id)->get(); ?>
            @if(count($archives)!=0)
            <div class="p-archive hidden-lg hidden-md hidden-sm" style="margin-top: 1vw; margin-bottom: 1vw">
               <h2><?php echo ($lang == 'es') ? 'Descargas:':'Downloads:';?></h2>
               <div class="table-responsive">
                  <table class="table table-hover">
                     <thead>
                        <tr>
                           <td style="width: 40%"><?php echo ($lang == 'es') ? 'Archivo' : 'Archive' ;?></td>
                           <td style="width: 20%"><?php echo ($lang == 'es') ? 'Tamaño' : 'Size' ;?></td>
                           <td style="width: 40%;text-align: right;"><?php echo ($lang == 'es') ? 'Descargar' : 'To Download' ;?></td>
                        </tr>
                     </thead>
                     <tbody>
                       @foreach($archives as $rs)
                        <tr>
                           <td style="vertical-align: middle;"><?php echo ($lang == 'es') ? $rs->name : $rs->name_en ;?></td>
                           <td style="vertical-align: middle;"><?php echo $rs->file_size;?></td>
                           <td  style="vertical-align: middle; text-align: right;">
                              <a class="btn btn-primary" target="_blank" href="<?php echo url('/');?>/descargar/<?php echo $rs->archive;?>">
                              <i class="fa fa-download" aria-hidden="true">
                              </i></a>
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
            @endif
         </div>
      </div>
   </div>
   </div>
   <?php $section = DB::table('sections')->where('id', '17')->first(); ?>
   @if($section->status==1)
   <div class="container hidden-xs">
      <div class="row">
         <div  class="col-md-12 col-sm-12">
            <hr>
            @if($section->status_content==1)
            <h2><?php echo ($lang == 'es') ? $section->title : $section->title_en ;?></h2>
            @if($section->content!="" && $lang=='es')
            <?php echo $section->content;?>
            @endif
            @if($section->content_en!="" && $lang=='en')
            <?php echo $section->content_en;?>
            @endif
            @endif
         </div>
      </div>
      <div class="row bg-project">
         <div class="col-md-12 clearfix"></div>
         <?php $events = DB::table('events')->where('id','!=',$diary->id)->offset(0)->limit(3)->orderBy('id', 'desc')->get(); ?>
         @foreach($events as $rs)
         @if($rs->image!="" && strpos($rs->image, ',') !== false  )
         <div class="col-md-4 col-sm-4 no-padding-p">
            <div class="thumbnail card-chica">
               <?php    $image=explode(",",$rs->image) ?>
               <img class="img-rounded" src="<?php echo url('/');?>/images/<?php echo $image[1];?>" alt="<?php echo ($lang == 'es') ? $rs->title : $rs->title_en ;?>" onclick="GoToEvento('<?php echo ($lang == 'es') ? $rs->url : $rs->url_en ;?>')">
               <div class="post-caption">
                  <h3 onclick="GoToEvento('<?php echo ($lang == 'es') ? $rs->url : $rs->url_en ;?>')"> <?php echo ($lang == 'es') ? $rs->title : $rs->title_en ;?></h3>
                  <div class="text-left mmb1">
                     <span class="label label-danger"> <?php echo nameMonth(date("m",strtotime($rs->created_at)),$lang).' '.date("d",strtotime($rs->created_at)).', '.date("Y",strtotime($rs->created_at)); ?></span>
                     <span class="label label-success"><?php echo $rs->place;?></span><br>
                  </div>
                  <p class="pcc"> <?php echo ($lang == 'es') ? $rs->resume : $rs->resume_en ;?></p>
                  <div class="text-center">
                     <a onclick="GoToEvento('<?php echo ($lang == 'es') ? $rs->url : $rs->url_en ;?>')" class="btn  btn-primary"> <?php echo ($lang == 'es') ? 'Leer más' : 'Read more' ;?></a>
                  </div>
               </div>
            </div>
         </div>
         @endif
         @endforeach
      </div>
   </div>
   <div class="container hidden-xs">
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
   @endif
</section>
@stop