<template>
  <section class="content">
      <div class="callout callout-info">
          <div class="row">
              <div class="col-sm-3">
                <!-- text input -->
                <div class="form-group">
                  <input type="text" class="form-control is-info" v-model="cedula" @keyup.enter="buscarCedula(cedula)" maxlength="8" placeholder="Ingrese Cedula" >
                </div>
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
                          <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-xl">Historico</button> |
                          <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#calculo" disabled>Calculo</button> |
                          <div v-if="condicion">
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
                        <th>Patronal</th>
                        <th>Socio</th>
                        <th>Prestamo</th>
                        <th>Seguro</th>
                        <th>Mes</th>
                        <th>Año</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="socio in arraySocio">
                          <td v-text="formatPrice(Number(socio.apor_ahorro))"></td>
                          <td v-text="formatPrice(Number(socio.apor_ahorro))"></td>
                          <td v-text="formatPrice(Number(socio.apor_presta))"></td>
                          <td v-text="formatPrice(Number(socio.seguro))"></td>
                          <td v-text="socio.mes"></td>
                          <td v-text="socio.ano"></td>
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
                  <h3 class="card-title">Estado de cuenta Socio</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:50%">Ahorro:</th>
                        <td>{{ formatPrice(Number(ahorro * 2)) }}</td>
                      </tr>
                      <tr>
                        <th>80%:</th>
                        <td>{{ formatPrice(Number(descuento=((ahorro*2)*0.80).toFixed(2))) }}</td>
                      </tr>
                      <tr>
                        <th>Prestamo:</th>
                        <td> {{ prestamos }} </td>
                      </tr>
                      <tr>
                        <tr>
                        <th>Deuda Restante:</th>
                        <td> {{ prestamos - monto_pag }} </td>
                      </tr>
                        <th>Seguro:</th>
                        <td>{{ formatPrice(Number(seguro)) }}</td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="modal-xl">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Historico</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title"></h3>

                    <div class="card-tools">
                      <ul class="pagination">
                              <li class="page-item" v-if="pagination.current_page > 1">
                                  <a class="page-link" href="#" @click.prevent = "cambiarPagina(pagination.current_page - 1,cedula)">Ant</a>
                              </li>
                              <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                  <a class="page-link" href="#"  @click.prevent="cambiarPagina(page,cedula)" v-text="page"></a>
                              </li>
                              <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                  <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,cedula)">Sig</a>
                              </li>
                          </ul>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body p-0">
                    <table class="table">
                      <thead>
                      <tr>
                        <th>Patronal</th>
                        <th>Socio</th>
                        <th>Prestamo</th>
                        <th>Seguro</th>
                        <th>Mes</th>
                        <th>Año</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="historico in arrayhistorico">
                          <td v-text="historico.apor_ahorro"></td>
                          <td v-text="historico.apor_ahorro"></td>
                          <td v-text="historico.apor_presta"></td>
                          <td v-text="historico.seguro"></td>
                          <td v-text="historico.mes"></td>
                          <td v-text="historico.ano"></td>
                      </tr>
                    </tbody>
                    </table>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

      -------------------------

      <div class="modal fade" id="calculo">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Calculo de Prestamos</h4> <div class="col-sm-2">
                           <input type="text" class="form-control is-info" v-model="cedula">
                        </div>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="col-md-12">
                <div class="card">
                  <div class="container">
                      <div class="row">
                        <div class="col-sm-3">
                          <!-- select -->
                          <div class="form-group">
                            <label>MES DESDE</label>
                            <select class="form-control" v-model="dmes">
                              <option value="">SELECCIONE MES</option>
                              <option value="1">ENERO</option>
                              <option value="2">FEBRERO</option>
                              <option value="3">MARZO</option>
                              <option value="4">ABRIL</option>
                              <option value="5">MAYO</option>
                              <option value="6">JUNIO</option>
                              <option value="7">JULIO</option>
                              <option value="8">AGOSTO</option>
                              <option value="9">SEPTIEMBRE</option>
                              <option value="10">OCTUBRE</option>
                              <option value="11">NOVIEMBRE</option>
                              <option value="12">DICIEMBRE</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-2">
                          <!-- select -->
                          <div class="form-group">
                            <label>AÑO DESDE</label>
                            <select class="form-control" v-model="dano">
                              <option value="2020">2020</option>
                              <option value="2021">2021</option>
                              <option value="2022">2022</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-3">
                        <!-- select -->
                          <label>MES HASTA</label>
                          <div class="form-group">
                            <select class="form-control" v-model="hmes">
                                <option value="">SELECCIONE MES</option>
                                <option value="1">ENERO</option>
                                <option value="2">FEBRERO</option>
                                <option value="3">MARZO</option>
                                <option value="4">ABRIL</option>
                                <option value="5">MAYO</option>
                                <option value="6">JUNIO</option>
                                <option value="7">JULIO</option>
                                <option value="8">AGOSTO</option>
                                <option value="9">SEPTIEMBRE</option>
                                <option value="10">OCTUBRE</option>
                                <option value="11">NOVIEMBRE</option>
                                <option value="12">DICIEMBRE</option>
                            </select>
                          </div>
                        </div>

                        <div class="col-sm-2">
                          <!-- select -->
                          <label>AÑO HASTA</label>
                            <select class="form-control" v-model="hano">
                              <option value="2020">2020</option>
                              <option value="2021">2021</option>
                              <option value="2022">2022</option>
                            </select>
                        </div>
                        <div class="col-sm-2">
                          <!-- select -->
                          <label>MONTO PAGADO</label>
                           <input type="text" class="form-control is-info" readonly v-model="total">
                        </div>
                      </div>
                    </div>
                </div>
                <!-- /.card -->
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">cerrar</button>
               <button type="button" class="btn btn-info" @click="calcularprestamos(cedula,dmes,dano,hmes,hano)" >Calcular</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
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

