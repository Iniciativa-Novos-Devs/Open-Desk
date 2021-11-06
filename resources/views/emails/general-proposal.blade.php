@extends('layouts.email')


@section('content')

{!! $email_data['email_intro'] ?? '' !!}

<table role="presentation" border="0" cellpadding="0" cellspacing="0"
    >
    <tbody>
        <tr>
            <td align="left">
                <table role="presentation" border="0" cellpadding="0"
                    cellspacing="0">
                    <tbody>
                        <tr>
                            <td>
                                {!! $email_data['email_content'] ?? '' !!}
                            </td>
                        </tr>
                        @foreach ($email_data['call_to_actions'] as $link)
                        @if ($link['url'] ?? '')
                            <tr>
                                <td>
                                    <a href="{{ $link['url'] ?? '#' }}"
                                    class="btn btn-primary">
                                    {{ $link['text'] ?? $link['url'] ?? '' }}</a>
                                </td>
                            </tr>
                        @endif
                        @endforeach
                        <tr>
                            <td>
                                {!! $email_data['email_footer'] ?? '' !!}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
{{-- <p>This is a really simple email template. Its sole purpose is to get the
    recipient to click the button with no distractions.</p> --}}
@endsection
