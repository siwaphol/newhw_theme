@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">Edit Admin</div>

                    <div class="panel-body">

                        <hr/>

                              @foreach($admin as $item)
                          {!! Form::open(['url' => 'admin/update']) !!}
                       <div class="form-group">
                          {!! Form::label('username', 'Username:')!!}
                          {!! Form::text('username', $item->username, ['class' => 'form-control']) !!}
                      </div><div class="form-group">
                          {!! Form::label('firstname_th', 'Firstname_th: ') !!}
                          {!! Form::text('firstname_th', $item->firstname_th, ['class' => 'form-control']) !!}
                      </div>
                      <div class="form-group">
                          {!! Form::label('firstname_en', 'Firstname_th: ') !!}
                          {!! Form::text('firstname_en', $item->firstname_en, ['class' => 'form-control']) !!}
                      </div>
                      <div class="form-group">
                          {!! Form::label('lastname_th', 'Lastname_th: ') !!}
                          {!! Form::text('lastname_th', $item->lastname_th, ['class' => 'form-control']) !!}
                      </div>
                      <div class="form-group">
                          {!! Form::label('lastname_en', 'Lastname_en: ') !!}
                          {!! Form::text('lastname_en', $item->lastname_en, ['class' => 'form-control']) !!}
                      </div>
                      <div class="form-group">
                          {!! Form::label('email', 'Email: ') !!}
                          {!! Form::text('email', $item->email, ['class' => 'form-control']) !!}
                      </div>
                       <input type="hidden" name="id" value="{{$item->id}}">
                       <div class="form-group">
                           {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
                                               </div>
                        {!! Form::close() !!}
                        @endforeach
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