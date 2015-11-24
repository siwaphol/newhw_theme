<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{url('home')}}">CS CMU MIS</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            <ul class="nav navbar-nav navbar-right">
                @if(!Auth::guest())
                    @if (Auth::user()->isAdmin())
                        <li class="dropdown">
                            <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> User<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{url('ta')}}">Teaching Assistant</a></li>
                                <li><a href="{{url('teachers')}}">Lecturer</a></li>
                                <li><a href="{{url('admin')}}">Admin</a></li>
                            </ul>
                        </li>
                        <li><a href="{{url('semesteryear')}}"><span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span> Semester</a></li>
                        <li><a href="{{url('course')}}"><span class="glyphicon glyphicon-book" aria-hidden="true"></span> Course</a></li>

                    @endif
                    @if(Auth::user()->isAdmin()||Auth::user()->isTeacher())

                        <li>
                            <a type="button" class="btn  " data-toggle="modal"
                                    data-target="#myModal"> {{\Session::get('semester')}}/{{Session::get('year')}}
                            </a>
                        </li>
                    @endif

                    <li><a href="{{url('home')}}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
                    @if(Auth::user()->isStudent() || Auth::user()->isStudentandTa())
                        <li><a href="#bin"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></li>
                    @endif
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-expanded="false">{{ Auth::user()->firstname_th . " " . Auth::user()->lastname_th }}
                            ({{ Auth::user()->role() }}) <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
            @if (!Auth::guest())
                @if (Auth::user()->isTeacher() || Auth::user()->isAdmin())
                    <ul class="nav navbar-nav navbar-right">
                        <div id="myModal" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title" align="center">Change semester year </h4>
                                    </div>
                                    <div class="modal-body">
                                        <script type="text/javascript">
                                            function onSubmit() {
                                                var msgErr = "";
                                                if ($("#year").val() == "") {
                                                    msgErr += "Please select year\n"
                                                }
                                                if ($("#semester").val() == "") {
                                                    msgErr += "Please select semester\n"
                                                }
                                                if (msgErr != "") {
                                                    alert(msgErr);
                                                    return false
                                                } else {
                                                    return true
                                                }
                                            }

                                            function Listsemester(SelectValue) {
                                                frmyear.semester.length = 0;
                                                //*** Insert null Default Value ***//
                                                var myOption = new Option('Select Semester', '');
                                                frmyear.semester.options[frmyear.semester.length] = myOption;
                                                <?php

                                                $intRows = 0;
                                                $objQuery=array();

                                                if(Auth::user()->isTeacher()){
                                                $objQuery =DB::select('SELECT DISTINCT semester,year FROM semester_year   ORDER BY semester ASC ');
                                                }
                                                if(Auth::user()->isAdmin()){
                                                    $objQuery =DB::select('SELECT DISTINCT semester,year FROM semester_year  ORDER BY semester ASC ');
                                                    }
                                                $count=count($objQuery);
                                                $i=0;
                                                for($i=0;$i<$count;$i++)
                                                {
                                                $intRows++;
                                                ?>
                                                x = <?php echo $intRows;?>;
                                                mySubList = new Array();
                                                strGroup = "<?php echo $objQuery[$i]->year;?>";
                                                strValue = "<?php echo $objQuery[$i]->semester;?>";
                                                mySubList[x, 0] = strGroup;
                                                mySubList[x, 1] = strValue;
                                                if (mySubList[x, 0] == SelectValue) {
                                                    var myOption = new Option(mySubList[x, 1]);
                                                    frmyear.semester.options[frmyear.semester.length] = myOption;
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
                                        <div class="portlet" align="right">
                                            <div class="portlet-body form" align="center">
                                                <form action="semester" method="post" name="frmyear" id="frmyear"
                                                      onsubmit="return onSubmit()" class="form-horizontal"
                                                      align="center">
                                                    <div class="form-body">
                                                        <div class="form-group" align="center">
                                                            <div class="col-md-4 col-md-offset-4" align="center">
                                                                {!! Form::label('year', 'Year ') !!}
                                                                <select id="year" name="year"
                                                                        onChange="Listsemester(this.value)"
                                                                        class="form-control">
                                                                    <option selected value="">Select Year</option>
                                                                    <?php
                                                                    $sql = array();
                                                                    if (Auth::user()->isTeacher()) {
                                                                        $sql = DB::select('SELECT DISTINCT year from semester_year order by year desc ');
                                                                    }
                                                                    if (Auth::user()->isAdmin()) {
                                                                        $sql = DB::select('select DISTINCT year from semester_year ORDER BY year desc');
                                                                    }
                                                                    $count = count($sql);

                                                                    $i = 0;
                                                                    for($i = 0;$i < $count;$i++){
                                                                    ?>
                                                                    <option value={{$sql[$i]->year}}>{{$sql[$i]->year}}</option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group" align="center">
                                                            <div class="col-md-4 col-md-offset-4">
                                                                {!!  Form::label('semester', 'Semester ') !!}
                                                                <select id="semester" name="semester"
                                                                        class="form-control">
                                                                    <option selected value="">Select Semester</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group" align="center">
                                                            <input type="hidden" name="_token"
                                                                   value="{{ csrf_token() }}"/>

                                                            <div class="col-md-4 col-md-offset-4">
                                                                <input type="submit" name="ok" value="Change"
                                                                       class="form-control"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </ul>
                @endif
            @endif


        </div>

    </div>
</nav>
