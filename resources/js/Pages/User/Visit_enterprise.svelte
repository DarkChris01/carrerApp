<script>
    import { inertia, useForm } from "@inertiajs/svelte";
    import Job from "@components/Jobs/Job.svelte";
    import PrimaryButton from "@utils/PrimaryButton.svelte";
    export let enterprise;
    const exemple = {
        description:
            "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam, ut tempore nulla consequuntur dicta autem ea eaque minus, quia id ab odio iure minima. Sint quas libero dolore doloremque vel.",
        story: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam, ut tempore nulla consequuntur dicta autem ea eaque minus, quia id ab odio iure minima. Sint quas libero dolore doloremque vel.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam, ut tempore nulla consequuntur dicta autem ea eaque minus, quia id ab odio iure minima. Sint quas libero dolore doloremque vel.",
    };
    let form = useForm({
        message: null,
        subject: null,
        enterprise: enterprise.id,
    });

    const contactUs = () => {
        $form.post("/enterprise/contact-us", {
            onSuccess: () => {
                toast.success("message envoyé");
            },
            onError: () => {
                toast.error("une erreur est survenue !");
            },
        });
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
            <div class="capitalize text-sm flex items-end">
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

    <div class="text-base p-2 my-8">
        <h1 class="font-semibold text-base text-gray-500 border-b">
            Qui sommes-nous ?
        </h1>
        <div class="mt-4 text-gray-500">
            {exemple.description}
        </div>

        <h1 class="font-semibold text-base text-gray-500 border-b mt-16">
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
            <h1 class="font-semibold text-base text-gray-500 border-b mt-16">
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
                                <PrimaryButton size="text-sm"
                                    >Consulter l'offre</PrimaryButton
                                >
                            </a>
                        </div>
                        <div>
                            <div class="mt-1 flex items-center flex-wrap">
                                {#each JSON.parse(job.competence.competence) as competence}
                                    {#if competence}
                                        <span
                                            class="px-2 text-sm rounded bg-gray-700 text-white p-0.5 flex items-center w-fit me-2 my-1"
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

            <div class="mt-6 text-base">
                <div>
                    <section class="bg-white dark:bg-gray-900">
                        <div class="py-8 lg:py-16 px-4 mx-auto max-w-screen-md">
                            <h2
                                class="mb-4 text-4xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white"
                            >
                                Nous Contacter
                            </h2>
                            <p
                                class="mb-8 lg:mb-16 font-light text-center text-gray-500 dark:text-gray-400 sm:text-xl"
                            >
                                Got a technical issue? Want to send feedback
                                about a beta feature? Need details about our
                                Business plan? Let us know.
                            </p>
                            <form
                                on:submit|preventDefault={contactUs}
                                class="space-y-8"
                            >
                                <div>
                                    <label
                                        for="subject"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                        >Subject</label
                                    >
                                    <input
                                        type="text"
                                        id="subject"
                                        bind:value={$form.subject}
                                        class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:shadow-sm-light"
                                        placeholder="raison du message"
                                        required
                                    />
                                </div>
                                <div class="sm:col-span-2">
                                    <label
                                        for="message"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400"
                                        >Message</label
                                    >
                                    <textarea
                                        bind:value={$form.message}
                                        id="message"
                                        rows="6"
                                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg shadow-sm border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        placeholder="Laisser un commentaire..."
                                    ></textarea>
                                </div>
                                <button
                                    disabled={$form.isProgress}
                                    type="submit"
                                    class="py-2 px-4 font-medium text-center text-white rounded-medium btn-primary btn btn-base hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                                    >Send message</button
                                >

                                {#if $form.errors.message}
                                    {$form.errors.message}
                                {/if}


                                {#if $form.errors.subject}
                                    {$form.errors.subject}
                                {/if}
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</main>
