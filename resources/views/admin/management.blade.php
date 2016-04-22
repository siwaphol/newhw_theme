@extends('app')

@section('content')

    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">ค้นหาบุคคล</h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse"></a></li>
                    <li><a data-action="close"></a></li>
                </ul>
            </div>
            <a class="heading-elements-toggle"><i class="icon-more"></i></a>

            @if (isset($errors)&&count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (isset($successMessage)&& !empty($successMessage))
                <div class="alert alert-success">
                    <strong>{{$successMessage}}</strong><br>
                </div>
            @endif
        </div>

        <div class="panel-body">
            <form action="{{url('admin')}}" method="post" class="main-search">
                <div class="input-group content-group">
                    <div class="has-feedback has-feedback-left">
                        <input type="text" name="search_value" class="form-control input-xlg" placeholder="Search Text here....">
                        <div class="form-control-feedback">
                            <i class="icon-search4 text-muted text-size-base"></i>
                        </div>
                    </div>

                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-primary btn-xlg">Search</button>
                    </div>
                </div>
                {{--Place holder for dropdown value--}}
                <input class="span2" id="search_type" type="hidden">
                <div class="row search-option-buttons">
                    <div class="col-sm-2">
                        <select class="select" name="search_user_filter">
                            <optgroup label="User Type">
                                <option value="0">All Users</option>
                                <option value="{{\App\User::TEACHER_ROLE}}">Teacher</option>
                                <option value="{{\App\User::TA_ROLE}}">TA</option>
                                <option value="{{\App\User::STUDENT_ROLE}}">Student</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <select class="select" name="search_criteria_filter">
                            <optgroup label="Criteria">
                                <option value="{{\App\User::SEARCH_CRITERIA_ID}}">ID</option>
                                <option value="{{\App\User::SEARCH_CRITERIA_EMAIL}}">Email</option>
                                <option value="{{\App\User::SEARCH_CRITERIA_ENGLISH_NAME}}">English Name</option>
                                <option value="{{\App\User::SEARCH_CRITERIA_THAI_NAME}}">Thai Name</option>
                                <option value="{{\App\User::SEARCH_CRITERIA_USERNAME}}">Username</option>
                            </optgroup>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="content-group">
        @if(isset($admins) && !is_null($admins))
        {{--Admin List--}}
        <div class="text-size-small text-uppercase text-semibold text-muted mb-10">Admin List</div>
        <div class="panel panel-body">
            <ul class="media-list">
                @foreach($admins as $admin)
                <li class="media">
                    <div class="media-body">
                        <div class="media-heading text-semibold">{{$admin->firstname_en?:''}} {{$admin->lastname_en?:''}}</div>
                        <span class="text-muted">Maybe display all roles?</span>
                    </div>
                    <div class="media-right media-middle">
                        <ul class="icons-list text-nowrap">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-menu9"></i></a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="#" data-user-id="{{$admin->id}}" class="delete-btn"><i class="icon-comment-discussion pull-right"></i> Delete From Role</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        @endif
        {{--End Admin List--}}

        {{--Search Results--}}
        @if(isset($resultSearchUser))
        <div class="text-size-small text-uppercase text-semibold text-muted mb-10">Search Result {{count($resultSearchUser)}} results</div>
        <div class="panel panel-body">
            <ul class="media-list">
            @if(count($resultSearchUser)>0)
            @foreach($resultSearchUser as $user)
                <li class="media">
                    <div class="media-body">
                        <div class="media-heading text-semibold">{{$user->firstname_en?:''}} {{$user->lastname_en?:''}}</div>
                        <span class="text-muted">อาจจะแสดง Role ที่มีอยู่ของคนนี้ทั้งหมด, หรือแสดง Course</span>
                    </div>
                    <div class="media-right media-middle">
                        <ul class="icons-list text-nowrap">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-menu9"></i></a>

                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="#" data-user-id="{{$user->id}}" class="add-btn"><i class="icon-comment-discussion pull-right"></i> Add</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </li>
            @endforeach
            @endif
            </ul>
        </div>
        @endif
        {{--End Search Results--}}
    </div>
@stop

@section('script')
    <script type="text/javascript" src="{{asset('limitless_assets/js/plugins/forms/selects/select2.min.js')}}"></script>
    <script>
        var addAdminURL = "{{url('admin/add')}}";
        var deleteAdminURL = "{{url('admin/delete')}}";
        function submitHiddenForm(url, value) {
            var form = $('<form action="' + url + '" method="post">' +
                    '<input type="text" name="user_id" value="' + value + '" />' +
                    '</form>');
            $('body').append(form);
            form.submit();
        }
        $(function() {
            $('.select').select2({
                minimumResultsForSearch: Infinity
            });

            $(".delete-btn").on("click", function (e) {
                e.preventDefault();
                var userId = $(this).attr('data-user-id');
                {{--$.post( "{{url('admin/delete')}}"--}}
                        {{--,{user_id:userId}--}}
                        {{--, function(data) {--}}
                    {{--console.log(data);--}}
                {{--})--}}
                {{--.fail(function(data) {--}}
                    {{--console.log(data);--}}
                {{--});--}}
                submitHiddenForm(deleteAdminURL,userId);

                console.log('delete-admin clicked ',$(this).attr('data-user-id'));
            });

            $(".add-btn").on("click", function (e) {
                e.preventDefault();
                var userId = $(this).attr('data-user-id');
                {{--$.post( "{{url('admin/add')}}"--}}
                        {{--, {user_id:userId}--}}
                        {{--, function(data) {--}}
                    {{--console.log(data);--}}
                {{--})--}}
                {{--.fail(function(data) {--}}
                    {{--console.log(data);--}}
                {{--});--}}
                submitHiddenForm(addAdminURL, userId);

                console.log('add-admin clicked ',$(this).attr('data-user-id'));
            });
        })
    </script>
@stop