@extends('layouts.app')

@section('content')
<h2>Sales Orders</h2>
<table class="table">
    <thead>
        <tr><th>ID</th><th>User</th><th>Total</th><th>Action</th></tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
        <tr>
            <td>#SA-00{{ $order->id }}</td>
            <td>{{ $order->user->name }}</td>
            <td>₹{{ $order->total }}</td>
            <td>
                <a href="{{ route('sales-orders.show', $order->id) }}" class="btn btn-sm btn-info">View</a>
                <a href="{{ route('sales-orders.download', $order->id) }}" class="btn btn-sm btn-primary">PDF</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
