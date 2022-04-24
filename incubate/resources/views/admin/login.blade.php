@extends('layouts.template_login')
@section('content')





{!! Form::open(['id'=>'formlogin','onsubmit'=>'true','method'=>'post','url'=> action('LoginController@callback')]) !!}

<div class="uk-margin-medium-top">
    <div class="row" style="margin-top:10px">
        <div class="form-group">
            <label for="user">Usuario<small class="text"></label>
            <input type="text" class="form-control" name="user">
        </div>
    </div>
    <div class="row" style="margin-top:10px">

        <div class="form-group">
            <label for="user">Contraseña</label>
            <input type="password" class="form-control" name="password">
        </div>
    </div>
    {{ csrf_field() }}
    <div class="row" style="margin-top:10px">
        <input type="submit" class="btn waves-effect waves-light orange" value="Ingresá"></button>
    </div>

</div>
{!! Form::close() !!}
