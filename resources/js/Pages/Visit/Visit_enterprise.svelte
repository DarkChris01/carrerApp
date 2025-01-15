<script>
    import { inertia, useForm } from "@inertiajs/svelte";
    import Job from "@components/Jobs/Job.svelte";
    import { load_domains } from "@dependencies/load";
    import PrimaryButton from "@utils/PrimaryButton.svelte";
    import { onMount } from "svelte";
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

{#if !isLoading}
    <!-- content here -->
    <main class="w-full justify-start items-start">
        <div
            class="flex-shrink-0 relative rounded h-screen image"
            style="background-image: url({enterprise.logo});"
        >
            <div class="absolute top-0 left-0 p-6">
                <div class="text-4xl font-extrabold">{enterprise.name}</div>
                <!-- <p class="text-gray-500 font-medium">Vous servir est notre dévise</p> -->
            </div>
            <div class="absolute font-extrabold p-1 rounded bottom-6 left-0 w-full bg-white/70">
                <div class="capitalize text-2xl flex items-center justify-center">
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

        <div class="text-base p-6 my-8">
            <div class="bg-white p-8 rounded">
                <h1 class="font-extrabold text-lg text-gray-800 border-b">
                    Qui sommes-nous ?
                </h1>
                <div class="mt-4 text-gray-800">
                    {exemple.description}
                </div>
            </div>

            <div class="bg-white p-8 my-2 rounded">
                <h1 class="font-extrabold text-lg text-gray-800 border-b">
                    Quels services proposons nous ?
                </h1>
                <div class="my-5">
                    <p class="my-2 text-gray-800">
                        Nous offrons des solutions dans les domaines:
                    </p>
                    <ul>
                        {#each JSON.parse(enterprise.sectors) as sector}
                            <li>
                                <div class="flex items-center capitalize">
                                    <div
                                        class="w-1.5 h-1.5 mx-2 bg-gray-400 rounded-full hidden md:block"
                                    ></div>
                                    {domains.find((domain) => {
                                        return domain.id === sector;
                                    }).intitules}
                                </div>
                            </li>
                        {/each}
                    </ul>
                </div>
            </div>
            <div class="bg-white p-8 rounded">
                <h1 class="font-extrabold text-lg text-gray-800 border-b mt-4">
                    Quelques offres ouvertes
                </h1>
                <div class="mt-6">
                    {#each enterprise.employer.jobs as job}
                        <div class="my-2 p-8 bg-white rounded border">
                            <div
                                class="flex w-full justify-between items-center"
                            >
                                <div class="border- font-extrabold capitalize">
                                    {job.poste}
                                </div>
                                <a use:inertia href="/job/mon-offre/{job.id}">
                                    <PrimaryButton size="text-base"
                                        >Consulter l'offre</PrimaryButton
                                    >
                                </a>
                            </div>
                            <div>
                                <div class="mt-1 flex items-center flex-wrap">
                                    {#each JSON.parse(job.competence.competence) as competence}
                                        {#if competence}
                                            <span
                                                class="px-2 text-base rounded bg-gray-700 text-white p-0.5 flex items-center w-fit me-2 my-1"
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
            <div class="bg-white p-8 rounded mt-4">
                <div class="mt-6 text-base">
                    <div>
                        <section class="bg-white dark:bg-gray-900">
                            <div
                                class="py-8 lg:py-16 px-4 mx-auto max-w-screen-md"
                            >
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
{/if}

<style>
    .image {
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
</style>
