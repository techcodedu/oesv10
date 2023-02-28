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
    $('.status-select').on('change', function() {
      var enrollmentId = $(this).data('enrollment-id');
      var newStatus = $(this).val();
      console.log("Updating enrollment status for enrollment " + enrollmentId + " to " + newStatus);
      $.ajax({
        url: '/admin/oapplication/updateEnrollmentStatus',
        type: 'POST',
        data: {
          enrollmentId: enrollmentId,
          newStatus: newStatus,
          _token: '{{ csrf_token() }}'
        },
        success: function(response) {
          console.log("Enrollment status updated successfully.");
        },
        error: function(response) {
          console.log("Error updating enrollment status:", response);
        }
      });
    });
  });
