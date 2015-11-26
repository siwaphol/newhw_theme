@extends('app')

@section('css')

@endsection

@section('content')
<!-- Basic setup -->
<div class="panel panel-white">
    <div class="panel-heading">
        <h6 class="panel-title">Basic example</h6>
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
                <div class="col-md-6">
                    <div class="form-group">
                        <label>University:</label>
                        <input type="text" name="university" placeholder="University name" class="form-control">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Country:</label>
                        <select name="university-country" data-placeholder="Choose a Country..." class="select">
                            <option></option>
                            <option value="1">United States</option>
                            <option value="2">France</option>
                            <option value="3">Germany</option>
                            <option value="4">Spain</option>
                        </select>
                    </div>
                </div>
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

    <script type="text/javascript" src="{{asset('limitless_assets/js/pages/wizard_steps.js')}}"></script>

    <script type="text/javascript">
        $(function () {
            $('#new_ys').click(function () {
                $("select[name='year-semester']").prop('disabled', true);
                $("select[name='new-year']").prop('disabled', false);
                $("select[name='new-semester']").prop('disabled', false);
            });
            $('#cancel_new_ys').click(function () {
                $("select[name='year-semester']").prop('disabled', false);
                $("select[name='new-year']").prop('disabled', true);
                $("select[name='new-semester']").prop('disabled', true);
            });
        });
    </script>
@endsection