<x-mail::message>
# Reset password

Click on this link to reset the password

<x-mail::button :url="$url">
Reset Password
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
