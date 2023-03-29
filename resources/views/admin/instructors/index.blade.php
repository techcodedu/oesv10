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
                        <div class="alert alert-success" id="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(Session::has('error'))
                        <div class="alert alert-danger" id="alert">
                            {{ Session::get('error') }}
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
                                            <a href="#" class="btn btn-info" data-toggle="modal" data-target="#instructorModal" data-id="{{ $instructor->id }}">{{ __('View') }}</a>
                                            <!-- Change the edit link to a button -->
                                            <a href="{{ route('admin.instructors.edit', $instructor->id) }}" class="btn btn-primary">Edit</a>
                                            <form onsubmit="return confirmDelete()" action="{{ route('instructors.destroy', $instructor->id) }}" method="POST" style="display: inline-block;">
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
    <div class="modal fade" id="instructorModal" tabindex="-1" role="dialog" aria-labelledby="instructorModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="instructorModalLabel">{{ __('Instructor Details') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="instructor-details-container">
                    <!-- Instructor details will be loaded here via AJAX -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- /.content -->
    @section('scripts')
        <script>
            $(document).ready(function() {
                $('#instructorModal').on('show.bs.modal', function(e) {
                    var button = $(e.relatedTarget);
                    var instructorId = button.data('id');
                    var url = '{{ route("admin.instructors.show", ":id") }}';
                    url = url.replace(':id', instructorId);

                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function(response) {
                            $('#instructor-details-container').html(response);
                        }
                    });
                });
            });
        </script>
        <script>
            function confirmDelete() {
                return confirm('Are you sure you want to delete this instructor?');
            }
        </script>
    @endsection
@endsection
