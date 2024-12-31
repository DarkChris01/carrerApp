<script>
    import Entretien from "@components/Employer/Entretien.svelte";
    import { entretiens_store } from "@dependencies/Stores/Store";
    import axios from "axios";
    export let entretiens;
    entretiens_store.set(entretiens);

    const delete_all = async () => {
        const request = await axios.delete("/mes-entretiens");
        if (request.status === 200) {
            entretiens_store.set([]);
        }
    };
</script>

<main class="flex justify-center p-2 my-10">
    <div class="w-full bg-white text-sm p-4 min-h-[33rem]">
        <h1 class="flex items-center">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="size-4 me-1"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M6.75 2.994v2.25m10.5-2.25v2.25m-14.252 13.5V7.491a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v11.251m-18 0a2.25 2.25 0 0 0 2.25 2.25h13.5a2.25 2.25 0 0 0 2.25-2.25m-18 0v-7.5a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v7.5m-6.75-6h2.25m-9 2.25h4.5m.002-2.25h.005v.006H12v-.006Zm-.001 4.5h.006v.006h-.006v-.005Zm-2.25.001h.005v.006H9.75v-.006Zm-2.25 0h.005v.005h-.006v-.005Zm6.75-2.247h.005v.005h-.005v-.005Zm0 2.247h.006v.006h-.006v-.006Zm2.25-2.248h.006V15H16.5v-.005Z"
                />
            </svg>

            Mes entretiens
        </h1>
       
        {#if $entretiens_store.find((entretien) => entretien.status === "pending")}
            <div class="flex justify-end mb-2">
                <button
                    on:click={delete_all}
                    class="p-1 ms-3 flex text-sm items-center bg-red-600 text-white rounded hover:bg-red-500 shadow hover:shadow-gray-200/80 shadow-400/80"
                    >Tout supprimer <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="size-4 ms-2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                        />
                    </svg>
                </button>
            </div>
        {/if}
        {#if $entretiens_store.length > 0}
            <table class="w-full text-sm min-h-24 cursor-pointer p-2">
                <tr>
                    <th>#</th>
                    <th>candidat</th>
                    <th>identifiant emploi</th>
                    <th>date</th>
                    <th>heure</th>
                    <th>status</th>
                    <th>actions</th>
                </tr>
                {#each $entretiens_store as entretien, i}
                    <Entretien {entretien} {i} />
                {/each}
            </table>
        {:else}
            <div
                class="flex h-96 w-full justify-center items-center text-gray-600/70 text-xl"
            >
                Aucun entretien prevu
            </div>
        {/if}
    </div>
</main>

