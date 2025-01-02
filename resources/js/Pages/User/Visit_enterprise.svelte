<script>
    import { inertia } from "@inertiajs/svelte";
    import Job from "@components/Jobs/Job.svelte";
    import PrimaryButton from "@utils/PrimaryButton.svelte";
    export let enterprise;
    const exemple = {
        description:
            "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam, ut tempore nulla consequuntur dicta autem ea eaque minus, quia id ab odio iure minima. Sint quas libero dolore doloremque vel.",
        story: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam, ut tempore nulla consequuntur dicta autem ea eaque minus, quia id ab odio iure minima. Sint quas libero dolore doloremque vel.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam, ut tempore nulla consequuntur dicta autem ea eaque minus, quia id ab odio iure minima. Sint quas libero dolore doloremque vel.",
    };
</script>

<main class="w-full justify-start items-start bg-white p-4">
    <div class="flex-shrink-0 relative bg-blue-600 rounded">
        <img
            class="p-1 w-full h-48"
            src={enterprise.logo}
            alt="enterprise-logo"
        />
        <div
            class="absolute font-semibold p-1 rounded bottom-2 right-2 bg-white"
        >
            <div class="capitalize text-xs flex items-end">
                {enterprise.address}
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="size-5 ms-1 stroke-red-600"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                    />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"
                    />
                </svg>
            </div>
        </div>
    </div>
    <div class="flex justify-start items-end mt-4">
        <div class="mb-1 me-1">
            <div class="ms-2">
                <a
                    class="hover:text-red-400 text-sm"
                    href="https://{enterprise.email}"
                    ><img
                        src="/storage/icones/gmail.png"
                        class="w-5"
                        alt=""
                    /></a
                >
            </div>

            {#if enterprise.facebook}
                <div class="flex mb-1 me-1">
                    <div class="ms-2">
                        <a
                            class="hover:text-red-400 text-sm"
                            href="https://{enterprise.facebook}"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="feather feather-facebook stroke-none fill-blue-500 w-6"
                                ><path
                                    d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"
                                ></path></svg
                            ></a
                        >
                    </div>
                </div>
            {/if}
            {#if enterprise.linkedin}
                <div class="flex mb-1 me-1">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="feather feather-linkedin bg-blue-500 w-6"
                        ><path
                            d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"
                        ></path><rect x="2" y="9" width="4" height="12"
                        ></rect><circle cx="4" cy="4" r="2"></circle></svg
                    >
                    <div class="ms-2 font-semibold text-sm">
                        {enterprise.linkedin}
                    </div>
                </div>
            {/if}
            {#if enterprise.twitter}
                <div class="flex mb-1 me-1">
                    <img src="/storage/icones/twitter.png" class="w-5" alt="" />
                </div>
            {/if}

            {#if enterprise.site}
                <div class="flex mb-1 me-1">
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
                            d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418"
                        />
                    </svg>
                    <div class="ms-2 font-semibold text-sm">
                        <a
                            class="hover:text-red-400 text-sm"
                            href={enterprise.site}>{enterprise.site}</a
                        >
                    </div>
                </div>
            {/if}
        </div>
    </div>

    <div class="text-sm p-2 my-8">
        <h1 class="font-semibold text-sm text-gray-500 border-b">
            Qui sommes-nous ?
        </h1>
        <div class="mt-4 text-gray-500">
            {exemple.description}
        </div>

        <h1 class="font-semibold text-sm text-gray-500 border-b mt-16">
            Quels services proposons nous ?
        </h1>
        <div class="my-5">
            <p class="my-2 text-gray-500">
                Nous offrons des solutions dans les domaines:
            </p>
            <ul>
                <li>
                    <div class="flex items-center capitalize">
                        <div
                            class="w-1.5 h-1.5 mx-2 bg-gray-400 rounded-full hidden md:block"
                        ></div>
                        {enterprise.sector.sector1}
                    </div>
                </li>
                <li>
                    <div class="flex items-center capitalize">
                        <div
                            class="w-1.5 h-1.5 mx-2 bg-gray-400 rounded-full hidden md:block"
                        ></div>
                        {enterprise.sector.sector2}
                    </div>
                </li>
                <li>
                    <div class="flex items-center capitalize">
                        <div
                            class="w-1.5 h-1.5 mx-2 bg-gray-400 rounded-full hidden md:block"
                        ></div>
                        {enterprise.sector.sector3}
                    </div>
                </li>
                <li>
                    <div class="flex items-center capitalize">
                        <div
                            class="w-1.5 h-1.5 mx-2 bg-gray-400 rounded-full hidden md:block"
                        ></div>
                        {enterprise.sector.sector4}
                    </div>
                </li>
            </ul>
        </div>
        <div>
            <h1 class="font-semibold text-sm text-gray-500 border-b mt-16">
                Quelques offres ouvertes
            </h1>
            <div class="mt-6">
                {#each enterprise.employer.jobs as job}
                    <div class="my-2 p-2 bg-gray-50 rounded border">
                        <div class="flex w-full justify-between items-center">
                            <div class="border-b capitalize">
                                {job.poste}
                            </div>
                            <a use:inertia href="/job/mon-offre/{job.id}">
                                <PrimaryButton size="text-xs"
                                    >Consulter l'offre</PrimaryButton
                                >
                            </a>
                        </div>
                        <div>
                            <div class="mt-1 flex items-center flex-wrap">
                                {#each JSON.parse(job.competence.competence) as competence}
                                    {#if competence}
                                        <span
                                            class="px-2 text-xs rounded bg-gray-700 text-white p-0.5 flex items-center w-fit me-2 my-1"
                                        >
                                            {competence}
                                        </span>
                                    {/if}
                                {/each}
                            </div>
                        </div>
                    </div>
                {/each}
            </div>
        </div>
    </div>
</main>
