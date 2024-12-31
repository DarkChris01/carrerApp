<script>
    export let disabled = false; 
</script>

<button type="submit" {disabled} class="bg-blue-600 border rounded p-1 text-sm px-3 text-white" on:click>
    <slot/>
</button>
