<script>
    export let competence;
</script>

{#if competence}
    {#each JSON.parse(competence.technical_competences) as competence}
        {#if competence}
            <div
                class="p-1 flex items-center rounded text-base text-nowrap capitalize font-medium text-gray-600"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="size-4 me-1 stroke-2 stroke-green-600"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="m4.5 12.75 6 6 9-13.5"
                    />
                </svg>
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
            <div
                class="p-1 flex items-center rounded text-base capitalize font-light text-gray-600/80"
            >
            <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="size-4 me-1 stroke-2 stroke-green-600"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="m4.5 12.75 6 6 9-13.5"
            />
        </svg>
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
