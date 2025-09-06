@include('menu.cabeza')
@include('menu.menu')
<alumnos :user="{{ json_encode(Auth::user()) }}"></alumnos>
@include('menu.pies')