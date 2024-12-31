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
                                            class="w-full text-standard text-gray-600"
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
                                <div class="flex text-gray-400 h-[24rem] font-semibold items-center justify-center">
                                    Aucune candidature recente
                                </div>
                            {/if}
                        </div>

                        <!-- <div
                            class="my-1 p-1 md:p-4 bg-white border border-gray-400/80 rounded"
                        >
                            <div>
                                <div
                                    class=" font-semibold text-gray-800 text-sm px-1 flex items-end"
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
                                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"
                                        />
                                    </svg>

                                    <span class="mx-1"> Cvs </span>
                                </div>
                                <div class="p-1 border-gray-400/80 rounded">
                                    <table
                                        class="w-full font-light text-sm px-2 rounded text-gray-600"
                                    >
                                        <tr class="font-semibold text-gray-700">
                                            <td></td>
                                            <td>Nom</td>
                                            <td>Email</td>
                                            <td>Specialité</td>
                                            <td>Action</td>
                                        </tr>
                                        {#each cvs as cv, i}
                                            <Cvs {cv} {i} />
                                        {:else}
                                             empty list 
                                        {/each} 
                                    </table> 
                                </div> 
                            </div> 
                        </div>  
                         <div
                            class="p-1 md:p-4 bg-white border mt-1 border-gray-400/80 rounded"
                        >
                            <h1
                                class="font-semibold text-gray-800 text-sm px-1 flex items-end"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="size-5 me-1 stroke-1"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z"
                                    />
                                </svg>

                                <span class="mx-1">Offres d'emploi </span>
                            </h1>
                            <div class="p-1 border-gray-400/80 rounded">
                                <table
                                    class="w-full font-light text-sm px-2 rounded text-gray-600"
                                >
                                    <tr class="font-semibold text-gray-700">
                                        <td></td>
                                        <td>Enterprise</td>
                                        <td>Poste</td>
                                        <td>Effectif</td>
                                        <td>Pays</td>
                                        <td>Date limite</td>
                                        <td>Action</td>
                                    </tr>
                                    {#each jobs as job, i}
                                        <Jobs {job} {i} />
                                    {:else}
                                        <div
                                            class="h-10 flex items-center justify-center"
                                        >
                                            Vous n'avez aucune offre en cours de
                                            traitement
                                        </div>
                                    {/each}
                                </table>
                            </div>
                        </div> -->
                    </div>
                    <!-- <div
                        class="my-8 md:my-0 bg-white border border-gray-400/80 sticky top-0 h-screen p-4"
                    >
                        <h1 class="p-2 text-gray-800/80 text-sm mt-2 flex">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="size-5 mx-1"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"
                                />
                            </svg>

                            <span class="mx-1"> Candidatures</span>
                        </h1>
                        <div
                            class="h-96 overflow-y-auto scrollable-light p-1 rounded"
                        >
                            {#if !isLoading}
                                <ul>
                                    {#each candidats as candidat}
                                        <tr>
                                            <td>{candidat}</td>
                                        </tr>
                                    {:else}
                                        <div
                                            class="text-gray-300 flex justify-center items-center h-full"
                                        >
                                            No users found
                                        </div>
                                    {/each}
                                </ul>
                            {:else}
                                <div
                                    class="text-gray-200 flex justify-center items-center h-full"
                                >
                                    <Spinner />
                                </div>
                            {/if}
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
