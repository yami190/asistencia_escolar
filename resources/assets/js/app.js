require('./bootstrap');

window.Vue = require('vue');

// Registrar componentes de Vue
Vue.component('login', require('./components/Login.vue').default);
Vue.component('nomina', require('./components/Nomina.vue').default);
Vue.component('movimiento', require('./components/Movimientos.vue').default);
Vue.component('socio', require('./components/Socios.vue').default);
Vue.component('cuentas', require('./components/Cuentas.vue').default);
Vue.component('contabilidad', require('./components/Contabilidad.vue').default);
Vue.component('usuarios', require('./components/Usuarios.vue').default);
Vue.component('nominacaja', require('./components/Nominacaja.vue').default);
Vue.component('balancesg', require('./components/Balances.vue').default);
Vue.component('transferencias', require('./components/Transferencias.vue').default);
Vue.component('movicaja', require('./components/CajaMoviNomina.vue').default);
Vue.component('expedientes', require('./components/Expedientes.vue').default);
Vue.component('liquidaciones', require('./components/Liquidaciones.vue').default);
Vue.component('estadocuenta', require('./components/Estadoscuentas.vue').default);
Vue.component('prestamos', require('./components/Prestamos.vue').default);
Vue.component('cuentassocios', require('./components/CuentasSocios.vue').default);
Vue.component('balancescaja', require('./components/BalancesCaja.vue').default);
Vue.component('nomin-socios', require('./components/Nomin_socios.vue').default);
Vue.component('prueba', require('./components/pruebas.vue').default);
Vue.component('asistencia', require('./components/Asistencia.vue').default);
Vue.component('asistenciape', require('./components/AsistenciaPe.vue').default);
Vue.component('alumnos', require('./components/Alumnos.vue').default);
Vue.component('personal', require('./components/Personal.vue').default);
Vue.component('reportes', require('./components/Reportes.vue').default);
Vue.component('ajusfi', require('./components/AjusteFi.vue').default);
Vue.component('cuotas', require('./components/Cuotas.vue').default);
Vue.component('database', require('./components/Database.vue').default);
Vue.component('gestion', require('./components/Gestionusu.vue').default);
Vue.component('calendario', require('./components/Calendario.vue').default);

// Instancia de Vue con datos del usuario
const app = new Vue({
    el: '#app',
    data: {
        menu: 0,
        user: window.Laravel.user || null
    },
    mounted() {
        console.log("Usuario desde Vue:", this.user);
    }
});

Vue.directive('permiso', {
    bind(el, binding, vnode) {
        const user = window.Laravel.user; // Obtener usuario desde Laravel
        if (user && user.id_rol === 4) {
            el.style.display = 'none'; // Ocultar si el usuario tiene rol 4
        }
    }
});
