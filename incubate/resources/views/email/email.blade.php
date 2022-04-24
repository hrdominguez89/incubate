

<?php

$site=DB::table('site')->where('id', '1')->first();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <title>Incubate</title>
   </head>
   <body style="width:100% !important; color:#ffffff; background:#fff; font-family: 'Times New Roman', Times, serif; font-size:13px; line-height:1;" >
      <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="background: #fff">
         <tr>
            <td align="left" style="background: ">
               <table cellpadding="0" cellspacing="0" border="0" width="640" align="center" style="background: #E6E7E8;">
                  <tr style="background: #fdd306">
                     <td height="5"></td>
                  </tr>
                  <tr>
                     <td height="50"></td>
                  </tr>
                  <tr>
                     <td style="text-align: center;">
                        <a href="<?php echo url('/')?>" style="text-align: center;">
                        <img src="<?php echo url('/')?>/uploads/backend/logo.png" alt="Incubate" style="width: 200px">
                        </a>
                  </td>
                  </tr>
                  <!--  2 -->
                  <tr>
                      <td height="30">
                      </td>
                  </tr>
                  <tr>
                     <td style="    font-size: 22px;
                        color: #666669;
                            font-weight: 700;
                        height: 5px;
                        text-align: center!important;
                        text-transform: uppercase;
                        font-family: Arial!important;"><?php echo $title;?></td>
                  </tr>
                  <!-- 3 -->
                  
                  <tr >
                     <td style="color: #666669!important; font-size:14px!important;font-family: Arial!important; padding: 40px; height: 5px;    line-height: 25px!important;"> <?php echo $content;?> </td>
                  </tr>
                  <tr >
                   <td style="color: #666669!important; font-size:14px!important;font-family: Arial!important;     padding: 0px 0px 40px 40px; height: 5px;    line-height: 25px!important;">Puede obtener mas detalles accediendo al área administrativa: <br><br>

                    <a href="<?php echo url('/');?>/cms" target="_blank" style="line-height: 36px!important;
    padding: 10px 2rem!important;
    font-family: Arial!important;
    border-radius: 6px;
    margin-top: 10px!important;
    text-transform: uppercase;
    text-decoration: none;
    font-size: 14px!important;
    color: #fff!important;
    background-color: #fdd306!important;
    background: #fdd306!important;
    line-height: 36px!important;">Iniciar Sesión</a>
                      </td>
                  </tr>
                  <tr>
                      <td height="140">
                      </td>
                  </tr>
                 @if($site->phone_emergencia!="")  
                  <tr >
                     <td  style="text-align: center!important; font-size: 14px!important; color: #666669!important;    height: 20px;font-family: Arial!important">
                     <p stye="text-align: center!important; font-size: 14px; color: #666669!important;    height: 30px;font-family: Arial!important">
                      <a href="tlf:<?php echo $site->phone_emergencia?>" style=" color: #666669!important; text-decoration: none;font-family: Arial!important;text-align: center!important;"><img border="0" src="<?php echo url('/');?>/uploads/icons/phone.png"> Emergencias: <?php echo $site->phone_emergencia?> </a>
                      </p>
                     </td>
                  </tr>
                  @endif
 





                   <tr >
                     <td  style="text-align: center!important; font-size: 14px!important; color: #666669!important;    height: 20px;">
                    <a href="mailto:<?php echo $site->email?>" style=" color: #666669!important; text-decoration: none;font-family: Arial!important;text-align: center!important;"><img border="0" src="<?php echo url('/');?>/uploads/icons/email.png">  <?php echo $site->email?> </a>
                     </td>
                  </tr>
                  <tr >
                     <td height="10" style="text-align: center!important; font-size: 14px; color: #666669!important;    height: 30px;font-family: Arial!important">
                     <p stye="text-align: center!important; font-size: 14px; color: #666669!important;    height: 30px;font-family: Arial!important">Incubate &copy; <?php echo date("Y");?></p>
                     </td>
                  </tr>
                  <tr>
                     <td style="text-align: center;">
                        <a href="<?php echo url('/')?>" style="text-align: center;">
                        <img src="<?php echo url('/')?>/uploads/icons/logo_1.png" alt="Incubate" style="width: 200px">
                        </a>
                  </td>
                  </tr>
                  <tr>
                      <td height="50">
                      </td>
                  </tr>
                  <tr style="background: #fdd306">
                     <td height="5"></td>
                  </tr>
               </table>
            </td>
         </tr>
      </table>
   </body>
</html>