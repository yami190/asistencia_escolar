<template>
  
    <div class="container">
        
        <div class="col-md-12 col-lg-12 mb-12">
            <div class="card">
            <div class="card-body">
                <h5 class="card-title">Gestion de Usuario</h5>
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
                                    <h5 class="card-title">Ingrese su Cédula, por favor, para continuar</h5>
                                    <form @submit.prevent="buscarCedula">
                                        <div class="row">
                                        <div class="col-sm-3">
                                            <!-- <label for="cedula" class="form-label">Número de Cédula</label> -->
                                            <input
                                            type="text"
                                            id="cedula"
                                            v-model="cedula"
                                            class="form-control"
                                            required
                                            placeholder="Ingresa tu número de cédula"
                                            autocomplete="off"
                                            >
                                        </div>
                                        <div class="col-sm-3 align-self-end">
                                            <button type="submit" class="btn btn-success">Buscar</button>  
                                        </div>
                                        </div>
                                    </form>
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
                                <div v-if="registrado">
                                    <h5 class="mt-3">Preguntas de Seguridad</h5>
                                    <div class="mb-3">
                                        <label class="form-label">¿En qué ciudad naciste?</label>
                                        <input type="text" v-model="respuesta1" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">¿Cuál es tu comida favorita?</label>
                                        <input type="text" v-model="respuesta2" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">¿En qué mes naciste?</label>
                                        <input type="text" v-model="respuesta3" class="form-control">
                                    </div>
                                    <button @click="validarRespuestas" class="btn btn-success">Validar</button>
                                    </div>
                                <div v-else-if="cedulaBuscada">
                                    <h5 class="mt-3">Registro de Nuevo Usuario</h5>
                                    <div class="row g-2">
                                        <div class="col mb-3">
                                        <label for="nombres" class="form-label">Nombres y Apellidos</label>
                                        <input 
                                            type="text" 
                                            id="nombres" 
                                            class="form-control" 
                                            v-model="nombres"
                                            autocomplete="off" 
                                            @keypress="soloLetras"
                                            @input="validarTexto('nombres')"
                                        />
                                        </div>
                                        <div class="col mb-3">
                                        <label for="cedula" class="form-label">Cédula</label>
                                        <input 
                                            type="text" 
                                            id="cedula" 
                                            class="form-control" 
                                            v-model="cedula" 
                                            autocomplete="off"
                                            @keypress="soloNumeros"
                                            @input="validarNumero('cedula')"
                                        >
                                        </div>
                                        <div class="col mb-3">
                                        <label for="telefono" class="form-label">Teléfono</label>
                                        <input 
                                            type="text" 
                                            id="telefono" 
                                            class="form-control" 
                                            v-model="telefono" 
                                            autocomplete="off"
                                            @keypress="soloNumeros"
                                            @input="validarNumero('telefono')"
                                        />
                                        </div>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col mb-3">
                                        <label for="correo" class="form-label">Correo</label>
                                        <input 
                                            type="email" 
                                            id="correo" 
                                            class="form-control" 
                                            v-model="correo" 
                                            autocomplete="off"
                                        >
                                        </div>
                                        <div class="col mb-3">
                                        <label for="clave" class="form-label">Contraseña</label>
                                        <input 
                                            type="password" 
                                            id="clave" 
                                            class="form-control" 
                                            v-model="clave" 
                                            autocomplete="off"
                                        >
                                        </div>
                                        <div class="col mb-2">
                                        <label for="confirmar_clave" class="form-label">Confirmar Contraseña</label>
                                        <input 
                                            type="password" 
                                            id="confirmar_clave" 
                                            class="form-control" 
                                            v-model="confirmar_clave" 
                                            autocomplete="off"
                                        >
                                        </div>
                                        <div class="row g-2">
                                       
                                        <input 
                                        type="hidden" 
                                        id="id_rol" 
                                        class="form-control" 
                                        v-model="id_rol" 
                                        autocomplete="off"
                                        />
                                    </div>
                                    
                                        <div class="col mb-3">
                                        <label for="respuesta1" class="form-label">¿En qué ciudad naciste?</label>
                                        <input 
                                            type="password" 
                                            id="respuesta1" 
                                            class="form-control" 
                                            v-model="respuesta1" 
                                            autocomplete="off"
                                        >
                                        </div>
                                        <div class="col mb-3">
                                        <label for="respuesta2" class="form-label">¿Cuál es tu comida favorita?</label>
                                        <input 
                                            type="password" 
                                            id="respuesta2" 
                                            class="form-control" 
                                            v-model="respuesta2" 
                                            autocomplete="off"
                                        >
                                        </div>
                                        <div class="col mb-3">
                                        <label for="respuesta3" class="form-label">¿En qué mes naciste?</label>
                                        <input 
                                            type="password" 
                                            id="respuesta3" 
                                            class="form-control" 
                                            v-model="respuesta3" 
                                            autocomplete="off"
                                        >
                                        </div>
                                    </div>
                                    <button class="btn btn-success" @click="registrarUsuario">Registrar</button>
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
export default {
    data() {
        return {
            cedula: "",
            registrado: false,
            cedulaBuscada: false,
            clave: "",
            nombres: "",
            correo: "",
            telefono: "",
            cargo: "PENDIENTE",
            id_rol: "4",
            confirmar_clave: "",
            respuesta1: "",
            respuesta2: "",
            respuesta3: ""
        };
    },
    methods: {
        soloNumeros(event) {
            if (!/[0-9]/.test(event.key)) {
              event.preventDefault();
            }
          },
          validarNumero(campo) {
            this[campo] = this[campo].replace(/\D/g, ""); // Solo números
          },
          soloLetras(event) {
            if (!/^[a-zA-Z\s]+$/.test(event.key)) {
              event.preventDefault();
            }
          },
          validarTexto(campo) {
            this[campo] = this[campo].replace(/[^a-zA-Z\s]/g, ""); // Solo letras
          },
          validarCorreo() {
            const correoRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!correoRegex.test(this.correo)) {
              // Aquí puedes manejar un error si el correo no es válido
              console.log("Correo no válido");
            }
          },
          
        buscarCedula() {
            if (!this.cedula) {
                alert("Por favor ingresa una cédula válida.");
                return;
            }

            axios.post('Bussuario', { cedula: this.cedula })
                .then(response => {
                    if (response.data.existe) {
                        this.registrado = true;
                    } else {
                        this.registrado = false;
                        this.cedulaBuscada = true;
                    }
                })
                .catch(error => {
                    console.error("Error al buscar cédula:", error);
                });
        },
        validarRespuestas() {
            axios.post('validar-respuestas', {
                cedula: this.cedula,
                respuesta1: this.respuesta1,
                respuesta2: this.respuesta2,
                respuesta3: this.respuesta3
            })
            .then(response => {
                if (response.data.validado) {
                    // Si las respuestas son correctas, mostramos el modal de SweetAlert para la nueva contraseña
                    Swal.fire({
                        title: 'Nueva Contraseña',
                        input: 'password',
                        inputLabel: 'Ingresa tu nueva contraseña',
                        inputPlaceholder: 'Nueva contraseña...',
                        showCancelButton: true,
                        confirmButtonText: 'Guardar',
                        cancelButtonText: 'Cancelar',
                        preConfirm: (password) => {
                            if (!password) {
                                Swal.showValidationMessage('Debes ingresar una contraseña');
                            }
                        }
                    }).then((result) => {
                        if (result.isConfirmed && result.value) {
                            // Enviar la nueva contraseña al backend para actualizarla
                            axios.post('actualizar-contraseña', {
                                cedula: this.cedula,
                                nueva_contraseña: result.value
                            })
                            .then(resp => {
                                if (resp.data.actualizado) {
                                    Swal.fire('Contraseña Actualizada', 'Ahora serás redirigido al login.', 'success')
                                    .then(() => {
                                        window.location.href = 'http://localhost/asistencia/public/';
                                    });
                                } else {
                                    Swal.fire('Error', resp.data.mensaje, 'error');
                                }
                            })
                            .catch(error => {
                                console.error("Error al actualizar contraseña:", error);
                                Swal.fire('Error', 'Ocurrió un error al actualizar la contraseña.', 'error');
                            });
                        }
                    });
                } else {
                    Swal.fire('Error', response.data.mensaje, 'error');
                }
            })
            .catch(error => {
                console.error("Error al validar respuestas:", error);
            });
        },
        registrarUsuario() {
            const camposRequeridos = {
        cedula: 'El campo "Cédula" es requerido',
        nombres: 'El campo "Nombres" es requerido',
        telefono: 'El campo "Teléfono" es requerido',
        correo: 'El campo "Correo" es requerido',
        clave: 'El campo "Contraseña" es requerido',
        confirmar_clave: 'El campo "Confirmar Contraseña" es requerido',
        respuesta1: 'El campo "¿En qué ciudad naciste?" es requerido',
        respuesta2: 'El campo "¿Cuál es tu comida favorita?" es requerido',
        respuesta3: 'El campo "¿En qué mes naciste?" es requerido'
      };

      this.msg = '';
      for (const campo in camposRequeridos) {
        if (!this[campo]) {
          this.msg = camposRequeridos[campo];
          break;
        }
      }

      if (this.msg) {
        this.mostrarError(this.msg);
        return;
      }

      // Validar que las contraseñas coincidan
      if (this.clave !== this.confirmar_clave) {
        this.mostrarError('Las contraseñas no coinciden');
        return;
      }

      axios.post('Gusuario', {
        cedula: this.cedula,
        nombres: this.nombres,
        telefono: this.telefono,
        id_rol: this.id_rol,
        cargo: this.cargo,
        correo: this.correo,
        clave: this.clave,
        confirmar_clave: this.confirmar_clave,
        respuesta1: this.respuesta1,
        respuesta2: this.respuesta2,
        respuesta3: this.respuesta3
      }).then(response => {
        this.mostrarExito("Usuario registrado correctamente.");
       
      }).catch(error => {
        if (error.response && error.response.status === 422) {
          // Laravel devolvió errores de validación
          const errores = error.response.data.errors;
          const primerCampo = Object.keys(errores)[0];
          this.mostrarError(errores[primerCampo][0]);
        } else {
          this.mostrarError(error.message || "Ocurrió un error al registrar el usuario.");
        }
      });
          },
          mostrarError(mensaje) {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: mensaje,
        didOpen: () => {
          const swalContainer = document.querySelector('.swal2-container');
          if (swalContainer) {
            swalContainer.style.zIndex = '9999';
          }
        }
      });
    },
          mostrarExito(mensaje) {
            Swal.fire({
              position: "top-end",
              icon: "success",
              title: mensaje,
              showConfirmButton: false,
              timer: 1500,
              didOpen: () => {
                const swalContainer = document.querySelector('.swal2-container');
                if (swalContainer) {
                  swalContainer.style.zIndex = '9999'; 
                  window.location.href = 'http://localhost/asistencia/public/';// Cambia este valor según sea necesario
                }
              }
            });
            
          },
          limpiarFormulario() {
            this.cedula = '';
            this.nombres = '';
            this.telefono = '';
            this.cargo = '';
            this.correo = '';
            this.clave = '';
          },
    }
};
</script>

    