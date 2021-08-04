<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        // Script in component's blade file

        if(window.Livewire)
        {
            Livewire.on('confirm', e => {
                if (!confirm(e.message)) { return }
                @this[e.callback](...e.argv)
            });
        }
    });
</script>
