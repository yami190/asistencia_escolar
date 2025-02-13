<template>
  <section class="content">
      <div class="callout callout-info">
          <div class="row">
              <div class="col-sm-3">
                <!-- text input -->
                <div class="form-group">
                  <input type="text" class="form-control is-info" v-model="cedula" @keyup.enter="listarSocio(cedula)" maxlength="8" placeholder="Ingrese Cedula" >
                </div>
              </div>
              <div class="col-sm-2">
                <!-- text input -->
                <div class="form-group">
                  <input type="text" class="form-control is-info" v-model="montop"  placeholder="0.00" >
                </div>
              </div>
              <div class="col-sm-2">
                <!-- text input -->
                <div class="form-group">
                  <input type="text" class="form-control is-info" v-model="referencia"  placeholder="Referencia" >
                </div>
              </div>
              <div class="col-sm-2">
                <!-- text input -->
                <div class="form-group">
                  <input type="date" class="form-control is-info" v-model="fecha" >
                </div>
              </div>
              <div class="col-sm-3">
                <button type="button" class="btn btn-info btn-flat" data-toggle="modal" @click="guardarCuotas()">Guardar</button>
              </div>
              
              
              
          </div>
         
      </div>
      <br>
      <div class="callout callout-info">
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
              <strong>Nombre Del Socio</strong>
              <address>
                <p>{{ nombres }}</p>
              </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                 <strong>Nomina</strong>
              <address>
                <p>{{ nomina }}</p>
              </address>
            </div>
        </div>
        <div class="row invoice-info">
          <div class="col-sm-6 invoice-col">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Movimientos</h3>
                  <div class="card-tools">
                      <div class="input-group input-group-sm">
                        <span class="input-group-append">
                          <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-xl">Pagado</button> |
                          <div v-if="estatus">
                            <span class="badge badge-success">Activo</span>
                          </div>
                          <div v-else>
                            <span class="badge badge-danger">Inactivo</span>
                          </div>
                        </span>
                      </div>

                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Monto</th>
                        <th>Referencia</th>
                        <th>Fecha de Pago</th>
                        <th>Accion</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="cuotas in arrayCuotas">
                        <td v-text="cuotas.id_cuota"></td>
                          <td v-text="formatPrice(Number(cuotas.montop))"></td>
                          <td v-text="cuotas.referencia"></td>
                          <td v-text="cuotas.fecha"></td>
                          <td><button type="button" class="btn btn-info btn-flat" @click="eliminarcuota(cuotas.id_cuota)">eliminar</button></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
          </div>
          <div class="col-sm-6 invoice-col">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Solvencia de Pago</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:50%">prestamo:</th>
                        <!-- <td>{{ formatPrice(Number(ahorro * 2)) }}</td> -->
                        <td>{{ formatPrice(prestamo) }}</td>
                      </tr>
                      <tr>
                        <th>Fecha</th>
                        <td>{{ fechad }}</td>
                      </tr>
                      <tr>
                        <tr>
                        <th>Debe:</th>
                        <td> {{ formatPrice(prestamo - pago) }} </td>
                        </tr>
                        <tr>
                        <th>Haber:</th>
                        <td> {{ formatPrice(pago) }} </td>
                        </tr>
                        <tr>
                          <th>Estatus:</th>
                          <td :class="{ 
                            'text-success': estatus === true, 
                            'text-danger': estatus === false,
                            'text-muted': estatus === null
                          }">
                          {{ estatus }}
                            <!-- {{ estatus === true ? 'Activo' : estatus === false ? 'Inactivo' : '' }} -->
                          </td>
                        </tr> 
                    </table>
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
          </div>
        </div>
      </div>


      <!-- /.modal -->
      <!-- finales -->
      </div>
      </div>
      </div>
  </section>
</template>

<script>

import axios from 'axios'
import Swal from 'sweetalert2';
export default {
  data() {
      return {
          arrayCuotas: [],
          arraypresta: [],
          cedula : '',
          prestamo : '',
          pago : '',
          fecha : '',
          estatus : '',
          fechad : '',
          nombres : '',
          nomina : '',
          prestamos : '',
          montop : '',
          referencia : '',
          id_cuota : '',
        
          
      }
  },
  methods: {
  
    formatPrice(value) {
      let val = (value/1).toFixed(2).replace('.', ',')
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
    },
    listarSocio (cedula){
        let me=this;
        var url= 'buscar-presta?cedula='+ me.cedula;
        axios.get(url).then(response => {

            var respuesta = response.data;
            me.arrayCuotas = respuesta.cuotas;
           

          })
          .catch(function (error) {
            console.log(error);
          });
          this.gprestamo(this.cedula);
     },
     guardarCuotas(){
        var url = 'aperturarPresta';
        axios.post(url, {
              cedula: this.cedula,
              montop: this.montop,
              referencia: this.referencia,
              fecha: this.fecha,
        }).then(response => {
            this.listarSocio(this.cedula);
          // this.listarPrestatemp();
              this.cedula='';
              this.montop='',
              this.referencia= '',
              this.fecha='';
            swal({
                title: "!Mensaje del sistema!",
                text: "El proceso fue ejecutado con exito!",
                icon: "success",
              });
            }).catch((error) => {
                let mensaje = error//'Error indefinido';
                    let err=error.response.data.errors;

                    if (err.hasOwnProperty('cedula')) {
                        mensaje  =  err.cedula[0];
                    }else if (err.hasOwnProperty('montop')) {
                        mensaje  =  err.montop[0];
                    }else if (err.hasOwnProperty('referencia')) {
                        mensaje  =  err.referencia[0];
                    }
                    else if (err.hasOwnProperty('fecha')) {
                        mensaje  =  err.fecha[0];
                    }
                    swal ( "Oops" ,  mensaje ,  "error" )
            });
    },
            
      gprestamo (cedula){
        let me=this;
        var url= 'prestamos?cedula=' + me.cedula;

        axios.get(url).then(function (response){
          var respuesta = response.data;
          me.arraypresta = respuesta.prestamos;

          if (me.arraypresta.length>0){
              me.nombres = me.arraypresta[0]['nombres'];
              me.nomina = me.arraypresta[0]['nomina'];
              me.prestamo = me.arraypresta[0]['prestamo'];
              me.prestamo = me.arraypresta[0]['prestamo'];
              me.pago = me.arraypresta[0]['pago'];
              me.estatus = me.arraypresta[0]['estatus'];
              me.fechad = me.arraypresta[0]['fechad'];
          }
          else{
            if (cedula > 0 ) {
              swal("Socio no posee prestamo activo");
              me.nombres ='';
              me.nomina ='';
              me.prestamo='';
              me.estatus='';
              me.fechad='';

            }
          }
        })
      .catch(function (error) {
        console.log(error);
      });
    },

    eliminarcuota(id_cuota){
      Swal.fire({
        title: "¿Estas seguro?",
        text: "¡No podrás revertir esto!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "¡Sí, bórralo!"
      }).then((result) => {
        if (result.isConfirmed) {
          let me = this;

            axios.put('eliminarCuota',{
                'id_cuota': id_cuota
            }).then(response => {
              me.listarSocio(this.cedula);
              
                Swal.fire({
                  title: "¡Eliminado!",
                  text: "Tu archivo ha sido eliminado.",
                  icon: "success"
                });
              }).catch(function (error) {
                        console.log(error);
            });
        }
      });
    },
    
   
  },

  mounted() {
    this.listarSocio(this.cedula);
  }
}
</script>
