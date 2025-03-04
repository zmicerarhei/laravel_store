@foreach ($products as $product)
    <div class="product">
        <div class="product_image">
            <img src={{ $product->link ?? '/images/no_image_icon.png' }} alt="">
        </div>
        <div class="product_content">
            <div class="product_title">
                <a
                    href={{ route('client.products.showProduct', ['category' => $product->category->slug, 'product' => $product->id]) }}>
                    {{ $product->name }}
                </a>
            </div>
            <div class="product_brand">{{ $product->brand->name }}</div>
            <div class="product_price" data-base-price="{{ $product->price }}">
                {{ $product->converted_price }} {{ session('currency_iso') }}
            </div>
        </div>
    </div>
@endforeach
