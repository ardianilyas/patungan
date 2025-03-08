<x-mail::message>
# Withdrawal Notification

@if($withdraw['status'] === 'success' || $withdraw['status'] === 'SUCCEEDED')
Withdraw status successfully processed and should reflect on your account soon.
@elseif($withdraw['status'] === 'failed')
Withdraw status failed to be processed, try to contact our team for more information.
@else
Your withdrawal is currently pending. We’ll notify you once it’s processed.
@endif

Thanks,<br>
{{ config('app.name') }} team
</x-mail::message>
