<!--   parte 1  -->
 <select class="form-select" aria-label="Default select example" id='seletor_area' onchange="verAtividade()">
        <option value =''> selecione a Area</option>
         @foreach ( $areas as $area )
            <option value="{{ $area->id }}" {{ $area_atual && $area_atual == $area->id ? "selected" : "" }}>{{ $area->sigla }}</option>
         @endforeach
  </select>



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




