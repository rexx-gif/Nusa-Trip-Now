@extends('layouts.admin')

@section('title', 'Edit Wisata')

@section('content')
    <form action="{{ route('admin.tours.update', $tour) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.tours._form')
    </form>
@endsection