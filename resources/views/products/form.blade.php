<form method="POST" action="{{ $action }}">
    @csrf
    @if($method === 'PUT') @method('PUT') @endif

    <div class="form-group mb-3">
        <label for="name">Name</label>
        <input 
            type="text" 
            name="name" 
            id="name" 
            class="form-control @error('name') is-invalid @enderror" 
            value="{{ old('name', $product->name ?? '') }}" 
            placeholder="Enter product name"
        >
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="sku">SKU</label>
        <input 
            type="text" 
            name="sku" 
            id="sku" 
            class="form-control @error('sku') is-invalid @enderror" 
            value="{{ old('sku', $product->sku ?? '') }}" 
            placeholder="Enter SKU"
        >
        @error('sku')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="price">Price</label>
        <input 
            type="number" 
            name="price" 
            id="price" 
            step="0.01" 
            class="form-control @error('price') is-invalid @enderror" 
            value="{{ old('price', $product->price ?? '') }}" 
            placeholder="Enter price"
        >
        @error('price')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group mb-4">
        <label for="quantity">Quantity</label>
        <input 
            type="number" 
            name="quantity" 
            id="quantity" 
            class="form-control @error('quantity') is-invalid @enderror" 
            value="{{ old('quantity', $product->quantity ?? '') }}" 
            placeholder="Enter quantity"
        >
        @error('quantity')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-success">{{ $buttonText }}</button>
</form>

