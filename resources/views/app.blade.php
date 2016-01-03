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

@if(!\Auth::guest())
@if(!isset($removeHeader))
<!-- Page header -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            <h4>
                <span class="text-semibold"> {{ isset($page_name) ? "$page_name" : "Page Name" }}</span> - {{ isset($sub_name) ? "$sub_name" : "Sub Name" }}
            </h4>
        </div>

        {{--<div class="heading-elements">--}}
            {{--<div class="heading-btn-group">--}}
                {{--<a href="#" class="btn btn-link btn-float has-text"><i class="icon-bars-alt text-primary"></i><span>Statistics</span></a>--}}
                {{--<a href="#" class="btn btn-link btn-float has-text"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>--}}
                {{--<a href="#" class="btn btn-link btn-float has-text"><i class="icon-calendar5 text-primary"></i> <span>Schedule</span></a>--}}
            {{--</div>--}}
        {{--</div>--}}
    </div>
</div>
<!-- /page header -->
@endif
@endif

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

@if(!\Auth::guest() && (\Auth::user()->isAdmin() || \Auth::user()->isTeacher()))
    @include('partials.scripts.change_semester_year')
@endif

@yield('script')

{{--@if (config('analytics.enabled', false))--}}
	{{--@include('analytics')--}}
{{--@endif--}}
</body>
</html>
