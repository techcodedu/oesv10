@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Edit Course') }}</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Update Course') }}</h3>
                        </div>
                        <form role="form" method="POST" action="{{ route('courses.update', ['course' => $course->id]) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">{{ __('Name') }}</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name', $course->name) }}" placeholder="{{ __('Enter course name') }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="description">{{ __('Description') }}</label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="3">{{ old('description', $course->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="training_hours">{{ __('Training Hours') }}</label>
                                    <input type="number" name="training_hours" class="form-control @error('training_hours') is-invalid @enderror" id="training_hours" value="{{ old('training_hours', $course->training_hours) }}" placeholder="{{ __('Enter training hours') }}">
                                    @error('training_hours')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="image">{{ __('Image') }}</label>
                                    <div>
                                        @if($course->image)
                                        <img src="{{ asset('storage/'.$course->image) }}" alt="{{ $course->name }}" width="200"/>
                                        @else
                                            <p>{{ __('No image uploaded') }}</p>
                                        @endif
                                       

                                    </div>
                                    <div class="mt-2">
                                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" id="image" accept="image/*">
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                

                                <div class="form-group">
                                    <label for="category_id">{{ __('Category') }}</label>
                                    <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" id="category_id">
                                        <option value="">{{ __('Select a category') }}</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $course->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="instructor_id">{{ __('Instructor') }}</label>
                                    <select name="instructor_id" class="form-control @error('instructor_id') is-invalid @enderror" id="instructor_id">
                                        <option value="">{{ __('Select an instructor') }}</option>
                                        @foreach($instructors as $instructor)
                                            <option value="{{ $instructor->id }}" {{ old('instructor_id', $course->instructor_id) == $instructor->id ? 'selected' : '' }}>{{ $instructor->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('instructor_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="price">{{ __('Price') }}</label>
                                    <input type="text" name="price" class="form-control @error('price') is-invalid @enderror" id="price" value="{{ old('price', $course->price) }}" placeholder="{{ __('Enter course price') }}">
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">{{ __('Update Course') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection