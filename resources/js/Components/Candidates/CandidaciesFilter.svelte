<script>
    import { router, inertia, page } from "@inertiajs/svelte";
    import { onMount } from "svelte";
    import Checkbox from "@utils/CheckBox.svelte";
    import Label from "@utils/Label.svelte";
    import { candidaciesFilterComponent } from "@dependencies/Stores/Modal";
    import LoadingSpinner from "@/Utils/Loading-spinner.svelte";
    import { get_job_posts } from "@dependencies/load";
    import axios from "axios";
    export let jobs;
    let postFilter = [];
    let activeFilter = [];
    let isLoading = true;

    onMount(async () => {
        const response = await get_job_posts();
        if (response.status == 200) {
            {
                for (const job of response.data) {
                    postFilter = [...postFilter, job.poste].sort((a, b) => {
                        return a.localeCompare(b);
                    });
                }
            }
            isLoading = false;
        }

        const params = new URLSearchParams(window.location.search);
        if (params) {
            params.forEach((value, _) => {
                activeFilter = [...activeFilter, value];
            });
        }
        postFilter = new Set(postFilter);
    });

    const checkJob = (event) => {
        
        const url = reformatURL(updateFilter(event));
        router.get(`?${url}`);
    };

    const updateFilter = (element) => {
        if (element.target.checked) {
            if (!activeFilter.some((data) => data == element.target.value)) {
                activeFilter = [...activeFilter, element.target.value];
            }
        } else {
            if (activeFilter.some((data) => data == element.target.value)) {
                activeFilter = activeFilter.filter(
                    (data) => data != element.target.value,
                );
            }
        }
        return activeFilter;
    };

    const reformatURL = (array) => {
        return array
            .map((value, index) => `poste[${index + 1}]=${value}`)
            .join("&");
    };

    const redirectTo = (url) => {
        activeFilter = [];
        router.get(url);
    };
</script>

<main>
    <div class="flex items-center">
        <button
            on:click={()=>redirectTo("?toutesmescandidatures")}
            class="btn btn-xs btn-primary rounded me-1 text-white"
            >Toutes
        </button>
        <button
            on:click={()=>redirectTo("?active")}
            class="btn btn-xs btn-primary rounded me-1 text-white"
        >
            En cours
        </button>

        <button
            on:click={()=>redirectTo("?expire")}
            class="btn btn-xs btn-primary rounded me-1 text-white"
            >Expirées</button
        >
        <button
            on:click={()=>redirectTo("?rejete")}
            class="btn btn-xs btn-primary rounded me-1 text-white"
            >Rejetées</button
        >

        <button
            on:click={()=>redirectTo("?accepte")}
            class="btn btn-xs btn-primary rounded me-1 text-white"
            >Valides</button
        >
        <div class="relative p-0 m-0 me-1">
            <button
                on:click|stopPropagation={() =>
                    candidaciesFilterComponent.set(
                        !$candidaciesFilterComponent,
                    )}
                class="btn btn-xs text-nowrap min-w-max btn-primary rounded text-white flex items-center"
            >
                Postes
                {#if isLoading}
                    <LoadingSpinner
                        height="h-3"
                        width="w-3"
                        background="bg-transparent"
                        margin="m-0"
                    />
                {:else}
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="ms-1 size-4 stroke-white"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m19.5 8.25-7.5 7.5-7.5-7.5"
                        />
                    </svg>
                {/if}
            </button>

            {#if $candidaciesFilterComponent}
                <div
                    class="text-start border rounded p-2 shadow text-standard absolute top-7 bg-white text-gray-600 min-w-max left-0"
                >
                    {#each postFilter as job}
                        <div
                            class="my-2 capitalize flex items-center hover:text-gray-400"
                        >
                            <Checkbox
                                value={job}
                                checked={activeFilter.some(
                                    (element) => element === job,
                                )}
                                on:change={(event) => checkJob(event)}
                            />
                            <Label style="ms-1" reason="job">{job}</Label>
                        </div>
                    {/each}
                </div>
            {/if}
        </div>
    </div>
</main>
