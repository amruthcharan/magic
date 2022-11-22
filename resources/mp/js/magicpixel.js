window._mp.waitUntil(function() { return _mp && _mp.eedlInstance; }, 10000, 100, function () {
    _mp.eedlInstance().ready();
    var data = {
        "currency": Shopify.checkout.currency,
        "transaction_id": Shopify.checkout.order_id,
        "value": parseFloat(Shopify.checkout.total_price),
        "coupon": Shopify.checkout.discount_code ? Shopify.checkout.discount_code : "",
        "shipping": parseFloat(Shopify.checkout.shipping_rate.price),
        "tax": parseFloat(Shopify.checkout.total_tax),
        "items": [],
        "user.profile.em": Shopify.checkout.email,
    };
    Shopify.checkout.line_items.forEach(function(item, i) {
        var item = {
            index: i,
            item_name: item.title,
            item_id: [item.product_id, item.sku, item.variant_id][window.MP_ID_TYPE],
            item_brand: item.vendor,
            price: parseFloat(item.price),
            quantity: item.quantity
        };
        data.items.push(item);
    });

    var user_info = {
        pid: Shopify.checkout.customer_id
    };

    if (Shopify.checkout.email) {
        user_info.email = Shopify.checkout.email;
    }
    if (Shopify.checkout.phone) {
        user_info.phone = Shopify.checkout.phone;
    }
    if (Shopify.checkout.billing_address.first_name) {
        user_info.fName = Shopify.checkout.billing_address.first_name;
    }
    if (Shopify.checkout.billing_address.last_name) {
        user_info.lName = Shopify.checkout.billing_address.last_name;
    }
    if (Shopify.checkout.billing_address.city) {
        user_info.city = Shopify.checkout.billing_address.city;
    }
    if (Shopify.checkout.billing_address.country_code) {
        user_info.country = Shopify.checkout.billing_address.country_code;
    }
    if (Shopify.checkout.billing_address.zip) {
        user_info.zip = Shopify.checkout.billing_address.zip;
    }
    if (Shopify.checkout.billing_address.province) {
        user_info.state = Shopify.checkout.billing_address.province;
    }


    eedl('user_info', user_info);
    window._mp.safeExecute('evPageLoad', function() {
        
        var payload = {
            'page.pageInfo.pageName': document.title,
            'env.pageUrl': window.location.href,
            'env.referrer': document.referrer,
            'env.pathName': window.location.pathname,
            'env.rs': 'prd',
        };
        eedl('page_load', payload);
        })();
    window._mp.safeExecute('evPurchase', function() {
        eedl('purchase', data);
    })();
});