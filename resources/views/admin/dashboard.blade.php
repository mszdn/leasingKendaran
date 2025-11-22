@extends('layouts.app')

@section('content')
    <h1>Dashboard Admin</h1>
    <p>Selamat datang, {{ auth()->user()->username }}</p>
@endsection