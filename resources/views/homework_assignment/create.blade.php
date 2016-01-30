@extends('app')

@section('content')
    <div class="content">
        <div class="panel panel-flat">
            <div class="panel-body">
                <div class="row">
                    {!! Form::open(['class' => 'form-horizontal', 'id'=>'new-homework-form', 'url'=>'homework'])!!}
                    <legend class="text-bold"><i class="icon-arrow-right5"></i> ข้อมูลไฟล์</legend>
                    <div class="form-group">
                        {!! Form::label('name','filename',['class' => 'col-md-1 text-right text-bold control-label']) !!}
                        <div class="col-md-2">
                            {!! Form::text('name',null, ['class' => 'form-control']) !!}    
                        </div>
                        {!! Form::label('type_id','file type',['class' => 'col-md-1 text-right text-bold control-label']) !!}
                        <div class="col-md-2">
                            {!! Form::select('type_id',$file_types, null ,['class' => 'select']) !!}
                        </div>
                        {!! Form::label('detail','more detail',['class' => 'col-md-1 text-right text-bold control-label']) !!}
                        <div class="col-md-1">
                            {!! Form::textarea('detail',null, ['class'=>'form-control']) !!}
                        </div>
                    </div>
                    {!!Form::close()!!}
                </div>
            </div>
        </div>
    </div>
@endsection