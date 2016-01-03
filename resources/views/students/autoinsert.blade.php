    @extends('app')
      @section('css')
          <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
      @endsection

       @section('content')
 <?php
 require_once '../Classes/PHPExcel/IOFactory.php';
            libxml_use_internal_errors(false);
            set_time_limit(0);

            $semester=Session::get('semester');
            $year=substr(Session::get('year'),-2);
            $sql=DB::select('select *  from course_section');
            $count=count($sql);
            $j=0;
            $k=0;

            for($i=0;$i<$count;$i++){
            //$course =Request::get('ddlCourse');
            //$sec =Request::get('ddlSection');
            $course = $sql[$i]->course_id;
            $sec = $sql[$i]->section;
            if($sec=='000'){
            $fileupload_name = 'https://www3.reg.cmu.ac.th/regist'.$semester.$year.'/public/stdtotal_xlsx.php?var=maxregist&COURSENO='.$course.'&SECLEC='.$sec.'&SECLAB=001&border=1&mime=xlsx&ctype=&';

            }else {

                $fileupload_name = 'https://www3.reg.cmu.ac.th/regist'.$semester.$year.'/public/stdtotal_xlsx.php?var=maxregist&COURSENO='.$course.'&SECLEC='.$sec.'&SECLAB=000&border=1&mime=xlsx&ctype=&';

                }
                        $fileupload='../temp/file.xlsx';
                        //chmod($fileupload, 0755);
                        	//chmod($fileupload_name, 0755);
                        	//copy($fileupload_name,$fileupload);
                        	//$objPHPExcel =PHPExcel_IOFactory::load('https://www3.reg.cmu.ac.th/regist'.$semester.$year.'/public/stdtotal_xlsx.php?var=maxregist&COURSENO='.$course.'&SECLEC='.$sec.'&SECLAB=000&border=1&mime=xlsx&ctype=&');
                        	//$objPHPExcel =PHPExcel_IOFactory::load($fileupload);

                       //if(PHPExcel_IOFactory::load($fileupload)==true){
                       if(copy($fileupload_name,$fileupload)){
                            $sco[$j]=$course;
                            $sse[$j]=$sec;
                            $l=0;
                            //$objReader = PHPExcel_IOFactory::createReader('Excel2007');
                            //$objReader->setReadDataOnly(true);
                           // $objPHPExcel = $objReader->load($fileupload);
                           // $objWorksheet = $objWorksheet->setActiveSheetIndex(1);
                        //$objPHPExcel = new PHPExcel();
                            $objPHPExcel =PHPExcel_IOFactory::load($fileupload);

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
                                $cell = $worksheet->getCellByColumnAndRow(1,$row);
                                $no = $cell->getValue();
                                $cell = $worksheet->getCellByColumnAndRow(2,$row);
                                $code = (string)$cell->getValue();
                                $cell = $worksheet->getCellByColumnAndRow(3,$row);
                                $fname = $cell->getValue();
                                $cell = $worksheet->getCellByColumnAndRow(4,$row);
                                $lname = $cell->getValue();
                                // $status=" ";
                                $cell=$worksheet->getCellByColumnAndRow(5,$row);
                                $status=$cell->getValue();
                                /*if(isset($cell)){
                                $status=" ";

                                }else{
                                $status=$cell->getValue();
                                }
                                */
                                //$fullnames=$fname."  ".$lname;
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

                                    $l++;

                               }
                                if ($rowregist==0 && $cuser>0 ) {

                                    //  $command =DB::insert('insert into students (id,studentName,status) values (?,?,?)',array($code,$fullnames,$status)) ;
                                       //$command =DB::insert('insert into users (id,firstname_th,lastname_th,role_id) values (?,?,?,?)',array($code,$fname,$lname,'0001')) ;

                                      $regis =DB::insert('insert into course_student(student_id,course_id,section,status,semester,year) values (?,?,?,?,?,?)',array($code,$course,$sec,$status,Session::get('semester'),Session::get('year')));
                                    $l++;


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
                        $stu[$j]=$l;
                        $j++;
                        }else{
                            $fco[$k]=$course;
                            $fse[$k]=$sec;
                            $k++;

                        }
                        }

      ?>
      <h2 align="center"> Import Result</h2>


          <div class="container">
              <div class="row">
                  <div class="col-md-10 col-md-offset-1">
                      <div class="panel panel-default">
                          <div class="panel-heading" align="center">Successfull</div>

                          <div class="panel-body">

                              {{--<h4><a href="{{ url('/assistants') }}">นักศึกษาช่วยสอนตามรายวิชา</a></h4>--}}

                              <div class="table-responsive">
                                  <table class="table" id="example" cellspacing="0" width="100%" >
                                      <thead>
                                      <tr>
                                          <th>No</th><th>Course</th><th>Section</th><th>Student</th>
                                      </tr>
                                      </thead>
                                      <tfoot>
                                      <tr>
                                          <th>No</th><th>Course</th><th>Section</th><th>Student</th>
                                      </tr>
                                      </tfoot>
                                      <tbody>

                                      <?php
                                      for($x=0;$x<$j;$x++){
                                      ?>

                                          <tr>
                                              <td>{{ $x+1}}</td>
                                              <td>{{ $sco[$x] }}</td>
                                              <td>{{ $sse[$x] }}</td>
                                              <td>{{$stu[$x]}}</td>
                                           </tr>
                                      <?php
                                      }
                                      ?>
                                      </tbody>
                                  </table>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <div class="container">
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="panel panel-default">
                                    <div class="panel-heading" align="center">Fail</div>

                                    <div class="panel-body">

                                        {{--<h4><a href="{{ url('/assistants') }}">นักศึกษาช่วยสอนตามรายวิชา</a></h4>--}}

                                        <div class="table-responsive">
                                            <table class="table" id="example1" cellspacing="0" width="100%" >
                                                <thead>
                                                <tr>
                                                    <th>No</th><th>Course</th><th>Section</th>
                                                    {{--<th>Student</th>--}}
                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>
                                                    <th>No</th><th>Course</th><th>Section</th>
                                                    {{--<th>Student</th>--}}
                                                </tr>
                                                </tfoot>
                                                <tbody>

                                                <?php
                                                for($x=0;$x<$k;$x++){
                                                ?>

                                                    <tr>
                                                        <td>{{ $x+1}}</td>
                                                        <td>{{ $fco[$x] }}</td>
                                                        <td>{{ $fse[$x] }}</td>

                                                     </tr>
                                                <?php
                                                }
                                                ?>
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
       $(document).ready(function() {
                $('#example1').dataTable( {
                    "order": [[ 3, "desc" ]],
                    "scrollX": true
                } );
            } );

          </script>

      @endsection

      @endsection
