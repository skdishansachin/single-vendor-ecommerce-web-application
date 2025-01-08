<x-mail::message>
Hello **{{ $order->user->name }}**,

Thank you for shopping with us!

We’re pleased to confirm that your order **{{ $order->formattedId }}** has been successfully placed. Here are the details of your order:

**Order Summary:**

<x-mail::table>
| Product Name          | Quantity                        | Price                                                           |
| :-------------------- | :------------------------------ | --------------------------------------------------------------: |
@foreach($order->cart->products as $product)
| {{ $product->name }}  | {{ $product->pivot->quantity }} | {{ Number::currency($product->pivot->purchase_price, 'LKR') }}  |
@endforeach
</x-mail::table>

**Shipping Address:**

{{ $order->line1 }}

{{ $order->line2 }}

{{ $order->city }} - {{ $order->postal_code }}

You will receive another email once your order has been shipped.

If you have any questions or need assistance, feel free to reply to this email or contact our customer support team at support@groke.com.

Thank you for choosing Groke. We look forward to serving you again!

Best regards,
Groke.
</x-mail::message>