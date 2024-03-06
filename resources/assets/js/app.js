/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

//window.Vue = require('EasyUI');
	

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

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
//varhalla
Vue.component('expedientes', require('./components/Expedientes.vue').default);
Vue.component('liquidaciones', require('./components/Liquidaciones.vue').default);
//Estados de cuentas
Vue.component('estadocuenta', require('./components/Estadoscuentas.vue').default);
//Prestamos
Vue.component('prestamos', require('./components/Prestamos.vue').default);
//Bancos
Vue.component('cuentassocios', require('./components/CuentasSocios.vue').default);
//Blanaces
Vue.component('balancescaja', require('./components/BalancesCaja.vue').default);
//Administrador
Vue.component('nomin-socios', require('./components/Nomin_socios.vue').default);
Vue.component('prueba', require('./components/pruebas.vue').default);
//Descuentos
Vue.component('ajusfi', require('./components/AjusteFi.vue').default);






//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
     data :{
    	menu : 0
    }
});
