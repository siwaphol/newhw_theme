<?php

 /* Created by PhpStorm.
 * User: boonchuay
 * Date: 23/6/2558
 * Time: 0:08
 */
 ?>
 @extends('app')
 @section('css')
     <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
 @endsection

 @section('content')
 @section('content')
   <script type="text/javascript">

  $(document).ready(function() {
      $('#example').dataTable( {
          "order": [[ 3, "desc" ]]
      } );
  } );

      </script>
 <?php
 require_once '../Classes/PHPExcel/IOFactory.php';

            //$course =Request::get('ddlCourse');
            //$sec =Request::get('ddlSection');
            $course = $cours['co'];
            $sec = $cours['sec'];
            $semester=Session::get('semester');
            $year=substr(Session::get('year'),-2);

            $fileupload_name = 'https://www3.reg.cmu.ac.th/regist'.$semester.$year.'/public/stdtotal_xlsx.php?var=maxregist&COURSENO='.$course.'&SECLEC='.$sec.'&SECLAB=000&border=1&mime=xlsx&ctype=&';
              $fileupload_name = $cours['fileupload'];

                        $fileupload='../temp/file.xlsx';
                        //chmod($fileupload, 0755);
                        	//chmod($fileupload_name, 0755);
                        copy($fileupload_name,$fileupload);

                        //$objPHPExcel = new PHPExcel();
                        $objPHPExcel = PHPExcel_IOFactory::load($fileupload);
                        //$objPHPExcel ->load($fileupload)->get();
                        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                            $worksheetTitle     = $worksheet->getTitle();
                            $highestRow         = $worksheet->getHighestRow(); // e.g. 10
                            $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
                            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
                            $nrColumns = ord($highestColumn) - 64;

                            for ($row =8; $row <= $highestRow; ++ $row) {
                                //echo '<tr>';
                                //for ($col = 1; $col < $highestColumnIndex; ++ $col) {
                                $cell = $worksheet->getCellByColumnAndRow(1, $row);
                                $no = $cell->getValue();
                                $cell = $worksheet->getCellByColumnAndRow(2, $row);
                                $code = (string)$cell->getValue();
                                $cell = $worksheet->getCellByColumnAndRow(3, $row);
                                $fname = $cell->getValue();
                                $cell = $worksheet->getCellByColumnAndRow(4, $row);
                                $lname = $cell->getValue();
                                 $status=" ";
                                $cell=$worksheet->getCellByColumnAndRow(5, $row);
                                $status=$cell->getValue();
                                /*if(isset($cell)){
                                $status=" ";

                                }else{
                                $status=$cell->getValue();
                                }
                                */
                                $fullnames=$fname."  ".$lname;
                                //echo $no;
                                if ($no>0 && $no<=200) {
                                    //$stu=DB::select('select *  from users Where id=? and role_id=0001',array($code));

                                    $reg=DB::select(' select * from course_student where course_id=? and section=? and student_id=?
                                                    and semester=? and year=?',array($course,$sec,$code,Session::get('semester'),Session::get('year')));
                                    //$rowstudent=count($stu);
                                $user=DB::select('select * from users where id=? ',array($code));

                                $cuser=count($user);
                               $rowregist=count($reg);
                               if ($rowregist==0 && $cuser==0 ) {

                                 //  $command =DB::insert('insert into students (id,studentName,status) values (?,?,?)',array($code,$fullnames,$status)) ;
                                    $command =DB::insert('insert into users (id,firstname_th,lastname_th,role_id) values (?,?,?,?)',array($code,$fname,$lname,'0001')) ;

                                   $regis =DB::insert('insert into course_student(student_id,course_id,section,status,semester,year) values (?,?,?,?,?,?)',array($code,$course,$sec,$status,Session::get('semester'),Session::get('year')));



                               }
                                if ($rowregist==0 && $cuser>0 ) {

                                    //  $command =DB::insert('insert into students (id,studentName,status) values (?,?,?)',array($code,$fullnames,$status)) ;
                                       //$command =DB::insert('insert into users (id,firstname_th,lastname_th,role_id) values (?,?,?,?)',array($code,$fname,$lname,'0001')) ;

                                      $regis =DB::insert('insert into course_student(student_id,course_id,section,status,semester,year) values (?,?,?,?,?,?)',array($code,$course,$sec,$status,Session::get('semester'),Session::get('year')));



                                  }
                                           if($rowregist>0){
                                               if($reg[0]->status!=$status){
                                                  $update=DB::update('update course_student set status=? where student_id=?
                                                                    and semester=? and year=?',array($status,$code,Session::get('semester'),Session::get('year')));
                                               }

                                           }


                                    }

                            }
                        }

      ?>
       <?php
              $student=DB::select('select re.student_id as studentid,stu.firstname_th as firstname_th,stu.lastname_th as lastname_th ,re.status as status
                                                 from course_student  re
                                                 left join users stu on re.student_id=stu.id
                                                 where re.course_id=? and  re.section=? and re.semester=? and re.year=?
                                                 order by re.student_id
                                                 ',array($course,$sec,Session::get('semester'),Session::get('year')));
              $count=count($student);
               $coid=DB::select('select * from course_section c where c.course_id=? and c.section=? and c.semester=? and c.year=?',array($course,$sec,Session::get('semester'),Session::get('year')));
              ?>
                  <div class="container">
                      <div class="row">
                          <div class="col-md-10 col-md-offset-1">
                              <div class="panel panel-default">
                                  <div class="panel-heading" align="center">Student Enrollment</div>

                                  <div class="panel-body">
                                      <h3 align="center">{{$course}} || {{$sec}} </h3>

                                      {{--<h4><a href="{{ url('/students/create/'.$coid[0]->id) }}">เพิ่มนักศึกษา</a></h4>--}}

                                       {{--{!! Form::open(['url' => 'students/export']) !!}--}}

                                        {{--<input type="hidden" name="course" id="course" value='{{$course}}'>--}}
                                        {{--<input type="hidden" name="sec" id="sec" value='{{$sec}}'>--}}

                                        {{--<button type="submit" class="btn btn-link">export csv</button>--}}
                                         {{--{!! Form::close() !!}--}}
                                      <div class="table-responsive">
                                          <table class="table" id="example" cellspacing="0" width="100%" >
                                              <thead>
                                              <tr>
                                                 <th>Student ID</th><th>Name</th><th>Status</th><th>Delete</th>
                                             </tr>
                                              </thead>
                                              <tfoot>
                                              <tr>
                                                 <th>Student ID</th><th>Name</th><th>Status</th><th>Delete</th>
                                             </tr>
                                              </tfoot>
                                              <tbody>
                                              {{-- */$x=0;/* --}}
                                              <?php
                                              $item=$student;
                                                  for($x=0;$x<$count;$x++){
                                              ?>

                                                  <tr>

                                                     <td>{{ $item[$x]->studentid }}</td>

                                                                                                    {{--<td><a href="{{ url('/students/show', $item[$x]->studentid) }}">{{ $item[$x]->studentid }}</a></td>--}}
                                                                                                    <td>{{ $item[$x]->firstname_th." ".$item[$x]->lastname_th }}</td>
                                                                                                    {{--<td><a href="{{ url('/students/show', $item[$x]->studentid) }}">{{ $item[$x]->firstname_th." ".$item[$x]->lastname_th }}</a></td>--}}
                                                                                                      <!--
                                                      <td><a href="{{ url('/students/edit/'.$item[$x]->studentid) }}">Edit</a> </td>
                                                      -->
                                                      <td>{{ $item[$x]->status }}</td>
                                                      <td>
                                                             <?php
                                                            // $data=array('id'=>$item[$x]->studentid,'co'=>$course['co'],'sec'=>$course['sec']);
                                                             ?>
                                                          {!! Form::open(['url' => 'students/delete']) !!}

                                                          <input type="hidden" name="course" id="course" value='{{$course}}'>
                                                          <input type="hidden" name="sec" id="sec" value='{{$sec}}'>
                                                          <input type="hidden" name="id" id="id" value='{{$item[$x]->studentid}}'>
                                                          <button type="submit" class="btn btn-link" onclick="return confirm('Are you sure you want to delete?')">Delete</button>
                                                          {!! Form::close() !!}
                                                          </td>
                                                  </tr>
                                              <?php } ?>
                                              </tbody>
                                          </table>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
      @endsection
      @section('script')
      <script src="//cdnjs.cloudflare.com/ajax/libs/datatables/1.10.7/js/jquery.dataTables.min.js"></script>

        <script type="text/javascript">

      $(document).ready(function() {
          $('#example').dataTable( {
              "order": [[ 3, "desc" ]],
              "scrollX": true
          } );
      } );

          </script>
      @endsection