$("#cedula").change(function() {
    if ($('#cedula').val() !='') {
        $('#cedula').css('border', '1px solid green');
    } else $('#cedula').css('border', '1px solid red');
});
function login_enter(){
   
    var usuario = $('#cedula').val();
    var clave = $('#clave').val();
    var msg = 0;
    /*Checking the value of inputs*/
    /*Validating the values of inputs that it is neither null nor undefined.*/
    if (cedula == '' || cedula == undefined) {
        $('#cedula').css('border', '1px solid red');
        msg = 'El campo "cedula" es requerido';
    } else if (clave == '' || clave == undefined) {
        $('#clave').css('border', '1px solid red');
        msg = 'El campo "clave" es requerido';
    }
    /*if there is no error, go to msg==0 condition*/
    if (msg == 0) {
        $.ajax({
         url: 'login_post',
         data : { 'cedula' : $('#cedula').val(),'clave':$('#clave').val()},
         dataType: 'json',
         async: true,
         method:'get',
         success: function(result) {
            switch(result) {
                case 1:
                    let timerInterval
                    Swal.fire({
                      title: 'Sus datos han sido validados!',
                      text: 'Será direccionado a la pantalla principal.',
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
                        window.location='administrador_de_noticias';             
                      }
                    });
                    break;
                case 2: //campo cedula no cumple requisitos
                    Swal.fire('El cedula introducido no es válido o está en blanco');
                    break;
                case 3: //campo clave no cumple los requisitos
                    //
                    Swal.fire('La clave introducida no es válida o está en blanco');
                    break;
                case 4: //error en validación de cedula y clave en el servidor
                    Swal.fire('El cedula no está registrado');
                    break;
                case 5: //contraseña inválida
                    Swal.fire('La clave introducida no corresponde al cedula. Intente de nuevo.');
                    break;
                case 6:
                    Swal.fire('El cedula se encuentra inactivo');
                    break;
                default:
                    Swal.fire('Se ha detectado un problema, comuníquese con la Div. de Sistemas');
                    break;
            }
         }
        });
    } else {
        Swal.fire({
          icon: 'error',
          title: 'Advertencia',
          text: msg
        });
    }
}

function redir(){
    $.ajax({
        url: 'redirex',
        async: true,
        method: 'post',
        success: function(result) {
            ip = result;
            if (result) {}
            Swal.fire({
              icon: 'error',
              title: 'Advertencia',
              text: result
            });
        }
    });
}