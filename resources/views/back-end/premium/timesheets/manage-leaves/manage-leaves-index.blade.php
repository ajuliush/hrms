@extends('back-end.premium.layout.premium-main')
@section('style')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet"
    type="text/css" />
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="Stylesheet"
    type="text/css" />
@endsection
<?php
use App\models\Leave;
?>
@section('content')



<section class="main-contant-section">


    <div class="mb-3">

        @if(Session::get('message'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>{{Session::get('message')}}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        @foreach ($errors->all() as $error)
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong class="text-danger">{{ $error }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endforeach

        <div class="card mb-0">
            <div class="card-header with-border">
                <h1 class="card-title text-center"> {{ __('Manage Leave List') }} </h1>
                <nav aria-label="breadcrumb">

                    <ol id="breadcrumb1">
                        <li><a href="{{ route('home') }}"><span class="icon icon-home"> </span></a></li>
                        @if ($add_permission == 'Yes' || Auth::user()->company_profile == 'Yes')
                        <li><a href="#" type="button" data-toggle="modal" data-target="#addDepartmentModal"><span
                                    class="icon icon-plus"> </span>Add</a></li>
                        @endif
                        <li><a href="{{ route('approve-manage-leave') }}"><span class="icon icon-list"> </span>Approve
                                List </a></li>
                        <li><a href="{{ route('pending-manage-leave') }}"><span class="icon icon-list"> </span>Pending
                                List </a></li>
                        <li><a href="{{ route('manage-leave') }}">List - All </a></li>
                    </ol>

                </nav>
            </div>
        </div>

        {{-- <div class="d-flex flex-row">
            @if($delete_permission == 'Yes' || Auth::user()->company_profile == 'Yes')
            <div class="p-2">
                <form method="post" action="{{route('bulk-delete-leaves')}}" id="sample_form" class="form-horizontal"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="bulk_delete_com_id" value="{{Auth::user()->com_id}}"
                        class="form-check-input">
                    <input type="submit" class="btn btn-danger w-100" value="{{__('Bulk Delete')}}" />
                </form>
            </div>
            @endif
        </div> --}}

        <div id="addDepartmentModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 id="exampleModalLabel" class="modal-title">{{_('Add Leave')}}</h5>
                        <button type="button" data-dismiss="modal" id="close" aria-label="Close" class="close"><i
                                class="dripicons-cross"></i></button>
                    </div>

                    <div class="modal-body">
                        <form method="post" action="{{route('add-leaves')}}" class="form-horizontal"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="row">

                                <input type="hidden" name="id" value="">

                                <div class="col-md-12 form-group">
                                    <label>Leave Type</label>
                                    <select name="leave_type" class="form-control selectpicker " data-live-search="true"
                                        data-live-search-style="begins" title='Leave Type'>

                                        @foreach($leave_types as $leave_type_value)
                                        <option value="{{$leave_type_value->id}}">{{$leave_type_value->leave_type}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 form-group">

                                    <label>Employee</label>
                                    <select name="employee_id" class="form-control selectpicker "
                                        data-live-search="true" data-live-search-style="begins" title='Employee'>
                                        @foreach($employees as $employees_value)
                                        <option value="{{$employees_value->id}}"
                                            data-subtext="<img class='rounded-circle' width='60' height='40'' src='{{$employees_value->profile_photo}}'>">
                                            {{$employees_value->first_name.'
                                            '.$employees_value->last_name}}({{$employees_value->company_assigned_id}})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <label>Start Date</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> <i class="fa fa-calendar"
                                                    aria-hidden="true"></i> </span>
                                        </div>
                                        <input type="date" name="start_date" class="form-control" value="">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <label>End Date</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> <i class="fa fa-calendar"
                                                    aria-hidden="true"></i> </span>
                                        </div>
                                        <input type="date" name="end_date" class="form-control" value="">
                                    </div>
                                </div>

                                <div class="col-md-12 form-group">
                                    <label for="leave_reason">Description</label>
                                    <textarea class="form-control" name="leave_reason" rows="3"></textarea>
                                </div>

                                <div class="col-md-12 ">
                                    <div class="custom-control form-group check-box ml-0 pl-0">
                                        <input type="checkbox" name="is_half" value="1">
                                        <label for="is_half">Half Day</label>
                                    </div>
                                </div>

                                <div class="col-sm-12 mt-4">
                                    <button class="btn btn-grad" type="submit"> <i class="fa fa-plus"
                                            aria-hidden="true"></i> Add </button>

                                </div>
                            </div>

                        </form>
                    </div>

                </div>

            </div>
        </div>

        <div class="content-box">

            <div class="table-responsive">
                <table id="user-table" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>{{__('SL')}}</th>
                            <th>{{__('Employee Name')}}</th>
                            <th>{{__('Employee ID')}}</th>
                            <th>{{__('Leave Type')}}</th>
                            <th>{{__('Department')}}</th>
                            <th>{{__('Designation')}}</th>
                            <th>{{__('Start Date')}}</th>
                            <th>{{__('End Name')}}</th>
                            <th>{{__('Document')}}</th>
                            <th>{{__('Total Days')}}</th>
                            <th>{{__('Status')}}</th>
                            <th>{{__('Action')}}</th>

                        </tr>
                    </thead>
                    <tbody>
                        @php($i = 1)
                        @foreach($leaves as $leaves_value)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$leaves_value->first_name}} {{$leaves_value->last_name}}</td>
                            <td>{{$leaves_value->company_assigned_id}}</td>
                            <td>{{$leaves_value->leave_type}}</td>
                            <td>{{$leaves_value->department_name}}</td>
                            <td>{{$leaves_value->designation_name}}</td>
                            <td>{{$leaves_value->leaves_start_date}}</td>
                            <td>{{$leaves_value->leaves_end_date}}</td>
                            @if($leaves_value->leave_document)
                            <td><a href="{{asset($leaves_value->leave_document)}}" download>Download</a></td>
                            @else
                            <td></td>
                            @endif

                            <td>{{$leaves_value->total_days}}</td>
                            <td>@if($leaves_value->leaves_status == 'Approved')<span class="rounded"
                                    style="background-color:#55ebeb;">Approved</span>@else<span class="rounded"
                                    style="background-color:#abcf56;">Pending</span>@endif</td>

                            <td>

                                <a href="#" class="btn view" data-toggle="modal"
                                    data-target="#viewModal{{$leaves_value->id}}" data-toggle="tooltip" title=" View "
                                    data-original-title="View"> <i class="fa fa-eye" aria-hidden="true"></i></a>

                                @if($delete_permission == 'Yes' || Auth::user()->company_profile == 'Yes')
                                <a href="{{route('delete-leaves',['id'=>$leaves_value->id])}}"
                                    class="btn btn-danger delete-post" data-toggle="tooltip" title=" Delete "
                                    data-original-title="Delete"> <i class="fa fa-trash-o" aria-hidden="true"></i></a>

                                @endif
                            </td>
                        </tr>

                        <?php

                    $current_year =  date('Y');
                    $startDate = date("Y-m-d");
                    //$endDate = date('Y-m-d',strtotime('+365 days'));
                    $endDate = date('Y') . '-' . '12' . '-' . '31';

                    $previous_start_date = date('Y-m-d', strtotime('-7 days'));
                    $upto_end_date = date('Y-m-d', strtotime('+1 days'));
                    $sick_leave_count = Leave::
                        // join('leave_types','leaves.leaves_leave_type_id','=','leave_types.id')
                        // ->select('leave_types.leave_type')
                        where('leaves_leave_type_id', '=', '4')
                        ->where('leaves_company_id', Auth::user()->com_id)
                        ->where('leaves_employee_id', $leaves_value->leaves_employee_id)
                        ->whereYear('created_at', '=', $current_year)
                        ->where('leaves_status', 'Approved')->sum('total_days');

                    $casual_leave_count = Leave::
                        // join('leave_types','leaves.leaves_leave_type_id','=','leave_types.id')
                        // ->select('leave_types.leave_type')
                        where('leaves_leave_type_id', '=', '5')
                        ->where('leaves_company_id', Auth::user()->com_id)
                        ->where('leaves_employee_id', $leaves_value->leaves_employee_id)
                        ->whereYear('created_at', '=', $current_year)
                        ->where('leaves_status', 'Approved')->sum('total_days');
                    $annual_leave_count = Leave::
                        // join('leave_types','leaves.leaves_leave_type_id','=','leave_types.id')
                        // ->select('leave_types.leave_type')
                        where('leaves_leave_type_id', '=', '7')
                        ->where('leaves_company_id', Auth::user()->com_id)
                        ->where('leaves_employee_id', $leaves_value->leaves_employee_id)
                        ->whereYear('created_at', '=', $current_year)
                        ->where('leaves_status', 'Approved')->sum('total_days');
            ?>


                        <!-- Bootstrap View Modal Starts-->

                        <div id="viewModal{{$leaves_value->id}}" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 id="exampleModalLabel" class="modal-title">Leave Request Details</h5>
                                        <button type="button" data-dismiss="modal" id="close" aria-label="Close"
                                            class="close"><i class="dripicons-cross"></i></button>
                                    </div>

                                    <div class="modal-body">


                                        <div class="row">
                                            <div class="col-md-12">
                                            <div class="text-center">
                                                <div class="">
                                                    <div class="leave-title">
                                                        <h4>  {{ $leaves_value->leave_type }} {{ __('Application') }} </h4>
                                                    </div>
                                                    <div class="leave-count">

                                                        <dl>
                                                            <dd>
                                                                   <b> {{ __('Leave Types') }} </b>

                                                            </dd>
                                                            <dd>
                                                               <b>{{ __('Allocated') }}</b>

                                                          </dd>
                                                            <dd>
                                                                   <b> {{ __('Approved') }} </b>

                                                            </dd>
                                                            <dd>
                                                                  <b> {{ __('Balance') }}</b>

                                                            </dd>
                                                        </dl>

                                                        <dl>

                                                            <dd>
                                                                {{ __('Sick') }}

                                                            </dd>
                                                            <dd>
                                                                @foreach ($Sick_leaves as $leave)
                                                                    {{ $leave->allocated_day }}
                                                                    {{ __('Days') }}
                                                                @endforeach
                                                            </dd>
                                                            <dd>

                                                                     {{ $sick_leave_count }}
                                                                    {{ __('Days') }}

                                                            </dd>
                                                            <dd>
                                                                @foreach ($Sick_leaves as $leave)

                                                                    {{ $leave->allocated_day - $sick_leave_count }}
                                                                    {{ __('Days') }}
                                                                @endforeach
                                                            </dd>
                                                        </dl>


                                                        <dl>
                                                            <dd>
                                                                {{ __('Casual') }}

                                                            </dd>
                                                            <dd>
                                                                @foreach ($Casual_Leaves as $leave)

                                                                    {{ $leave->allocated_day  }}
                                                                    {{ __('Days') }}
                                                                @endforeach
                                                            </dd>
                                                            <dd>

                                                                    {{$casual_leave_count }}
                                                                    {{ __('Days') }}

                                                            </dd>
                                                            <dd>
                                                                @foreach ($Casual_Leaves as $leave)

                                                                    {{ $leave->allocated_day - $casual_leave_count }}
                                                                    {{ __('Days') }}
                                                                @endforeach
                                                            </dd>
                                                        </dl>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <div class="employe-info">
                                                    <dl>
                                                        <dd>
                                                            <b>Employee Name : </b>
                                                        </dd>
                                                        <dd>
                                                            {{ $leaves_value->first_name }}
                                                            {{ $leaves_value->last_name }}
                                                        </dd>
                                                    </dl>
                                                    <dl>
                                                        <dd>
                                                            <b>Department : </b>
                                                        </dd>
                                                        <dd>
                                                            {{ $leaves_value->department_name }}
                                                        </dd>
                                                    </dl>

                                                    <dl>
                                                        <dd>
                                                            <b>Designation : </b>
                                                        </dd>
                                                        <dd>
                                                            {{ $leaves_value->designation_name }}
                                                        </dd>
                                                    </dl>

                                                    <dl>
                                                        <dd>
                                                            <b> Leave Date Starts : </b>
                                                        </dd>
                                                        <dd>
                                                            {{ $leaves_value->leaves_start_date }}
                                                        </dd>
                                                    </dl>
                                                    <dl>
                                                        <dd>
                                                            <b> Leave Date Ends : </b>
                                                        </dd>
                                                        <dd>
                                                            {{ $leaves_value->leaves_end_date }}
                                                        </dd>
                                                    </dl>
                                                    <dl>
                                                        <dd>
                                                            <b> Total Days : </b>
                                                        </dd>
                                                        <dd>
                                                            {{ $leaves_value->total_days }}
                                                        </dd>
                                                    </dl>
                                                </div>
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <label>Leave Reason : </label>

                                                <textarea class="form-control" rows="10"
                                                    readonly>{{$leaves_value->leave_reason}}</textarea>

                                            </div>
                                            <br>


                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>

                        <!-- Bootstrap View Modal Ends-->


                        @endforeach



                    </tbody>

                </table>
            </div>

        </div>


    </div>
</section>





<!-- edit boostrap model -->
<div class="modal fade" id="edit-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="ajaxModelTitle"></h4>
            </div>
            <div class="modal-body">
                <form method="post" id="edit_form" class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="h5f0Eaj8GaFG1KmsSlCDotQT79aNw86yhW22gybY">
                    <input type="hidden" name="id" id="id">

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Leave Type</label>
                        <div class="col-sm-12">
                            <input type="text" name="leave_type" id="leave_type" class="form-control" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Day Allocating</label>
                        <div class="col-sm-12">
                            <input type="text" name="allocated_day" id="allocated_day" class="form-control" value="">
                        </div>
                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Save changes
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
<!-- end bootstrap model -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>


<script type="text/javascript">
    $(document).ready( function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
            $('#user-table').DataTable({

                    "aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
                    "iDisplayLength": 25,

                    dom: '<"row"lfB>rtip',

                    buttons: [
                        {
                            extend: 'pdf',
                            text: '<i title="export to pdf" class="fa fa-file-pdf-o"></i>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                        },
                        {
                            extend: 'csv',
                            text: '<i title="export to csv" class="fa fa-file-text-o"></i>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                        },
                        {
                            extend: 'print',
                            text: '<i title="print" class="fa fa-print"></i>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                        },
                        {
                            extend: 'colvis',
                            text: '<i title="column visibility" class="fa fa-eye"></i>',
                            columns: ':gt(0)'
                        },
                    ],
                });


            var date = new Date();
            date.setDate(date.getDate());
            $('.date').datepicker({
            startDate: date
            });





   });


</script>

@endsection
