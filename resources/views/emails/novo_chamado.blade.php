@extends('layouts.email')


@section('content')
<p>Olá {{ $name }},</p>
<p>Seu chamado foi criado com sucesso.</p>
<table role="presentation" border="0" cellpadding="0" cellspacing="0"
    class="btn btn-primary">
    <tbody>
        <tr>
            <td align="left">
                <table role="presentation" border="0" cellpadding="0"
                    cellspacing="0">
                    <tbody>
                        <tr>
                            <td> <a href="{{ route('chamados_show', $chamado->id) }}"
                                    target="_blank">Veja seu chamado</a> </td>
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
