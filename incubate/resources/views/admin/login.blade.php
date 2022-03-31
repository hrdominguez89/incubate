@extends('layouts.template_login')
@section('content')





{!! Form::open(['id'=>'form','onsubmit'=>'return false']) !!}

<div class="uk-margin-medium-top">

   <input type="button"  onclick="window.location='<?php echo url('login');?>'" class="btn waves-effect waves-light orange" value="Ingresá">
</div>
{!! Form::close() !!}

<script type="text/javascript">
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

</script>
@stop