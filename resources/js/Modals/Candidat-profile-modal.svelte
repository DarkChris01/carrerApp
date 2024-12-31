<script>
    import { format_date_anglo_to_french } from "@dependencies/utilities";
    import { get_candadite_information } from "@dependencies/load";
    import Mission from "@components/Candidates/Mission.svelte";
    import CandidateAction from "@components/Candidates/Candidate-action.svelte";
    import LoadingSpinner from "@utils/Loading-spinner.svelte";
    import { onMount, onDestroy } from "svelte";
    export let candidat_id;
    let isloading = true;
    let candidat = {};

    onMount(async () => {
        const response = await get_candadite_information(candidat_id);
        if (response.status == 200) {
            candidat = await response.data;
            isloading = false;
            document.body.style.overflow = "hidden";
        }
    });

    onDestroy(() => {
        document.body.style.overflow = "";
    });
</script>

<!-- svelte-ignore a11y-click-events-have-key-events -->
<!-- svelte-ignore a11y-no-noninteractive-element-interactions -->

{#if !isloading}
    <main
        class="fixed top-0 left-0 z-10 flex justify-center h-screen items-center w-full bg-black/90"
        on:click|self
    >
        <div class="md:w-3/4 lg:w-1/2 bg-white lg:rounded px-1 lg:px-3">
            <div class="w-full overflow-y-auto scrollable my-6">
                <div
                    class="capitalizeh-screen md:h-[35rem] 2xl:h-[40rem] text-gray-700p-2 text-[15px] xl:text-sm p-1"
                >
                    <div class="block md:hidden px-1">
                        <button on:click>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="size-6"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6 18 18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>

                    <div class="mb-4 border-b py-2">
                        <CandidateAction candidacy={candidat} />
                    </div>

                    <div class="grid grid-cols-3 items-center">
                        <div class="flex justify-center col-span-1">
                            <img
                                class="w-48 p-2"
                                src={candidat.picture ??
                                    "/storage/avatars/default/man.png"}
                                alt="avatar"
                            />
                        </div>
                        <div class="col-span-2 text-sm flex justify-center">
                            <div class="text-gray-600">
                                <div class="mt-1">
                                    {candidat.firstName}
                                    {candidat.lastName}
                                </div>
                                <div class="mt-1">
                                    {candidat.email}
                                </div>
                                <div class="mt-1">
                                    {candidat.phone}
                                </div>
                                <div class="mt-1">
                                    {candidat.country}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="my-8">
                        <h1 class="text-sm text-gray-400 my-1">Formations</h1>
                        <div
                            class="md:flex flex-wrap border-b text-gray-600 rounded"
                        >
                            {#each JSON.parse(candidat.formations) as formation}
                                {#if formation.school}
                                    <div class="my-1 p-1 mx-1 w-1/2 rounded">
                                        <div
                                            class="text-orange-600 text-nowrap"
                                        >
                                            {formation.school}
                                        </div>
                                        <div>
                                            Filiere : <p class="ms-2 inline">
                                                {formation.domain}
                                            </p>
                                        </div>
                                        <div class="flex justify-start">
                                            Niveau : <p class="ms-2 inline">
                                                {formation.degree}
                                            </p>
                                        </div>
                                    </div>
                                {/if}
                            {/each}
                        </div>
                    </div>
                    <div>
                        <h1 class="text-sm text-gray-400 my-1">Experiences</h1>
                        <div class="block border-b rounded">
                            {#each JSON.parse(candidat.experience) as experience}
                                {#if experience.enterprise}
                                    <div class=" my-3 p-1 mx-1 rounded">
                                        <div
                                            class="w-full lg:flex flex-nowrap justify-start"
                                        >
                                            <div>
                                                <div class="text-orange-600">
                                                    {experience.enterprise}
                                                </div>
                                                <div>
                                                    <div>
                                                        {experience.poste}
                                                    </div>

                                                    <div
                                                        class="font-light text-nowrap text-sm"
                                                    >
                                                        Du {format_date_anglo_to_french(
                                                            new Date(
                                                                experience.start,
                                                            ),
                                                        )} au {format_date_anglo_to_french(
                                                            new Date(
                                                                experience.end,
                                                            ),
                                                        )}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="w-full lg:mx-4">
                                                <Mission
                                                    text={experience.mission}
                                                />
                                            </div>
                                        </div>
                                    </div>
                                {/if}
                            {/each}
                        </div>
                    </div>

                    <!-- competences  -->
                    <div class="my-8">
                        <div class="text-sm my-2 text-gray-400">
                            Competences
                        </div>
                        <div class="flex justify-center flex-wrap">
                            {#each JSON.parse(candidat.technical_competences) as competence}
                                {#if competence}
                                    <div class="my-1">
                                        <span
                                            class="me-1 mt-1 text-nowrap bg-red-600 text-white p-1 rounded"
                                            >{competence}</span
                                        >
                                    </div>
                                {/if}
                            {/each}

                            {#each JSON.parse(candidat.no_technical_competences) as competence}
                                <div class="my-1">
                                    {#if competence}
                                        <span
                                            class="me-1 mt-1 text-nowrap bg-blue-600 text-white p-1 rounded"
                                            >{competence}</span
                                        >
                                    {/if}
                                </div>
                            {/each}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
{:else}
    <div class="fixed z-10 top-2 right-4 rounded p-1 flex">
        <LoadingSpinner background="bg-transparent" spinnerColor="border-black"/>
    </div>
{/if}
