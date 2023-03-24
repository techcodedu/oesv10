@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Add New Instructor') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <a href="{{ route('admin.instructors.index') }}" class="btn btn-secondary float-right">{{ __('Back to List') }}</a>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">{{ __('Instructor Information') }}</div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.instructors.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="name">{{ __('Name') }}</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="{{ __('Enter Name') }}">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="area_of_field">{{ __('Area of Field') }}</label>
                                    <select class="form-control @error('area_of_field') is-invalid @enderror" id="area_of_field" name="area_of_field" required>
                                        <option value="" selected disabled>{{ __('Select Area of Field') }}</option>
                                        @foreach ($areas_of_field_values as $value)
                                        <option value="{{ $value }}" {{ old('area_of_field') == $value ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @error('area_of_field')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="bio">{{ __('Bio') }}</label>
                                    <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" placeholder="{{ __('Enter Bio') }}" rows="5">{{ old('bio') }}</textarea>
                                    @error('bio')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="image">{{ __('Image') }}</label>
                                    <input type="file" class="form-control-file @error('image') is-invalid @enderror" id="image" name="image">
                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
