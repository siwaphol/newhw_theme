@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        <h1>Edit homework1</h1>
                        <hr/>

                        {!! Form::model($homework1, ['method' => 'PATCH', 'action' => ['Homework1Controller@update', $homework1->id]]) !!}

                        <div class="form-group">
                        {!! Form::label('id', 'Id: ') !!}
                        {!! Form::text('id', null, ['class' => 'form-control']) !!}
                    </div><div class="form-group">
                        {!! Form::label('cours_id', 'Cours Id: ') !!}
                        {!! Form::text('cours_id', null, ['class' => 'form-control']) !!}
                    </div><div class="form-group">
                        {!! Form::label('section', 'Section: ') !!}
                        {!! Form::text('section', null, ['class' => 'form-control']) !!}
                    </div><div class="form-group">
                        {!! Form::label('name', 'Name: ') !!}
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                    </div><div class="form-group">
                        {!! Form::label('type_id', 'Type Id: ') !!}
                        {!! Form::text('type_id', null, ['class' => 'form-control']) !!}
                    </div><div class="form-group">
                        {!! Form::label('detail', 'Detail: ') !!}
                        {!! Form::text('detail', null, ['class' => 'form-control']) !!}
                    </div><div class="form-group">
                        {!! Form::label('sub_folder', 'Sub Folder: ') !!}
                        {!! Form::text('sub_folder', null, ['class' => 'form-control']) !!}
                    </div><div class="form-group">
                        {!! Form::label('assign_date', 'Assign Date: ') !!}
                        {!! Form::text('assign_date', null, ['class' => 'form-control']) !!}
                    </div><div class="form-group">
                        {!! Form::label('due_date', 'Due Date: ') !!}
                        {!! Form::text('due_date', null, ['class' => 'form-control']) !!}
                    </div><div class="form-group">
                        {!! Form::label('accept_date', 'Accept Date: ') !!}
                        {!! Form::text('accept_date', null, ['class' => 'form-control']) !!}
                    </div>
                        
                        <div class="form-group">
                            {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
                        </div>
                        {!! Form::close() !!}

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