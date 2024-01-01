<x-mail::message>
# Email verification link

verify your email now

<x-mail::button :url="$url">
Verify
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
