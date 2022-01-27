@extends('layouts.page')

@section('content')
    <!--
    Bootstrap docs: https://getbootstrap.com/docs
    -->

    <div class="container" x-data="page()">


        <select x-model="selectedOption" name="area_id" id="add_area" class="form-control form-select">
            <option value="" transfer_target="label">Selecione</option>
            <template x-for="color in colors" :key="color.id">
                <option :value="color.id" x-text="color.label"></option>
            </template>
        </select>
        <br>
        <button @click="access()" class="btn btn-sm btn-danger">
            Access Data
        </button>

        <label class="block">Output: "<span x-ref="output">bacon</span>"</label>
        <script type="text/javascript">
            function page() {
                return {
                    selectedOption: "",
                    colors: [{
                            id: 1,
                            label: 'Red'
                        },
                        {
                            id: 2,
                            label: 'Orange'
                        },
                        {
                            id: 3,
                            label: 'Yellow'
                        },
                    ],
                    access() {
                        this.$refs.output.innerText = this.selectedOption;
                    },
                };
            }
        </script>
    </div>

@endsection
