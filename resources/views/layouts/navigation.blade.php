<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
            {{-- <a href="{{ route('profile.show') }}" class="d-block">{{ Auth::user()->name }}</a> --}}
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
            data-accordion="false">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                        {{ __('Dashboard') }}
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.courseinfo') }}" class="nav-link">
                    <i class="nav-icon fas fa-compass"></i>
                    <p>
                        {{ __('Course Information') }}
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview" style="display: none;">
                    <li class="nav-item">
                        <a href="{{ route('categories.index') }}" class="nav-link">
                            <i class="fas fa-clipboard-list"></i>
                            {{ __('Course Categories') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('courses.index') }}" class="nav-link">
                            <i class="fas fa-user-circle"></i>
                             {{ __('Courses') }}
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.users') }}" class="nav-link">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        {{ __('User Management') }}
                    </p>
                </a>
            </li>
  

            <li class="nav-item">
                <a href="{{ route('admin.oapplication') }}" class="nav-link">
                    <i class="nav-icon  fas fa-globe"></i>
                    <p>
                        {{ __('Online Application') }}
                    </p>
                </a>
            </li>
            
          
              <li class="nav-item">
                <a href="{{ route('admin.certificate') }}" class="nav-link">
                    <i class="nav-icon fas fa-certificate"></i>
                    <p>
                        {{ __('Certificate Issuance') }}
                    </p>
                </a>
            </li>
             </li>
              <li class="nav-item">
                <a href="{{ route('admin.reports') }}" class="nav-link">
                    <i class="nav-icon fas fa-chart-bar "></i>
                    <p>
                        {{ __('Analytics and Reporting') }}
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-user"></i>
                    <p>
                        Student
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview" style="display: none;">
                    <li class="nav-item">
                        <a href="{{ route('admin.studentregistration') }}" class="nav-link">
                            <i class="fas fa-clipboard-list"></i>
                            {{ __('Registration') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.studprofile') }}" class="nav-link">
                            <i class="fas fa-user-circle"></i>
                             {{ __('Profile') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.payments') }}" class="nav-link">
                            <i class="fas fa-wallet"></i>
                             {{ __('Payments') }}
                        </a>
                    </li>
                </ul>
            </li> 
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->

{{-- Online application - A system for prospective students to apply for TESDA courses online. --}}
{{--Payment gateway - A secure payment system for students to pay course fees online.--}}
{{-- Student registration - A system for TESDA to keep track of student enrollment and  --}}
{{-- Student profile - A place for students to view and manage their personal and academic information. --}}
{{-- Certificate issuance - A system for TESDA to issue certificates to students who have successfully completed their courses. --}}
{{-- Analytics and reporting - A system for TESDA to track and analyze student performance, enrollment trends, and other key metrics. --}}