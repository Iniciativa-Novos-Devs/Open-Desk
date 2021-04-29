@extends('layouts.page')

@section('content')

    @livewire('atividades-index')

    <div class="d-none">
        <label> Problemas da Atividades da Área </label>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Problema </th>
                    <th scope="col">Data Cadastro </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">2</th>
                    <td>NF - Valor Errado</td>
                    <td>11/01/2021</td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>NF - data Errada</td>
                    <td>15/01/2021</td>
                </tr>

                <tr>
                    <th scope="row">3</th>
                    <td>UP - valor errado</td>
                    <td>17/01/2021</td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>UP - data Errada</td>
                    <td>17/01/2021</td>
                </tr>

            </tbody>
        </table>
    </div>
@endsection
