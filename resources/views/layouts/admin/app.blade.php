<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Wisma Kita | @yield('title','Admin')</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
@include('layouts.admin.css')
@stack('styles')
</head>
<body>
<div class="admin-wrapper">
@include('layouts.admin.sidebar')
<div class="main-area">
@include('layouts.admin.header')
<main class="page-content">@yield('content')</main>
@include('layouts.admin.footer')
</div>
</div>
@include('layouts.admin.js')
@stack('scripts')
</body></html>
