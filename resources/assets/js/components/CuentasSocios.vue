<template>
    <section class="content">
        <div class="callout callout-info">
            <div class="row">
                <div class="col-sm-3">
                  <!-- text input -->
                  <div class="form-group">
                    <input type="text" class="form-control is-info" v-model="cedula" @keyup.enter="buscarCuenta(cedula)" maxlength="8" placeholder="Ingrese Cedula" >
                  </div>
                </div> 
            </div>
        </div>
        <div class="callout callout-info">
              <div class="row invoice-info">
                  <div class="col-sm-3 invoice-col">
                    <strong>Nombre Del Socio</strong>
                    <address>
                      <p>{{ nombres }}</p>
                    </address>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 invoice-col">
                       <strong>Nomina</strong>
                    <address>
                      <p>{{ nomina }}</p>
                    </address>
                  </div>
                  <div class="col-sm-3 invoice-col">
                       <strong>Banco</strong>
                    <address>
                      <p>{{ banco }}</p>
                    </address>
                  </div>
                  <div class="col-sm-3 invoice-col">
                       <strong>Número Cuenta</strong>
                    <address>
                      <p>{{ ncuenta }}</p>
                    </address>
                  </div>
              </div>
        </div>
        
     </section>
</template>

<script>

    import axios from 'axios'
    
    export default {
        data() {
            return {
                arrayCuentas: [],
                cedula: '',
                nombres: '',
                nomina: '',
                banco: '',
                ncuenta: '',
            }
        },
            methods: {
            buscarCuenta(cedula){
                  let me=this;
                  var url= 'cuentas-socio?cedula=' + me.cedula;

                  axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayCuentas = respuesta.cuentas;

                    if (me.arrayCuentas.length>0){
                        me.nombres = me.arrayCuentas[0]['nombres'];
                        me.nomina = me.arrayCuentas[0]['nomina'];
                        me.banco = me.arrayCuentas[0]['banco'];
                        me.ncuenta = me.arrayCuentas[0]['ncuenta'];
                    }
                    else{
                        if (cedula > 0 ) {
                            swal("Socio No se encuentra registrado o no tiene cuenta asociada");

                            me.nombres='';
                            me.nomina='';
                            me.banco='';
                            me.ncuenta='';
                        }
                       
                    }
                  })
                  .catch(function (error) {
                    console.log(error);
                  });
                },
                
            },
        mounted() {
            this.buscarCuenta(this.cedula);
        }
    }
</script>
