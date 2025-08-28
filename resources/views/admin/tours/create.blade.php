@extends('layouts.admin')

@section('title', 'Tambah Wisata Baru')

@section('content')
    <form action="{{ route('admin.tours.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.tours._form')
    </form>
@endsection