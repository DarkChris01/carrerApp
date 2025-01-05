<script>
    import Spinner from "@utils/Spinner.svelte";
    import { inertia } from "@inertiajs/svelte";
    import { page } from "@inertiajs/svelte";
    import { onMount } from "svelte";
    import { format_date_anglo_to_french } from "@dependencies/utilities";
    import Experience from "@components/Cv/Experience.svelte";
    import Competence from "@components/Cv/Competence.svelte";
    import NotificationForm from "@components/Notifications/Notification-form.svelte";
    export let cv;
    let show = false;

    const toogleNotification = () => {
        show = true;
    };
</script>

{#if show}
    <NotificationForm {cv} on:click={() => (show = false)} />
{/if}

<main class="p-1 text-sm 2xl:p-2">
    <div class="p-1 lg:p-1 w-full mx-auto">
        <div
            class="md:mb-2 text-gray-700 w-full font-light cursor-pointer mx-auto"
        >
            <div class="font-light flex items-center justify-end">
                <div class="p-2">
                    <div>
                        <button
                            on:click={toogleNotification}
                            class="lg:border items-center hover:ring-1 flex p-1 rounded border-gray-300/20 hover:shadow hover:text-gray-600 hover:bg-gray-50"
                        >
                            <span class="hidden lg:block me-1">
                                Laissez un message</span
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
                                    d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
                {#if cv.cv}
                    <div class="p-2">
                        <div>
                            <a
                                href="/download/{cv.id}"
                                class="lg:border flex items-center hover:ring-1 p-1 rounded border-gray-300/20 hover:shadow hover:text-gray-600 hover:bg-gray-50"
                            >
                                <span class="hidden lg:block me-1">
                                    Telecharger Cv
                                </span>
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
                                        d="M9 3.75H6.912a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H15M2.25 13.5h3.86a2.25 2.25 0 0 1 2.012 1.244l.256.512a2.25 2.25 0 0 0 2.013 1.244h3.218a2.25 2.25 0 0 0 2.013-1.244l.256-.512a2.25 2.25 0 0 1 2.013-1.244h3.859M12 3v8.25m0 0-3-3m3 3 3-3"
                                    />
                                </svg>
                            </a>
                        </div>
                    </div>
                {/if}

                <div class="p-2">
                    <div>
                        <button
                            class="text-sm px-1 bg-red-600 hover:ring-1 ring-red-600 text-white rounded p-0.5 hover:bg-red-500 hover:shadow"
                        >
                            Signaler
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex w-full">
                <div
                    class="text-sm transition border duration-300 w-1/4 ease-in-out rounded bg-white py-2 p-4"
                >
                    <div class="w-full flex justify-center items-start my-2">
                        <img
                            src={cv.picture}
                            class="w-24 h-24 rounded-full"
                            alt="photo_de_cv"
                        />
                    </div>
                    <div>
                        <div
                            class="text-nowrap uppercase text-center font-semibold px-1"
                        >
                            {cv.firstName}
                        </div>
                        <div class="text-center text-gray-600/70 capitalize">
                            <h1>
                                {cv.profession}
                            </h1>
                        </div>
                    </div>
                    <div class="my-10">
                        <div
                            class="text-start text-sm font-semibold text-gray-200 border-b mb-6"
                        >
                            Competences
                        </div>
                        <div>
                            <div>
                                {#if cv.competence}
                                    <Competence competence={cv.competence} />
                                {:else}
                                    <div
                                        class="flex justify-center w-full items-center h-[10rem] text-gray-400"
                                    >
                                        Aucune donnée enregistrée
                                    </div>
                                {/if}
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="transition duration-300 ease-in-out p-8 text-sm w-full bg-white rounded border mx-1"
                >
                    <div class="my-1 transition duration-300 ease-in-out p-2">
                        <div
                            class=" text-sm lg:text-xl font-bold rounded text-gray-200"
                        >
                            Experiences
                        </div>

                        <div class="my-1">
                            <div>
                                {#if cv.experience}
                                    {#each JSON.parse(cv.experience.experience) as experience}
                                        <div>
                                            {#if experience.enterprise}
                                                <Experience {experience} />
                                            {/if}
                                        </div>
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
                        </div>
                    </div>
                    <div class="p-2 my-6">
                        <div
                            class=" text-sm border-b lg:text-xl font-bold rounded text-gray-300"
                        >
                            Formations
                        </div>
                        <div class="mt-4">
                            <div>
                                {#if cv.formation}
                                    {#each JSON.parse(cv.formation.formations) as formation}
                                        {#if formation.school}
                                            <div class="my-4 text-base text-gray-600">
                                                <div
                                                    class="my-1 flex justify-between"
                                                >
                                                    <div
                                                        class="capitalize font-bold"
                                                    >
                                                        {formation.school}
                                                    </div>

                                                    <div
                                                        class=" capitalize font-bold text-orange-600"
                                                    >
                                                        {formation.domain}
                                                    </div>
                                                </div>
                                                <div class="my-1 flex">
                                                    <div class="">
                                                        {formation.degree}
                                                        {"(" +
                                                            new Date(
                                                                formation.date,
                                                            ).getFullYear() +
                                                            ")"}
                                                    </div>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
