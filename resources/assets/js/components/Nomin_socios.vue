<template>
    <div class="container">
        <div class="callout callout-info">
            <div class="row">
                <div class="col-sm-3">
                  <!-- text input -->
                  <div class="form-group">
                    <p>Actualizar Nomina</p>
                  </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                      <select class="form-control" v-model="ncuenta">
                        <option value="">SELECCIONE BANCO</option>
                        <option value="0128">BANCO CARONI</option>
                        <option value="0175">BANCO BICENTENARIO</option>
                        <option value="0102">BANCO DE VENEZUELA</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <select class="form-control" v-model="mes">
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
                  <div class="col-md-3">
                    <div class="form-group">
                      <button type="button" class="btn btn-info" @click="eportnomina(ncuenta, mes)">Exportar</button>
                    </div>
                  </div> 
            </div>
        </div>
        <div class="callout callout-info">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header">
                      <div class="row">
                        <div class="col-md-4 col-sm-6 col-12">
                          <div class="info-box bg-info">
                            <span class="info-box-icon"><i class="far fa-bookmark"></i></span>

                            <div class="info-box-content">
                              <span class="info-box-text">Banco Bicentenario</span>
                              <tr v-for="bicentenario in arrayBicentenario">
                              <span class="info-box-number">Socio {{ formatPrice(bicentenario.ahorro) }}</span>
                              <span class="info-box-number">Prestamos {{ formatPrice(bicentenario.prestamos) }}</span>
                              <span class="info-box-number">Seguro {{ formatPrice(bicentenario.seguro) }}</span>
                              <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                              </div>
                              <span class="progress-description">
                                Total {{ formatPrice(Number(bicentenario.ahorro) + Number(bicentenario.prestamos) + Number(bicentenario.seguro)) }}
                              </span>
                              </tr>
                            </div>
                            <!-- /.info-box-content -->
                          </div>
                          <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4 col-sm-6 col-12">
                          <div class="info-box bg-info">
                            <span class="info-box-icon"><i class="far fa-bookmark"></i></span>

                            <div class="info-box-content">
                              <span class="info-box-text">Banco Caroni</span>
                              <tr v-for="caroni in arrayCaroni">
                              <span class="info-box-number">Socio {{ formatPrice(caroni.ahorro) }}</span>
                              <span class="info-box-number">Prestamos {{ formatPrice(caroni.prestamos) }}</span>
                              <span class="info-box-number">Seguro {{ formatPrice(caroni.seguro) }}</span>
                              <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                              </div>
                              <span class="progress-description">
                                Total {{ formatPrice(Number(caroni.ahorro) + Number(caroni.prestamos) + Number(caroni.seguro)) }}
                              </span>
                              </tr>
                            </div>
                            <!-- /.info-box-content -->
                          </div>
                          <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4 col-sm-6 col-12">
                          <div class="info-box bg-info">
                            <span class="info-box-icon"><i class="far fa-bookmark"></i></span>

                            <div class="info-box-content">
                              <span class="info-box-text">Banco de Venezuela</span>
                              <tr v-for="venezuela in arrayVenezuela">
                              <span class="info-box-number">Socio {{ formatPrice(venezuela.ahorro) }}</span>
                              <span class="info-box-number">Prestamos {{ formatPrice(venezuela.prestamos) }}</span>
                              <span class="info-box-number">Seguro {{ formatPrice(venezuela.seguro) }}</span>
                              <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                              </div>
                              <span class="progress-description">
                                Total {{ formatPrice(Number(venezuela.ahorro) + Number(venezuela.prestamos) + Number(venezuela.seguro)) }}
                              </span>
                              </tr>
                            </div>
                            <!-- /.info-box-content -->
                          </div>
                          <!-- /.info-box -->
                        </div>
                      </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      <table class="table table-bordered">
                        <thead>                  
                          <tr>
                            <th style="width: 10px">Cedula</th>
                            <th>Nombres</th>
                            <th>codigo</th>
                            <th>Banco</th>
                            <th>Nro Cuenta</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="socio in arraysociolis">
                            <td>{{ socio.cedula }}</td>
                            <td>{{ socio.nombres }}</td>
                            <td>{{ socio.codigo }}</td>
                            <!-- <td>{{ sumPrecios(socio.details) }}</td> -->
                             <td>{{   formatPrice(Number(socio.apor_ahorro) + Number(socio.apor_presta) + Number(socio.seguro)) }} </td>
                            <td>{{ socio.ncuenta }}</td>
                          </tr>
                        </tbody>
                      </table> 
                    </div>
                  </div>
                </div>
              </div>
            </div> 
          </div>
        </div>
    </div>
</template>

<script>

    import axios from 'axios'
    
    export default {
        data() {
            return {
                arraysociolis: [],
                arrayBicentenario: [],
                arrayCaroni: [],
                arrayVenezuela: [],
                ncuenta:'',
                mes:'',
            }
        },
          created: function(){
                this.listarSocio();
                this.BancoBicentenario();
                this.BancoCaroni();
                this.BancoVenezuela();
            },

          
            methods: {
                BancoBicentenario (){
                  let me=this;
                  var url= 'Banco-Bicentenario';
                  axios.get(url).then(response => {

                      var respuesta = response.data;
                      me.arrayBicentenario = respuesta.bicentenario;
                      //console.log(respuesta.bicentenario);

                    })
                    .catch(function (error) {
                      console.log(error);
                    });
                },
                BancoCaroni (){
                  let me=this;
                  var url= 'Banco-Caroni';
                  axios.get(url).then(response => {

                      var respuesta = response.data;
                      me.arrayCaroni = respuesta.caroni;
                      //console.log(respuesta.bicentenario);

                    })
                    .catch(function (error) {
                      console.log(error);
                    });
                },
                BancoVenezuela (){
                  let me=this;
                  var url= 'Banco-Venezuela';
                  axios.get(url).then(response => {

                      var respuesta = response.data;
                      me.arrayVenezuela = respuesta.venezuela;
                      //console.log(respuesta.bicentenario);

                    })
                    .catch(function (error) {
                      console.log(error);
                    });
                },
                listarSocio (){
                    let me=this;
                var url= 'veri-nue-socio';
                axios.get(url).then(response => {
                    
                    var respuesta = response.data;
                    me.arraysociolis = respuesta.cuentasSocios.data;
                    me.pagination = respuesta.pagination; 
                    console.log(respuesta.cuentasSocioscuentasSocios)                   
                  })
                  .catch(function (error) {
                     swal ( "Oops" ,  error.massage ,  "error" )
                  });
             },
             formatPrice(value) {
                let val = (value/1).toFixed(2).replace('.', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            },
            eportnomina(ncuenta, mes){

              swal({
                title: "¿Esta Seguro de procesar la información?",
                text: "Una vez procesada la información no pordra ser revertida",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {
                 location.href ='Expor-nomina-socio?ncuenta=' + ncuenta + '&mes=' + mes;
                   
                  swal("La información Ha sido procesado con exito", {
                    icon: "success",
                  });
                } else {
                  //swal("Your imaginary file is safe!");
                }
              });
            },
            actcodigo(){

              axios.get('act-socio-data', {
                })
                .then(function (response) {
                  console.log(response);
                   this.actcodigo();
                })
                .catch(function (error) {
                  console.log(error);
                });
            },
        }
    }
</script>
