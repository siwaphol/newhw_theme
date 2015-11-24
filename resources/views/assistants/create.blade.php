@extends('app')

@section('content')



    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">Add Teacher Assistent</div>

                    <div class="panel-body">
                        {{--<h4 align="center">กระบวนวิชา {{$cosec['course']}} ตอน {{$cosec['sec']}}</h4>--}}
                        <hr/>

                        <!--{!! Form::open(['url' => 'assistants/create/save']) !!}
                        -->
                        <form action="create/save" method="post" name="frmMain" id="frmMain" onsubmit="return onSubmitMain()" class="form-horizontal"  >

                     <div class="form-group">
                        {!! Form::label('courseId', 'Course No: ') !!}
                        {!! Form::text('courseId', $cosec['course'], ['class' => 'form-control','disabled' => 'disabled']) !!}
                     </div>
                    <div class="form-group">
                        {!! Form::label('sectionId', 'Section: ') !!}
                        {!! Form::text('sectionId', $cosec['sec'], ['class' => 'form-control','disabled' => 'disabled'])!!}
                    </div>
                    <input type="hidden" name="courseId" value="{{$cosec['course']}}">
                    <input type="hidden" name="sectionId" value="{{$cosec['sec']}}">
                    <div class="form-group">
                    {!! Form::label('taId', 'Stuudent ID') !!}
                      <input type="text" name="taId" class="form-control" >
                    </div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            {!! Form::submit('Add', ['class' => 'btn btn-primary form-control']) !!}
                        </div>
                        </form>
                        <!--{{ Form::close() }}
                            -->
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection