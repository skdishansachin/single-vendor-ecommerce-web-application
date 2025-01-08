<x-mail::message>
**Hello {{ $order->user->name }}**,

We are pleased to inform you that your order {{ $order->formattedId }} has been successfully fulfilled. Your items are now on their way to you!

**Order Summary:**

<x-mail::table>
| Product Name          | Quantity                        | Price                                                           |
| :-------------------- | :------------------------------ | --------------------------------------------------------------: |
@foreach($order->cart->products as $product)
| {{ $product->name }}  | {{ $product->pivot->quantity }} | {{ Number::currency($product->pivot->purchase_price, 'LKR') }}  |
@endforeach
</x-mail::table>

Thank you for shopping with us! If you have any questions or need assistance, feel free to reply to this email or contact our customer support team at support@groke.com.

Thank you for choosing Groke. We look forward to serving you again!

Best regards,
Groke.
</x-mail::message>