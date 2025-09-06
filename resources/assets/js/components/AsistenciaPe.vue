<template>
  
    <div class="container">
        
        <div class="col-md-12 col-lg-12 mb-12">
            <div class="card">
            <div class="card-body fondo-verde-manzana">
                <h5 class="card-title">Lista de Asistencia</h5>
            </div>
            </div>
        </div>
        <br>
    
        <div class="card">
            <h5 class="card-header">Tabla de Asistencia</h5>
            <div class="table-responsive text-nowrap">
                <table class="table">
                <caption class="ms-4">
                    <!-- falta modificar el rol 4, problemas con este rol no muestra el boton en ningun rol -->
                    <button  type="button"  class="btn rounded-pill btn-success"  @click="enviarAsistencia">Registrar</button>    
                </caption>
                <thead>
                    <tr>                   
                    <th>Cedula Esc.</th>
                    <th>Nombres y Apellidos</th>
                    <th>Cargo</th>
                    <th>Asistencia</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(personal, index) in arrayPersonal" :key="index">
                        <td>{{ personal.cedula }}</td>
                        <td>{{ personal.nombre_apellido }}</td>
                        <td>{{ personal.cargo }}</td>  
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" v-permiso
                                    type="checkbox"
                                    v-model="personal.asistio"
                                    :true-value="true"
                                    :false-value="false"
                                />
                            </div>
                        </td>
                    </tr>
                </tbody>
                </table>
            </div>
        </div>
    
    </div>
  </template>
  
  <script>
    
    import axios from 'axios'
    
  export default {
      data() {
          return {
              arrayPersonal: [],
              isLoad: false,
              id_personal:'',
              asistio : '',

          }
      },
      
        created: function(){
            this.cargarpersonal();

              
          },
          methods: {
           
            cargarpersonal() {
              
                axios.get('asispersonal')
                    .then(response => {
                        console.log('Respuesta del backend:', response.data);
                        this.$set(this, 'arrayPersonal', response.data.personal);
                    })
                    .catch(error => {
                        console.error('Error al cargar el personal:', error);
                    });

                },
                
                enviarAsistencia() {
                        console.log('Datos de Personal:', this.arrayPersonal);

                        const asistenciaData = this.arrayPersonal.map(personal => ({
                            id_personal: personal.id_personal,
                            asistio: personal.asistio === true,
                        }));

                        console.log('Datos de asistencia a enviar:', asistenciaData);

                        Swal.fire({
                            title: "¿Estás seguro?",
                            text: "Se enviará la asistencia registrada del personal.",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#4ed571",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Sí, guardar",
                            cancelButtonText: "Cancelar"
                        }).then((result) => {
                            if (result.isConfirmed) {
                            axios.post('GasistenciaP', { asistencia: asistenciaData })
                                .then(response => {
                                console.log('Respuesta del backend:', response.data);
                                Swal.fire({
                                    title: "Guardado!",
                                    text: "La asistencia del personal fue registrada exitosamente.",
                                    icon: "success"
                                });
                                })
                                .catch(error => {
                                console.error('Error al enviar la asistencia:', error);
                                Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    text: "Ocurrió un error al guardar la asistencia del personal.",
                                });
                                });
                            } else {
                            Swal.fire({
                                title: "Cancelado",
                                text: "Los cambios no fueron guardados.",
                                icon: "info"
                            });
                            }
                        });
                        }

            
       }
       
  }
  </script>
  <style>
  .fondo-verde-manzana {
      background-color: #e3f8d7 !important;
  }
  </style>
