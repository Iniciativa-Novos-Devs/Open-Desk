<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Áreas</title>
</head>
<body>
    @include('cabecalho');
    @include('navbaradm');

    <select class="form-select" aria-label="Default select example">
        <option selected>Area</option>
        <option value="1">One</option>
        <option value="2">Two</option>
        <option value="3">Three</option>
      </select>


      <label >  Atividades Área </label>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Atividade </th>
            <th scope="col">Data Cadastro </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">1</th>
            <td>Contratos</td>
            <td>11/01/2021</td>
          </tr>
          <tr>
            <th scope="row">2</th>
            <td>Utilidade Pública</td>
            <td>15/01/2021</td>
          </tr>

        </tbody>
      </table>


      <label >  Problemas da Atividades da  Área </label>
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




</body>
</html>
