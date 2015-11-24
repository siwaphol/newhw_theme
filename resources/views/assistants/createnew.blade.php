@extends('app')

@section('content')

<script type="text/javascript">
function onSubmitMain() {
	var msgErr = ""
	if($("#courseId").val() == ""){
		msgErr += "กรุณาเลือกวิชา\n"
	}
	if($("#sectionId").val() == ""){
		msgErr += "กรุณาเลือกตอน\n"
	}
	if(msgErr != ""){
		alert(msgErr)
		return false
	}else{
		return true
	}
}

	function ListSection(SelectValue)
    {
    frmMain.sectionId.length = 0
    //*** Insert null Default Value ***//
    var myOption = new Option('เลือกตอน','')
    frmMain.sectionId.options[frmMain.sectionId.length]= myOption
    <?php
    $intRows = 0;
    $objQuery =DB::select('SELECT section,course_id FROM course_section ORDER BY section ASC ');
    $count=count($objQuery);
    $i=0;
    for($i=0;$i<$count;$i++)
    {
    $intRows++;
    ?>
    x = <?php echo $intRows;?>;
    mySubList = new Array();
    strGroup = "<?php echo $objQuery[$i]->course_id;?>";
    strValue = "<?php echo $objQuery[$i]->section;?>";
    mySubList[x,0] = strGroup;
    mySubList[x,1] = strValue;
    if (mySubList[x,0] == SelectValue){
    var myOption = new Option(mySubList[x,1])
    frmMain.sectionId.options[frmMain.sectionId.length]= myOption
    }
    <?php
    }

    ?>
    }


    </script>

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">เพิ่มนักศึกษาช่วยสอน</div>

                    <div class="panel-body">

                        <hr/>

                        <!--{!! Form::open(['url' => 'assistants/create/save']) !!}
                        -->
                        <form action="create/save" method="post" name="frmMain" id="frmMain" onsubmit="return onSubmitMain()" class="form-horizontal"  align="center">
                        <div class="form-group">
                        {!! Form::label('courseId', 'กระบวนวิชา ') !!}
                        <select id="courseId" name="courseId" onChange = "ListSection(this.value)" class="form-control">
                        						<option selected value="">เลือกวิชา</option>
                        						<?php

                        						$sql=DB::select('select * from course_section');
                                                $count=count($sql);
                                                $i=0;
                                                  for($i=0;$i<$count;$i++){
                        						?>
                        						<option value={{$sql[$i]->course_id}}>{{$sql[$i]->course_id}}</option>
                        						<?php
                        						}
                        						?>
                        					</select>
                    </div><div class="form-group">
                    {!! Form::label('sectionId', 'ตอน ') !!}
                   <select id="sectionId" name="sectionId" class="form-control">
                   						<option selected value="">เลือกตอน</option>
                   					</select>
                    </div><div class="form-group">
                    {!! Form::label('taId', 'นักศึกษาช่วยสอน ') !!}
                      <input type="text" name="taId" class="form-control" >
                    </div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            {!! Form::submit('เพิ่ม', ['class' => 'btn btn-primary form-control']) !!}
                        </div>
                        </form>>
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