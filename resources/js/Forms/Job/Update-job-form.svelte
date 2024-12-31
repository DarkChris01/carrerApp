<script>
    import {
        fadeIn,
        format_date_anglo_to_french,
    } from "@dependencies/utilities";
    import { useForm } from "@inertiajs/svelte";
    import { load_domains } from "@dependencies/load";
    import { onMount, onDestroy } from "svelte";
      import Spinner from "@utils/Spinner.svelte"
    import toast from "svelte-french-toast";
    import axios from "axios";
    export let job;

    let add_competence5 = false;
    let add_competence6 = false;
    let show_button5 = true;
    let show_button6 = false;
    let btn_reset_competence5 = false;
    let btn_reset_competence6 = false;
    let domains = [];
    let formations = [];
    let loading = true;
    let mission;
    let handle;

    const form = useForm({
        job: job.id,
        poste: job.poste,
        formation: job.formation.id,
        domain: job.domain_id,
        experience: job.experiences,
        town: job.town,
        type: job.type,
        salary: job.salary,
        delay: format_date_anglo_to_french(job.expired_at),
        effective: job.effective,
        competence1: JSON.parse(job.competences)[0],
        competence2: JSON.parse(job.competences)[1],
        competence3: JSON.parse(job.competences)[2],
        competence4: JSON.parse(job.competences)[3],
        competence5: JSON.parse(job.other_competences)[0],
        competence6: JSON.parse(job.other_competences)[1],
    });

    const create_Job = () => {
        $form
            .transform((form) => ({
                ...form,
                mission: mission.value,
            }))
            .post("/employer/updatejob", {
                onSuccess: () => {
                    toast.success("Offre mis à jour avec succes!");
                },
            });
    };

    const toggle_competence5 = () => {
        add_competence5 = !add_competence5;
        show_button6 = !show_button6;
        show_button5 = !show_button5;
    };

    const toggle_competence6 = () => {
        add_competence6 = !add_competence6;
        show_button6 = !show_button6;
    };
</script>

<!-- svelte-ignore a11y-click-events-have-key-events -->
<!-- svelte-ignore a11y-no-noninteractive-element-interactions -->

<main
    class="fixed top-0 left-0 flex font-light justify-center h-screen items-center w-full bg-gray-900/80"
