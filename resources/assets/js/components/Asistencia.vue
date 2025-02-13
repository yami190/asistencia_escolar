<template>
  
    <div class="container">
        
        <div class="col-md-12 col-lg-12 mb-12">
            <div class="card">
            <div class="card-body">
                <h5 class="card-title">Lista de Asistencia</h5>
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
                                    <div class="col-sm-3">
                                        <label for="exampleFormControlSelect1" class="form-label">Matrícula</label>
                                        <select class="form-select" v-model="id_aula" @change="cargarAlumnos" aria-label="Default select example">
                                            <option v-for="aula in arrayAula" :key="aula.id_aula" :value="aula.id_aula" > {{ aula.nombres }}</option>
                                        </select>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>        
        </div>
        <div class="card">
            <h5 class="card-header">Tabla de Asistencia</h5>
            <div class="table-responsive text-nowrap">
                <table class="table">
                <caption class="ms-4">
                    <template v-if="id_aula > 0">
                        <button type="button" class="btn rounded-pill btn-success"  @click="enviarAsistencia">Registrar</button>
                    </template>
                    <template v-else>
                        
                    </template>
                    
                </caption>
                <thead>
                    <tr>  
                                        
                    <th>Cedula Esc.</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Sexo</th>
                    <th>Aula</th>
                    <th>Asistencia</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="alumno in arrayAlumnos" :key="alumno.id_alumno">
                        
                        
                    <td>{{ alumno.cedul_esco }}</td>
                    <td>{{ alumno.nombres }}</td>
                    <td>{{ alumno.apellidos }}</td>  
                    <td>{{ alumno.sexo }}</td>
                    <td>{{ alumno.aula }}</td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input"
                                type="checkbox"
                                v-model="alumno.asistio"
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
              arrayAlumnos: [],
              isLoad: false,
              id_aula:'',
              id_alumno:'',
              asistio : '',
              arrayAula : [],
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
                    me.arrayAula = respuesta.aulas;
                        me.id_aula = me.arrayAula[0]['id_aula'];
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cargarAlumnos() {
                if (this.id_aula) {
                    let me = this;
                var url = 'Lalumnos?id_aula=' + this.id_aula;

                axios.get(url)
                    .then(response => {
                        console.log('Respuesta del backend:', response.data); // Verifica la respuesta

                        if (response.data.alumnos && response.data.alumnos.length > 0) {
                            me.arrayAlumnos = response.data.alumnos; // Asignar los alumnos si existen
                        } else {
                            me.arrayAlumnos = []; // Limpiar la lista si no hay alumnos
                            console.error('No se encontraron alumnos en esta aula.');
                            Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "No se encontraron alumnos en esta aula.",
                            footer: ''
                            });
                            //alert('No se encontraron alumnos en esta aula.'); // Mostrar alerta al usuario
                        }
                    })
                    .catch(error => {
                        console.error('Error al cargar los alumnos:', error);
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Por favor, selecciona un aula.",
                        //footer: '<a href="#">Why do I have this issue?</a>'
                        });
                    //alert('Por favor, selecciona un aula.');
                    this.arrayAlumnos = []; // Limpiar la lista si no se selecciona un aula
                }
                
                },
                
                enviarAsistencia() {
                    
                    // Verificar los datos antes de enviarlos
                    console.log('Datos de alumnos:', this.arrayAlumnos);

                    // Preparar los datos para enviar al backend
                    const asistenciaData = this.arrayAlumnos.map(alumno => ({
                        id_alumno: alumno.id_alumno,
                        asistio: alumno.asistio === true, // Forzar a true o false
                    }));

                    // Verificar los datos preparados
                    console.log('Datos de asistencia a enviar:', asistenciaData);
                    Swal.fire({
                    title: "¿Quieres guardar los cambios?",
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Si",
                    denyButtonText: `No`
                    }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        axios.post('Gasistencia', { asistencia: asistenciaData })
                            .then(response => {
                                //this.id_aula = '';
                                this.cargarAlumnos();
                                //this.asistio = '';
                            console.log('Respuesta del backend:', response.data);
                            Swal.fire("Guardado!", "", "success");
                            })
                            
                            .catch(error => {
                            console.error('Error al enviar la asistencia:', error);
                            Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Ocurrió un error al guardar la asistencia.",
                            //footer: '<a href="#">Why do I have this issue?</a>'
                            });
                            //alert('Ocurrió un error al guardar la asistencia.');
                            });
                        
                    } else if (result.isDenied) {
                        Swal.fire("Los cambios no se guardan", "", "info");
                    }
                    });
                    // Enviar los datos al backend usando POST
                    
                    },
            
       }
       
  }
    </script>