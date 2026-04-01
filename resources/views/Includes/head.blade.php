<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
@if (! config('app.skip_external_fonts', false))
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto+Condensed:300,300i,400,400i,700,700i&amp;display=swap" rel="stylesheet">
@else
<style>body, .az-body { font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Noto Sans KR", "Malgun Gothic", sans-serif; }</style>
@endif
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/logo.png') }}">
<meta name="description" content="자동차 운송 통합 시스템">
<meta name="author" content="자동차 운송 통합 시스템">
<title>자동차 운송 통합 시스템</title>
<link href="{{ asset('lib/fontawesome-free/css/all.min.css') }}" rel="stylesheet"> 
<link href="{{ asset('lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
<link href="{{ asset('lib/typicons.font/typicons.css') }}" rel="stylesheet">
<link href="{{ asset('lib/line-awesome/css/line-awesome.min.css') }}" rel="stylesheet">
<link href="{{ asset('lib/flag-icon-css/css/flag-icon.min.css') }}" rel="stylesheet">
<link href="{{ asset('lib/datatables.net-dt/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ asset('lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ asset('lib/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">
<link href="{{ asset('lib/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/vrs.css') }}" rel="stylesheet">
<link href="{{ asset('css/avtoteever.css') }}" rel="stylesheet">
{{-- <script type="text/javascript" src="js/jquery-3.5.1.min.js"></script> --}}
 
<!-- DevExtreme theme -->
<link rel="stylesheet" href="{{asset('lib/dev-extreme/css/dx.light.css')}}">

<!-- DevExtreme library -->

