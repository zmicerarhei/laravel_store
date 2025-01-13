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

            @foreach ($fields as $name => $field)
                <div class="form-group">
                    <label for="{{ $name }}">{{ $field['label'] }}</label>
                    <input type="{{ $field['type'] }}" class="form-control @error($name) is-invalid @enderror"
                        id="{{ $name }}" name="{{ $name }}"
                        value="{{ old($name, $field['type'] === 'number' ? number_format($product->{$name} ?? 0, 2, '.', '') : $product->{$name} ?? '') }}"
                        @if (isset($field['max'])) max="{{ $field['max'] }}" @endif
                        @if (isset($field['min'])) min="{{ $field['min'] }}" @endif
                        @if (isset($field['step'])) step="{{ $field['step'] }}" @endif>
                    @error($name)
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                    @if ($name === 'price')
                        <small class="form-text text-muted">Введите цену в рублях и копейках.</small>
                    @endif
                </div>
            @endforeach

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
