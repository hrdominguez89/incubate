@extends('layouts.template_recovery')
@section('content')

 
  <script src="https://www.google.com/recaptcha/api.js?render=<?php echo env('CAPTCHA_KEY_SITE');?>"></script>
  
{!! Form::open(['id'=>'form','onsubmit'=>'return false']) !!}
<input type="hidden" name="captcha" id="captcha" value="">
                     <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
<div class="input-field">
   <label for="email">Correo electrónico</label>
   {!!Form::text('email',null,['id'=>'email-recovery','class' => 'form-control'])!!}  
</div>
<div class="uk-margin-medium-top">
   {!!Form::button('Enviar', ['id'=>'btn-recovery','class' => 'btn waves-effect waves-light orange'])!!}
</div>
{!! Form::close() !!}
<input type="hidden" value="<?php echo env('CAPTCHA_KEY_SITE');?>" id="captcha-key">

@stop