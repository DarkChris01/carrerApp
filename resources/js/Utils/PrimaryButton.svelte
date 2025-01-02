<script>
    export let disabled = false; 
    export let size="text-sm"
</script>

<button type="submit" {disabled} class="bg-blue-600 border rounded p-1 {size} px-3 text-white" on:click>
    <slot/>
</button>
