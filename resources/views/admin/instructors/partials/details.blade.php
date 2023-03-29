<!-- admin/instructors/partials/details.blade.php -->

<div class="card">
    <div class="card-header">
        <h4 class="card-title">{{ $instructor->name }}</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                @if($instructor->image)
                    <img src="{{ asset('storage/' . $instructor->image) }}" alt="{{ $instructor->name }}" class="img-fluid img-thumbnail">
                @else
                    <img src="{{ asset('images/default-user.png') }}" alt="{{ $instructor->name }}" class="img-fluid img-thumbnail">
                @endif
            </div>
            <div class="col-md-8">
                <table class="table table-bordered">
                    <tr>
                        <th>{{ __('Name') }}</th>
                        <td>{{ $instructor->name }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('Area of Field') }}</th>
                        <td>{{ $instructor->area_of_field }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('Qualifications') }}</th>
                        <td>
                            @foreach ($qualifications as $qualification)
                                <span class="badge badge-primary">{{ $qualification->title }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>{{ __('Bio') }}</th>
                        <td>{!! nl2br(e($instructor->bio)) !!}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
