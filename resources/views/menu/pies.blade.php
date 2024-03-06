            </div>
          </div>
        </div>
      </div>
      <?php 
        use Carbon\Carbon;
        $date = Carbon::now();
        $date = $date->format('Y');

      ?>
    </section>

  </div>
<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 4.8.2
    </div>
    <strong>Copyright &copy; 2020-{{ $date}} <a href="#">Desarrollado por Freddy Salazar</a>.</strong> Todos los derechos reservados.
  </footer>

  <aside class="control-sidebar control-sidebar-dark">
  </aside>
</div>

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/sweetalert.min.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>


<!-- jQuery -->
<script src="bt/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="bt/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="bt/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="bt/dist/js/demo.js"></script>
</body>
</html>