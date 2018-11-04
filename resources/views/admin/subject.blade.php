@extends('admin.templates.restricted')
@section('additional-css')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/r-2.2.2/datatables.min.css"/>
@endsection

@section('content')
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    @include('common.alert_box')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Subjects</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <button class="btn btn-sm btn-primary" data-toggle="collapse" href="#add_edit_subject" role="button" aria-expanded="false" aria-controls="add_edit_subject">Add New Subject</button>
            </div>
        </div>
    </div>
    <div class="block-center">
        <div class="row collapse {{ (!$errors->isEmpty()) ? 'show' : '' }}"  id="add_edit_subject">
            <div class="col-lg-1 col-md-1 col-sm-1"></div>
            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12"><form method="POST" action="{{ route('admin-store-subjects') }}" class="form-horizontal form-centered">
                    {{ csrf_field() }}
                    <input type="hidden" name="subject_id" id="subject_id" value="">
                    <div class="form-group {{ $errors->has('name') ? ' invalid' : '' }} row">
                        <label class="control-label col-sm-2" for="name">Subject Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Subject Name" value="{{ old('name') }}">
                            <div class="invalid-feedback">
                                {{ $errors->has('name') ? $errors->first('name') : '' }}
                            </div>
                        </div>

                    </div>
                    <div class="form-group {{ $errors->has('duration') ? ' invalid' : '' }} row">
                        <label class="control-label col-sm-2" for="name">Duration</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="duration" name="duration" placeholder="Months" value="{{ old('duration') }}">
                            <div class="invalid-feedback">
                                {{ $errors->has('duration') ? $errors->first('duration') : '' }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('category') ? ' invalid' : '' }} row">
                        <label class="control-label col-sm-2" for="category">Subject category</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="category" name="category">
                                <option value="">Select category</option>
                                @foreach ($categories as $key => $category)
                                    <option value="{{ $category->id }}" {{(old("category") == $category->id) ? "selected": ""}}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                {{ $errors->has('category') ? $errors->first('category') : '' }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('description') ? ' invalid' : '' }} row">
                        <label class="control-label col-sm-2" for="description">Description</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            <div class="invalid-feedback">
                                {{ $errors->has('description') ? $errors->first('description') : '' }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="form-check-label control-label col-sm-2" for="is_active">
                            Active subject
                        </label>
                        <div class="form-check col-sm-10">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{ old('is_active')=='on' ? ' checked' : '' }} >

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
                <table class="table table-striped table-bordered table-sm custom-table" id="subject_datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Subject name</th>
                            <th>Short code</th>
                            <th>Duration(months)</th>
                            <th>Category</th>
                            <th>Subject status</th>
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
    function resetForm(){
        $('#add_edit_subject .form-group').removeClass('invalid');
        $('#add_edit_subject input:not([name=_token])').val('');
        $('#add_edit_subject textarea').html();
        $('#add_edit_subject #is_active').prop('checked', false); 
        $('#add_edit_subject #category').val('');
    }
    function setEditForm(row_data){
        resetForm();
        if(!$('.collapse').hasClass('show')){
            $('.collapse').collapse()
        }
        $('#add_edit_subject #subject_id').val(row_data.id);
        $('#add_edit_subject #name').val(row_data.name);
        $('#add_edit_subject #duration').val(row_data.duration);
        $('#add_edit_subject #category').val(row_data.category.id);
        $('#add_edit_subject #description').val(row_data.description);
        $('#add_edit_subject  #is_active').prop('checked', row_data.is_active); 
    }
    
    $('#subject_datatable tbody').on('click', 'a.edit', function () {
        var tr = $(this).closest('tr');
        var row = oTable.row(tr);
        setEditForm(row.data());
    });
    
    $('#subject_datatable tbody').on('click', 'a.delete', function () {
        var tr = $(this).closest('tr');
        var row_data = oTable.row(tr).data();
        var r = confirm("You are about to delete a subject?");
        if (r == true) {
            $.ajax({
              url: window.location.origin + '/admin/subjects/delete/' + row_data.id,
              type: "get",
              success: function (data) {
                  location.reload();
              },
              error: function(data){
                console.log('error');
              }
            });
        }
    });

    $('#add_edit_subject').on('hidden.bs.collapse', function (e) {
        resetForm();
    })
    
    $('.reset-form').click(function (){
        resetForm();
    });

  $(document).ready(function() {
    oTable =  $('#subject_datatable').DataTable({
            fixedHeader:true,
            "ajax": "{{ route('admin-get-subjects') }}",
            "columns": [
                {"data": "id"},
                {"data": "name"},
                {"data": "short_code"},
                {"data": "duration"},
                {"orderable": false,
                    "data": null,
                    "render": function (data, type, full, meta) {
                        return data.category.name;
                    }
                },
                {"orderable": false,
                    "data": null,
                    "render": function (data, type, full, meta) {
                        return (data.is_active) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-secondary">Inactive</span>';
                    }
                },
                {   "class": 'action',
                    "orderable": false,
                    "data": null,
                    "render": function (data, type, full, meta) {
                        return '<a class="edit">'
                                +'<i class="fas fa-pencil-alt" aria-hidden="true"></i>'
                                +'</a>'
                                +'<a class="delete">'
                                +'<i class="fa fa-trash red-btn " aria-hidden="true"></i>'
                                +'</a>';
                    }
                }
            ]
        });
        if(!$("#alert-notification").hasClass('hidden')){
            setTimeout(function(){ 
            $("#alert-notification").slideUp(500, function(){
                       $("#alert-notification").slideUp(500);
                });  
            }, 2000);
        }
        

  });
</script>
@endsection