<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	@if (isset($description))
		<meta name="description" content="{{ $description }}">
	@else
		<meta name="description" content="Homework management Computer Science, CMU">
	@endif

	<title>Laravel Datatables {{ isset($title) ? " | $title" : "" }}</title>

	@include('partials.css_import')

    @yield('css')

</head>
<body>
@include('partials.nav')

<!-- Page header -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            <h4>
                <i class="icon-arrow-left52 position-left"></i>
                <span class="text-semibold">Home</span> - Dashboard
                <small class="display-block">Good morning, Victoria Baker!</small>
            </h4>
        </div>

        <div class="heading-elements">
            <div class="heading-btn-group">
                <a href="#" class="btn btn-link btn-float has-text"><i class="icon-bars-alt text-primary"></i><span>Statistics</span></a>
                <a href="#" class="btn btn-link btn-float has-text"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>
                <a href="#" class="btn btn-link btn-float has-text"><i class="icon-calendar5 text-primary"></i> <span>Schedule</span></a>
            </div>
        </div>
    </div>
</div>
<!-- /page header -->

<!-- Page container -->
<div class="page-container">
    <!-- Page content -->
    <div class="page-content">
        <!-- Main content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>
</div>

@include('partials.scripts_import')

@include('partials.scripts.change_semester_year')

@yield('script')

{{--@if (config('analytics.enabled', false))--}}
	{{--@include('analytics')--}}
{{--@endif--}}
</body>
</html>
