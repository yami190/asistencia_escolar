
        <div class="sidebar">
            <nav class="sidebar-nav">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="/"><i class="icon-speedometer"></i> Escritorio</a>
                    </li>
                    <li class="nav-title">
                        Mantenimiento
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-bag"></i> Socios</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=1" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i> Movimientos</a>
                            </li>
                            <li @click="menu=2" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i> Datos Personales</a>
                            </li>
                            <li @click="menu=3" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i>Cargos</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-wallet"></i> Nominas Caja</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=9" class="nav-item">
                                <a class="nav-link" href="i#"><i class="icon-wallet"></i>Movi. Caja de Ahorro</a>
                            </li>
                            <li @click="menu=7" class="nav-item">
                                <a class="nav-link" href="i#"><i class="icon-wallet"></i> Nominacaja de Ahorro</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-notebook"></i> Recibo de Pagos</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-Bank "></i> Bancos</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=4" class="nav-item">
                                <a class="nav-link" href="i#"><i class="icon-basket-loaded"></i> Cuentas Socios</a>
                            </li>
                            <li @click="menu=5" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-notebook"></i> Contabilidad</a>
                            </li>
                             <li @click="menu=8" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-notebook"></i>Transferencias</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-people"></i> Acceso</a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-user"></i> Usuarios</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-user-following"></i> Roles</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-pie-chart"></i> Reportes</a>
                        <ul @click="menu=7" class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="reporte-balances"><i class="icon-chart"></i> Balances</a>
                            </li>
                        </ul>
                         <ul @click="menu=10" class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-chart"></i> prueba</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="main.html"><i class="icon-book-open"></i> Ayuda <span class="badge badge-danger">PDF</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="main.html"><i class="icon-info"></i> Acerca de...<span class="badge badge-info">IT</span></a>
                    </li>
                </ul>
            </nav>
            <button class="sidebar-minimizer brand-minimizer" type="button"></button>
        </div>

     