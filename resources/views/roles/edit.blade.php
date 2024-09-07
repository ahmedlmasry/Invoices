@extends('layouts.master')
@section('css')
    <!--Internal  Font Awesome -->
    <link href="{{URL::asset('assets/plugins/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
    <!--Internal  treeview -->
    <link href="{{URL::asset('assets/plugins/treeview/treeview-rtl.css')}}" rel="stylesheet" type="text/css"/>
    @section('title')
        تعديل الصلاحيات - مورا سوفت للادارة القانونية
    @stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الصلاحيات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل
                الصلاحيات</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>خطا</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{url(route('roles.update',$role->id))}}" method="post">
        @csrf
        @method('put')
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card mg-b-20">
                    <div class="card-body">
                        <div class="main-content-label mg-b-5">
                            <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0">
                                <p>اسم الصلاحية :</p>
                                <input class="form-control form-control-sm mg-b-20" name="name" value="{{$role->name}}"
                                       type="text"
                                >
                            </div>
                        </div>
                        <div class="row">
                            <!-- col -->
                            <div class="col-lg-4">
                                <ul id="treeview1">
                                    <li><a href="#">الصلاحيات</a>
                                        <ul>
                                            <li>
                                                <input  id="selectAll" type="checkbox"><label   for='selectAll'>تحديد الكل</label>
                                                <br>
                                                @foreach($permissions as $permission)
                                                        <input class="form-check-box" type="checkbox"
                                                               value="{{$permission->id}}"
                                                               name="permissions_list[] "
                                                               @if($role->hasPermissionTo($permission->name)) checked @endif>
                                                        <label class="form-check-label " for="flexCheckDefault">
                                                            {{$permission->name}}
                                                        </label>
                                                    <br/>
                                                @endforeach
                                            </li>

                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-main-primary">تحديث</button>
                            </div>
                            <!-- /col -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- row closed -->
    </form>
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Treeview js -->
    <script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>
    <script>
        $("#selectAll").click(function () {
            $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
        });
    </script>
@endsection
