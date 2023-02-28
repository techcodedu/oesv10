@extends('layouts.frontapp')
@section('title', 'Courses')

@section('content')
<div class="container py-5">
    <div class="row">
        @if($courses->count() > 0)
            @foreach($courses as $course)
                <div class="col-12 col-md-4 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="position-relative">
                            <img src="{{ asset('storage/'.$course->image) }}" style="max-width: 100%; height: auto;"  alt="{{ $course->name }}" />
                            <div class="overlay bg-dark position-absolute top-0 start-0 end-0 bottom-0 opacity-75"></div>
                        </div>
                        <div class="card-body position-relative">
                            <h5 class="card-title text-white mb-0" style="font-size: 22px">{{ $course->name }}</h5>
                            <div class="card-text text-white mb-3">
                                <span class="small">{{ __('Trainer') }}:</span>
                                <span class="font-weight-bold">{{ $course->instructor->name }}</span>
                            </div>
                            <div class="card-text text-white mb-3">
                                <span class="small">{{ __('Duration') }}:</span>
                                <span class="font-weight-bold">{{ $course->training_hours }} {{ __('hours') }}</span>
                            </div>
                            <button type="button" class="btn btn-light btn-sm rounded-pill position-absolute bottom-0 end-0" data-toggle="modal" data-target="#courseModal_{{ $course->id }}">
                                {{ __('View Details') }}
                            </button>
                            @if (Auth::check() && $course->enrollments()->where('user_id', Auth::user()->id)->where('status', 'inReview')->first())
                                <span class="badge badge-pill badge-success position-absolute bottom-0 end-0 me-2 mb-2 p-2 " style="bottom: 5px; right: 10px;">Enrollment being reviewed</span>
                            @elseif (Auth::check() && $course->enrollments()->where('user_id', Auth::user()->id)->where('status', 'inProgress')->first())
                                <span class="badge badge-pill badge-success position-absolute bottom-0 end-0 me-2 mb-2 p-2 " style="bottom: 5px; right: 10px;">Enrollment in Progress</span>
                            @else
                                @if (Auth::check() && $course->enrollments()->where('user_id', Auth::user()->id)->where('status', 'enrolled')->first())
                                    <span class="badge badge-pill badge-success position-absolute bottom-0 end-0 me-2 mb-2 p-2 " style="bottom: 5px; right: 10px;">Enrolled</span>
                                @endif
                            @endif
                        </div>
                    </div>
                    <div class="modal fade" id="courseModal_{{ $course->id }}" tabindex="-1" role="dialog" aria-labelledby="courseModal_{{ $course->id }}_label" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-xl" role="document" style="max-width:500px;">
                            <div class="modal-content">
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title" id="courseModal_{{ $course->id }}_label">{{ $course->name }}</h5>
                                    
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h6 class="card-title text-muted mb-2">{{ __('Trainer') }}</h6>
                                                    <p class="card-text">{{ $course->instructor->name }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h6 class="card-title text-muted mb-2">{{ __('Duration') }}</h6>
                                                    <p class="card-text">{{ $course->training_hours }} {{ __('hours') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h6 class="card-title text-muted mb-2">{{ __('Training Cost') }}</h6>
                                                    <p class="card-text">{{ $course->price }} &#8369;</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h6 class="card-title text-muted mb-2">{{ __('Category') }}</h6>
                                                    <p class="card-text">{{ $course->category->name }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <img src="{{ asset('storage/'.$course->image) }}" style="width:100%; height:auto; object-fit:container;" alt="{{ $course->name }}" />
                                    <p class="mt-3">{{ $course->description }}</p>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                                    @auth
                                        @if($course->enrollments()->where('user_id', Auth::id())->where('status', \App\Models\Enrollment::STATUS_IN_REVIEW)->exists())
                                            <button type="button" class="btn btn-secondary" disabled>{{ __('Enrollment in Review') }}</button>
                                        @elseif($course->enrollments()->where('user_id', Auth::id())->where('status', \App\Models\Enrollment::STATUS_IN_PROGRESS)->exists())
                                            <button type="button" class="btn btn-secondary" disabled>{{ __('Enrollment in Progress') }}</button>
                                        @elseif($course->enrollments()->where('user_id', Auth::id())->where('status', \App\Models\Enrollment::STATUS_ENROLLED)->exists())
                                            <button type="button" class="btn btn-secondary" disabled>{{ __('Enrolled') }}</button>
                                        @else
                                            <a href="{{ route('enrollment.form', ['course' => $course->id, 'user' => Auth::id()]) }}" class="btn btn-primary">{{ __('Enroll Now') }}</a>
                                        @endif
                                    @else
                                        <a href="{{ route('signin') }}" class="btn btn-primary">{{ __('Login to Enroll') }}</a>
                                    @endauth   
                                </div>
                                
                                
                            </div>
                        </div>
                    </div>
                    
                </div>
            @endforeach
        @else
        <div class="col-12 text-center py-5">
            <h2 class="text-muted" style="font-size: 30px;">{{ __('No available course in this category.') }}</h2>
        </div>
        
        
        @endif
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#categorySelect').on('change', function() {
            var categoryId = $(this).val();
            $.ajax({
                type: 'GET',
                url: '/courses/category/' + categoryId,
                success: function(data) {
                    $('#courseList').html(data);
                },
                error: function() {
                    alert('Error loading courses.');
                }
            });
        });
    });
</script>
@endsection