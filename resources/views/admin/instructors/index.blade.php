@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Instructors') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <a href="{{ route('admin.instructors.create') }}" class="btn btn-primary float-right">{{ __('Add New Instructor') }}</a>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('List of Instructors') }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="instructors_table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Area of Field') }}</th>
                                        <th>{{ __('Bio') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($instructors as $key => $instructor)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $instructor->name }}</td>
                                            <td>{{ $instructor->area_of_field }}</td>
                                            <td>{{ $instructor->bio }}</td>
                                            <td>
                                                <a href="{{ route('admin.instructors.show',$instructor->id) }}" class="btn btn-info">{{ __('View') }}</a>
                                                <a href="{{ route('admin.instructors.edit',$instructor->id) }}" class="btn btn-primary">{{ __('Edit') }}</a>
                                                <form action="{{ route('instructors.destroy',$instructor->id) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
