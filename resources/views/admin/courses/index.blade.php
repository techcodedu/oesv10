@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Courses') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Courses') }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        @if(session('success'))
                        <div class="alert alert-success" id="alert">{{ session('success')}}</div>
                    @endif
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Courses List') }}</h3>
                            <div class="card-tools">
                                <a href="{{ route('courses.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> {{ __('Add New') }}</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Description') }}</th>
                                        <th>{{ __('#hours') }}</th>
                                        <th>{{ __('Category') }}</th>
                                        <th>{{ __('Instructor') }}</th>
                                        <th>{{ __('Price') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($courses as $course)
                                        <tr>
                                            <td>{{ $course->name }}</td>
                                            <td>{{ $course->description }}</td>
                                            <td>{{ $course->training_hours }}</td>
                                            <td>{{ $course->category->name }}</td>
                                            <td>{{ $course->instructor->name }}</td>
                                            <td>{{ $course->price }}</td>
                                            <td>
                                                <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i> {{ __('Edit') }}</a>
                                                <form action="{{ route('courses.destroy', $course->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this category?')"><i class="fas fa-trash" ></i> {{ __('Delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
        
    </div>
    <script>
        setTimeout(function () {
    $(".alert").fadeOut("slow");
}, 2000);

    </script>
    <!-- /.content -->
@endsection
