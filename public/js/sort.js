$(document).ready(function () {

    $('.product_sorting_btn').click(function () {
        let orderBy = $(this).data('order');
        $('.sorting_text').text($(this).find('span').text());
        let queryParams = new URLSearchParams(window.location.search);
        let queryObject = Object.fromEntries(queryParams.entries());
        $.ajax({
            type: "GET",
            url: window.categoryUrl,
            data: {
                ...queryObject,
                orderBy: orderBy,
            },
            success: function (response) {
                let currentUrl = new URL(window.location.href);
                currentUrl.searchParams.set('orderBy', orderBy);
                history.pushState({}, '', currentUrl);

                $('.pagination a').each(function () {
                    let link = $(this).attr('href');
                    let url = new URL(link);
                    url.searchParams.set('orderBy', orderBy);
                    $(this).attr('href', url.toString());
                })


                $('.products_grid').html(response);
                $('.products_grid').isotope('destroy');
                $('.products_grid').imagesLoaded(function () {
                    $('.products_grid').isotope({
                        itemSelector: '.product',
                        layoutMode: 'fitRows',
                        fitRows: {
                            gutter: 30
                        }
                    });
                });
            }
        });
    })
});