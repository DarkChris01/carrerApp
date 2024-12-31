<script>
    export let competence;    
</script>

{#if competence}
    {#each JSON.parse(competence.technical_competences) as competence}
        {#if competence}
            <div class="p-1 rounded m-1 text-nowrap capitalize font-bold text-gray-700/90">
                {competence}
            </div>
        {/if}
    {:else}
        <div
            class="flex justify-center w-full items-center h-[10rem] text-gray-400"
        >
            No data
        </div>
    {/each}

    {#each JSON.parse(competence.no_technical_competences) as competence}
        {#if competence}
            <div class="p-1 rounded m-1 capitalize font-light text-gray-600/80">
                {competence}
            </div>
        {/if}
    {:else}
        <div
            class="flex justify-center w-full items-center h-[10rem] text-gray-400"
        >
            No data
        </div>
    {/each}
{:else}
    <div
        class="flex justify-center w-full items-center h-[10rem] text-gray-400"
    >
        No data
    </div>
{/if}
