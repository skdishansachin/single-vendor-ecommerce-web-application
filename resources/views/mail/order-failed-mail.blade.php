<x-mail::message>
Dear {{ $order->user->name }},

We regret to inform you that there was an issue with processing your recent order #{{ Str::take(Str::reverse($order->id), 5) }}.

Order Details:

@foreach($order->cart->products as $product)
- Product Name: {{ $product->name }}
- Quantity: {{ $product->pivot->quantity }}
- Price: {{ Number::currency($product->pivot->purchase_price, 'LKR') }}
@endforeach

Issue Description:
[Provide a brief explanation of the issue, e.g., payment failure, stock unavailability, etc.]

What You Can Do:

Review Your Payment Information: Check to ensure your payment details are correct and try placing the order again.
Check Product Availability: Confirm that the items you are trying to purchase are still in stock.
If you need assistance, please reply to this email or contact our customer support team at support@groke.com. We are here to help you resolve this issue as quickly as possible.

We apologize for any inconvenience this may have caused and appreciate your understanding. Thank you for your patience.

Best regards,
Groke.
</x-mail::message>