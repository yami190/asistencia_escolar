@include('menu.cabeza')
@include('menu.menu')
<personal :user="{{ json_encode(Auth::user()) }}"></personal>

@include('menu.pies')