@extends('app')

@section('content')

<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('input[type="radio"]').click(function(){
        if($(this).attr("value")=="no"){
            $(".box").not(".no").hide();
            $(".no").show();
        }
        if($(this).attr("value")=="yes"){
            $(".box").not(".yes").hide();
            $(".yes").show();
        }
         if($(this).attr("value")=="yest"){
                    $(".box").not(".yest").hide();
                    $(".yest").show();
                }
          if($(this).attr("value")=="not"){
                     $(".box").not(".not").hide();
                     $(".not").show();
                 }
          if($(this).attr("value")=="yestt"){
                             $(".box").not(".yestt").hide();
                             $(".yestt").show();
                         }
                   if($(this).attr("value")=="nott"){
                              $(".box").not(".nott").hide();
                              $(".nott").show();
                          }
    });
});
</script>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">กำหนดการบ้าน</div>

                    <div class="panel-body">
                        <h1 align="center">กระบวนวิชา {{$course['co']}}</h1>
                        <hr/>

                        {{ Form::open(['url' => 'homework_assignment/create/save']) }}
                        <input type="hidden" name="courseId" value={{$course['co']}}>
                    <div class="form-control">
                            <label><input type="radio" name="issec" value="yes" checked="checked"> แยกตอน</label>
                            <label><input type="radio" name="issec" value="no" >ทุกตอน</label>


                        </div>
                        <div class="no box"> </div>
                        <div class="yes box">
                    <div class="form-group" align="center">

                    					<select id="sectionid" name="sectionid" onChange = "ListSection(this.value)" class="form-control">
                    						<option selected value="">เลือกตอน</option>
                    						<?php

                    						$sql=DB::select('select * from course_section where courseId=?',array($course['co']));
                                            $count=count($sql);
                                            $i=0;
                                              for($i=0;$i<$count;$i++){
                    						?>
                    						<option value={{$sql[$i]->sectionId}}>{{$sql[$i]->sectionId}}</option>
                    						<?php
                    						}
                    						?>
                    					</select>

                    </div>
                        <!--
                        <div class="form-group">
                        {{ Form::label('sectionid', 'ตอน ') }}
                        {{ Form::text('sectionid', null, ['class' => 'form-control']) }}
                        </div>
                        -->


                        </div>
                        <!--
                        <div class="form-group">
                        {{ Form::label('sectionid', 'ตอน ') }}
                        {{ Form::text('sectionid', null, ['class' => 'form-control']) }}
                    </div>
                    -->
                    <div class="form-group">
                        {{ Form::label('homeworkname', 'ชื่อการบ้าน: ') }}
                        {{ Form::text('homeworkname', null, ['class' => 'form-control']) }}
                   </div>
                    <div class="form-group">
                        {{ Form::label('homeworkFileName', 'ชื่อไฟล์: ') }}
                        {{ Form::text('homeworkFileName', null, ['class' => 'form-control']) }}
                    </div>
                     <div class="form-control">
                           {{ Form::label('homeworkFileType', 'ชนิดไฟล์: ') }}
                         <label><input type="radio" name="istype" value="yest" checked="checked"> กำหนด</label>
                         <label><input type="radio" name="istype" value="not" >ไม่กำหนด</label>


                    </div>
                    <div class="not box"> </div>
                    <div class="yest box">
                        <div class="form-group">
                        	<select id="homeworkFileType" name="homeworkFileType" onChange = "ListSection(this.value)" class="form-control">
                                            						<option selected value="">เลือกชนิดไฟล์</option>
                                            						<?php

                                            						$sql=DB::select('select * from homework_type ');
                                                                    $count=count($sql);
                                                                    $i=0;
                                                                      for($i=0;$i<$count;$i++){
                                            						?>
                                            						<option value={{$sql[$i]->hwTypeName}}>{{$sql[$i]->hwTypeName}}</option>
                                            						<?php
                                            						}
                                            						?>
                                            					</select>
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('homeworkDetail', 'รายละเอียด: ') }}
                        {{ Form::text('homeworkDetail', null, ['class' => 'form-control']) }}
                    </div>
                    <!--
                    <div class="form-group">
                        {{ Form::label('issubFolder', 'Issubfolder: ') }}
                        {{ Form::text('issubFolder', null, ['class' => 'form-control']) }}
                    </div>
                    -->
                     <div class="form-control">
                                               {{ Form::label('issubFoldee', 'สร้างไดเร็คทอรี์: ') }}
                                             <label><input type="radio" name="issubFolder" value="yestt" checked="checked"> สร้าง</label>
                                             <label><input type="radio" name="issubFolder" value="nott" >ไม่สร้าง</label>


                       </div>
                       <div class="nott box"> </div>
                       <div class="yestt box">
                    <div class="form-group">

                        {{ Form::text('subFolder', null, ['class' => 'form-control']) }}
                    </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('dueDtae', 'วันกำหนดส่ง: ') }}
                        {{ Form::input('date','dueDtae', null, ['class' => 'form-control']) }}
                    </div>
                    <!--
                    <div class="form-group">
                        {{ Form::label('assignDate', 'วันNoกำหนดการบ้าน: ') }}
                        {{ Form::input('date','assignDate', null, ['class' => 'form-control']) }}
                    </div>
                    -->
                    <div class="form-group">
                        {{ Form::label('acceptDate', 'วันNoส่งช้าNoสุด: ') }}
                        {{ Form::input('date','acceptDate', null, ['class' => 'form-control']) }}
                    </div>

                        <div class="form-group">
                            {{ Form::submit('Create', ['class' => 'btn btn-primary form-control']) }}
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