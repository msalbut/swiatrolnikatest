<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Panel Logowania - Światrolnika.info</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<!-- --------------style css --------------->
<link href="{{ asset('css/admin.css') }}?t<?= time() ?>" rel="stylesheet" type="text/css">

</head>
<style>
    body {
        font-size: 1rem;
        font-weight: 400;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        background-color: #f5f8fb;
    }
</style>
<body class="vh-100">
    @yield('content')
</body>
</html>
