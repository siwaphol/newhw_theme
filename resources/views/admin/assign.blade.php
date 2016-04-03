@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">Change role between Admin and  Lecturer</div>

                    <div class="panel-body">
                    <div>

                      <!-- Nav tabs -->
                      <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Admin To Lecturer</a></li>
                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Lecturer To Admin</a></li>
                        {{--<li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Messages</a></li>--}}
                        {{--<li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>--}}
                      </ul>

                      <!-- Tab panes -->
                      <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="home">
                        {!! Form::open(['url' => 'admin/assign/save']) !!}

                      <div class="form-group">
                          {!! Form::label('adminid', 'User Admin: ') !!}
                            <input type="hidden" name="type" value=1>
                           <select id="adminid" name="adminid" onChange = "ListSection(this.value)" class="form-control">
                              <option selected value="">Select User</option>
                              @foreach($teacher as $item)
                             <option value={{$item->id}}>{{$item->firstname_en.' '.$item->lastname_en}}</option>
                             @endforeach
                           </select>
                       </div>
                       <div class="form-group">
                           {!! Form::submit('Add ', ['class' => 'btn btn-primary form-control']) !!}
                       </div>
                       {!! Form::close() !!}

                       @if ($errors->any())
                           <ul class="alert alert-danger">
                               @foreach ($errors->all() as $error)
                                   <li>{{ $error }}</li>
                               @endforeach
                           </ul>
                       @endif</div>
                        <div role="tabpanel" class="tab-pane" id="profile">
                        {!! Form::open(['url' => 'admin/assign/save']) !!}
                        <input type="hidden" name="type" value=0>
                       <div class="form-group">
                           {!! Form::label('adminid', 'User Lecturer: ') !!}

                            <select id="adminid" name="adminid" onChange = "ListSection(this.value)" class="form-control">
                               <option selected value="">Select User</option>
                               @foreach($admin as $item)
                              <option value={{$item->id}}>{{$item->firstname_en.' '.$item->lastname_en}}</option>
                              @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            {!! Form::submit('Add ', ['class' => 'btn btn-primary form-control']) !!}
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
                        {{--<div role="tabpanel" class="tab-pane" id="messages">...</div>--}}
                        {{--<div role="tabpanel" class="tab-pane" id="settings">...</div>--}}
                      </div>

                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection