@extends('layouts.app')

{{-- home.blade --}}
@section('hero_section')
    @include('components.hero')
@endsection
@section('content_section')
    @include('components.content')
@endsection
@section('howitworks_section')
    @include('components.howitworks')
@endsection
@section('footer_section')
    @include('components.footer')
@endsection
