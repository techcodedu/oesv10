<!-- admin/enrollment/show.blade.php -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Enrollment Details</h3>
        </div>

        <div class="card-body">
            <h4>Personal Information</h4>
                <table class="table">
                    <tr>
                        <td>Full Name</td>
                        <td>{{ $enrollment->personalInformation->fullname }}</td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td>{{ $enrollment->personalInformation->address }}</td>
                    </tr>
                    <tr>
                        <td>Age</td>
                        <td>{{ $enrollment->personalInformation->age }}</td>
                    </tr>
                    <tr>
                        <td>Contact Number</td>
                        <td>{{ $enrollment->personalInformation->contact_number }}</td>
                    </tr>
                    <tr>
                        <td>Facebook</td>
                        <td>{{ $enrollment->personalInformation->facebook }}</td>
                    </tr>
                    <tr>
                        <td>Currently Schooling</td>
                        <td>{{ $enrollment->personalInformation->currently_schooling }}</td>
                    </tr>
                    <tr>
                        <td>Employment Status</td>
                        <td>{{ $enrollment->personalInformation->employment_status }}</td>
                    </tr>
                </table>

            <h4>Enrollment Details</h4>
                <table class="table">
                        <tr>
                            <td>Application ID</td>
                            <td>{{ $enrollment->id }}</td>
                        </tr>
                        <tr>
                            <td>Course Name</td>
                            <td>{{ $enrollment->course->name }}</td>
                        </tr>
                        <tr>
                            <td>Enrollment Type</td>
                            <td>{{ $enrollment->enrollment_type }}</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>{{ $enrollment->status }}</td>
                        </tr>
                    </tr>
                </table>
                <h4>Enrollment Documents</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Document Type</th>
                            <th>Download</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($enrollment->enrollmentDocuments as $document)
                        <tr>
                            <td>{{ $document->path ? pathinfo(storage_path('app/' . $document->path), PATHINFO_FILENAME) . '.' . pathinfo(storage_path('app/' . $document->path), PATHINFO_EXTENSION) : 'N/A' }}</td>
                            <td>{{ $document->document_type }}</td>
                            <td><a href="{{ asset('storage/' . str_replace(' ', '%20', $document->path)) }}" target="_blank">View</a></td>
                        </tr>
                    @endforeach
                    
                    </tbody>
                </table>
                
    </div>
</div>
