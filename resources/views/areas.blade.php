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

    <select class="form-select" aria-label="Default select example" id='seletor_area' onchange="verAtividade()">
        <option value =''> selecione a Area</option>
         @foreach ( $areas as $area )
            <option value="{{ $area->id }}" {{ $area_atual && $area_atual == $area->id ? "selected" : "" }}>{{ $area->sigla }}</option>
         @endforeach


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
          @foreach ($atividades as $atividade )
          <tr>
            <td scope="row">{{ $atividade->id }}</td>
            <td>{{ $atividade->nome }}</td>
            <td>{{ $atividade->created_at }}</td>
          </tr>

          @endforeach

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


 <script>
    function isNumber(n) { return !isNaN(parseFloat(n)) && !isNaN(n - 0); }


     function verAtividade (){
         var area = document.getElementById('seletor_area');
         if (area && area.value && isNumber(area.value)){
             var area_id = area.value;
             window.location.href="{{ route ('areas') }}" + "?area=" + area_id
         }


     }

 </script>

</body>
</html>
