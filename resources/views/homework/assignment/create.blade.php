@extends('app')

@section('content')
    <div class="row">
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h6 class="panel-title">New Assignment for {{$course->id}} {{$course->name}}</h6>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="" class="control-label col-lg-2">File Name</label>
                    <div class="col-lg-10">
                        {!! Form::input('text', 'name', null,['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="control-label col-lg-2">Extension</label>
                    <div class="col-lg-10">
                        {!! Form::input('text', 'type_id', null,['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="control-label col-lg-2">Details</label>
                    <div class="col-lg-10">
                        {!! Form::textarea( 'details', null,['class'=>'form-control']) !!}
                    </div>
                </div>
            </div>
        </div>

        @foreach($sections as $section)
            <div class="panel panel-body border-top-primary">
                <div class="form-group">
                    <label for="" class="control-label col-lg-2">Section {{$section->section}} Assign Date</label>
                    <div class="col-lg-4">
                        {!! Form::input( 'date','assign_date[]',null,['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="control-label col-lg-2">Section {{$section->section}} Assign Time</label>
                    <div class="col-lg-4">
                        {!! Form::input( 'time','assign_time[]',null,['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="control-label col-lg-2">Section {{$section->section}} Due Date</label>
                    <div class="col-lg-4">
                        {!! Form::input( 'date','due_date[]',null,['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="control-label col-lg-2">Section {{$section->section}} Due Time</label>
                    <div class="col-lg-4">
                        {!! Form::input( 'time','due_time[]',null,['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="control-label col-lg-2">Section {{$section->section}} Accept Date</label>
                    <div class="col-lg-4">
                        {!! Form::input( 'date','accept_date[]',null,['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="control-label col-lg-2">Section {{$section->section}} Accept Time</label>
                    <div class="col-lg-4">
                        {!! Form::input( 'time','accept_time[]',null,['class'=>'form-control']) !!}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('script')

@endsection