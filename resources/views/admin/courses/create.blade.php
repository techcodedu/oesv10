@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('Create Course') }}</h3>
        </div>
        <form role="form" method="POST" action="{{ route('courses.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                <div class="form-group">
                    <label for="name">{{ __('Name') }}</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name') }}" placeholder="{{ __('Enter course name') }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">{{ __('Description') }}</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="3" placeholder="{{ __('Enter course description') }}">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="training_hours">{{ __('Training Hours') }}</label>
                    <input type="number" name="training_hours" class="form-control @error('training_hours') is-invalid @enderror" id="training_hours" value="{{ old('training_hours') }}" placeholder="{{ __('Enter course training hours') }}">
                    @error('training_hours')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                

                <div class="form-group">
                    <label for="image">{{ __('Image') }}</label>
                    <input type="file" name="image" class="form-control-file @error('image') is-invalid @enderror" id="image">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price">{{ __('Price') }}</label>
                    <?php $formattedPrice = number_format(old('price', 0), 2, '.', ','); ?>
                    <input type="text" name="price" class="form-control @error('price') is-invalid @enderror price-input" id="price" value="{{ old('price') }}" placeholder="{{ __('Enter course price') }}">
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                

                <div class="form-group">
                    <label for="category_id">{{ __('Category') }}</label>
                    <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" id="category_id">
                        <option value="">{{ __('Select a category') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
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
                            <option value="{{ $instructor->id }}" {{ old('instructor_id') == $instructor->id ? 'selected' : '' }}>{{ $instructor->name }}</option>
                        @endforeach
                    </select>
                    @error('instructor_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                    <a href="{{ route('courses.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                </div>

            </form>
        </div>
        <script>
            setTimeout(function () {
        $(".alert").fadeOut("slow");
    }, 2000);
    
        </script>

        @endsection