>
    <div
        class="relative w-full h-screen lg:h-[38rem] 2xl:h-[44rem] overflow-y-auto scrollable md:w-1/2 xl:w-1/2 2xl:w-1/3 bg-white lg:rounded p-2 py-10 text-[13px] xl:text-sm 2xl:text-sm"
    >
        <div class="lg:hidden absolute top-3 right-3">
            <button on:click
                ><svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="size-6 hover:stroke-red-600"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6 18 18 6M6 6l12 12"
                    />
                </svg>
            </button>
        </div>
        <div
            class="md:mx-0 w-auto p-2 md:p-6 py-10 text-[13px] xl:text-sm 2xl:text-sm"
        >
            <div class="my-6">
                <h1 class="text-sm md:text-xl font-bold text-center">
                    Créer une nouvelle offre
                </h1>
                <p class="text-center text-sm text-gray-500 p-1">
                    Remplissez tous les champs avec la meilleura orthographe
                    possible pour un meilleur reférencement
                </p>
            </div>
            {#if !loading}
                <form on:submit|preventDefault={create_Job}>
                    <div>
                        <div class="my-3">
                            <label
                                for="small-input"
                                class="block mb-1 text-sm font-medium text-gray-600 dark:text-white"
                                >Poste</label
                            >
                            <input
                                required
                                bind:value={$form.poste}
                                type="text"
                                class="block w-full p-1 text-gray-800 border capitalize placeholder:text-gray-400 border-gray-300 rounded-lg bg-gray-50 text-sm md:text-[13px] xl:text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            />
                        </div>
                        <div class="my-3">
                            <label
                                for="small-input"
                                class="block mb-1 text-sm font-medium text-gray-600 dark:text-white"
                                >Type de contrat</label
                            >
                            <select
                                required
                                bind:value={$form.type}
                                type="text"
                                class="block w-full p-1 text-gray-800 border capitalize placeholder:text-gray-400 border-gray-300 rounded-lg bg-gray-50 text-sm md:text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            >
                                <option
                                    value="cdi"
                                    selected={$form.type === "cdi"}>CDI</option
                                >
                                <option
                                    value="cdd"
                                    selected={$form.type === "cdd"}>CDD</option
                                >
                                <option
                                    value="interimaire"
                                    selected={$form.type === "stage"}
                                    >Interimaire</option
                                >
                                <option
                                    value="essai"
                                    selected={$form.type === "essai"}
                                    >Essai</option
                                >
                                <option
                                    value="stage"
                                    selected={$form.type === "stage"}
                                    >Stagiaire</option
                                >
                                <option
                                    value="freelance"
                                    selected={$form.type === "freelance"}
                                    >Freelance</option
                                >
                            </select>
                        </div>

                        <section>
                            <div class="my-3">
                                <label
                                    for="small-input"
                                    class="block mb-1 text-sm font-medium text-gray-600 dark:text-white"
                                    >Domain</label
                                >
                                <div class="rounded">
                                    <select
                                        bind:value={$form.domain}
                                        type="text"
                                        class="scrollable block w-full capitalize p-1 text-gray-700 border border-gray-300 rounded-lg bg-gray-50 text-sm md:text-[12px] xl:text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    >
                                        {#each domains as domain}
                                            <option
                                                class="capitalize text-sm"
                                                selected={domain.id ==
                                                    $form.domain_id}
                                                value={domain.id}
                                                >{domain.name}</option
                                            >
                                        {/each}
                                    </select>
                                </div>
                            </div>
                            <section class="competences border p-3">
                                <div class="my-3">
                                    <label
                                        for="small-input"
                                        class="block mb-1 text-sm font-medium text-gray-600 dark:text-white"
                                        >Competences</label
                                    >
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <select
                                                required
                                                bind:value={$form.competence1}
                                                placeholder="PHP "
                                                type="text"
                                                class="block w-full p-1 text-gray-800 border capitalize placeholder:text-gray-400 border-gray-300 rounded-lg bg-gray-50 text-sm md:text-[13px] xl:text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            >
                                                {#each domains as domain}
                                                    {#each JSON.parse(domain.competences) as competence}
                                                        <option
                                                            class="text-sm capitalize"
                                                            value={competence}
                                                            >{competence}</option
                                                        >
                                                    {/each}
                                                {/each}
                                            </select>
                                        </div>
                                        <div>
                                            <select
                                                bind:value={$form.competence2}
                                                placeholder="Laravel"
                                                type="text"
                                                class="block w-full p-1 text-gray-800 border capitalize placeholder:text-gray-400 border-gray-300 rounded-lg bg-gray-50 text-sm md:text-[13px] xl:text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            >
                                                {#each domains as domain}
                                                    {#each JSON.parse(domain.competences) as competence}
                                                        <option
                                                            class="text-sm capitalize"
                                                            value={competence}
                                                            >{competence}</option
                                                        >
                                                    {/each}
                                                {/each}
                                            </select>
                                        </div>
                                        <div>
                                            <select
                                                bind:value={$form.competence3}
                                                placeholder=" Sveltekit"
                                                type="text"
                                                class="block w-full p-1 text-gray-800 border capitalize placeholder:text-gray-400 border-gray-300 rounded-lg bg-gray-50 text-sm md:text-[13px] xl:text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            >
                                                {#each domains as domain}
                                                    {#each JSON.parse(domain.competences) as competence}
                                                        <option
                                                            class="text-sm capitalize"
                                                            value={competence}
                                                            >{competence}</option
                                                        >
                                                    {/each}
                                                {/each}
                                            </select>
                                        </div>
                                        <div>
                                            <select
                                                bind:value={$form.competence4}
                                                placeholder="React Js"
                                                type="text"
                                                class="block w-full p-1 text-gray-800 border capitalize placeholder:text-gray-400 border-gray-300 rounded-lg bg-gray-50 text-sm md:text-[13px] xl:text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            >
                                                {#each domains as domain}
                                                    {#each JSON.parse(domain.competences) as competence}
                                                        <option
                                                            class="text-gray-700 text-sm capitalize"
                                                            value={competence}
                                                            >{competence}</option
                                                        >
                                                    {/each}
                                                {/each}
                                            </select>
                                        </div>

                                        {#if add_competence5}
                                            <div class="relative">
                                                <input
                                                    bind:value={$form.competence5}
                                                    placeholder="MySQL"
                                                    type="text"
                                                    class="block w-full p-1 text-gray-800 border capitalize-0 placeholder:text-gray-400 ring-2 rounded-lg bg-gray-50 text-sm md:text-[13px] xl:text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                />
                                                {#if !add_competence6}
                                                    <button
                                                        type="button"
                                                        class="absolute top-1.5 right-0.5 h-fit"
                                                        on:click={() => {
                                                            $form.competence5 =
                                                                null;
                                                            toggle_competence5();
                                                        }}
                                                        ><svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            fill="none"
                                                            viewBox="0 0 24 24"
                                                            stroke-width="1.5"
                                                            stroke="currentColor"
                                                            class="size-5 stroke-red-600 hover:scale-125 duration-300 ease transition"
                                                        >
                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                                                            />
                                                        </svg>
                                                    </button>
                                                {/if}
                                            </div>
                                        {/if}

                                        {#if add_competence6}
                                            <div class="relative">
                                                <input
                                                    bind:value={$form.competence6}
                                                    placeholder="Javascript"
                                                    type="text"
                                                    class="block w-full p-1 text-gray-800 border capitalize-0 placeholder:text-gray-400 ring-2 rounded-lg bg-gray-50 text-sm md:text-[13px] xl:text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                />
                                                <button
                                                    type="button"
                                                    class="absolute top-1.5 right-0.5"
                                                    on:click={() => {
                                                        $form.competence6 =
                                                            null;
                                                        toggle_competence6();
                                                    }}
                                                    ><svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke-width="1.5"
                                                        stroke="currentColor"
                                                        class="size-5 stroke-red-600 hover:scale-125 duration-300 ease transition"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                                                        />
                                                    </svg>
                                                </button>
                                            </div>
                                        {/if}
                                    </div>
                                </div>
                                {#if show_button5}
                                    <button
                                        on:click={toggle_competence5}
                                        type="button"
                                        class="bg-red-600 text-sm p-1 text-gray-100 hover:text-white hover:bg-red-500 rounded"
                                        >Ajouter une competence</button
                                    >
                                {/if}
                                {#if show_button6}
                                    <button
                                        type="button"
                                        on:click={toggle_competence6}
                                        class="bg-red-600 text-sm p-1 text-gray-100 hover:text-white hover:bg-red-500 rounded"
                                        >Ajouter une competence</button
                                    >
                                {/if}
                            </section>
                            <div class="my-3 md:grid md:grid-cols-2 md:gap-2">
                                <div class="my-3">
                                    <label
                                        for="small-input"
                                        class="block mb-1 text-sm font-medium text-gray-600 dark:text-white"
                                        >Experience professionelle</label
                                    >
                                    <input
                                        bind:value={$form.experience}
                                        placeholder="3"
                                        type="number"
                                        class="block w-fit p-1 text-gray-800 border placeholder:text-gray-400 border-gray-300 rounded-lg bg-gray-50 text-sm md:text-[13px] xl:text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    />
                                </div>
                                <div class="my-3 w-full">
                                    <label
                                        for="small-input"
                                        class="block mb-1 text-sm font-medium text-gray-600 dark:text-white"
                                        >Niveau de formation</label
                                    >
                                    <select
                                        bind:value={$form.formation}
                                        class="block p-1 text-gray-800 border w-full placeholder:text-gray-400 border-gray-300 rounded-lg bg-gray-50 text-sm md:text-[13px] xl:text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    >
                                        {#each formations as formation}
                                            <option
                                                class="text-sm"
                                                selected={$form.formation.id ===
                                                    formation.id}
                                                value={formation.id}
                                                >{formation.name}</option
                                            >
                                        {/each}
                                    </select>
                                </div>
                            </div>
                        </section>

                        <div class="my-3 md:grid md:grid-cols-2 md:gap-2">
                            <div>
                                <label
                                    for="small-input"
                                    class="block mb-1 text-sm font-medium text-gray-600 dark:text-white"
                                    >Salaire</label
                                >
                                <input
                                    bind:value={$form.salary}
                                    type="number"
                                    placeholder="300000"
                                    class="block w-fit p-1 text-gray-800 border placeholder:text-gray-400 border-gray-300 rounded-lg bg-gray-50 text-sm md:text-[13px] xl:text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                />
                            </div>
                            <div>
                                <label
                                    for="small-input"
                                    class="block mb-1 text-sm font-medium text-gray-600 dark:text-white"
                                    >Ville</label
                                >
                                <input
                                    bind:value={$form.town}
                                    type="text"
                                    placeholder="Douala"
                                    class="block w-fit p-1 text-gray-800 border placeholder:text-gray-400 border-gray-300 rounded-lg bg-gray-50 text-sm md:text-[13px] xl:text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                />
                            </div>
                        </div>

                        <div class="my-3 md:grid md:grid-cols-2 md:gap-2">
                            <div class="w-full">
                                <label
                                    for="small-input"
                                    class="block mb-1 text-sm font-medium text-gray-600 dark:text-white"
                                    >Date limite (dépôt de candidature)</label
                                >
                                <input
                                    bind:value={$form.delay}
                                    type="date"
                                    class="block w-full p-1 text-gray-800 border capitalize placeholder:text-gray-400 border-gray-300 rounded-lg bg-gray-50 text-sm md:text-[13px] xl:text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                />
                            </div>
                            <div class="w-full">
                                <label
                                    for="small-input"
                                    class="block mb-1 text-sm font-medium text-gray-600 dark:text-white"
                                    >Nombre de poste</label
                                >
                                <input
                                    placeholder="2"
                                    bind:value={$form.effective}
                                    type="number"
                                    class="block w-1/2 p-1 text-gray-800 border placeholder:text-gray-400 border-gray-300 rounded-lg bg-gray-50 text-sm md:text-[13px] xl:text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                />
                            </div>
                        </div>

                        <div class="my-3">
                            <label
                                for="description"
                                class="block mb-1 text-sm font-medium text-gray-600 dark:text-white"
                                >Responsabilité</label
                            >
                            <textarea
                                required
                                bind:this={mission}
                                id="message"
                                maxlength="1000"
                                rows="4"
                                class="block p-1.5 w-full placeholder:text-gray-400 text-sm text-gray-800 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Exemple : Chargé du developpement d'applications ..."
                                >{job.missions}</textarea
                            >
                        </div>
                    </div>
                    <div class="mt-8">
                        {#if $form.isDirty}
                            <!-- content here -->
                            <button
                                disabled={$form.processing}
                                type="submit"
                                class="bg-blue-600 p-2 text-white rounded w-full"
                                >Mettre à jour</button
                            >
                        {/if}
                    </div>
                </form>
            {:else}
                <div class="flex w-full h-96 justify-center items-center">
                    <Spinner/>
                </div>
            {/if}
        </div>
    </div>
</main>
