@extends('layouts.main')

@section('title', 'Product');

@section('custom_css');
    <link rel="stylesheet" type="text/css" href="/styles/product.css">
    <link rel="stylesheet" type="text/css" href="/styles/product_responsive.css">
@endsection

@section('custom_js')
    <script src="/js/product.js"></script>
@endsection

@section('content')
    <div class="product_details">
        <div class="container">
            <div class="row details_row">

                <div class="col-lg-6">
                    <div class="details_image">
                        <div class="details_image_large">
                            <img src={{ $product->link ? "$product->link" : '/images/no_image_icon.png' }} alt="">
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="details_content">
                        <div class="details_name">{{ $product->name }}</div>
                        <div class="details_brand">{{ $product->brand->name }}</div>
                        <div>
                            <span class="details_price" data-base-price="{{ $product->price }}">{{ $product->price }}
                            </span>
                            <span>BYN</span>
                        </div>
                        <div class="details_date">Дата выпуска: {{ $product->release_date }}</div>
                        <div class="details_text">
                            <p>{{ $product->description }}</p>
                        </div>
                        <div class="details_services">
                            <h4>Дополнительные услуги:</h4>
                            @foreach ($product->services as $service)
                                <div class="product_service">
                                    <input id="service_{{ $service->id }}" type="checkbox"
                                        class="regular_checkbox service_checkbox" data-price="{{ $service->price }}"
                                        @if ($service->name === 'Гарантийное обслуживание') checked disabled @endif>
                                    <label for="service_{{ $service->id }}"><img src="/images/check.png"
                                            alt=""></label>
                                    <span class="checkbox_title">{{ $service->name }}: {{ $service->price }} BYN</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="product_quantity_container">
                            <div class="product_quantity clearfix">
                                <span>Qty</span>
                                <input id="quantity_input" type="text" pattern="[0-9]*" value="1">
                                <div class="quantity_buttons">
                                    <div id="quantity_inc_button" class="quantity_inc quantity_control"><i
                                            class="fa fa-chevron-up" aria-hidden="true"></i></div>
                                    <div id="quantity_dec_button" class="quantity_dec quantity_control"><i
                                            class="fa fa-chevron-down" aria-hidden="true"></i></div>
                                </div>
                            </div>
                            <div class="button cart_button"><a href="#">Add to cart</a></div>
                        </div>

                        <div class="details_share">
                            <span>Share:</span>
                            <ul>
                                <li><a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row description_row">
                <div class="col">
                    <div class="description_title_container">
                        <div class="description_title">Description</div>
                        <div class="reviews_title"><a href="#">Reviews <span>(1)</span></a></div>
                    </div>
                    <div class="description_text">
                        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt
                            ut labore et dolore magna aliquyam erat, sed diam voluptua. Phasellus id nisi quis justo tempus
                            mollis sed et dui. In hac habitasse platea dictumst. Suspendisse ultrices mauris diam. Nullam
                            sed aliquet elit. Mauris consequat nisi ut mauris efficitur lacinia.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
