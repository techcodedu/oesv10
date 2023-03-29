@extends('layouts.app')

@section('content')
    @section ('styles')
        <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            

        }
        .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            white-space: normal;
        }
        </style>

    @endsection
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
                                <!-- multiple selection -->
                                <div class="form-group">
                                    <label for="qualifications">{{ __('Qualifications') }}</label>
                                    <select class="form-control @error('qualifications') is-invalid @enderror" id="qualifications" name="qualifications[]" multiple>
                                        @foreach ($default_qualifications as $value)
                                        <option value="{{ $value }}" {{ in_array($value, old('qualifications', [])) ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @error('qualifications')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>{{ __('Selected Qualifications') }}</label>
                                    <ul id="selected-qualifications" class="list-group"></ul>
                                </div>
                                <input type="hidden" id="hidden-qualifications" name="qualifications[]" multiple>
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
    @push('scripts')
        <script>
            const qualificationsSelect = document.getElementById('qualifications');
            const selectedQualificationsList = document.getElementById('selected-qualifications');
            const hiddenQualificationsInput = document.getElementById('hidden-qualifications');

            // Initialize the Select2 component
            $(qualificationsSelect).select2({
                placeholder: 'Select Qualifications',
                allowClear: true,
                closeOnSelect: false,
                width: '100%'
            });

            function updateSelectedQualifications() {
                const selectedOptions = [...qualificationsSelect.selectedOptions];
                selectedQualificationsList.innerHTML = '';
                hiddenQualificationsInput.innerHTML = ''; // Clear the hidden input field

                selectedOptions.forEach(option => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item';
                    li.textContent = option.label;
                    selectedQualificationsList.appendChild(li);

                    // Add the selected option to the hidden input field
                    const hiddenOption = document.createElement('option');
                    hiddenOption.value = option.value;
                    hiddenOption.selected = true;
                    hiddenQualificationsInput.appendChild(hiddenOption);
                });
            }

            // This event listener will update the selected qualifications list upon closing the dropdown
            $(qualificationsSelect).on('select2:close', function() {
                updateSelectedQualifications();
            });

            // ...rest of the script code...
        </script>
    @endpush

    @section('scripts')
    // Add this inside the <script> tag
    $(document).ready(function() {
        // ... other code ...

        // Add this before the submit event listener
        $('form').on('submit', function() {
            if ($('#qualifications').val().length === 0) {
                $('#qualifications-error').remove();
                const errorMessage = 'The qualifications field is required.';
                const errorHtml = `
                    <span id="qualifications-error" class="invalid-feedback" role="alert">
                        <strong>${errorMessage}</strong>
                    </span>`;
                $('#qualifications').parent().append(errorHtml);
            } else {
                $('#qualifications-error').remove();
            }
        });

        // ... other code ...
    });

    @endsection


    <!-- /.content -->
@endsection
