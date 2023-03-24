@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Instructor Details') }}</h1>
                </div><!-- /.col -->
               
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <!-- Modal -->
    <!-- Modal -->
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
    @section('script')
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
    @endsection
@endsection
