@extends('layouts.frontapp')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mt-4">
            <div class="card">
                <div class="card-header">
                    <h2>Step 1: Enrollment Type</h2>
                </div>

                <div class="card-body">
                    {{-- <form method="POST" action="{{ route('enrollment.step1.submit', ['course' => $courseId, 'user' => Auth::id()]) }}"> --}}
                        {{-- <form method="POST" action="{{ route('enrollment.step1.submit', ['courseId' => $course->id, 'userId' => auth()->id()]) }}"> --}}
                            <form method="POST" action="{{ route('enrollment.store', [$course->id, $user->id]) }}">


                        @csrf
                        <input type="hidden" name="course" value="{{ $course->id }}">
                        <input type="hidden" name="user" value="{{ Auth::id() }}">
                        <div class="form-group row">
                            <label for="enrollment_type" class="col-md-4 col-form-label text-md-right">{{ __('Enrollment Type') }}</label>
                            <div class="col-md-6">
                                <select id="enrollment_type" name="enrollment_type" class="form-control @error('enrollment_type') is-invalid @enderror" required>
                                    <option value="" disabled selected>Select enrollment type</option>
                                    <option value="scholarship">Scholarship</option>
                                    <option value="regular_training">Regular Training</option>
                                    <option value="assessment">Assessment Only</option>
                                </select>
                                @error('enrollment_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">{{ __('Continue') }}</button>
                            </div>
                        </div>
                    </form>
                    
                        
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
