@include('menu.cabeza')
<script>
    window.Laravel = {!! json_encode(['user' => Auth::user()]) !!};
</script>
<div id="app">
<gestion></gestion>
@include('menu.pies')