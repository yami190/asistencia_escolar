@include('menu.cabeza')
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="Expedientes"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="CAHORRO" class="nav-link">VALHALLA</a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="Expedientes" class="brand-link">
      <img src="bt/dist/img/valhalla.jpg"
           alt="AdminLTE Logo"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">VALHALLA</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="bt/dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Administrador de Sistemas</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-calculator"></i>
              <p>
                Aten. Socio
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="EstCuenta" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Estados de Cuenta</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="CuentasSocios" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Cuentas Socios</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-archive"></i>
              <p>
                Archivo
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="Expedientes" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Expedientes</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="Liquidaciones" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Liquidaciones</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="Balances-caja" class="nav-link">
              <i class="nav-icon fa fa-coins"></i>
              <p>
                Balance
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Descuentos
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="Prestamos" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Prestamos</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-globe"></i>
              <p>
                Administrador
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="Nomina-socio" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Nomina - Socio</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="listar-archivos" class="nav-link">
              <i class="nav-icon fa fa-folder-open"></i>
              <p>
                Documentos Caja
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="old" class="nav-link">
              <i class="nav-icon fa fa-reply"></i>
              <p>
                Sistema antiguo
              </p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <div class="content-wrapper">

    <section class="content-header">
      
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Default box -->
            <div id="app">
              

