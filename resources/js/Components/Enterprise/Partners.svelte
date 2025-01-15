<script>
    import { load_domains } from "@dependencies/load";
    import Spinner from "@utils/Spinner.svelte";
    import { onMount } from "svelte";
    import {inertia}  from "@inertiajs/svelte"
    export let enterprises;
    let domains = [];
    let isLoading = true;

    onMount(async () => {
        const response = await load_domains();
        if (response.status === 200) {
            domains = response.data;

            isLoading = false;
        }
    });
</script>

<header class="bg-blue-600 text-white py-6">
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold text-center">
            Nos entreprises partenaires
        </h1>
        <p class="text-center mt-2">
            Découvrez nos entreprises partenaires et leurs opportunités uniques.
        </p>
    </div>
</header>

{#if !isLoading}
    <main class="container mx-auto px-4 py-8">
        <div
            class="flex items-start justify-start gap-6 overflow-x-auto scrollable"
        >
            <!-- Carte entreprise -->
            {#each enterprises as enterprise}
                <div
                    class="bg-white rounded-lg w-1/4 shadow-lg overflow-hidden"
                >
                    <img
                        src={enterprise.logo}
                        alt="Logo entreprise"
                        class="w-full h-32 object-cover"
                    />
                    <div class="p-4">
                        <h3 class="font-bold text-lg text-blue-600">
                            {enterprise.name}
                        </h3>
                        <ul class="font-extrabold capitalize">
                            {#each JSON.parse(enterprise.sectors) as sector}
                                <li
                                    class="text-sm flex items-center text-gray-700 mt-2"
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
                                    {domains.find((domain) => {
                                        return domain.id === sector;
                                    }).intitules}
                                </li>
                            {/each}
                        </ul>
                        <div class="mt-4">
                            <a use:inertia
                                href="/enterprise/{enterprise.id}"
                                class="text-sm text-blue-600 font-semibold hover:underline"
                                >En savoir plus</a
                            >
                        </div>
                    </div>
                </div>
            {/each}
        </div>
    </main>
{:else}
    <div class="justify-center h-32 flex items-center">
        <Spinner />
    </div>
{/if}
