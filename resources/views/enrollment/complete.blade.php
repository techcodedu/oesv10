@extends('layouts.frontapp')
@section('title', 'Completed Steps')

@section('content')
<div class="modal fade" id="completionModal" tabindex="-1" role="dialog" aria-labelledby="completionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="completionModalLabel">Processing your enrollment</h5>
      </div>
      <div class="modal-body text-center">
        <div class="spinner-border text-primary" role="status">
          <span class="sr-only">Loading...</span>
        </div>
        <p class="mt-2">Saving your data</p>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  $(function() {
    $('#completionModal').modal({
      backdrop: 'static',
      keyboard: false
    });
    setTimeout(function() {
      window.location.href = '{{ route("index") }}';
    }, 4000); // Change the delay time (in milliseconds) as needed
  });
</script>
@endsection