export default {
  data() {
      return {
          arraysocio: [],
          arraySocio: [],
          arraycalcular: [],
          arrayhistorico: [],
          arraycalcularprestamos: [],
          cedula : '',
          nombres : '',
          nomina : '',
          seguro : '',
          ahorro : '',
          prestamos : '',
          condicion: '',
          dmes : '',
          dano : '',
          hmes : '',
          hano : '',
          total : '',
          monto_pag : '',
          pagination: {
          'total' : 0,
          'current_page' : 0,
          'per_page' : 0,
          'last_page' : 0,
          'from' : 0,
          'to' : 0,
          },
          offset : 12,
      }
  },

  computed:{
      isActived: function(){
          return this.pagination.current_page;
      },
      //Calcula los elementos de la pagination
      pagesNumber: function() {
          if(!this.pagination.to){
              return [];
          }

          var from = this.pagination.current_page - this.offset;
          if(from < 1){
              from = 1;
          }

          var to = from + (this.offset * 2);
          if(to >= this.pagination.last_page){
              to = this.pagination.last_page;
          }

          var pagesArray = [];
          while(from <= to) {
              pagesArray.push(from);
              from++;
          }
          return pagesArray;
      }
  },

  methods: {
    mensaje(){
        alert("Ahora se puede identificar si el socio esta activo o no");
    },
    buscarCedula(cedula){
      let me=this;
      var url= 'estado-socio?cedula=' + me.cedula;

      axios.get(url).then(function (response){
        var respuesta = response.data;
        me.arraysocio = respuesta.socio;

        if (me.arraysocio.length>0){
            me.nombres = me.arraysocio[0]['nombres'];
            me.nomina = me.arraysocio[0]['nomina'];
            me.condicion = me.arraysocio[0]['condicion'];
        }
        else{
          if (cedula > 0 ) {
              swal("Socio No se encuentra registrado");

              me.nombres='';
              me.nomina='';
          }
        }
      })
      .catch(function (error) {
        console.log(error);
      });
      this.listarSocio(this.cedula);
      this.sumassocio(this.cedula);
      this.listaHistorico (1,this.cedula);
    },
    formatPrice(value) {
      let val = (value/1).toFixed(2).replace('.', ',')
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
    },
    listarSocio (cedula){
        let me=this;
        var url= 'est-socio?cedula='+ me.cedula;
        axios.get(url).then(response => {

            var respuesta = response.data;
            me.arraySocio = respuesta.socioslista.data;

          })
          .catch(function (error) {
            console.log(error);
          });
     },
     calcularprestamos (cedula,dmes,dano,hmes,hano){

      let me=this;
      var url= 'calculo-prestamos?cedula=' + me.cedula + '&dmes=' + me.dmes + '&dano=' + me.dano + '&hmes=' + me.hmes + '&hano=' + me.hano;

      axios.get(url).then(function (response){
        var respuesta = response.data;
        me.arraycalcularprestamos = respuesta.totalp;
        //console.log(arraycalcularprestamos)

        if (me.arraycalcularprestamos.length>0){
            me.total = me.arraycalcularprestamos[0]['total'];
        }
        else{
          if (total > 0 ) {
           swal("Socio No se encuentra con deuda");
            me.total='';
          }
        }
      })
      .catch(function (error) {
        console.log(error);
      });

      },
      sumassocio (cedula){
        let me=this;
      var url= 'suma-socio?cedula=' + me.cedula;

      axios.get(url).then(function (response){
        var respuesta = response.data;
        me.arraycalcular = respuesta.calcularsocio;

        if (me.arraycalcular.length>0){
            me.ahorro = me.arraycalcular[0]['ahorro'];
            me.prestamos = me.arraycalcular[0]['prestamos'];
            me.monto_pag = me.arraycalcular[0]['monto_pag'];
            me.seguro = me.arraycalcular[0]['seguro'];
        }
        else{
          if (cedula > 0 ) {
            swal("Socio No se encuentra registrado");
            me.nombres='';
            me.nomina='';

          }
        }
      })
      .catch(function (error) {
        console.log(error);
      });
     },
     listaHistorico (page,cedula){
        let me=this;
        var url= 'lista-historico?page=' + page + '&cedula=' + me.cedula ;
        axios.get(url).then(response => {

            var respuesta = response.data;
            me.arrayhistorico = respuesta.historico.data;
            me.pagination = respuesta.pagination;
            //console.log(respuesta.calcular);

          })
          .catch(function (error) {
            console.log(error);
          });
     },
     cambiarPagina(page,cedula){
        let me = this;
        //Actualiza la Pagina Actual
        me.pagination.current_page = page;
        //Enviar la peticion para visualizar la data de esa pagina
        me.listaHistorico(page,cedula);
    }
  },

  mounted() {
    this.mensaje();
    this.buscarCedula(this.cedula);
    this.listarSocio(this.cedula);
    this.sumassocio(this.cedula);
    this.listaHistorico (1,this.cedula);
  }
}
</script>
