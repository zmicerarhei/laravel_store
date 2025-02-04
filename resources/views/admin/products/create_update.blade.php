@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>{{ isset($product) ? 'Изменение продукта' : 'Создание продукта' }}</h1>

        <form action="{{ isset($product) ? route('admin.products.update', $product->id) : route('admin.products.store') }}"
            method="POST">
            @csrf
            @if (isset($product))
                @method('PUT')
            @endif

            <div class="form-group">
                <label for="name">Название</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                    value="{{ old('name', $product->name ?? '') }}">
                @error('name')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="brand_id">Бренд</label>
                <select class="form-control @error('brand_id') is-invalid @enderror" id="brand_id" name="brand_id">
                    <option value="">Выберите бренд</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}"
                            {{ old('brand_id', $product->brand_id ?? '') == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
                @error('brand_id')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="category_id">Категория</label>
                <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                    <option value="">Выберите категорию</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                            {{ $category->title }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Описание</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description', $product->description ?? '') }}</textarea>
                @error('description')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="release_date">Дата выпуска товара</label>
                <input type="date" class="form-control @error('release_date') is-invalid @enderror" id="release_date"
                    name="release_date" value="{{ old('release_date', $product->release_date ?? '') }}"
                    max="{{ date('Y-m-d') }}">
                @error('release_date')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="price">Цена (в BYN)</label>
                <input type="number" class="form-control @error('price') is-invalid @enderror" id="price"
                    name="price"
                    value="{{ old('price', isset($product->price) ? number_format($product->price, 2, '.', '') : '') }}"
                    min="0.01" step="0.01">
                @error('price')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">Введите цену в рублях и копейках.</small>
            </div>

            <div class="form-group">
                <label>Дополнительные услуги</label><br>
                @if ($services->isEmpty())
                    <p>Нет доступных услуг.</p>
                @else
                    @foreach ($services as $service)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="{{ $service->id }}" name="services[]"
                                value="{{ $service->id }}"
                                {{ isset($selectedServices) && in_array($service->id, $selectedServices) ? 'checked' : '' }}>
                            <label class="form-check-label" for="{{ $service->id }}">
                                {{ $service->name }}
                            </label>
                        </div>
                    @endforeach
                @endif
            </div>

            <button type="submit" class="btn btn-primary">{{ isset($product) ? 'Обновить' : 'Создать' }}</button>
        </form>
    </div>
@endsection
