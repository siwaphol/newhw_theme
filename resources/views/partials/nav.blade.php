<!-- Main navbar -->
<div class="navbar navbar-inverse">
    <div class="navbar-header">
        <a class="navbar-brand" href="/">CS CMU MIS</a>

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

            <li class="dropdown language-switch">
                <a class="dropdown-toggle" data-toggle="dropdown">
                    <img src="{{asset('limitless_assets/images/flags/gb.png')}}" class="position-left" alt="">
                    English
                    <span class="caret"></span>
                </a>

                <ul class="dropdown-menu">
                    <li><a class="deutsch"><img src="{{asset('limitless_assets/images/flags/th.png')}}" alt=""> ภาษาไทย</a></li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-file-text2"></i>
                    <span class="visible-xs-inline-block position-right">Messages</span>
                    <span class="badge bg-warning-400">2</span>
                </a>

                <div class="dropdown-menu dropdown-content width-350">
                    <div class="dropdown-content-heading">
                        Messages
                        <ul class="icons-list">
                            <li><a href="#"><i class="icon-compose"></i></a></li>
                        </ul>
                    </div>

                    <ul class="media-list dropdown-content-body">
                        <li class="media">
                            <div class="media-left">
                                <img src="{{asset('limitless_assets/images/placeholder.jpg')}}" class="img-circle img-sm" alt="">
                                <span class="badge bg-danger-400 media-badge">5</span>
                            </div>

                            <div class="media-body">
                                <a href="#" class="media-heading">
                                    <span class="text-semibold">James Alexander</span>
                                    <span class="media-annotation pull-right">04:58</span>
                                </a>

                                <span class="text-muted">who knows, maybe that would be the best thing for me...</span>
                            </div>
                        </li>
                    </ul>

                    <div class="dropdown-content-footer">
                        <a href="#" data-popup="tooltip" title="All messages"><i class="icon-menu display-block"></i></a>
                    </div>
                </div>
            </li>

            <li class="dropdown dropdown-user">
                <a class="dropdown-toggle" data-toggle="dropdown">
                    <img src="{{asset('limitless_assets/images/placeholder.jpg')}}" alt="">
                    <span>Victoria</span>
                    <i class="caret"></i>
                </a>

                <ul class="dropdown-menu dropdown-menu-right">
                    <li><a href="#"><i class="icon-user-plus"></i> My profile</a></li>
                    <li><a href="#"><i class="icon-coins"></i> My balance</a></li>
                    <li><a href="#"><span class="badge badge-warning pull-right">58</span> <i class="icon-comment-discussion"></i> Messages</a></li>
                    <li class="divider"></li>
                    <li><a href="#"><i class="icon-cog5"></i> Account settings</a></li>
                    <li><a href="{{ url('/auth/logout') }}"><i class="icon-switch2"></i> Logout</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<!-- /main navbar -->

@if(Auth::user()->isAdmin())
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
                   <li><a href="{{url('course_section/selectcreate')}}"> Section</a></li>
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
                   <li><a href="{{url('students/autoimport')}}"><i class="icon-cloud-download"></i> Students</a></li>
                   <li class="dropdown-header"> Excel Import</li>
                   <li><a href="#toStudentManagement"><i class="icon-file-excel"></i> Student</a></li>
               </ul>
           </li>
           <!--/Automate Task Menu-->
       </ul>

       <ul class="nav navbar-nav navbar-right">
           <li class="dropdown open">
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
@endif
<!-- /second navbar -->
@endif