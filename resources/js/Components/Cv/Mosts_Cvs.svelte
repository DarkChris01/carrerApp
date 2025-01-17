<script>
    import { onMount } from "svelte";
    import { inertia } from "@inertiajs/svelte";
    import Cvs from "@components/Cv/Cvs.svelte";
    import { get_mosts_cvs, rateCandidate } from "@dependencies/load";
    import Spinner from "@utils/Spinner.svelte";
    let candidates = [];
    let isLoading = true;
    let timeout = false;

    onMount(async () => {
        const response = await get_mosts_cvs();

        if (response.status === 200 && response.data) {
            if ((Array.isArray(response.data), response.data.length > 0)) {
                for (const candidate of response.data) {
                    const rate = await rateCandidate(`/rate/${candidate.id}`);
                    if (rate.status === 200 && rate.data) {
                        candidates = [
                            ...candidates,
                            { ...candidate, rate: rate.data },
                        ];
                    }
                }
            }
            isLoading = false;
        }
        if (response.code === "ECONNABORTED") {
            isLoading = false;
            timeout = true;
        }
        isLoading = false;
    });
</script>

<div class="relative rounded my-1 p-1">
    <div class="p-2 rounded">
        <div class="p-1 rounded">
            {#if !isLoading}
                {#if !timeout}
                    <div class="mb-6 text-gray-800">
                        <h1
                            class=" px-1 lg:text-[14px] font-bold flex items-center"
                        >
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
                                    d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"
                                />
                            </svg>
                            Meilleurs profils
                        </h1>
                        <p class="px-2 text-[14px] text-gray-400 mt-1">
                            Plus un candidat a d'étoiles plus il repond aux
                            differents besoins de votre entreprise. La note
                            maximale est 10
                        </p>
                    </div>

                    {#if Array.isArray(candidates) && candidates.length > 0}
                        {#each candidates as candidate}
                            <a
                                href="/employer/curicculum-vitae/{candidate.id}"
                                use:inertia
                                class="cursor-pointer flex items-center flex-wrap justify-start rounded text-sm bg-gray-50 hover:bg-gray-100 transition duration-50 ease-linear w-auto my-2 p-1 border"
                            >
                                <div
                                    class=" flex items-center me-6 mb-1 text-xs uppercase text-nowrap"
                                >
                                    <img
                                        class="w-8 h-8 rounded-full me-2"
                                        src={candidate.picture}
                                        alt="img"
                                    />
                                    {candidate.firstName}
                                    {candidate.lastName}
                                </div>
                                <div
                                    class="flex justify-between w-full items-center flex-wrap"
                                >
                                    <div
                                        class="bg-indigo-600 text-white text-xs me-1 p-1 capitalize rounded"
                                    >
                                        {candidate.profession}
                                    </div>
                                    <div class="flex items-center">
                                        <div class="flex items-center">
                                            {#each Array(candidate.rate).fill() as _}
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke-width="1.5"
                                                    stroke="currentColor"
                                                    class="size-3 fill-orange-500 stroke-none"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"
                                                    />
                                                </svg>
                                            {/each}

                                            <span
                                                class="bg-gray-800 py-0.5 px-2 text-xs text-gray-50 rounded ms-2"
                                                >{candidate.rate > 1
                                                    ? candidate.rate +
                                                      "/10 points"
                                                    : candidate.rate +
                                                      "/10 point"}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        {/each}
                    {:else}
                        <div
                            class="w-full flex justify-center items-center text-center h-24 lg:text-sm text-gray-300/70"
                        >
                            Aucun candidat trouvé
                        </div>
                    {/if}
                {:else}
                    <div
                        class="w-full flex justify-center items-center h-24 lg:text-xl text-gray-400"
                    >
                        Probleme de reseau
                    </div>
                {/if}
            {:else}
                <div
                    class="h-24 flex justify-center items-center text-gray-300"
                >
                    <Spinner />
                </div>
            {/if}
        </div>
    </div>
</div>
