<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                  <div class="card-header">Nominas por grupos</div>
                  <div class="card-body">
                    <div class="container">
                      <div class="row">
                        <div class="col-sm-3">
                          <!-- select -->
                          <div class="form-group">
                            <label>DESDE</label>
                            <select class="form-control" v-model="gmes">
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
                        <div class="col-sm-3">
                        <!-- select -->
                          <label>HASTA</label>
                          <div class="form-group">
                            <select class="form-control" v-model="gmes2">
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
                        <div class="col-sm-3">
                          <!-- select -->
                          <div class="form-group">
                            <label>AÑO</label>
                            <select class="form-control" v-model="gano">
                              <option value="2020">2020</option>
                              <option value="2021">2021</option>
                              <option value="2022">2022</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-3">
                          <!-- select -->
                          <div class="form-group">
                            <label>GRUPO</label>
                            <select class="form-control" v-model="gremio">
                              <option value="1">GOBERNACIÓN</option>
                              <option value="3">SALUD</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-3">
                        <!-- select -->
                          <div class="form-group">
                              <button type="submit" @click="reportesbalances(gmes,gmes2,gremio,gano)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                          </div>
                        </div>
                      </div>
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th>Socios</th>
                            <th>Aporte Socio</th>
                            <th>Aporte Patronal</th>
                            <th>Prestamos</th>
                            <th>Seguro</th>
                            <th>Mes</th>
                            <th>Año</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="balance in arraybalance" >
                            <td v-text="balance.filas"></td>
                            <td v-text="balance.ahorro"></td>
                            <td v-text="balance.ahorro"></td>
                            <td v-text="balance.prestamos"></td>
                            <td v-text="balance.seguro"></td>
                            <td v-text="balance.mes"></td>
                            <td v-text="balance.ano"></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                 <div class="card">
                    <div class="card-header">Nominas por Gremios salud</div>
                    <div class="card-body">
                      <div class="container">
                        <div class="row">
                          <div class="col-sm-3">
                            <!-- select -->
                            <div class="form-group">
                              <label>DESDE</label>
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
                          <div class="col-sm-3">
                            <!-- select -->
                            <div class="form-group">
                              <label>HASTA</label>
                              <select class="form-control" v-model="mes2">
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
                          <div class="col-sm-3">
                          <!-- select -->
                          <div class="form-group">
                            <label>AÑO</label>
                            <select class="form-control" v-model="ano">
                              <option value="2019">2019</option>
                              <option value="2020">2020</option>
                              <option value="2021">2021</option>
                              <option value="2022">2022</option>
                            </select>
                          </div>
                        </div>
                          <div class="col-sm-3">
                            <!-- select -->
                            <div class="form-group">
                              <label>GREMIO</label>
                              <select class="form-control" v-model="sud_gremio">
                                <option value="1">MPPS</option>
                                <option value="2">ISP</option>
                                <option value="3">GOBERNACIÓN</option>
                                <option value="4">OBRE. SERVI. GENERALES</option>
                                <option value="5">OBRE. EDUCACIÓN</option>
                                <option value="6">POLICÍAS</option>
                                <option value="7">JUB. POLICIA</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <!-- select -->
                            <div class="form-group">
                              <button type="submit" @click="reportesbalancessudgremio(mes,mes2,sud_gremio,ano)" class="btn btn-primary form-group"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                          </div>
                        </div>
                        <table class="table table-bordered">
                          <thead>
                            <tr>
                              <th>Socio</th>
                              <th>Aporte Socio</th>
                              <th>Aporte Patronal</th>
                              <th>Prestamos</th>
                              <th>Seguro</th>
                              <th>Mes</th>
                              <th>Año</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="balance in arraybalancesud" >
                              <td v-text="balance.filas"></td>
                              <td v-text="balance.ahorro"></td>
                              <td v-text="balance.ahorro"></td>
                              <td > {{ prestamos = balance.prestamos}}</td>
                              <td v-text="balance.seguro"></td>
                              <td v-text="balance.mes"></td>
                              <td v-text="balance.ano"></td>
                              <!-- <td>{{  total=( balance.ahorro*2 )+(balance.prestamos).toFixed(2) }} </td> -->
                            </tr>
                          </tbody>
                        </table>
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
                arraybalance: [],
                gmes : '',
                gmes2 : '',
                gano : '',
                gremio: '',
                arraybalancesud: [],
                arraycompare: [],
                mes : '',
                mes2 : '',
                ano : '',
                sud_gremio: '',

            }
        },
          created: function(){
                this.reportesbalances(gmes,gmes2,gremio,gano);
                this.reportesbalancessudgremio(mes,mes2,sud_gremio,ano);
                this.reportesbalancescompare(mes,mes2,sud_gremio,ano);
            },
            methods: {
                 reportesbalances (gmes,gmes2,gremio,gano){
                let me=this;
                var url= 'balance-porrango?gmes=' + gmes + '&gmes2=' + gmes2 + '&gremio=' + gremio + '&gano=' + gano;
                axios.get(url).then(response => {

                    var respuesta = response.data;
                    me.arraybalance = respuesta.balance;
                    //console.log(respuesta.balance);

                  })
                  .catch(function (error) {
                    console.log(error);
                  });
            },

             reportesbalancessudgremio (mes,mes2,sud_gremio,ano){
                let me=this;
                var url= 'balance-porrangosud?mes=' + mes + '&mes2=' + mes2 + '&sud_gremio=' + sud_gremio + '&ano=' + ano;
                axios.get(url).then(response => {

                    var respuesta = response.data;
                    me.arraybalancesud = respuesta.balancedos;
                    //console.log(respuesta.balancedos);

                  })
                  .catch(function (error) {
                    console.log(error);
                  });
            },
             reportesbalancescompare (mes,mes2,sud_gremio,ano){
                let me=this;
                var url= 'balance-compare?mes=' + mes + '&mes2=' + mes2 + '&sud_gremio=' + sud_gremio + '&ano=' + ano;
                axios.get(url).then(response => {

                    var respuesta = response.data;
                    me.arraycompare = respuesta.compare;
                    //console.log(respuesta.balancedos);

                  })
                  .catch(function (error) {
                    console.log(error);
                  });
            },
                }
            }

</script>
