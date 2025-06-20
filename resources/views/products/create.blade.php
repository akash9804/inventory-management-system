@extends('layouts.app')
@section('content')
<h2>Create Product</h2>
@include('products.form', ['action' => route('products.store'), 'method' => 'POST', 'buttonText' => 'Save'])
@endsection
