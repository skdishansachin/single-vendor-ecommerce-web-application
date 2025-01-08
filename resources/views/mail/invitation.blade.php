<x-mail::message>
# You are invited to Groke staff.

Click the below link to join to Groke.

You will redirected to a create a new account and that's all.

<x-mail::button :url="$signedUrl">
    Accept
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>