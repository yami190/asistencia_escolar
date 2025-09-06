<template>
    <div class="container">
        <img class="wave" src="login/img/wave.png">
            <div class="container">
                <div class="img">
                    
                </div>
                <div class="login-content">
                    <form action="#">
                        <img src="login/img/IMG-20240425-WA0010.jpg">
                        <h2 class="title">Bienvenido</h2>
                        <div class="input-div one">
                        <div class="i">
                                <i class="fas fa-user"></i>
                        </div>
                        <div class="div">
                                <h5>Cedula</h5>
                                <input type="text" v-model="cedula" class="input">
                        </div>
                        </div>
                        <div class="input-div pass">
                        <div class="i"> 
                                <i class="fas fa-lock"></i>
                        </div>
                        <div class="div">
                                <h5>Contraseña</h5>
                                <input type="password" class="input" v-model="clave" >
                        </div>
                        </div>
                        <a href="Gsuario">Recuperar Contraseña</a>
                        <input type="submit" class="btn"  @click="entar">
                    </form>
                </div>
            </div>
    </div>
</template>

<script>

    import axios from 'axios'
   
    
    export default {
        data() {
            return {
                cedula: '',
                clave: '',
                nombres: '',
                correo: '',
                arayarchivosocio: [],
            }
        },
        //   created: function(){
               
        //     },
            methods: {
                entar() {
                    
                    // Inicialización del mensaje
                this.msg = '';

                // Validación básica
                if (!this.cedula) {
                    this.msg = 'El campo "usuario" es requerido';
                } else if (!this.clave) {
                    this.msg = 'El campo "clave" es requerido';
                }

                // Mostrar mensaje de error si existe
                if (this.msg) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Advertencia',
                        text: this.msg
                    });
                }else {
                        // Envío de datos al servidor
                        axios.post('entrada_login', { cedula: this.cedula, clave: this.clave })
                            .then(response => {
                                switch(response.data) {
                                        case 1:
                                            let timerInterval
                                            Swal.fire({
                                            title: 'Bienvenido Usuario',
                                            text: 'Su cuenta está activada.',
                                            timer: 2000,
                                            icon: 'success',
                                            didOpen: () => {
                                                const content = Swal.getHtmlContainer()
                                                const $ = content.querySelector.bind(content)
                                                Swal.showLoading()
                                                timerInterval = setInterval(() => {
                                            /*    Swal.getHtmlContainer().querySelector('strong')
                                                    .textContent = (Swal.getTimerLeft() / 1000)
                                                    .toFixed(0)*/
                                                }, 80)
                                            },
                                            willClose: () => {
                                                clearInterval(timerInterval);
                                                /*Redireccionando al inicio en 3 segundos*/
                                                window.location='AdmUser';             
                                            }
                                            });
                                            break;
                                        case 2: //campo usuario no cumple requisitos
                                            Swal.fire('El usuario introducido no es válido o está en blanco');
                                            break;
                                        case 3: //campo clave no cumple los requisitos
                                            //
                                            Swal.fire('La clave introducida no es válida o está en blanco');
                                            break;
                                        case 4: //error en validación de usuario y clave en el servidor
                                            Swal.fire('El usuario no está registrado');
                                            break;
                                        case 5: //contraseña inválida
                                            Swal.fire('La clave introducida no corresponde al usuario. Intente de nuevo.');
                                            break;
                                        case 6:
                                            Swal.fire('El usuario se encuentra inactivo');
                                            break;
                                        default:
                                            Swal.fire('Se ha detectado un problema, comuníquese con la Div. de Sistemas');
                                            break;
                                    }
                            })
                            .catch(error => {
                                // Manejo de errores de la solicitud
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Ocurrió un error al iniciar sesión. Inténtalo de nuevo.'
                                });
                            });
                    } 
                    },
                    buscarUsuario(cedula) {
                        let me=this;
                        var url= 'buscarUsuario?cedula=' + me.cedula;

                        axios.get(url).then(function (response){
                            var respuesta = response.data;
                            me.arayarchivosocio = respuesta.user;
                            //console.log(me.arayarchivosocio);

                            if (me.arayarchivosocio.length>0){
                                me.cedula = me.arayarchivosocio[0]['cedula'];
                                me.nombres = me.arayarchivosocio[0]['nombres'];
                                me.correo = me.arayarchivosocio[0]['correo'];

                            }
                            else{
                               //alert(me.cedula)
                            if (cedula == null ) {
                                swal("Socio No se encuentra registrado");

                                me.nombres='';
                                me.correo='';
                                
                            }
                            }
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                        },

                    crearUsuario(){
                           
                            let me = this;
                            axios.post('Gusuarios',{
                                'cedula': this.cedula,
                                'clave': this.clave,
                                'nombres': this.nombres,
                                'correo': this.correo,
                            }).then(response => {
                                Swal.fire({
                                icon: 'success',
                                title: '¡Éxito!',
                                text: 'Usuario creado correctamente.'
                                });
                                this.cedula='';
                                this.clave='';
                                this.nombres='';
                                this.correo='';
                            }).catch(function (error){
                                Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Algo salió mal. Por favor, intenta de nuevo.'
                                });

                                if (error.response && error.response.status === 422) {
                                // Mostrar errores de validación más específicos si es necesario
                                console.error(error.response.data);
                                }
                          
                    });

                }
  
              }
    }
</script>


