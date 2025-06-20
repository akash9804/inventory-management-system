@extends('layouts.app')
@section('content')
<h2>Edit Product</h2>
@include('products.form', ['action' => route('products.update', $product), 'method' => 'PUT', 'buttonText' => 'Update'])
@endsection
