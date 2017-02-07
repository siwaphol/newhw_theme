<!-- Main navbar -->
<div class="navbar navbar-inverse">
    <div class="navbar-header">
        <a class="navbar-brand" href="{{url('/')}}">CS CMU MIS</a>

        <ul class="nav navbar-nav pull-right visible-xs-block">
            <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
        </ul>
    </div>
@if(!\Auth::guest())
    <div class="navbar-collapse collapse" id="navbar-mobile">
        <ul class="nav navbar-nav navbar-right">
            @if(Auth::user()->isAdmin()||Auth::user()->isTeacher())
            <li class="dropdown language-switch">
                <a class="dropdown-toggle" data-toggle="dropdown">
                    {{\Session::get('semester')}}-{{\Session::get('year')}}
                    <span class="caret"></span>
                </a>

                <ul class="dropdown-menu">
                    <li><a href="#" id="change_sem_year">Change</a></li>
                </ul>
            </li>
            @endif

            {{--<li class="dropdown language-switch">--}}
                {{--<a class="dropdown-toggle" data-toggle="dropdown">--}}
                    {{--<img src="{{asset('limitless_assets/images/flags/gb.png')}}" class="position-left" alt="">--}}
                    {{--English--}}
                    {{--<span class="caret"></span>--}}
                {{--</a>--}}

                {{--<ul class="dropdown-menu">--}}
                    {{--<li><a class="deutsch"><img src="{{asset('limitless_assets/images/flags/th.png')}}" alt=""> ภาษาไทย</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}

            <li class="dropdown dropdown-user">
                <a class="dropdown-toggle" data-toggle="dropdown">
                    <span>{{\Auth::user()->firstname_en}} {{\Auth::user()->lastname_en}} ({{\Auth::user()->role()}})</span>
                    <i class="caret"></i>
                </a>

                <ul class="dropdown-menu dropdown-menu-right">
                    <li><a href="#"><i class="icon-user-plus"></i> My profile</a></li>
                    <li><a href="{{ url('/auth/logout') }}"><i class="icon-switch2"></i> Logout</a></li>
                </ul>
            </li>
        </ul>
    </div>
@endif
</div>
<!-- /main navbar -->

@if(!\Auth::guest() && \Auth::user()->isAdmin())
<!-- Second navbar -->
<div class="navbar navbar-default" id="navbar-second">
   <ul class="nav navbar-nav no-border visible-xs-block">
       <li><a class="text-center collapsed" data-toggle="collapse" data-target="#navbar-second-toggle"><i class="icon-menu7"></i></a></li>
   </ul>

   <div class="navbar-collapse collapse" id="navbar-second-toggle">
       <ul class="nav navbar-nav">
           <li class="active"><a href="{{url('/')}}"><i class="icon-display4 position-left"></i> Dashboard</a></li>
           <!--User Management Menu-->
           <li class="dropdown">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                   <i class="icon-people position-left"></i> User Management <span class="caret"></span>
               </a>

               <ul class="dropdown-menu width-150">
                   <li><a href="{{url('admin')}}"> Admin</a></li>
                   <li><a href="{{url('teachers')}}"> Teacher</a></li>
                   <li><a href="{{url('ta')}}"> TA</a></li>
                   <li><a href="#toStudentManagement"> Student</a></li>
               </ul>
           </li>
           <!--/User Management Menu-->
           <!--Classroom Management Menu-->
           <li class="dropdown">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                   <i class="icon-book position-left"></i> Classroom Management <span class="caret"></span>
               </a>
               <ul class="dropdown-menu width-150">
                   <li><a href="{{url('course')}}"> Course</a></li>
                   <li><a href="{{url('course_section/create')}}"> A Section</a></li>
                   <li><a href="{{url('course_section/selectcreate')}}"> Multiple Section</a></li>
                   <li><a href="{{url('semesteryear')}}"> Semester and Year</a></li>
               </ul>
           </li>
           <!--/Classroom Management Menu-->
           <!--Automate Task Menu-->
           <li class="dropdown">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                   <i class="icon-cog position-left"></i> Automate Task <span class="caret"></span>
               </a>
               <ul class="dropdown-menu width-150">
                   <li><a href="{{url('first_time_wizard')}}"><i class="icon-magic-wand2"></i> First Time Wizard...</a></li>
                   <li class="dropdown-header"> Reg Website Import</li>
                   <li><a href="{{url('course_section/auto')}}"><i class="icon-cloud-download"></i> Course And Section</a></li>
                   <li><a href="{{url('students/autoimport')}}"><i class="icon-cloud-download"></i> Students For All Course and Section</a></li>
                   <li><a href="#{{url('students/autoimport-select')}}"><i class="icon-cloud-download"></i> Students For Selected Section</a></li>
                   <li class="dropdown-header"> Excel Import</li>
                   <li><a href="#toStudentManagement"><i class="icon-file-excel"></i> Student</a></li>
               </ul>
           </li>
           <!--/Automate Task Menu-->
       </ul>

       <ul class="nav navbar-nav navbar-right">
           <li class="dropdown">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                   <i class="icon-cog3"></i>
                   <span class="visible-xs-inline-block position-right">Share</span>
                   <span class="caret"></span>
               </a>
               <ul class="dropdown-menu dropdown-menu-right">
                   <li><a href="#"><i class="icon-gear"></i> All settings</a></li>
               </ul>
           </li>
       </ul>
   </div>
</div>
<!-- /second navbar -->
@endif