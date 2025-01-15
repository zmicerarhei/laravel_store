@extends('layouts.main')

@section('title', 'Каталог:: ' . ($category['title'] ?? 'Все товары'))
@section('content')

    <div class="products">
        <div class="container">
            <div class="category_title">
                {{ $category['title'] ?? 'Все товары' }}
            </div class="category_title">
            <div class="row mt-3">
                <div class="col">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#filtersModal">
                        Показать фильтры
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="sorting_bar d-flex flex-md-row flex-column align-items-md-center justify-content-md-start">
                        <div class="results">Найдено <span>{{ $total }}</span> результатов</div>
                        <div class="sorting_container d-flex ml-md-auto">
                            <div class="currencies">
                                <ul class="item_sorting">
                                    <li>
                                        <span class="sorting_text">Выберите валюту</span>
                                        <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                        <ul>
                                            <li class="product_sorting_btn" data-order='default'>
                                                <span>Беларуский рубль, BYN</span>
                                            </li>
                                            <li class="product_sorting_btn" data-order='price-low-high'>
                                                <span>Доллар США, USD</span>
                                            </li>
                                            <li class="product_sorting_btn" data-order='price-high-low'>
                                                <span>Евро, EUR</span>
                                            </li>
                                            <li class="product_sorting_btn" data-order='name-a-z'>
                                                <span>Российский рубль, RUB</span>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="sorting">
                                <ul class="item_sorting">
                                    <li>
                                        <span class="sorting_text">Сортировать по</span>
                                        <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                        <ul>
                                            <li class="product_sorting_btn" data-order='default'>
                                                <span>По умолчанию</span>
                                            </li>
                                            <li class="product_sorting_btn" data-order='price-low-high'>
                                                <span>Цена: min-max</span>
                                            </li>
                                            <li class="product_sorting_btn" data-order='price-high-low'>
                                                <span>Цена: max-min</span>
                                            </li>
                                            <li class="product_sorting_btn" data-order='name-a-z'>
                                                <span>Имя: А-Я</span>
                                            </li>
                                            <li class="product_sorting_btn" data-order='name-z-a'>
                                                <span>Имя: Я-А</span>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col">
                    <div class="products_grid">
                        @include('partials.products')
                    </div>
                    <div class="pb-3 products_pagination">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="filtersModal" tabindex="-1" role="dialog" aria-labelledby="filtersModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <form method="GET"
                                action="{{ route('client.products.showProductsByCategory', $category['slug'] ?? '') }}">
                                <div class="row">
                                    <div class="col-md-6 col-lg-3">
                                        <div class="card mb-3">
                                            <div class="card-header">
                                                <h5>Бренд</h5>
                                            </div>
                                            <ul class="list-group list-group-flush">
                                                @foreach ($filters['manufacturer'] as $filter)
                                                    <li class="list-group-item">
                                                        <input id="{{ $filter }}" type="checkbox"
                                                            class="form-check-input me-2" name="manufacturer[]"
                                                            value="{{ $filter }}"
                                                            {{ in_array($filter, request('manufacturer', [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="{{ $filter }}">{{ $filter }}</label>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col text-right">
                                        <button class="btn btn-primary" type="submit">Применить</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Закрыть</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_js')
    <script>
        window.categoryUrl = "{{ route('client.products.showProductsByCategory', $category['slug'] ?? '') }}";
    </script>
    <script src="/js/sort.js"></script>
@endsection
