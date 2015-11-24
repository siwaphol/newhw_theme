<?php
/**
 * Created by PhpStorm.
 * User: boonchuay
 * Date: 22/6/2558
 * Time: 20:23
 */
?>
@extends('app')
@section('content')

<script type="text/javascript">
function onSubmitMain() {
	var msgErr = ""
	if($("#ddlCourse").val() == ""){
		msgErr += "กรุณาเลือกวิชา\n"
	}
	if($("#ddlSection").val() == ""){
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
    frmMain.ddlSection.length = 0
    //*** Insert null Default Value ***//
    var myOption = new Option('เลือกตอน','')
    frmMain.ddlSection.options[frmMain.ddlSection.length]= myOption
    <?php

    $intRows = 0;
    $objQuery=array();
    $teacher=Auth::user()->username;
    if(Auth::user()->role_id=='0100'){
    $objQuery =DB::select('SELECT DISTINCT  section,course_id FROM course_section cs
                          left join users  tea on cs.teacher_id=tea.id
                          where tea.username=?
                          and cs.semester=? and cs.year=?
                           ORDER BY section ASC ',array($teacher,Session::get('semester'),Session::get('year')));
}
    if(Auth::user()->role_id=='1000'){
        $objQuery =DB::select('SELECT  DISTINCT section,course_id FROM course_section cs
                               where cs.semester=? and cs.year=? ORDER BY section ASC ',array(Session::get('semester'),Session::get('year')));
        }
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
    frmMain.ddlSection.options[frmMain.ddlSection.length]= myOption
    }
    <?php
    }

    ?>
    }
    /*function MM_jumpMenu(targ,selObj,restore){ //v3.0
      eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
      if (restore) selObj.selectedIndex=0;
    }*/

    </script>

<h3 align="center">เลือกกระบวนวิชา ตอน Noต้องการดูรายชื่อ</h3>
<div class="portlet"align="right">
<div class="portlet-body form"  align="center">
<form action="students/showlist" method="post" name="frmMain" id="frmMain" onsubmit="return onSubmitMain()" class="form-horizontal"  align="center">
<div class="form-body" >
            <div class="form-group" align="center">
                    <div class="col-md-4 col-md-offset-4" align="center" >
					<select id="ddlCourse" name="ddlCourse" onChange = "ListSection(this.value)" class="form-control">
						<option selected value="">เลือกวิชา</option>
						<?php
						$teacher=Auth::user()->username;
                        $sql=array();
                        if(Auth::user()->role_id=='0100'){
                        $sql=DB::select('SELECT DISTINCT course_id FROM course_section cs
                                          left join users  tea on cs.teacher_id=tea.id
                                          where tea.username=?
                                          and cs.semester=? and cs.year=?
                                           ORDER BY course_id ASC ',array($teacher,Session::get('semester'),Session::get('year')));
}
                        if(Auth::user()->role_id=='1000'){
						$sql=DB::select('select DISTINCT course_id from course_section cs
                                           where  cs.semester=? and cs.year=?
                                           ORDER BY course_id ASC',array(Session::get('semester'),Session::get('year')));
}
                        $count=count($sql);

                        $i=0;
                          for($i=0;$i<$count;$i++){
						?>
						<option value={{$sql[$i]->course_id}}>{{$sql[$i]->course_id}}</option>
						<?php
						}
						?>
					</select>
					</div>
			</div>

			<div class="form-group" align="center">
					<div class="col-md-4 col-md-offset-4">

					<select id="ddlSection" name="ddlSection" class="form-control">
						<option selected value="">เลือกตอน</option>
					</select>
                      </div>
            </div>

            <div class="form-group" align="center">
                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                    <div class="col-md-4 col-md-offset-4">
                    <input type="submit" name="ok" value="ตกลง"  class="form-control"/>
                    </div>
            </div>
          </div>
          </form>
          </div>
          </div>

    @endsection
    @sectoon('jquery')

    @include ('partials.jquery')
    @endsection