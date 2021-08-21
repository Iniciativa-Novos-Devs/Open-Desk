@extends('layouts.page')

@section('content')
    <!--
      Bootstrap docs: https://getbootstrap.com/docs
    -->

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <div class="container" x-data="page()">
    <p>
        <span x-cloak x-text="await getLabel()"></span>
    </p>
    <br>
    <select x-model="selectedOption" name="area_id" id="add_area" class="form-control form-select">
        <option value="" transfer_target="label">Selecione</option>
        <template x-cloak x-for="pessoa in (await getPessoas())" :key="pessoa.id">
            <option :value="pessoa.id" x-text="pessoa.nome"></option>
        </template>
    </select>
    <br>
    <button @click="access()" class="btn btn-sm btn-danger">
        Access Data
    </button>
    <label class="block">Output: "<span x-ref="output"></span>"</label>

        <script type="text/javascript">
        // ('alpine.api_text')
        // ('alpine.api_pessoas')
        //http://192.168.2.3:8000/alpine/api/text

        // async function getLabel()
        // {
        //     let response = await fetch("{{ route('alpine.api_text') }}")

        //     return await response.text()
        // }

        function page() {
        return {
            selectedOption: "",
            access() {
                this.$refs.output.innerText = this.selectedOption;
            },
            getLabel() {
                return (async function (){
                    let url = "{{ route('alpine.api_text') }}";
                    let response = await fetch(url);
                    return await response.json();
                })
            },
            getPessoas() {
                return (async function (){
                    let url = "{{ route('alpine.api_pessoas') }}";
                    let response = await fetch(url);
                    return await response.json();
                })
            },
        };
    }
</script>
    </div>

@endsection
