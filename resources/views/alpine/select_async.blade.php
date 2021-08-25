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

    <p>
        <button x-cloak @click="selectPessoas()" class="btn btn-sm btn-danger">
            Select Pessoas
        </button>
    </p>
    <div x-cloak>
        <label for="tipo1">
            <input type="radio" x-on:change="changedTipo()" x-model="tipo" name="tipo" value="tipo1" id="tipo1">
            tipo1
        </label><br>

        <label for="tipo2">
            <input type="radio" x-on:change="changedTipo()" x-model="tipo" name="tipo" value="tipo2" id="tipo2">
            tipo2
        </label><br>
        <label class="block">Output: "<span x-ref="output_tipo" x-text="tipo"></span>"</label>
    </div>
    <br>
    <template x-cloak x-if="select_pessoas">
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
    </template>

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
            inicial: 1,
            select_pessoas: false,
            tipo: "tipo1",
            selectedOption: "",
            selectPessoas(){
                this.select_pessoas = !this.select_pessoas;
                // this.inicial = this.inicial +1;
            },
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
                console.log("getPessoas", this.tipo);
                return (async function (){
                    let url = "{{ route('alpine.api_pessoas') }}/" + this.tipo;
                    let response = await fetch(url);
                    return await response.json();
                })
            },
            changedTipo(){
                console.log("changedTipo", this.tipo);
                this.select_pessoas = false;
                this.select_pessoas = true;
            },
        };
    }
</script>
    </div>

@endsection
