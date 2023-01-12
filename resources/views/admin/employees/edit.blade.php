@extends('layouts.app')        

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Employee</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">
                        Edit Employee
                    </li>
                </ol>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-8 mx-auto">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h5 class="text-center mt-2">Edit employee</h5>
                    </div>
                    @include('messages.alerts')
                    <form action="{{route('admin.employees.update',[$employee->employee_id])}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                    <div class="card-body">
                        
                            <fieldset>
                                <div class="form-group">
                                    <label for="">First Name</label>
                                    <input type="text" name="first_name" value="@if(old('first_name')){{ old('first_name') }} @else {{$employee->first_name}} @endif  " class="form-control">
                                    @error('first_name')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Last Name</label>
                                    <input type="text" name="last_name" value="@if(old('last_name')){{ old('last_name') }} @else {{$employee->last_name}} @endif " class="form-control">
                                    @error('last_name')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="email" name="email" value="@if(old('email')){{ old('email') }} @else {{$employee->email}} @endif " class="form-control">
                                    @error('email')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="phone_number">Phone No</label>
                                    <input type="text" name="phone_number" id="phone_number" vlaue="@if(old('phone_number')){{ old('phone_number') }} @else {{$employee->phone_number}} @endif " class="form-control">
                                    @error('phone_number')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                               
                                <div class="form-group">
                                    <label for="join_date">Hire Date</label>
                                    <input type="text" name="join_date" id="join_date" class="form-control">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">Job</label>
                                        <select name="job_id" class="form-control">
                                            <option hidden disabled selected value> -- select Job -- </option>
                                          @foreach($jobs as $job)
                                                <option value="{{ $job->job_id }}"
                                                @if (old('job_id') == $job->job_id)
                                                        selected
                                                    @endif  
                                                >
                                                  {{$job->job_title}}
                                                </option>
                                           @endforeach
                                        </select>
                                      
                                        @error('job_id')
                                        <div class="text-danger">
                                            Please select a valid option
                                        </div>
                                    @enderror
                                       
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Department</label>
                                        <select name="department_id" class="form-control">
                                            <option hidden disabled selected value> -- select Department -- </option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->department_id }}"
                                                    @if (old('department_id') == $department->department_id)
                                                        selected
                                                    @endif    
                                                >
                                                    {{ $department->department_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('department_id')
                                        <div class="text-danger">
                                            Please select a valid option
                                        </div>
                                    @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Salary</label>
                                    <input type="text" name="salary" value="@if(old('salary')){{ old('salary') }} @else {{$employee->salary}} @endif " class="form-control">
                                    @error('salary')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Photo</label>
                                    <input type="file" name="photo" class="form-control-file">
                                    @error('photo')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                               
                              
                            </fieldset>
                            
                        
                    </div>
                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-sm btn-secondary" style="width: 60%; font-size:1.3rem">Update</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
        
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->

<!-- /.content-wrapper -->

@endsection

@section('extra-js')
<script>
    $().ready(function() {
        if('{{ old('dob') }}') {
            const dob = moment('{{ old('dob') }}', 'DD-MM-YYYY');
            const join_date = moment('{{ old('join_date') }}', 'DD-MM-YYYY');
            console.log('{{ old('dob') }}')
            $('#dob').daterangepicker({
                "startDate": dob,
                "singleDatePicker": true,
                "showDropdowns": true,
                "locale": {
                    "format": "DD-MM-YYYY"
                }
            });
            $('#join_date').daterangepicker({
                "startDate": join_date,
                "singleDatePicker": true,
                "showDropdowns": true,
                "locale": {
                    "format": "DD-MM-YYYY"
                }
            });
        } else {
            $('#dob').daterangepicker({
                "singleDatePicker": true,
                "showDropdowns": true,
                "locale": {
                    "format": "DD-MM-YYYY"
                }
            });
            $('#join_date').daterangepicker({
                "singleDatePicker": true,
                "showDropdowns": true,
                "locale": {
                    "format": "DD-MM-YYYY"
                }
            });
        }
        
    });
</script>
@endsection