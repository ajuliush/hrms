@extends('back-end.premium.layout.employee-setting-main')
@section('content')


<section class="main-contant-section">


    <div class=" mb-3">

        @if(Session::get('message'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>{{Session::get('message')}}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <div class="card mb-0">
            <div class="card-header with-border">
                <h1 class="card-title text-center"> {{ __('Hourly Salary List') }} </h1>
                <ol id="breadcrumb1">
                    <li><a href="{{ route('home') }}"><span class="icon icon-home"> </span></a></li>
                    {{-- @if($add_permission == "Yes" || (Auth::user()->company_profile == 'Yes')) --}}

                    <li><a href="#" type="button" data-toggle="modal" data-target="#addModal"><span
                                class="icon icon-plus"> </span>Add</a></li>
                    {{-- @endif --}}
                    <li><a href="#">List - Gross Salary </a></li>
                </ol>
            </div>
        </div>


    </div>


    <!-- Add Modal Starts -->

    <div id="addModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header" style="background-color:#61c597;">
                    <h5 id="exampleModalLabel" class="modal-title">{{_('Add Salary')}}</h5>
                    <button type="button" data-dismiss="modal" id="close" aria-label="Close" class="close"><i
                            class="dripicons-cross"></i></button>
                </div>

                <div class="modal-body">
                    <form method="post" action="{{route('add-employee-hourly-salaries')}}" class="form-horizontal"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <input type="hidden" name="id" value="{{Session::get('employee_setup_id')}}">
                            <div class="col-md-12 form-group">
                                <label>Per Day Rate</label>
                                <input type="number" name="per_day_rate" placeholder="500" class="form-control" value=""
                                    min="0" step="0.01" title="Currency" pattern=" ^\d+(?:\.\d{1,2})?$">
                            </div>
                            <div class="col-md-12 form-group">
                                <label>Per Day Hour</label>
                                <input type="number" name="per_day_hour" placeholder="2" class="form-control" value=""
                                    min="0" step="0.01" title="Currency" pattern=" ^\d+(?:\.\d{1,2})?$">
                            </div>
                            <br>

                            <div class="col-sm-12">

                                <input type="submit" name="action_button" class="btn btn-primary btn-block"
                                    value="{{__('Add')}}" />

                            </div>
                        </div>

                    </form>
                </div>

            </div>

        </div>
    </div>

    <!-- Add Modal Ends -->

    <div class="table-responsive">
        <table id="user-table" class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>{{__('SL')}}</th>
                    <th>{{__('Per Day Rate (TK)')}}</th>
                    <th>{{__('Per Day Hour (TK)')}}</th>
                    <th>{{__('Per Hour Rate (TK)')}}</th>
                    @if($add_permission == "Yes" || $edit_permission == "Yes" || $delete_permission == "Yes" ||
                    (Auth::user()->company_profile == 'Yes'))
                    <th>{{__('Action')}}</th>
                    @endif
                </tr>
            </thead>

            <tbody>
                @php($i=1)
                @foreach( $user_hourly_salary_configs as $value)
                <tr>
                    <td>{{$i++ }}</td>
                    <td>{{$value->per_day_rate }}</td>
                    <td>{{$value->per_day_hour }}</td>
                    <td>{{$value->per_hour_rate }}</td>

                    @if($edit_permission == "Yes" || $delete_permission == "Yes" || (Auth::user()->company_profile ==
                    'Yes'))
                    <td>


                        <a href="javascript:void(0)" class="btn edit" data-id="{{$value->id}}"> <i
                                class="fa fa-pencil-square-o" aria-hidden="true"></i> </a>
                        <a href="{{route('delete-hourly-employee-gross-salaries',['id'=>Session::get('employee_setup_id')])}}"
                            class="btn btn-danger delete delete-post"> <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </a>

                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>

        </table>

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
                <form method="post" action="{{route('update-employee-hourly-salary')}}" class="form-horizontal"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="id">

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Per Day Rate</label>
                            <input type="number" name="per_day_rate" id="per_day_rate" class="form-control" value=""
                                min="0" step="0.01" title="Currency" pattern=" ^\d+(?:\.\d{1,2})?$">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Per Day Hour</label>
                            <input type="number" name="per_day_hour" id="per_day_hour" class="form-control" value=""
                                min="0" step="0.01" title="Currency" pattern=" ^\d+(?:\.\d{1,2})?$">
                        </div>
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
<!-- end bootstrap model -->



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





             //value retriving and opening the edit modal starts

             $('.edit').on('click', function () {
                var id = $(this).data('id');

                $.ajax({
                    type:"POST",
                    url: 'hourly-salary-config-by-id',
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                    $('#ajaxModelTitle').html("Edit");
                    $('#edit-modal').modal('show');
                    $('#id').val(res.hourly_salary_employee_id);
                    $('#per_day_rate').val(res.per_day_rate);
                    $('#per_day_hour').val(res.per_day_hour);
                }
                });
            });

           //value retriving and opening the edit modal ends

             // edit form submission starts

          $('#edit_form').submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                console.log(formData);
                $('#error-message').text('');

                $.ajax({
                    type:'POST',
                    url: `/update-employee-gross-salary`,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (response) => {
                        window.location.reload();
                        if (response) {
                        this.reset();
                        alert('Data has been updated successfully');
                        }
                    },
                    error: function(response){
                        console.log(response);
                            $('#error-message').text(response.responseJSON.errors.file);
                    }
                });
            });

            // edit form submission ends








  } );


</script>



@endsection