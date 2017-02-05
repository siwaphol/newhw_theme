    @extends('app')
      @section('css')
          <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
      @endsection

       @section('content')
 <?php


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
