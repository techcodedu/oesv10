@extends('layouts.app')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
.modal-body {
  max-height: 400px;
  overflow-y: scroll;
}
</style>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Application') }}</h1>
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
                        <div class="card-header">
                            <h3 class="card-title">Applications</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Application ID</th>
                                        <th>Full Name</th>
                                        <th>Course Name</th>
                                        <th>Enrollment Type</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($enrollments as $enrollment)
                                    <tr>
                                        <td>{{ $enrollment->id }}</td>
                                        <td>{{ $enrollment->personalInformation->fullname }}</td>
                                        <td>{{ $enrollment->course->name }}</td>
                                        <td>{{ $enrollment->enrollment_type }}</td>
                                        <td>
                                            <select name="status" class="form-control status-select" data-enrollment-id="{{ $enrollment->id }}">
                                                <option value="inReview" {{ $enrollment->status === 'inReview' ? 'selected' : '' }}>In Review</option>
                                                <option value="inProgress" {{ $enrollment->status === 'inProgress' ? 'selected' : '' }}>In Progress</option>
                                                <option value="enrolled" {{ $enrollment->status === 'enrolled' ? 'selected' : '' }}>Enrolled</option>
                                            </select>
                                            
                                        </td>
                                        <td>
                                            <a href="#" data-toggle="modal" data-target="#enrollmentModal" data-id="{{ $enrollment->id }}">Show Details</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer clearfix">
                            {{ $enrollments->links() }}
                        </div>
                    </div>

                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

    <!-- Modal -->
    <div class="modal fade" id="enrollmentModal" tabindex="-1" role="dialog" aria-labelledby="enrollmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="enrollmentModalLabel">Enrollment Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 500px;">
                    <div id="enrollmentDetails"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="messageModalLabel">Message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="messageText"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    <script>
        
    </script>
   <script>
    $(function() {
    // Event listener for opening the modal window
    $(document).on('click', 'a[data-target="#enrollmentModal"]', function(e) {
      e.preventDefault();
  
      // Get the enrollment ID from the data-id attribute of the clicked element
      var enrollmentId = $(this).data('id');
      console.log("Making AJAX request for enrollment " + enrollmentId);
      $.ajax({
        url: "{{ route('admin.enrollment.show', ':id') }}".replace(':id', enrollmentId),
        type: 'GET',
        dataType: 'html',
        success: function(response) {
          console.log("Received response: ", response);
          // Update the modal content with the enrollment details
          $('#enrollmentModal .modal-body').html(response);
          // Show the modal
          $('#enrollmentModal').modal('show');
        },
        error: function(response) {
          console.log("Error:", response);
        }
      });
    });
  
    // Event listener for updating the enrollment status
    // Event listener for updating the enrollment status
    $('.status-select').on('change', function() {
    var enrollmentId = $(this).data('enrollment-id');
    var newStatus = $(this).val();
    console.log("Updating enrollment status for enrollment " + enrollmentId + " to " + newStatus);
    $.ajax({
        url: '/admin/enrollments/updateStatus',
        type: 'PUT',
        data: {
        enrollment: enrollmentId,
        status: newStatus,
        _token: '{{ csrf_token() }}'
        },
        success: function(response) {
        console.log("Enrollment status updated successfully.");
        $('#messageText').text('Enrollment status updated successfully.');
        $('#messageModal').modal('show');
        },
        error: function(response) {
        console.log("Error updating enrollment status:", response);
        $('#messageText').text('Error updating enrollment status.');
        $('#messageModal').modal('show');
        }
    });
    });

  });

   </script>
@endsection
