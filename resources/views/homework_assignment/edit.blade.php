@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        <h1>Edit homework_assignment</h1>
                        <hr/>

                        {{ Form::model($homework_assignment, ['method' => 'PATCH', 'action' => ['Homework_assignmentController@update', $homework_assignment->id]]) }}

                        <div class="form-group">
                        {{ Form::label('courseId', 'Courseid: ') }}
                        {{ Form::text('courseId', null, ['class' => 'form-control']) }}
                    </div><div class="form-group">
                        {{ Form::label('homeworkFileName', 'Homeworkfilename: ') }}
                        {{ Form::text('homeworkFileName', null, ['class' => 'form-control']) }}
                    </div><div class="form-group">
                        {{ Form::label('homworkFileType', 'Homworkfiletype: ') }}
                        {{ Form::text('homworkFileType', null, ['class' => 'form-control']) }}
                    </div><div class="form-group">
                        {{ Form::label('homeworkDetail', 'Homeworkdetail: ') }}
                        {{ Form::text('homeworkDetail', null, ['class' => 'form-control']) }}
                    </div><div class="form-group">
                        {{ Form::label('issubFolder', 'Issubfolder: ') }}
                        {{ Form::text('issubFolder', null, ['class' => 'form-control']) }}
                    </div><div class="form-group">
                        {{ Form::label('subFolder', 'Subfolder: ') }}
                        {{ Form::text('subFolder', null, ['class' => 'form-control']) }}
                    </div><div class="form-group">
                        {{ Form::label('dueDtae', 'Duedtae: ') }}
                        {{ Form::text('dueDtae', null, ['class' => 'form-control']) }}
                    </div><div class="form-group">
                        {{ Form::label('assignDate', 'Assigndate: ') }}
                        {{ Form::text('assignDate', null, ['class' => 'form-control']) }}
                    </div><div class="form-group">
                        {{ Form::label('acceptDate', 'Acceptdate: ') }}
                        {{ Form::text('acceptDate', null, ['class' => 'form-control']) }}
                    </div>
                        
                        <div class="form-group">
                            {{ Form::submit('Update', ['class' => 'btn btn-primary form-control']) }}
                        </div>
                        {{ Form::close() }}

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