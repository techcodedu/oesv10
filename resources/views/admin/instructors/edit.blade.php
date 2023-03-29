@extends('layouts.app')

@section('content')
    <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">{{ __('Instructor Information') }}</div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('admin.instructors.update', $instructor->id) }}" enctype="multipart/form-data" id="update-instructor-form">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="name">Name:</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ $instructor->name }}" required>
                                     @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </div>

                                     <div class="form-group">
                                        <label for="bio">Bio:</label>
                                        <textarea id="bio" class="form-control" name="bio" required>{{ $instructor->bio }}</textarea>
                                     @error('bio')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </div>

                                     <div class="form-group">
                                        <label for="area_of_field">Area of Field:</label>
                                        <select id="area_of_field" name="area_of_field" class="form-control" required>
                                            @foreach ($areas_of_field_values as $area_of_field)
                                                <option value="{{ $area_of_field }}" {{ $instructor->area_of_field === $area_of_field ? 'selected' : '' }}>{{ $area_of_field }}</option>
                                            @endforeach
                                        </select>
                                         @error('area_of_field')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="image">{{ __('Image') }}</label>
                                        @if($instructor->image)
                                            <img src="{{ asset('storage/'.$instructor->image) }}" alt="{{ $instructor->name }}" class="img-thumbnail mb-2" width="200">
                                        @endif
                                        <input type="file" class="form-control-file @error('image') is-invalid @enderror" id="image" name="image">
                                        @error('image')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Qualifications:</label>
                                        <select class="form-control @error('qualifications') is-invalid @enderror" id="qualifications" name="qualifications[]" multiple>
                                            @foreach ($default_qualifications as $value)
                                            <option value="{{ $value }}" {{ in_array($value, old('qualifications', $qualifications->pluck('title')->toArray())) ? 'selected' : '' }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                         @error('qualifications')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        @foreach ($instructor->qualifications as $index => $qualification)
                                            <div>
                                                <input type="hidden"class="form-control" name="qualifications[{{ $index }}][id]" value="{{ $qualification->id }}">
                                                <input type="text" class="form-control" name="qualifications[{{ $index }}][title]" value="{{ $qualification->title }}" required>
                                            </div>
                                        @endforeach
                                    </div>

                                    <button type="submit" class="btn btn-primary">Update Instructor</button>
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

            // Prepopulate the Selected Qualifications list and the hidden input field with saved qualifications
            
            savedQualifications.forEach(qualification => {
                const option = new Option(qualification, qualification, true, true);
                $(qualificationsSelect).append(option).trigger('change');
            });
            updateSelectedQualifications();

            // This event listener will update the selected qualifications list upon closing the dropdown
            $(qualificationsSelect).on('select2:close', function() {
                updateSelectedQualifications();
            });

            // ...rest of the script code...
        </script>
        <script>
            const form = document.getElementById('update-instructor-form');

            form.addEventListener('submit', (e) => {
                e.preventDefault();

                // Remove the existing qualifications inputs
                document.querySelectorAll('input[name^="qualifications["]').forEach(input => input.remove());

                // Add the selected qualifications as hidden inputs with the correct name structure
                const selectedOptions = [...qualificationsSelect.selectedOptions];
                selectedOptions.forEach((option, index) => {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = `qualifications[${index}][title]`;
                    hiddenInput.value = option.value;
                    form.appendChild(hiddenInput);
                });

                console.log('Form submitted');
                form.submit();
            });

        </script>
    @endpush
@endsection
