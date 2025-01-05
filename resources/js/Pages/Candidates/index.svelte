<script>
    import { inertia } from "@inertiajs/svelte";
    import Filter from "@utils/Filter.svelte";
    import Candidacy from "@components/Candidates/Candidacy.svelte";
    import CandidaciesFilter from "@components/Candidates/CandidaciesFilter.svelte";
    import { jobs_store } from "@dependencies/Stores/Store";
    import { page } from "@inertiajs/svelte";
    import { candidaciesFilterComponent } from "@dependencies/Stores/Modal";
    export let jobs;
    let search;

    $:if ($page.props) {
        jobs_store.set(jobs);
        candidaciesFilterComponent.set(false);
    }
</script>

<main class="flex justify-center">
    <div class="p-0.5 mb-1 w-full my-1 2xl:w-3/4">
        <div class="my-1 lg:p-4 min-h-[32rem] me-1 bg-white border">
            <div class="p-1">
                <div class="flex justify-start text-sm">
                    {#if search}
                        <div
                            class="flex justify-between items-center text-sm lowercase px-2 my-1 rounded bg-red-600 text-white p-1 min-w-16"
                        >
                            {search}

                            <button>
                                <a
                                    use:inertia={{
                                        preserveScroll: true,
                                    }}
                                    href="/candidatures"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="size-4"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M6 18 18 6M6 6l12 12"
                                        />
                                    </svg>
                                </a>
                            </button>
                        </div>
                    {/if}
                </div>

                <CandidaciesFilter {jobs} />
                <div>
                    <div class="mt-8 text-sm">
                        {#if $jobs_store.length > 0}
                            <table class="w-full">
                                <tr>
                                    <th>#</th>
                                    <th>user</th>
                                    <th>poste</th>
                                    <th>expire</th>
                                    <th>status</th>
                                    <th>action</th>
                                </tr>
                                {#each $jobs_store as job}
                                    {#each job.candidacies as candidacy, index}
                                        <Candidacy {candidacy} {job} />
                                    {/each}
                                {/each}
                            </table>
                        {:else}
                            <div
                                class="min-h-[24rem] text-gray-300 font-semibold flex items-center justify-center"
                            >
                                Aucune candidature
                            </div>
                        {/if}
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
