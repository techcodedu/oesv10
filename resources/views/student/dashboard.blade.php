@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Enrollment Step 3') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('enrollment.step3.store', ['enrollment' => $enrollment]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('POST')

                        <div class="form-group row">
                            <label for="otr_path" class="col-md-4 col-form-label text-md-right">{{ __('Official Transcript of Records (OTR)') }}</label>

                            <div class="col-md-6">
                                <input id="otr_path" type="file" class="form-control-file @error('otr_path') is-invalid @enderror" name="otr_path" required>

                                @error('otr_path')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="birth_certificate_path" class="col-md-4 col-form-label text-md-right">{{ __('Birth Certificate') }}</label>

                            <div class="col-md-6">
                                <input id="birth_certificate_path" type="file" class="form-control-file @error('birth_certificate_path') is-invalid @enderror" name="birth_certificate_path" required>

                                @error('birth_certificate_path')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="marriage_certificate_path" class="col-md-4 col-form-label text-md-right">{{ __('Marriage Certificate') }}</label>

                            <div class="col-md-6">
                                <input id="marriage_certificate_path" type="file" class="form-control-file @error('marriage_certificate_path') is-invalid @enderror" name="marriage_certificate_path">

                                @error('marriage_certificate_path')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Complete Enrollment') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
