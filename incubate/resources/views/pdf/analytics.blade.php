<?php  $site = DB::table('site')->where('id', '1')->first(); ?>
<?php
   function month($mes) {
           setlocale(LC_TIME, 'spanish');
           $nombre = strftime("%B", mktime(0, 0, 0, $mes, 1, 2000));
           return ucwords($nombre);
       }
   
      function getDay($day){
      
              if($day=='0'){
                  return 'Domingo';
              }
              if($day=='1'){
                  return 'Lunes';
              }
              if($day=='2'){  
                  return 'Martes';
              }
              if($day=='3'){
                  return 'Miércoles';
              }
              if($day=='4'){
                  return 'Jueves';
              }
              if($day=='5'){
                  return 'Viernes';
              }
              if($day=='6'){
                  return 'Sábado';  
              }
          }
      ?>
<!DOCTYPE html>
<html>
   <head>
      <title>Reporte <?php echo $site->name;?> <?php echo date('d/m/Y',strtotime($init));?> - <?php echo date('d/m/Y',strtotime($end));?></title>
   </head>
   <style type="text/css">
      .roboto {
      font-family: Arial, Helvetica, sans-serif;
      }
      .main {
      font-family: Arial, Helvetica, sans-serif;
      width: 100%;
      }
      .main-1 {
      font-family: Arial, Helvetica, sans-serif;
      width: 100%;
      margin-top: 20px;
      border: 1px solid #ddd;
      border-bottom: none;
      border-radius: 4px;
      }
      .heading>td {
      background: #f3f3f3;
      padding: 10px 10px;
      border-bottom: 1px solid #ddd;
      font-family: Arial, Helvetica, sans-serif;
      font-weight: bold;
      text-transform: uppercase;
      }
      .t-body {
      border-bottom: 1px solid #ddd;
      }
      .t-body>td {
      color: #808080!important;
      padding: 10px 10px;
      font-size: 14px;
      border-bottom: 1px solid #ddd;
      }
      .t-body:last-child {
      border-bottom: none;
      }
      .nm {
      margin: 0
      }
      .tr {
      text-align: right;
      }
      .uk-text-center {
      text-align: center;
      }
      .uk-text-upper {
      text-transform: uppercase;
      }
      .uk-text-italic {
      font-style: italic;
      }
      .uk-text-small {
      font-size: 14px!important;
      }
      .uk-text-muted {
      color: #808080!important;
      }
      .uk-text-strong {
      font-weight: 700;
      }
      .uk-text-danger {
      color: #e53935!important;
      }
      .uk-text-success {
      color: #808080!important;
      }
      .tl {
      text-align: left;
      }
      .bold {
      font-weight: bold
      }
      .t14 {
      font-size: 14px
      }
      .t13 {
      font-size: 13px
      }
      .t16 {
      font-size: 16px
      }
      .t18 {
      font-size: 18px
      }
      .t22 {
      font-size: 22px
      }
      .f300 {
      font-weight: normal;
      }
      .fact {
      width: 100%;
      margin-top: 30px;
      font-family: Arial, Helvetica, sans-serif;
      ;
      }
      .fact tr th {
      font-style: normal;
      font-weight: 400;
      color: #fff;
      font-size: 16px;
      background: #021063;
      text-align: center;
      }
      .fact tr td {
      font-size: 14px;
      text-align: center;
      border-bottom: 1px solid #aaa;
      padding: 5px 0;
      background: #ecebeb
      }
      .ffa {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 16px;
      font-weight: bold
      }
      .nbor {
      border-width: 0px!important;
      }
      .bbottom {
      border-bottom: 1px solid #fff;
      border-spacing: 0px;
      }
      .art {
      text-align: right
      }
      table {
      border-spacing: 0px;
      border-collapse: separate;
      }
      .pie {
      font-family: Arial, Helvetica, sans-serif;
      position: absolute;
      height: 40px;
      width: 100%;
      text-align: center;
      bottom: 10px;
      font-size: 11px;
      color: #808080!important;
      }
      .pie img {
      width: 120px;
      margin-bottom: 5px;
      text-align: center;
      }
   </style>
   <body>
      <table class="main">
         <tr >
            <td class="bbottom">
               <?php
                  $image=$_SERVER['DOCUMENT_ROOT'].'/images/'.$site->image_1;
                  
                  ?>
               <img src="<?php echo $image;?>" style="width: 100px">
            </td>
            <td width="49%" class="bbottom art">
            </td>
         </tr>
      </table>
      <h2 class="main t14 uk-text-upper " style="color: #000000;font-weight: bold;">Analytics <?php echo date('d/m/Y',strtotime($init));?> - <?php echo date('d/m/Y',strtotime($end));?></h2>
      <table class="main-1">
         <tr class="heading">
            <td class="bbottom" colspan="2" style="font-size: 14px">Sesiones por dispositivo</td>
         </tr>
         <tr class="t-body">
            <td class="bbottom" style="width: 30%">Computadoras:</td>
            <td style="width: 60%"><?php echo $desktop;?></td>
         </tr>
         <tr class="t-body">
            <td class="bbottom" style="width: 30%">Móviles:</td>
            <td style="width: 60%"><?php echo $mobiles;?></td>
         </tr>
         <tr class="t-body">
            <td class="bbottom" style="width: 30%">Tablets:</td>
            <td style="width: 60%"><?php echo $tablets;?></td>
         </tr>
      </table>
      <table class="main-1">
         <tr class="heading">
            <td class="bbottom" colspan="2" style="font-size: 14px">Usuarios activos por día</td>
         </tr>
         @foreach($days as $rs)
         <tr class="t-body">
            <td class="bbottom" style="width: 30%">{{getDay($rs->day)}}</td>
            <td style="width: 60%">{{$rs->total}}</td>
         </tr>
         @endforeach
      </table>
      <table class="main-1">
         <tr class="heading">
            <td class="bbottom" colspan="2" style="font-size: 14px">Usuarios por hora del día</td>
         </tr>
         <?php   $i=0; ?> 
         @foreach($hours as $rs)
         <?php   $i=$i+1; ?> 
         <tr class="t-body">
            <td class="bbottom" style="width: 30%">
               <?php 
                  echo date("H",strtotime($rs->hour)).':00'; 
                  
                   if(date("H",strtotime($rs->hour))<12){ 
                  
                     echo ' am';
                  
                      } else{  
                  
                       echo ' pm';
                    }
                  
                   ?>
            </td>
            <td style="width: 60%">{{$rs->total}}</td>
         </tr>
         @endforeach
      </table>
      <table class="main-1">
         <tr class="heading">
            <td class="bbottom" colspan="2" style="font-size: 14px">Usuarios activos en el mes</td>
         </tr>
         <?php   $i=0; ?> 
         @foreach($users_month as $rs)
         <?php   $i=$i+1; ?> 
         <tr class="t-body">
            <td class="bbottom" style="width: 30%">  {{month(date("m",strtotime($rs->date)))}}  {{date("d",strtotime($rs->date))}}, {{date("Y",strtotime($rs->date))}} </td>
            <td style="width: 60%">{{$rs->total}}</td>
         </tr>
         @endforeach
      </table>
      <table class="main-1">
         <tr class="heading">
            <td class="bbottom" colspan="2" style="font-size: 14px">Sesiones por ciudad</td>
         </tr>
         @foreach($code as $rs)
         <tr class="t-body">
            <td class="bbottom" style="width: 30%">@if($rs->name!='') {{$rs->name}}@if($rs->code!=''),@endif @endif @if($rs->code!='') {{$rs->code}} @endif  @if($rs->name=='' && $rs->code=='') United States @endif</td>
            <td style="width: 60%">{{$rs->total}}</td>
         </tr>
         @endforeach
      </table>
      <table class="main-1">
         <tr class="heading">
            <td class="bbottom" colspan="2" style="font-size: 14px">¿Qué páginas visitan sus usuarios?</td>
         </tr>
         @foreach($pages as $rs)
         <tr class="t-body">
            <td class="bbottom" style="width: 30%">{{$rs->page}}</td>
            <td style="width: 60%">{{$rs->total}}</td>
         </tr>
         @endforeach
      </table>
   </body>
</html>