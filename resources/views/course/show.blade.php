@extends('app')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">Course Detail</div>
                    <div class="panel-body">
                        <div class="form-group">
                            {!! Form::label('id','Course No')!!}
                            {!! Form::text('id',$course->id,['class'=>'form-control','readonly'])!!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('name','Title')!!}
                            {!! Form::text('name',$course->name,['class'=>'form-control','readonly'])!!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">Sections {{Session::get('semester')}}-{{Session::get('year')}}</div>
                    <div class="panel-body">

                    </div>
                    <div class="table-responsive">
                        <table class="table table-lg" id="section-datatable">
                            <thead>
                            <tr>
                                <th>Section</th>
                                <th>Teacher Name</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sections as $section=>$item)
                                <tr>
                                    <th colspan="2" class="active">{{$section}}</th>
                                </tr>
                                @foreach($item as $teacher)
                                    <tr>
                                        <td></td>
                                        <td>{{$teacher->firstname_en}} {{$teacher->lastname_en}}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section('script')
    {{--<script>--}}
        {{--$(function () {--}}
            {{--$('#section-datatable').DataTable();--}}
        {{--})--}}
    {{--</script>--}}
@endsection