@extends('layouts.frontapp')

@section('title', 'About Us')

@section('content')
  <div class="container py-5">
    <div class="row">
      <div class="col-12">
        <h1 class="text-center mb-4">{{ __('About Us') }}</h1>
        <p class="lead text-center">
          {{ __('We are a team of dedicated professionals who are passionate about providing high-quality training programs to help individuals enhance their skills and achieve their goals.') }}
        </p>
        <p class="text-center">
          {{ __('Our training programs are designed to equip individuals with the knowledge and skills needed to succeed in today’s competitive job market. We offer a wide range of courses in various fields, from business and finance to technology and software development.') }}
        </p>
        <p class="text-center">
          {{ __('We are committed to delivering an exceptional learning experience to our students, and we are always striving to improve our courses and services to meet their evolving needs.') }}
        </p>
      </div>
    </div>
  </div>
@endsection
