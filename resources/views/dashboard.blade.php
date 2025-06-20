@extends('layouts.app')
@section('content')
 <div class="container">
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card bg-light">
                    <div class="card-body">
                        <h5>Total Products</h5>
                        <p class="font-weight-bold  h2 mt-1 text-primary">{{ $productCounts }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-light">
                    <div class="card-body">
                        <h5>Total Orders</h5>
                        <p class="font-weight-bold  h2 mt-1 text-primary">{{ $totalOrders }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-light">
                    <div class="card-body">
                        <h5>Total Sales</h5>
                        <p class="font-weight-bold h2 mt-1 text-primary">₹{{ number_format($totalSales, 2) }}</p>
                    </div>
                </div>
            </div>
            
        </div>

        <h4 class="bg-primary text-white p-3 mb-2 ">⚠️ Low Stock Products (Below 5)</h4>
        @if($lowStockProducts->count())
            <ul>
                @foreach($lowStockProducts as $product)
                    <li>{{ $product->name }} ({{ $product->quantity }} left)</li>
                @endforeach
            </ul>
        @else
            <p>All products have sufficient stock.</p>
        @endif
    </div>
    @endsection