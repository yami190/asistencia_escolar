     @extends('principal')
    @section('contenido')
        <template v-if="menu==0">
            <h1> Inicio </h1>
        </template>

         <template v-if="menu==1">
            <movimiento></movimiento>
        </template>

         <template v-if="menu==2">
            <socio></socio>
        </template>

         <template v-if="menu==3">
            <nomina></nomina>
        </template>

         <template v-if="menu==4">
            <cuentas></cuentas>
         </template>

         <template v-if="menu==5">
            <contabilidad></contabilidad>
        </template>

         <template v-if="menu==6">
            <nominacaja></nominacaja>
        </template>

         <template v-if="menu==7">
            <balancesg></balancesg>
        </template>

         <template v-if="menu==8">
            <transferencias></transferencias>
        </template>

         <template v-if="menu==9">
            <movicaja></movicaja>
        </template>

        <template v-if="menu==10">
           9
        </template>

    @endsection