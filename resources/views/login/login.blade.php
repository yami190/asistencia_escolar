
</html>
<!DOCTYPE html>
<html>
<head>
	
	<title>E.B.N "Villa Bolívar"</title>
	
	<link rel="icon" type="image/x-icon" href="assets/img/favicon/IMG-20240425-WA0010.ico" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="login/css/style.css">
	<!-- Bootstrap CSS -->




	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<script>
        window.Laravel = {!! json_encode(['user' => Auth::user()]) !!};
    </script>
	<div id="app">
        <login></login>
	</div>
	<script src="{{ asset('js/app.js') }}"></script>
	<!-- Bootstrap Bundle con Popper -->

    <script type="text/javascript" src="login/js/main.js"></script>
	<script src="sweetalert2@11.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
	
</body>
</html>