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
        </div>

        <div class="panel-body">
            <form action="#" class="main-search">
                <div class="input-group content-group">
                    <div class="has-feedback has-feedback-left">
                        <input type="text" class="form-control input-xlg" placeholder="Search Text here....">
                        <div class="form-control-feedback">
                            <i class="icon-search4 text-muted text-size-base"></i>
                        </div>
                    </div>

                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-primary btn-xlg">Search</button>
                    </div>
                </div>

                <div class="row search-option-buttons">
                    <div class="col-sm-6">
                        <ul class="list-inline list-inline-condensed no-margin-bottom">
                            <li class="dropdown">
                                <a href="#" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <i class="icon-stack2 position-left"></i> All Users <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li><a href="#"><i class="icon-reading"></i> Teacher</a></li>
                                    <li><a href="#"><i class="icon-gear"></i> TA</a></li>
                                    <li><a href="#"><i class="icon-graduation"></i> Student</a></li>
                                </ul>
                            </li>

                            <li class="dropdown">
                                <a href="#" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <i class="icon-stack2 position-left"></i> English Name <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li><a href="#"><i class="icon-question7"></i> Thai Name</a></li>
                                    <li><a href="#"><i class="icon-accessibility"></i> User Code (student code, teacher id)</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="content-group">
        {{--Admin List--}}
        <div class="text-size-small text-uppercase text-semibold text-muted mb-10">Admin List</div>
        <div class="panel panel-body">
            <ul class="media-list">
                <li class="media">
                    <div class="media-body">
                        <div class="media-heading text-semibold">James Alexander</div>
                        <span class="text-muted">Development</span>
                    </div>
                    <div class="media-right media-middle">
                        <ul class="icons-list text-nowrap">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-menu9"></i></a>

                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="#"><i class="icon-comment-discussion pull-right"></i> Start chat</a></li>
                                    <li><a href="#"><i class="icon-phone2 pull-right"></i> Make a call</a></li>
                                    <li><a href="#"><i class="icon-mail5 pull-right"></i> Send mail</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#"><i class="icon-statistics pull-right"></i> Statistics</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        {{--End Admin List--}}

        {{--Search Results--}}
        <div class="text-size-small text-uppercase text-semibold text-muted mb-10">Search Result 0 results</div>
        <div class="panel panel-body">
            <ul class="media-list">
                <li class="media">
                    <div class="media-body">
                        <div class="media-heading text-semibold">James Alexander</div>
                        <span class="text-muted">อาจจะแสดง Role ที่มีอยู่ของคนนี้ทั้งหมด, หรือแสดง Course</span>
                    </div>
                    <div class="media-right media-middle">
                        <ul class="icons-list text-nowrap">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-menu9"></i></a>

                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="#"><i class="icon-comment-discussion pull-right"></i> Edit</a></li>
                                    <li><a href="#"><i class="icon-phone2 pull-right"></i> Delete</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        {{--End Search Results--}}
    </div>
@stop

@section('script')

@stop