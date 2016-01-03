<div id="editsend" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" align="center">Edit Status Homework </h4>
            </div>
            <div class="modal-body">
                <div class="portlet" align="right">
                    <div class="portlet-body form" align="center">
                        <form action="{{url('homework/editstatus')}}" method="post" name="frmhw" id="frmhw"
                              onsubmit="return onSubmit()" class="form-horizontal" align="center">
                            <div class="form-body">
                                <div class="form-group" align="center">
                                    <div class="col-md-4 col-md-offset-4" align="center">
                                        {!! Form::label('hw', 'Homework') !!}
                                        <select id="hw" name="hw" class="form-control">
                                            <option selected value="">Select Homework</option>
                                            <?php
                                            $sql = array();

                                            $sql = DB::select('SELECT * from homework where course_id=? and section=?
                                                                  and semester=? and year=?
                                                                order by name ',
                                                    array($course['co'], $course['sec'], Session::get('semester'), Session::get('year')));

                                            $count = count($sql);

                                            $i = 0;
                                            for($i = 0;$i < $count;$i++){
                                            ?>
                                            <option value={{$sql[$i]->id}}>{{$sql[$i]->name}}</option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" name="course" value="{{$course['co']}}">
                                <input type="hidden" name="sec" value="{{$course['sec']}}">

                                <div class="form-group" align="center">
                                    <div class="col-md-4 col-md-offset-4" align="center">
                                        {!! Form::label('stu', 'Student') !!}
                                        <select id="stu" name="stu" class="form-control">
                                            <option selected value="">Select Student</option>
                                            <?php
                                            $sql = array();

                                            $sql = DB::select('SELECT * from course_student
                                                                  where course_id=? and section=?
                                                                  and semester=? and year=?
                                                                order by student_id ',
                                                    array($course['co'], $course['sec'], Session::get('semester'), Session::get('year')));

                                            $count = count($sql);

                                            $i = 0;
                                            for($i = 0;$i < $count;$i++){
                                            ?>
                                            <option value={{$sql[$i]->student_id}}>{{$sql[$i]->student_id}}</option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" align="center">
                                    <div class="col-md-4 col-md-offset-4" align="center">
                                        {!! Form::label('status', 'Status') !!}
                                        <select id="status" name="status" class="form-control">
                                            <option selected value="">Select Status</option>
                                            <option value=1>OK</option>
                                            <option value=2>LATE</option>
                                            <option value=3>!!!</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group" align="center">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

                                    <div class="col-md-4 col-md-offset-4">
                                        <input type="submit" name="ok" value="Edit" class="form-control"/>
                                    </div>
                                </div>
                            </div>
                        </form>
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
</div>