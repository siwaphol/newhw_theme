@extends('app')

@section('content')
    <div class="content">
        @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">Add Student</div>
                    <div class="panel-body">
                        <hr/>
                        {!! Form::open(['url' => 'students/create/save']) !!}
                        <div class="form-group">
                            {!! Form::label('course_id', 'Course No: ') !!}
                            @if(is_null($id))
                                {!! Form::select('course_id', $course, null, ['class'=>'select2','id'=>'course-select']) !!}
                            @else
                                {!! Form::text('course_id', $id, ['class' => 'form-control', $readonly]) !!}
                            @endif
                            <div class="form-group">
                                {!! Form::label('section', 'Section: ') !!}
                                {!! Form::text('section',null, ['class' => 'form-control', "id"=>'section-select'])!!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('student_id', 'Student ID: ') !!}
                                {!! Form::text('student_id', null, ['class' => 'form-control']) !!}
                                <input type="hidden" name="status" value="">
                            </div>
                            <div class="form-group">
                                {!! Form::submit('Submit', ['class' => 'btn btn-primary form-control'])!!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        var apiUrl = "{{url('api/v1')}}"
        var semester = {!! Session::get('semester') !!}
        var year = {!! Session::get('year') !!}

        $(function () {
            $('#course-select').select2();

            $('#course-select').on("change", function (e) {
                var courseNo = $(this).val()
                axios.get(apiUrl+"/course/"+courseNo+"/sections?semester="+semester+"&year="+year)
                    .then(function (response) {
                        console.log(response)
                        fillData(response.data)
                    })
            })
                function fillData(data) {
                    var $sectionSelect = $('#section-select')
                    if ($sectionSelect.hasClass('form-control'))
                        $sectionSelect.removeClass('form-control')
                    $sectionSelect.select2({data:data})
                }
        })
    </script>
@endsection