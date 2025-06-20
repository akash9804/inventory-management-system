@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Create Sales Order</h2>

    <!-- Search Bar -->
    <div class="form-group">
        <input type="text" id="product-search" class="form-control" placeholder="Search Product...">
        <div id="search-results" class="mt-2"></div>
    </div>

    <!-- Order Table -->
    <form method="POST" action="{{ route('sales-orders.store') }}">
        @csrf
        <table class="table table-bordered mt-4" id="order-items">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Stock</th>
                    <th>Qty</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- JavaScript will insert rows here -->
            </tbody>
        </table>

        <button type="submit" class="btn btn-success mt-2">Submit Order</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
let orderItems = [];

document.getElementById('product-search').addEventListener('keyup', function () {
    // alert('Searching for products...');
    const query = this.value.trim();
    if (query.length < 2) return;

    fetch(`{{ route('products.search') }}?q=${encodeURIComponent(query)}`)
        .then(res => res.json())
        .then(products => {
            let html = '';
            products.forEach(p => {
                if (!orderItems.find(item => item.id === p.id)) {
                    html += `
                        <div class="border p-2 mb-1">
                            <strong>${p.name}</strong> (Stock: ${p.quantity})
                            <button type="button" class="btn btn-sm btn-primary float-right"
                                onclick="addProduct(${p.id}, '${p.name}', ${p.quantity})">Add</button>
                        </div>`;
                }
            });
console.log(html);
            document.getElementById('search-results').innerHTML = html;
        });
});

function addProduct(id, name, stock) {
    orderItems.push({ id, name, quantity: 1, stock });
    renderTable();
    document.getElementById('search-results').innerHTML = '';
    document.getElementById('product-search').value = '';
}

function removeProduct(id) {
    orderItems = orderItems.filter(p => p.id !== id);
    renderTable();
}

function updateQty(id, qty) {
    const item = orderItems.find(p => p.id === id);
    if (item) {
        item.quantity = Math.min(item.stock, Math.max(1, parseInt(qty) || 1));
    }
}

function renderTable() {
    const tbody = document.querySelector('#order-items tbody');
    tbody.innerHTML = '';

    orderItems.forEach((item, index) => {
        tbody.innerHTML += `
            <tr>
                <td>
                    ${item.name}
                    <input type="hidden" name="items[${index}][product_id]" value="${item.id}">
                </td>
                <td>${item.stock}</td>
                <td>
                    <input type="number" name="items[${index}][quantity]" value="${item.quantity}" min="1" max="${item.stock}"
                        class="form-control" onchange="updateQty(${item.id}, this.value)">
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeProduct(${item.id})">Remove</button>
                </td>
            </tr>
        `;
    });
}
</script>
@endpush
