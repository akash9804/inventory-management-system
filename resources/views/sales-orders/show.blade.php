<!-- <a href="{{ route('sales-orders.download', $order->id) }}" class="btn btn-primary">
    Download PDF
</a> -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Sales Order #{{ $order->id }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Customer:</strong> {{ $order->user->name ?? 'N/A' }}</p>
            <p><strong>Order Date:</strong> {{ $order->created_at->format('Y-m-d') }}</p>
            <p><strong>Total:</strong> ₹{{ number_format($order->total, 2) }}</p>
        </div>
    </div>

    <h4>Order Items</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Price (₹)</th>
                <th>Subtotal (₹)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price, 2) }}</td>
                    <td>{{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-end">Total</th>
                <th>₹{{ number_format($order->total, 2) }}</th>
            </tr>
        </tfoot>
    </table>

    <a href="{{ route('sales-orders.download', $order->id) }}" class="btn btn-secondary mt-3">
        Download PDF
    </a>
</div>
@endsection
