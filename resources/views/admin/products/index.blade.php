@extends('layouts.admin')

@section('content')
    <h1>Список продуктов</h1>
    <div class="admin_top_container">
        <div class="d-flex align-items-center">
            <form action="{{ route('admin.products.create') }}" method="GET">
                @csrf
                <button class="btn btn-primary" type="submit">Создать
                    продукт</button>
            </form>
            <form class="ml-3" action="{{ route('admin.products.export') }}" method="POST">
                @csrf
                <button class="btn btn-primary" type="submit">Экспорт продуктов</button>
            </form>
        </div>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
                {{ session('success') }}
                <button type="button" class="close admin_notification_close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    </div>
    <table class="table table-striped mt-3">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Производитель</th>
                <th>Описание</th>
                <th>Услуги</th>
                <th>Дата выпуска</th>
                <th>Цена, BYN</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->brand->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>
                        <ul>
                            @if ($product->services && count($product->services) > 0)
                                @foreach ($product->services as $service)
                                    <li>{{ $service->name }}</li>
                                @endforeach
                            @else
                                <li>Нет доступных услуг</li>
                            @endif
                        </ul>
                    </td>
                    <td>{{ $product->release_date }}</td>
                    <td>{{ $product->price }}</td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product->id) }}"
                            class="btn btn-warning btn-sm">Редактировать</a>
                        <form class="btn-delete" action="{{ route('admin.products.delete', $product) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
