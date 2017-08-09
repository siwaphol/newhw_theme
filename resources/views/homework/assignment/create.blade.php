@extends('app')

@section('css')
    <style>

    </style>
@endsection

@section('content')
    <div class="row">
        @if(is_null($homework))
        {!! Form::open(['method'=>'post', 'url'=>'assignment', 'id'=>'new-file-form']) !!}
        @else
            {!! Form::model($homework,['method'=>'post', 'url'=>"assignment/" . $homework->id,
            'id'=>'new-file_form']) !!}
        @endif
        {!! Form::input('input','course_id',$course->id, ['class'=>'hidden']) !!}
        <div class="panel panel-flat">
            <div class="panel-heading">
                {{--<h6 class="panel-title">New Assignment for {{$course->id}} {{$course->name}}</h6>--}}
                @if (isset($errors)&&count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                            @if(Session::has('extra-error'))
                                <li>{{Session::get('extra-error')}}</li>
                            @endif
                        </ul>
                    </div>
                @endif
            </div>
            <div class="panel-body">
                <div class="form-horizontal">
                    <div class="row">
                        <label for="" class="control-label col-lg-2"></label>
                        <label for="" class="col-lg-10"><code>การตั้งชื่อไฟล์ ให้ใช้เฉพาะอักขระภาษาอังกฤษ ตัวเลข และเครื่องหมาย _ สำหรับระบุตำแหน่งรหัสนักศึกษาในชื่อไฟล์ให้ใช้ {id} ไม่ต้องใส่นามสกุลไฟล์</code>
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label col-lg-2">File Name</label>
                        <div class="col-lg-10">
                            {!! Form::text( 'name', old('name'),['class'=>'form-control', 'placeholder'=>'ex. lab_01_{id}']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <label for="" class="control-label col-lg-2"></label>
                        <label for="" class="col-lg-10"><code>นามสกุลไฟล์ ต้องมี . นำหน้า และคั่นระหว่างหลายนามสกุลด้วย ,</code>
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="type_id" class="control-label col-lg-2">Extension</label>
                        <div class="col-lg-10">
                            @if(is_null($homework))
                            {!! Form::text('type', old('type'),['class'=>'form-control', 'placeholder'=>'ex. .xls,.xlsx']) !!}
                            @else
                            {!! Form::text('type', $homework->extension ,['class'=>'form-control', 'placeholder'=>'ex. .xls,.xlsx']) !!}
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="details" class="control-label col-lg-2">Details</label>
                        <div class="col-lg-10">
                            {!! Form::textarea( 'detail', old('detail'),['class'=>'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="section" class="control-label col-lg-2">Sections</label>
                        <div class="col-lg-10">
                            @if(is_null($homework))
                            {!! Form::select('section[]',$distinctSection,null,['multiple'=>'multiple','id'=>'section-select','class'=>'select']) !!}
                            @else
                            {!! Form::text('section', null, ['readonly', 'class'=>'form-control']) !!}
                            @endif
                        </div>
                    </div>
                    <div class="form-group text-center" style="margin-top: 10px;">
                        <a href="" class="btn btn-primary" id="select-all-btn">Select All Sections</a>
                        <a href="" class="btn btn-primary" id="deselect-all-btn">DeSelect All Sections</a>
                    </div>
                    <div class="form-group text-center" style="margin-top: 10px;">
                        {!! Form::input('submit', 'submit', 'submit', ['class'=>'btn btn-success']) !!}
                    </div>
                </div>
            </div>
        </div>

            @if(is_null($homework))
                @foreach($distinctSection as $c_section)
                    <div class="panel panel-body border-top-primary hidden" id="section-{{$c_section}}-panel">
                        <div class="form-group">
                            <label for="" class="control-label col-lg-2">Section {{$c_section}} Due Date</label>
                            <div class="col-lg-4">
                                <input type="date" name="due_date[]" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label col-lg-2">Section {{$c_section}} Due Time</label>
                            <div class="col-lg-4">
                                <input type="time" name="due_time[]" value="00:00" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label col-lg-2">Section {{$c_section}} Accept Date</label>
                            <div class="col-lg-4">
                                <input type="date" name="accept_date[]" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label col-lg-2">Section {{$c_section}} Accept Time</label>
                            <div class="col-lg-4">
                                <input type="time" name="accept_time[]" value="23:59" class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="panel panel-body border-top-primary" id="section-{{$homework->section}}-panel">
                    <div class="form-group">
                        <label for="" class="control-label col-lg-2">Section {{$homework->section}} Due Date</label>
                        <div class="col-lg-4">
                            {!! Form::date('due_date', $homework->due_date->format('Y-m-d'), ['class'=>"form-control"]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label col-lg-2">Section {{$homework->section}} Due Time</label>
                        <div class="col-lg-4">
                            {!! Form::time('due_time', $homework->due_date->format("H:i"), ['class'=>"form-control"]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label col-lg-2">Section {{$homework->section}} Accept Date</label>
                        <div class="col-lg-4">
                            {!! Form::date('accept_date', $homework->accept_date->format('Y-m-d'), ['class'=>"form-control"]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label col-lg-2">Section {{$homework->section}} Accept Time</label>
                        <div class="col-lg-4">
                            {!! Form::time('accept_time', $homework->accept_date->format("H:i"), ['class'=>"form-control"]) !!}
                        </div>
                    </div>
                </div>
            @endif
        {!! Form::close() !!}
    </div>
@endsection

@section('script')
    @if(is_null($homework))
    <script type="text/javascript" src="{{asset('limitless_assets/js/plugins/forms/selects/select2.min.js')}}"></script>
    <script>
        $(function(){
            var $selectClass = $(".select");

            function showAndHideSectionPanel(section, option) {
                var $cSectionPanel = $("#section-"+section+"-panel");

                if(option==='show'){
                    $cSectionPanel.find('input').each(function(index){
                        $(this).prop("disabled", false);
                    });
                    $cSectionPanel.removeClass("hidden");
                    return 0;
                }

                $cSectionPanel.find('input').each(function(index){
                    $(this).prop("disabled", true);
                });
                $cSectionPanel.addClass("hidden");
            }

            if ($("#section-select").val()){
                $("#section-select").val().map(function(item){
                    showAndHideSectionPanel(item, 'show')
                    return item
                })
            }

            $selectClass.select2({
                minimumResultsForSearch: "-1",
                placeholder: "Click to select..."
            });
            $selectClass.on("change", function (e) {
                console.log("change",e);
                if(e.added){
                    showAndHideSectionPanel(e.added.id,'show');
                }
                else{
                    showAndHideSectionPanel(e.removed.id,'hidden');
                }
            });

            $("#select-all-btn").click(function (e) {
                e.preventDefault();
                $selectClass.select2('destroy').find('option').prop('selected', 'selected').end().select2();
                $selectClass.find("option").each(function (index) {
                    showAndHideSectionPanel($(this).val(),'show');
                });
            });
            $("#deselect-all-btn").click(function (e) {
                e.preventDefault();
                $selectClass.select2('destroy').find('option').prop('selected', false).end().select2();
                $selectClass.find("option").each(function (index) {
                    showAndHideSectionPanel($(this).val(),'hidden');
                });
            });
        });
    </script>
    @endif
@endsection