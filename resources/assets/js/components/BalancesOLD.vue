<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                         <div class="container">
                             <div class="row">
                                 <div class="input-group mb-6">
                                  <div class="input-group-prepend">
                                    <label class="input-group-text" for="inputGroupSelect01"></label>
                                  </div>
                                  <select class="custom-select" v-model="mes">
                                    <option selected>Seleccione Mes</option>
                                    <option value="ENERO">ENERO</option>
                                    <option value="FEBRERO">FEBRERO</option>
                                    <option value="MARZO">MARZO</option>
                                    <option value="ABRIL">ABRIL</option>
                                    <option value="MAYO">MAYO</option>
                                    <option value="JUNIO">JUNIO</option>
                                    <option value="JULIO">JULIO</option>
                                    <option value="AGOSTO">AGOSTO</option>
                                    <option value="SEPTIEMBRE">SEPTIEMBRE</option>
                                    <option value="OCTUBRE">OCTUBRE</option>
                                    <option value="NOVIEMBRE">NOVIEMBRE</option>
                                    <option value="DICIEMBRE">DICIEMBRE</option>
                                  </select>
                                </div>

                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <label class="input-group-text" for="inputGroupSelect01"></label>
                                  </div>
                                  <div class="col-sm-6">
                                    <div class="form-group">
                                      <label>Select Disabled</label>
                                      <select class="form-control" disabled>
                                        <option>option 1</option>
                                        <option>option 2</option>
                                        <option>option 3</option>
                                        <option>option 4</option>
                                        <option>option 5</option>
                                      </select>
                                    </div>
                                  </div>
                                  <input type="text" v-model="codigodesde">
                                </div>
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <label class="input-group-text" for="inputGroupSelect02"></label>
                                  </div>
                                  <input type="text" v-model="codigohasta">
                                </div>
                                <button type="submit" @click="reportesbalances(mes,codigodesde,codigohasta)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
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
                arraybalance: [],
                mes : 'SEPTIEMBRE',
                codigodesde: '',
                codigohasta : ''
            }
        },
          created: function(){
                this.reportesbalances(mes,codigodesde,codigohasta);
            },
            methods: {
                 reportesbalances (mes,codigodesde,codigohasta){
                let me=this;
                var url= 'balance-porrango?mes=' + mes + '&codigodesde=' + codigodesde + '&codigohasta=' + codigohasta;
                axios.get(url).then(response => {
                    
                    window.location=url;
                    
                  })
                  .catch(function (error) {
                    console.log(error);
                  });
            },
                }
            }
</script>
