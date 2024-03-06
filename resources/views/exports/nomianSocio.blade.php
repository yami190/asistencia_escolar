<?php use Carbon\Carbon; ?>

	<table>
    <thead>
        <?php $dt = Carbon::now(); ?>
        <tr>
            <th>01750526220072326906</th>
            <th><?php echo $dt->toDateString(); ?></th>
            @foreach($sumas as $suma)
            <th>{{$suma->ahorro}}</th>
            @endforeach

        </tr>
    </thead>
    <tbody>
    @foreach($cuentas as $cuenta)
        <tr>
            <td>0196</td>
            <td>
               {{ $total = ($cuenta->apor_ahorro + $cuenta->apor_presta + $cuenta->seguro) *100 }}
            </td>
            <td>{{ $cuenta->ncuenta }}</td>
            <td>{{ $cuenta->cedula }}</td>
            <td>00000</td>
            <td>100</td>
            
      </tr>
    @endforeach
    </tbody>
</table>

{{-- ->whereNotIn('book_price', [100,200]) --}}