## TODO

## FrontStore

-   Order cancle (closed as not planed)
-   Order update? (closed as not planed)
-   order refund. (closed as not planed)

## Dashboard

-   Notifications (closed as not planed)
-   RBAC
-   user show page
-   product, order archive
-   stripe refund, cancle and order edit (closed as not planed)

---

# Pages

-   Home page
-   Collection page (single)
-   Collection page (index)
-   Search page
-   Cart page
-   Profile page
-   User orders history page

-   Login page
-   Register page
-   Forgot password page
-   Reset password page

---

-   Product management
-   Collection management (categories)
-   Order management
-   Shipping profile
-   User management
-   Invite staff users
-   Administration login and logout
-   Profile management

```
2024-08-02 13:49:53   --> charge.succeeded [evt_3PjGiJGsXqj4bnIi1lbXklX8]
2024-08-02 13:49:53   --> customer.created [evt_1PjGiKGsXqj4bnIiOY82liJK]
2024-08-02 13:49:53   --> customer.updated [evt_1PjGiLGsXqj4bnIiwZ6vD2w6]
2024-08-02 13:49:53   --> payment_intent.succeeded [evt_3PjGiJGsXqj4bnIi181BLYV9]
2024-08-02 13:49:53   --> payment_intent.created [evt_3PjGiJGsXqj4bnIi1Jpw7Mqc]
2024-08-02 13:49:54  <--  [200] POST http://localhost:8000/stripe/webhook [evt_3PjGiJGsXqj4bnIi1lbXklX8]
2024-08-02 13:49:54   --> checkout.session.completed [evt_1PjGiMGsXqj4bnIiSHleULxk]
2024-08-02 13:49:54  <--  [200] POST http://localhost:8000/stripe/webhook [evt_1PjGiKGsXqj4bnIiOY82liJK]
2024-08-02 13:49:55   --> invoice.created [evt_1PjGiMGsXqj4bnIifhWoqDAI]
2024-08-02 13:49:55   --> invoice.finalized [evt_1PjGiMGsXqj4bnIiOaOgGA6g]
2024-08-02 13:49:55   --> charge.updated [evt_3PjGiJGsXqj4bnIi1orhNqsc]
2024-08-02 13:49:55   --> charge.updated [evt_3PjGiJGsXqj4bnIi1yjxwAmb]
2024-08-02 13:49:55  <--  [200] POST http://localhost:8000/stripe/webhook [evt_1PjGiLGsXqj4bnIiwZ6vD2w6]
2024-08-02 13:49:55   --> invoice.sent [evt_1PjGiNGsXqj4bnIicPsCJphv]
2024-08-02 13:49:55   --> invoice.paid [evt_1PjGiNGsXqj4bnIii50u1nt0]
2024-08-02 13:49:55   --> invoice.payment_succeeded [evt_1PjGiNGsXqj4bnIiXVBWKZU9]
```

```
[2024-08-02 08:19:57] local.INFO: Stripe\Checkout\Session JSON: {
    "id": "cs_test_b12hyD9uAskfFdA5gfLCAfPnppAyok4q8ieFMVVioZM7WxoF2vxmDHAh1i",
    "object": "checkout.session",
    "after_expiration": null,
    "allow_promotion_codes": null,
    "amount_subtotal": 850000,
    "amount_total": 920000,
    "automatic_tax": {
        "enabled": false,
        "liability": null,
        "status": null
    },
    "billing_address_collection": null,
    "cancel_url": "http:\/\/localhost:8000\/checkout\/cancel?session_id={CHECKOUT_SESSION_ID}",
    "client_reference_id": null,
    "client_secret": null,
    "consent": null,
    "consent_collection": null,
    "created": 1722586717,
    "currency": "lkr",
    "currency_conversion": null,
    "custom_fields": [],
    "custom_text": {
        "after_submit": null,
        "shipping_address": null,
        "submit": null,
        "terms_of_service_acceptance": null
    },
    "customer": "cus_QaRbLt6NazLlwW",
    "customer_creation": "if_required",
    "customer_details": {
        "address": {
            "city": "city",
            "country": "LK",
            "line1": "Address line 1",
            "line2": "Address line 2",
            "postal_code": "00150",
            "state": null
        },
        "email": "janedoe@ex.com",
        "name": "Jane Doe",
        "phone": null,
        "tax_exempt": "none",
        "tax_ids": []
    },
    "customer_email": "janedoe@ex.com",
    "expires_at": 1722673117,
    "invoice": "in_1PjGiLGsXqj4bnIiFwsqnnto",
    "invoice_creation": {
        "enabled": true,
        "invoice_data": {
            "account_tax_ids": null,
            "custom_fields": null,
            "description": null,
            "footer": null,
            "issuer": {
                "type": "self"
            },
            "metadata": [],
            "rendering_options": null
        }
    },
    "livemode": false,
    "locale": null,
    "metadata": [],
    "mode": "payment",
    "payment_intent": "pi_3PjGiJGsXqj4bnIi1w2ehVE8",
    "payment_link": null,
    "payment_method_collection": "if_required",
    "payment_method_configuration_details": null,
    "payment_method_options": {
        "card": {
            "request_three_d_secure": "automatic"
        }
    },
    "payment_method_types": [
        "card"
    ],
    "payment_status": "paid",
    "phone_number_collection": {
        "enabled": false
    },
    "recovered_from": null,
    "saved_payment_method_options": {
        "allow_redisplay_filters": [
            "always"
        ],
        "payment_method_remove": null,
        "payment_method_save": null
    },
    "setup_intent": null,
    "shipping_address_collection": {
        "allowed_countries": [
            "LK"
        ]
    },
    "shipping_cost": {
        "amount_subtotal": 70000,
        "amount_tax": 0,
        "amount_total": 70000,
        "shipping_rate": "shr_1PjGh7GsXqj4bnIiv0Z9h4Z7"
    },
    "shipping_details": {
        "address": {
            "city": "city",
            "country": "LK",
            "line1": "Address line 1",
            "line2": "Address line 2",
            "postal_code": "00150",
            "state": null
        },
        "name": "Jane Doe"
    },
    "shipping_options": [
        {
            "shipping_amount": 0,
            "shipping_rate": "shr_1PjGh7GsXqj4bnIigNuD7LCs"
        },
        {
            "shipping_amount": 70000,
            "shipping_rate": "shr_1PjGh7GsXqj4bnIiv0Z9h4Z7"
        },
        {
            "shipping_amount": 40000,
            "shipping_rate": "shr_1PjGh7GsXqj4bnIirBK7iCy2"
        }
    ],
    "status": "complete",
    "submit_type": null,
    "subscription": null,
    "success_url": "http:\/\/localhost:8000\/checkout\/success?session_id={CHECKOUT_SESSION_ID}",
    "total_details": {
        "amount_discount": 0,
        "amount_shipping": 70000,
        "amount_tax": 0
    },
    "ui_mode": "hosted",
    "url": null
}
```
