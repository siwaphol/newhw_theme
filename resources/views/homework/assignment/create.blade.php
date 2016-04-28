@extends('app')

@section('css')
    <style>
        .form-group{
            margin-bottom: 0;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        {!! Form::open(['method'=>'post', 'url'=>'testing', 'id'=>'new-file-form']) !!}
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h6 class="panel-title">New Assignment for {{$course->id}} {{$course->name}}</h6>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="name" class="control-label col-lg-2">File Name</label>
                    <div class="col-lg-10">
                        {!! Form::input('text', 'name', null,['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label for="type_id" class="control-label col-lg-2">Extension</label>
                    <div class="col-lg-10">
                        {!! Form::input('text', 'type_id', null,['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label for="details" class="control-label col-lg-2">Details</label>
                    <div class="col-lg-10">
                        {!! Form::textarea( 'details', null,['class'=>'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label for="section" class="control-label col-lg-2">Sections</label>
                    <div class="col-lg-10">
                        {!! Form::select('section',$distinctSection,null,['multiple'=>'multiple','id'=>'section-select','class'=>'select']) !!}
                    </div>
                </div>

                <a href="" class="btn btn-success" id="select-all-btn">Select All</a>
                <a href="" class="btn btn-success" id="deselect-all-btn">De-Select All</a>
            </div>
        </div>

        @foreach($distinctSection as $section)
            <div class="panel panel-body border-top-primary" id="section-{{$section}}-panel">
                {{--Assign Date & Time ควรจะถูกกำหนดหลังจากที่ข้อมูลถูกต้อง และบันทึกลงฐานข้อมูลสำเร็จ--}}
                {{--<div class="form-group">--}}
                    {{--<label for="" class="control-label col-lg-2">Section {{$section->section}} Assign Date</label>--}}
                    {{--<div class="col-lg-4">--}}
                        {{--{!! Form::input( 'date','assign_date[]',null,['class'=>'form-control']) !!}--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="form-group">--}}
                    {{--<label for="" class="control-label col-lg-2">Section {{$section->section}} Assign Time</label>--}}
                    {{--<div class="col-lg-4">--}}
                        {{--{!! Form::input( 'time','assign_time[]',null,['class'=>'form-control']) !!}--}}
                    {{--</div>--}}
                {{--</div>--}}
                <div class="form-group">
                    <label for="" class="control-label col-lg-2">Section {{$section}} Due Date</label>
                    <div class="col-lg-4">
                        {!! Form::input( 'date','due_date[]',null,['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="control-label col-lg-2">Section {{$section}} Due Time</label>
                    <div class="col-lg-4">
                        {!! Form::input( 'time','due_time[]','00:00',['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="control-label col-lg-2">Section {{$section}} Accept Date</label>
                    <div class="col-lg-4">
                        {!! Form::input( 'date','accept_date[]',null,['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="control-label col-lg-2">Section {{$section}} Accept Time</label>
                    <div class="col-lg-4">
                        {!! Form::input( 'time','accept_time[]','23:59',['class'=>'form-control']) !!}
                    </div>
                </div>
            </div>
        @endforeach
        {!! Form::close() !!}
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="{{asset('limitless_assets/js/plugins/forms/selects/select2.min.js')}}"></script>
    <script>
        $(function(){
            var $selectClass = $(".select");

            $selectClass.select2({
                minimumResultsForSearch: "-1",
                placeholder: "Click to select..."
            });
            $selectClass.on("change", function (e) { console.log("change",e); });

            $("#select-all-btn").click(function (e) {
                e.preventDefault();
                $selectClass.select2('destroy').find('option').prop('selected', 'selected').end().select2();
            });
            $("#deselect-all-btn").click(function (e) {
                e.preventDefault();
                $selectClass.select2('destroy').find('option').prop('selected', false).end().select2();
            });
        });
    </script>
@endsection