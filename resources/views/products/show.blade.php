@extends('layout')

@section('content')
    <h1>Product Details</h1>
    <p>Name: {{ $product->name }}</p>
    <p>Category: {{ $product->category }}</p>
    <p>Price: {{ $product->price }}</p>
    <a href="{{ route('products.edit', $product->id) }}">Edit</a>
    <form action="{{ route('products.destroy', $product->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">Delete</button>
    </form>
    <a href="{{ route('products.index') }}">Back to Products</a>
@endsection
