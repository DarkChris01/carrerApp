<script>
    import { page, inertia } from "@inertiajs/svelte";
    import Spinner from "@utils/Spinner.svelte";
    import Resume from "@components/Dashboard/Resume.svelte";
    import CandidatesTab from "@/Components/Candidates/Candidates-tab.svelte";
    import Jobs from "@components/Jobs/Jobs.svelte";
    import Cvs from "@components/Cv/Cvs.svelte";
    import axios from "axios";
    export let candidates;

    let candidats = [];
    let isLoading = true;
</script>

<div>
    <div>
        <div>
            <div>
                <div>
                    <div class=" md:col-span-3">
                        <div>
                            <Resume />
                        </div>

                        <div
                            class="bg-white border border-gray-400/80 min-h-[24rem] p-4"
                        >
                            {#if Array.isArray(candidates) & (candidates.length > 0)}
                                <h1
                                    class="p-2 flex items-end text-gray-800 font-bold text-sm mt-2"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="size-5 stroke-1 me-1"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"
                                        />
                                    </svg>
                                    Candidatures recentes
                                </h1>
                                <div class="p-1 rounded">
                                    <ul>
                                        <table
                                            class="w-full text-base text-gray-600"
                                        >
                                            <tr
                                                class="font-semibold text-gray-700"
                                            >
                                                <td></td>
                                                <td>candidat</td>
                                                <td>specialité</td>
                                                <td>poste convoité</td>
                                                <td>action</td>
                                            </tr>

                                            {#each candidates as candidat, i}
                                                <CandidatesTab {candidat} {i} />
                                            {/each}
                                        </table>
                                    </ul>
                                </div>
                            {:else}
                                <div
                                    class="flex text-gray-400 h-[24rem] font-semibold items-center justify-center"
                                >
                                    Aucune candidature recente
                                </div>
                            {/if}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
