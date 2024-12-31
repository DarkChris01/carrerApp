<script>
    import Spinner from "@utils/Spinner.svelte";
    import { inertia } from "@inertiajs/svelte";
    import { onMount } from "svelte";
    import { format_date_anglo_to_french } from "@dependencies/utilities";
    import Experience from "@components/Cv/Experience.svelte";
    import Competence from "@components/Cv/Competence.svelte";
    import Render from "@components/Cv/Render.svelte";
    export let cv;
    let loading = true;
</script>

<div class="md:mb-2 text-gray-700 w-full cursor-pointer">
        <div class="md:flex w-full">
        <div
            class="text-[15px] md:w-1/3 md:mx-1 xl:text-sm transition duration-300 ease-in-out md:rounded bg-white border p-2 md:p-2"
        >
            <div>
                <div class="flex justify-center rounded p-2">
                    <img
                        class="w-32 h-32 rounded-full"
                        src={cv.picture
                            ? cv.picture
                            : "/storage/avatars/default/man.png"}
                        alt="photo_de_cv"
                    />
                </div>
                <div class="font-bold">
                    <div
                        class="mb-1 text-nowrap text-sm uppercase text-center font-bold text-gray-800/80"
                    >
                        {cv.firstName}
                    </div>
                    <div
                        class="mb-1 text-nowrap text-center font-bold text-gray-500/80"
                    >
                        {cv?.profession}
                    </div>
                </div>
            </div>
            <div class="flex w-full px-2 justify-end">
                <a
                    use:inertia
                    href="/cv/personal-informations"
                    class=" p-1 text-gray-500 hover:text-gray-800 font-bold rounded text-sm"
                    ><svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="size-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"
                        />
                    </svg>
                </a>
            </div>

            <div class="my-2 mt-8 transition duration-300 ease-in-out p-">
                <div
                    class=" text-sm lg:text-xl font-bold border-b text-gray-500/50 border-b-gray-300"
                >
                    Competences
                </div>
                <div class="">
                    {#if cv.competence && cv}
                        <Competence competence={cv.competence} />
                    {:else}
                        <div
                            class="flex justify-center w-full items-center h-[10rem] text-gray-400"
                        >
                            Aucune donnée enregistrée
                        </div>
                    {/if}
                    <div class="flex w-full px-2 justify-end">
                        <a
                            use:inertia
                            href="/cv/competences"
                            class="p-1 text-gray-500 hover:text-gray-800 font-bold rounded text-sm"
                            ><svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="size-5"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"
                                />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white md:mx-1 p-2 lg:p-8 md:rounded w-full border">
            <div class="my-2 transition duration-300 ease-in-out p-2">
                <div class="text-sm lg:text-2xl font-semibold text-gray-500/40">
                    Experiences
                </div>

                <div class="my-2">
                    <div>
                        {#if cv.experience}
                            {#each JSON.parse(cv.experience.experience) as experience}
                                {#if experience.enterprise}
                                    <Experience {experience} />
                                {/if}
                            {:else}
                                <div
                                    class="flex justify-center w-full items-center h-[10rem] text-gray-400"
                                >
                                    Aucune donnée enregistrée
                                </div>
                            {/each}
                        {:else}
                            <div
                                class="flex justify-center w-full items-center h-[10rem] text-gray-400"
                            >
                                Aucune donnée enregistrée
                            </div>
                        {/if}
                    </div>
                    <div class="flex w-full px-2 justify-end">
                        <a
                            use:inertia
                            href="/cv/experiences"
                            class=" p-1 text-gray-500 hover:text-gray-800 font-bold rounded text-sm"
                            ><svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="size-5"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"
                                />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div
                class="my-2 transition duration-300 ease-in-out p-2 text-[15px] lg:text-sm"
            >
                <div
                    class="text-sm mb-6 lg:text-2xl font-semibold text-gray-500/40"
                >
                    Formations
                </div>
                <div class="text-sm">
                    <div>
                        {#if cv.formation}
                            <!-- content here -->
                            {#each JSON.parse(cv.formation.formations) as formation}
                                {#if formation.school}
                                    <div class="mb-2 my-4">
                                        <div
                                            class="my-1 md:flex justify-between"
                                        >
                                            <div
                                                class=" font-bold capitalize text-gray-700/70"
                                            >
                                                {formation.school}
                                            </div>

                                            <div
                                                class="capitalize text-orange-600 font-bold"
                                            >
                                                {formation.domain}
                                            </div>
                                        </div>
                                        <div class="my-1 flex text-gray-600/80">
                                            <p>
                                                {formation.degree}
                                                {"(" +
                                                    new Date(
                                                        formation.date,
                                                    ).getFullYear() +
                                                    ")"}
                                            </p>
                                        </div>
                                    </div>
                                {/if}
                            {:else}
                                <div
                                    class="flex justify-center items-center h-[10rem] text-gray-400"
                                >
                                    Aucune donnée enregistrée
                                </div>
                            {/each}
                        {:else}
                            <div
                                class="flex justify-center w-full items-center h-[10rem] text-gray-400"
                            >
                                Aucune donnée enregistrée
                            </div>
                        {/if}
                    </div>
                    <div class="flex px-2 justify-end">
                        <a
                            use:inertia
                            href="/cv/formations"
                            class=" h-fit p-1 text-gray-500 hover:text-gray-800 font-bold rounded text-sm"
                            ><svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="size-5"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"
                                />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
