<template>
  
    <div class="container">
        
        <div class="col-md-12 col-lg-12 mb-12">
            <div class="card">
            <div class="card-body fondo-verde-manzana">
                <h5 class="card-title">Reportes</h5>
            </div>
            </div>
        </div>
        <br>
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 mb-12 mb-xl-12">
                        <div class="demo-inline-spacing mt-3">
                            <div class="list-group">
                                <div class="row">
                                    <h5 class="card-title">Reporte de Alumnos</h5>
                                    <div class="col-sm-3">
                                        <label for="exampleFormControlSelect1" class="form-label">Matrícula</label>
                                        <select class="form-select" v-model="id_aula"  aria-label="Default select example">
                                            <option v-for="a in arrayAulas" :key="a.id_aula" :value="a.id_aula">{{ a.nombres }}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="exampleFormControlSelect1" class="form-label">Fecha</label>
                                        <input type="date" id="fecha" class="form-control" v-model="fecha" autocomplete="off"/>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="exampleFormControlSelect1" class="form-label"></label>
                                        
                                        <input type="submit"  class="form-control btn rounded-pill btn-outline-success" value="Reporte" @click="generarpdf()">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>        
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 mb-12 mb-xl-12">
                        <div class="demo-inline-spacing mt-3">
                            <div class="list-group">
                                <div class="row">
                                    <h5 class="card-title">Reporte del Presonal</h5>
                                    <div class="col-sm-3">
                                        <label for="exampleFormControlSelect1" class="form-label">Fecha</label>
                                        <input type="date" id="fecha" class="form-control" v-model="fechap" autocomplete="off"/>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="exampleFormControlSelect1" class="form-label"></label>
                                        
                                        <input type="submit"  class="form-control btn rounded-pill btn-outline-success" value="Reporte" @click="generarpersonalpdf()">
                                    </div>
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
              arrayAlumnos: [],
              isLoad: false,
              id_aula:'',
              fecha:'',
              fechap:'',
              arrayAulas : [],
          }
      },
      
        created: function(){
            this.selectAula();

              
          },
          methods: {
          
            selectAula (){
                let me=this;
                var url= 'aula';
                axios.get(url).then(response => {
                    console.log(response);
                    var respuesta = response.data;
                    me.arrayAulas = respuesta.aulas;
                        me.id_aula = me.arrayAulas[0]['id_aula'];
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            generarpdf() {
                if (!this.id_aula || !this.fecha) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Por favor, seleccione un aula y una fecha.",
                        });
                    return;
                }

                // Crear un enlace dinámico para descargar el PDF
                let url = `reporte/pdf?id_aula=${this.id_aula}&fecha=${this.fecha}`;
                window.open(url, "_blank"); // Abre el PDF en una nueva pestaña
            },

            generarpersonalpdf() {
                if (!this.fechap) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Por favor, seleccione una fecha.",
                        });

                    return;
                }

                // Crear un enlace dinámico para descargar el PDF
                let url = `reporteperdonal?fecha=${this.fechap}`;
                window.open(url, "_blank"); // Abre el PDF en una nueva pestaña
            }
                
               
            
       }
       
  }
    </script>
      <style>
      .fondo-verde-manzana {
          background-color: #e3f8d7 !important;
      }
      </style>