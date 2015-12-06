@extends('app')

@section('css')

@endsection

@section('content')
<!-- Basic setup -->
<div class="panel panel-white">
    <div class="panel-heading">
        <h6 class="panel-title">First Time Wizard</h6>
    </div>

    <div class="steps-basic" action="#">
        <h6>Semester/Year</h6>
        <fieldset>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Select year and semester:</label>
                        <select name="year-semester" data-placeholder="Select position" class="select">
                            @foreach($ys_arr as $section_year)
                                <option value="{{$section_year["year"]}}-{{$section_year["semester"]}}" @if($section_year["selected"])selected="selected"@endif>{{$section_year["year"]}} - {{$section_year["semester"]}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <a type="button" class="btn btn-default" id="new_ys"><i class="icon-cog3 position-left"></i> New</a>
                        <a type="button" class="btn btn-default" id="cancel_new_ys"> Cancel</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Year</label>
                        <select name="new-year" data-placeholder="Select position" class="select" disabled>
                            @foreach($year_range as $aYear)
                                <option value="{{$aYear}}">{{$aYear}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <label>Semester</label>
                    <select name="new-semester" data-placeholder="Select position" class="select" disabled>
                        <option value="1">1</option>
                        <option value="2">2</option>
                    </select>
                </div>
            </div>
        </fieldset>

        <h6>Course Section</h6>
        <fieldset>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <a type="button" class="btn btn-default" id="import-course-section"><i class="icon-cog3 position-left"></i> Import</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <table id="course-section-list" class="display" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Course No</th>
                        <th>Name</th>
                        <th>Section</th>
                        <th>E.Teacher Name</th>
                        <th>T.Teacher Name</th>
                        <th>Status</th>
                        <th>Detail</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Course No</th>
                        <th>Name</th>
                        <th>Section</th>
                        <th>E.Teacher Name</th>
                        <th>T.Teacher Name</th>
                        <th>Status</th>
                        <th>Detail</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </fieldset>

        <h6>Student</h6>
        <fieldset>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Company:</label>
                        <input type="text" name="experience-company" placeholder="Company name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Position:</label>
                        <input type="text" name="experience-position" placeholder="Company name" class="form-control">
                    </div>
                </div>
            </div>
        </fieldset>

        <h6>Additional info</h6>
        <fieldset>

        </fieldset>
    </div>
</div>
<!-- /basic setup -->
@endsection

@section('script')
    <script type="text/javascript" src="{{asset('limitless_assets/js/plugins/forms/wizards/steps.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('limitless_assets/js/plugins/forms/selects/select2.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('limitless_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('limitless_assets/js/core/libraries/jasny_bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('limitless_assets/js/plugins/forms/validation/validate.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('limitless_assets/js/plugins/extensions/cookie.js')}}"></script>
    <script type="text/javascript" src="{{asset('limitless_assets/js/plugins/notifications/sweet_alert.min.js')}}"></script>

    <script type="text/javascript">
        var getAllCourseSectionURL = '{{url('api/v1/auto_ajax1')}}';
    </script>
    <script type="text/javascript" src="{{asset('limitless_assets/js/pages/wizard_steps.js')}}"></script>

    {{--<script type="text/javascript">--}}


        {{--$(function () {--}}

{{--//            // show course and section list from autoajax1 before insert or update--}}
{{--//            $('#course-section-list').DataTable({--}}
{{--//                "processing": true,--}}
{{--//                "ajax": {--}}
{{--//                    url: getAllCourseSectionURL,--}}
{{--//                    data: {"semester": '', "year": ''}--}}
{{--//                },--}}
{{--//                "columns": [--}}
{{--//                    { "data": "id"},--}}
{{--//                    { "data": "name"},--}}
{{--//                    { "data": "section"},--}}
{{--//                    { "data": "teacher"--}}
{{--//                    ,"render": function ( data, type, full, meta) {--}}
{{--//                        return data.length==0?'<p style="color:red;">Not found</p>':(data.firstname_en+' '+data.lastname_en);--}}
{{--//                    }},--}}
{{--//                    { "data": "teacher"--}}
{{--//                    ,"render": function ( data, type, full, meta) {--}}
{{--//                        return data.length==0?'<p style="color:red;">Not found</p>':(data.firstname_th+' '+data.lastname_th);--}}
{{--//                    }},--}}
{{--//                    { "data": null--}}
{{--//                    ,"render": function ( data, type, full, meta) {--}}
{{--//                        return '';--}}
{{--//                    }},--}}
{{--//                    { "data": null--}}
{{--//                    ,"render": function ( data, type, full, meta) {--}}
{{--//                        return '';--}}
{{--//                    }}--}}
{{--//                ]--}}
{{--//            });--}}
        {{--});--}}
    {{--</script>--}}
@endsection