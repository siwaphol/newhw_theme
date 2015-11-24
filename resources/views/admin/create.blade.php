@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">Add Admin</div>

                    <div class="panel-body">

                        <hr/>

                        {!! Form::open(['url' => 'admin/create/save']) !!}
                        
                      <div class="form-group">
                          {!! Form::label('email', 'Email: ') !!}
                          {!! Form::label('warning', '** ',array('style'=>'color:red')) !!}
                          <div class="col-md-15 input-group">
                              <input type="text" class="form-control" name="email" value="{{ old('email') }}">
                              <span class="input-group-addon" id="basic-addon2">@cmu.ac.th</span>
                          </div>
                      </div>
                      <div class="form-group">
                           {!! Form::label('firstname_th', 'Firstname_th: ') !!}
                           {!! Form::text('firstname_th', null, ['class' => 'form-control']) !!}
                       </div>
                       <div class="form-group">
                           {!! Form::label('firstname_en', 'Firstname_en: ') !!}
                           {!! Form::label('warning', '** ',array('style'=>'color:red')) !!}
                           {!! Form::text('firstname_en', null, ['class' => 'form-control']) !!}
                       </div>
                       <div class="form-group">
                           {!! Form::label('lastname_th', 'Lastname_th: ') !!}
                           {!! Form::text('lastname_th', null, ['class' => 'form-control']) !!}
                       </div>
                       <div class="form-group">
                           {!! Form::label('lastname_en', 'Lastname_en: ') !!}
                           {!! Form::label('warning', '** ',array('style'=>'color:red')) !!}
                           {!! Form::text('lastname_en', null, ['class' => 'form-control']) !!}
                       </div>
                       {{--<div class="form-group">--}}
                           {{--{!! Form::label('email', 'อีเมล: ') !!}--}}
                           {{--{!! Form::text('email', null, ['class' => 'form-control']) !!}--}}
                       {{--</div>--}}
                        <div class="form-group">
                            {!! Form::submit('Add', ['class' => 'btn btn-primary form-control']) !!}
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