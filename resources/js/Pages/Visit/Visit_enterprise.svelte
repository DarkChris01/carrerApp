<script>
    import { inertia, useForm } from "@inertiajs/svelte";
    import Job from "@components/Jobs/Job.svelte";
    import { load_domains } from "@dependencies/load";
    import PrimaryButton from "@utils/PrimaryButton.svelte";
    import { onMount } from "svelte";
    import Spinner from "@utils/Spinner.svelte"
    export let enterprise;
    let domains = [];
    let isLoading = true;
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

    onMount(async () => {
        const response = await load_domains();
        if (response.status === 200) {
            domains = response.data;
            isLoading = false;
        }
    });

    const   contactUs = () => {
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

<!-- content here -->
<main class="w-full justify-start items-start">
    <div class="container mx-auto px-4 py-12">
        <section class="bg-white rounded-lg shadow-md p-8">
            <div class="flex flex-col md:flex-row md:space-x-8">
                <!-- Logo de l'entreprise -->
                <div class="flex-shrink-0">
                    <img
                        src={enterprise.logo}
                        alt="Logo de l'entreprise"
                        class="w-36 h-36 rounded-full mx-auto md:mx-0"
                    />
                </div>
                <!-- Informations principales -->
                <div class="flex-grow">
                    <h2 class="text-3xl font-bold text-gray-800">
                        {enterprise.name}
                    </h2>
                    {#if !isLoading}
                        <span class="font-medium flex space-x-2">
                            {#each JSON.parse(enterprise.sectors) as sector}
                                <div
                                    class="flex bg-blue-800 text-white px-2 rounded items-center capitalize"
                                >
                                    {domains.find((domain) => {
                                        return domain.id === sector;
                                    }).intitules}
                                </div>
                            {/each}
                        </span>
                        {:else}
                        <div class="flex justify-start h-10 items-center">
                            <Spinner/>
                        </div>
                    {/if}

                    <p class="text-gray-600 mt-1">
                        Localisation : <span class="font-medium"
                            >{enterprise.address}</span
                        >
                    </p>
                    {#if enterprise.site}
                        <!-- content here -->
                        <p class="text-gray-600 mt-1">
                            Site web : <a
                                href={enterprise.site}
                                class="text-blue-600 hover:underline"
                                >{enterprise.site ?? enterprise.facebook}</a
                            >
                        </p>
                    {/if}
                </div>
            </div>
        </section>

        <section class="mt-8">
            <!-- Description de l'entreprise -->
            <div class="bg-white rounded-lg shadow-md p-8">
                <h3 class="text-2xl font-semibold text-gray-800">
                    À propos de nous
                </h3>
                <p class="text-gray-600 mt-4">
                    {enterprise.about}
                </p>
            </div>
        </section>

        <section class="mt-8">
            <!-- Offres d'emploi -->
            <div class="bg-white rounded-lg shadow-md p-8">
                <h3 class="text-2xl font-semibold text-gray-800">
                    Offres d'emploi disponibles
                </h3>
                <ul class="mt-4 space-y-4">
                    {#each enterprise.employer.jobs as job}
                        <li class="border-b border-gray-200 pb-4">
                            <h3
                                class="block text-lg first-letter:uppercase font-medium text-blue-600"
                            >
                                {job.poste}
                            </h3>
                            <div class="flex w-full justify-between items-end">
                                <p class="text-sm text-gray-500 capitalize">
                                    <span class="uppercase">{job.type} </span>- {job.country}
                                </p>
                                <a use:inertia href="/job/mon-offre/{job.id}">
                                    <PrimaryButton size="text-sm"
                                        >Consulter l'offre</PrimaryButton
                                    >
                                </a>
                            </div>
                        </li>
                    {/each}
                </ul>
            </div>
        </section>

        <div class="bg-white p-8 rounded-lg mt-4">
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
                                class="mb-8 lg:mb-16 font-light text-center text-gray-800 dark:text-gray-400 sm:text-xl"
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
                                        class="block mb-2 text-base font-medium text-gray-900 dark:text-gray-300"
                                        >Subject</label
                                    >
                                    <input
                                        type="text"
                                        id="subject"
                                        bind:value={$form.subject}
                                        class="block p-3 w-full text-base text-gray-900 bg-gray-50 rounded-lg border border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:shadow-sm-light"
                                        placeholder="raison du message"
                                        required
                                    />
                                </div>
                                <div class="sm:col-span-2">
                                    <label
                                        for="message"
                                        class="block mb-2 text-base font-medium text-gray-900 dark:text-gray-400"
                                        >Message</label
                                    >
                                    <textarea
                                        bind:value={$form.message}
                                        id="message"
                                        rows="6"
                                        class="block p-8.5 w-full text-base text-gray-900 bg-gray-50 rounded-lg shadow-sm border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        placeholder="Laisser un commentaire..."
                                    ></textarea>
                                </div>
                                <button
                                    disabled={$form.isProgress}
                                    type="submit"
                                    class="py-2 px-4 font-medium text-center text-white rounded-medium btn-primary btn btn-base hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                                    >Laisser un message</button
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
