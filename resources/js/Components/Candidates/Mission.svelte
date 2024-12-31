<script>
    export let text;
    let extend = false;
    const extendText = () => {
        extend = !extend;
    };
</script>

<button class="text-sm text-start p-1" on:click={extendText}>
    {#if extend}
        {text}
    {:else}
        {text.substr(0, 200)}...
    {/if}
</button>
