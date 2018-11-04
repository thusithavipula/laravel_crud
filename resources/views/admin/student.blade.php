@extends('admin.templates.restricted')
@section('additional-css')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/r-2.2.2/datatables.min.css"/>
@endsection

@section('content')
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    @include('common.alert_box')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Students</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <button class="btn btn-sm btn-primary" data-toggle="collapse" href="#add_edit_student" role="button" aria-expanded="false" aria-controls="add_edit_student">Add New Student</button>
            </div>
        </div>
    </div>
    <div class="block-center">
        <div class="row collapse {{ (!$errors->isEmpty()) ? 'show' : '' }}"  id="add_edit_student">
            <div class="col-lg-1 col-md-1 col-sm-1"></div>
            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12"><form method="POST" action="{{ route('admin-store-students') }}" class="form-horizontal form-centered">
                    {{ csrf_field() }}
                    <input type="hidden" name="student_id" id="student_id" value="">
                    <div class="form-group {{ $errors->has('title') ? ' invalid' : '' }} row">
                        <label class="control-label col-sm-2" for="title">Title</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="title" name="title">
                                @foreach ($titles as $key => $title)
                                <option value="{{ $key }}" {{(old("title") == $key) ? "selected": ""}}>{{ $title }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                {{ $errors->has('title') ? $errors->first('title') : '' }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('first_name') ? ' invalid' : '' }} row">
                        <label class="control-label col-sm-2" for="first_name">First Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value="{{ old('first_name') }}">
                            <div class="invalid-feedback">
                                {{ $errors->has('first_name') ? $errors->first('first_name') : '' }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('last_name') ? ' invalid' : '' }} row">
                        <label class="control-label col-sm-2" for="last_name">Last Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="First Name" value="{{ old('last_name') }}">
                            <div class="invalid-feedback">
                                {{ $errors->has('last_name') ? $errors->first('last_name') : '' }}
                            </div>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('address') ? ' invalid' : '' }} row">
                        <label class="control-label col-sm-2" for="address">Address</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="address" name="address" placeholder="Qualifications" value="{{ old('address') }}">
                            <div class="invalid-feedback">
                                {{ $errors->has('address') ? $errors->first('address') : '' }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="form-check-label control-label col-sm-2" for="is_active">
                            Active student
                        </label>
                        <div class="form-check col-sm-10">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{ old('is_active')=='on' ? ' checked' : '' }} >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="form-check-label control-label col-sm-2" for="subject_studies">Subjects studies</label>
                        <div class="col-sm-10">
                            <select name="subject_studies[]" id="subject_studies" size="10" class="form-control" multiple>
                                @foreach($subject_categories as $key => $category)
                                    <optgroup label="{{$category->name}}">
                                        @foreach($category->subjects as $key => $subject)
                                            <option value="{{$subject->id}}" {{ (collect(old('subject_studies'))->contains($subject->id)) ? 'selected' : '' }}>{{$subject->short_code.'/'.$subject->name}}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">        
                        <div class="col-lg-offset-2 col-lg-10 col-md-offset-2 col-md-10 col-sm-offset-2 col-sm-10">
                            <div class="form-btn-wrapper">
                                <button type="submit" class="btn btn-primary ali">Submit</button>
                                <button type="reset" class="btn btn-default ali reset-form">Reset</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
                <table class="table table-striped table-bordered table-sm custom-table" id="student_datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>First name</th>
                            <th>Last name</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</main>



@endsection
@section('additional-scripts')
<script src="{{ asset('/js/dashboard.js')}}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/r-2.2.2/datatables.min.js"></script>
<script type="text/javascript">
var oTable = null;
function resetForm() {
    $('#add_edit_student .form-group').removeClass('invalid');
    $('#add_edit_student input:not([name=_token])').val('');
    $('#add_edit_student textarea').html();
    $('#add_edit_student #is_active').prop('checked', false);
    $('#add_edit_student #subject_studies').val('');
}
function setEditForm(row_data) {
    resetForm();
    if (!$('.collapse').hasClass('show')) {
        $('.collapse').collapse()
    }
    $('#add_edit_student #student_id').val(row_data.id);
    $('#add_edit_student #title').val(row_data.title);
    $('#add_edit_student #first_name').val(row_data.first_name);
    $('#add_edit_student #last_name').val(row_data.last_name);
    $('#add_edit_student #address').val(row_data.address);
    $('#add_edit_student #is_active').prop('checked', row_data.is_active);
    $.each(row_data.student_subjects, function(i,e){
        $("#add_edit_student #subject_studies option[value='" + e.subject_id + "']").prop("selected", true);
    });
}

$('#student_datatable tbody').on('click', 'a.edit', function () {
    var tr = $(this).closest('tr');
    var row = oTable.row(tr);
    setEditForm(row.data());
});

$('#student_datatable tbody').on('click', 'a.delete', function () {
    var tr = $(this).closest('tr');
    var row_data = oTable.row(tr).data();
    var r = confirm("You are about to delete a student?");
    if (r == true) {
        $.ajax({
            url: window.location.origin + '/admin/students/delete/' + row_data.id,
            type: "get",
            success: function (data) {
                location.reload();
            },
            error: function (data) {
                console.log('error');
            }
        });
    }
});

$('#add_edit_student').on('hidden.bs.collapse', function (e) {
    resetForm();
})

$('.reset-form').click(function () {
    resetForm();
});

$(document).ready(function () {
    oTable = $('#student_datatable').DataTable({
        fixedHeader: true,
        "ajax": "{{ route('admin-get-students') }}",
        "columns": [
            {"data": "id"},
            {"data": "title"},
            {"data": "first_name"},
            {"data": "last_name"},
            {"data": "address"},
            {"orderable": false,
                "data": null,
                "render": function (data, type, full, meta) {
                    return (data.is_active) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-secondary">Inactive</span>';
                }
            },
            {"class": 'action',
                "orderable": false,
                "data": null,
                "render": function (data, type, full, meta) {
                    return '<a class="edit">'
                            + '<i class="fas fa-pencil-alt" aria-hidden="true"></i>'
                            + '</a>'
                            + '<a class="delete">'
                            + '<i class="fa fa-trash red-btn " aria-hidden="true"></i>'
                            + '</a>';
                }
            }
        ]
    });
    if (!$("#alert-notification").hasClass('hidden')) {
        setTimeout(function () {
            $("#alert-notification").slideUp(500, function () {
                $("#alert-notification").slideUp(500);
            });
        }, 2000);
    }


});
</script>
@endsection