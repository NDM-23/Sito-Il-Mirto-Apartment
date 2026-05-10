<x-mail::message>
# {{ __('mirto.newsletter.confirm_title') }}

{{ __('mirto.newsletter.confirm_body') }}

<x-mail::button :url="$confirmUrl">
{{ __('mirto.newsletter.confirm_button') }}
</x-mail::button>

{{ __('mirto.newsletter.confirm_footer') }}

</x-mail::message>
