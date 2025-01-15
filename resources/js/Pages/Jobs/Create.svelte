<script>
    import { fadeIn } from "@dependencies/utilities";
    import countries from "@dependencies/helpers/countries.json";
    import { load_domains, get_competences } from "@dependencies/load";
    import { useForm } from "@inertiajs/svelte";
    import { onMount, onDestroy } from "svelte";
    import toast from "svelte-french-toast";
    import Spinner from "@utils/Spinner.svelte";
    import axios from "axios";
    let add_competence5 = false;
    let add_competence6 = false;
    let show_button5 = true;
    let show_button6 = false;
    let btn_reset_competence5 = false;
    let btn_reset_competence6 = false;
    let domains = [];
    let isLoading = true;
    let requirements = [];

    onMount(async () => {
        const response_ = await load_domains();
        if (response_.status === 200) {
            const datas = response_.data;
            domains = datas.sort((a, b) => {
                return a.intitules.localeCompare(b.intitules);
            });
        }

        const requirement_response = await get_competences();

        if (requirement_response.status === 200) {
            const datas = requirement_response.data;
            requirements = datas.sort((a, b) => {
                return a.name.localeCompare(b.intitules);
            });

            isLoading = false;
        }
    });

    const form = useForm({
        poste: null,
        mission: null,
        formation: null,
        domain: null,
        experience: null,
        country: null,
        type: null,
        salary: null,
        delay: null,
        effective: null,
        competence1: null,
        competence2: null,
        competence3: null,
        competence4: null,
        competence5: null,
        competence6: null,
    });

    const create_Job = () => {
        $form.post("/employer/storejob", {
            onSuccess: () => {
                toast.success("l'offre a été crée!");
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
<main class="flex font-light justify-center my-8">
    <div
        class=" md:mx-0 md:w-3/4 2xl:w-2/3 p-2 md:p-6 text-[13px] xl:text-sm 2xl:text-sm bg-white"
    >
        {#if !isLoading}
            <div class="my-10">
                <h1 class="text-sm md:text-xl font-bold text-center">
                    Créer une nouvelle offre
                </h1>
                <p class="text-center text-sm text-gray-500 p-1">
                    Remplissez tous les champs avec la meilleure orthographe
                    possible pour un meilleur reférencement
                </p>
            </div>

            <form on:submit|preventDefault={create_Job}>
                <div>
                    <div class="my-3">
                        <label
                            for="small-input"
                            class="block mb-1 text-sm lg:text-sm text-gray-600 dark:text-white"
                            >Poste</label
                        >
                        <input
                            required
                            bind:value={$form.poste}
                            type="text"
                            class="block w-full text-gray-800 border placeholder:text-gray-400 border-gray-300 rounded-lg scrollable bg-gray-50 text-sm md:text-[13px] xl:text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        />
                    </div>
                    <div class="my-3">
                        <label
                            for="small-input"
                            class="block mb-1 text-sm lg:text-sm text-gray-600 dark:text-white"
                            >Type de contrat</label
                        >
                        <select
                            required
                            bind:value={$form.type}
                            type="text"
                            class="block w-full text-gray-800 border placeholder:text-gray-400 border-gray-300 rounded-lg scrollable bg-gray-50 text-sm md:text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        >
                            <option value="cdi">CDI</option>
                            <option value="cdd" selected>CDD</option>
                            <option value="stage">Interimaire</option>
                            <option value="stage">Essai</option>
                            <option value="stage">Stagiaire</option>
                            <option value="stage">Temps partiel</option>
                            <option value="stage">Temps plein</option>
                            <option value="freelance">Freelance</option>
                        </select>
                    </div>

                    <section>
                        <div class="my-3">
                            <label
                                for="small-input"
                                class="block mb-1 text-sm lg:text-sm text-gray-600 dark:text-white"
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
                                            value={domain.id}
                                            >{domain.intitules}</option
                                        >
                                    {/each}
                                </select>
                            </div>
                        </div>
                        <section class="requirements">
                            <div class="my-3">
                                <label
                                    for="small-input"
                                    class="block mb-1 text-sm lg:text-sm text-gray-600 dark:text-white"
                                    >competences</label
                                >
                                <div
                                    class="grid md:grid-cols-2 grid-cols-1 gap-2"
                                >
                                    <div>
                                        <select
                                            required
                                            bind:value={$form.competence1}
                                            placeholder="PHP "
                                            type="text"
                                            class="block w-full text-gray-800 border placeholder:text-gray-400 border-gray-300 rounded-lg scrollable bg-gray-50 text-sm md:text-[13px] xl:text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        >
                                            {#each requirements as domain}
                                                <option
                                                    class="text-sm capitalize"
                                                    value={domain.name}
                                                    >{domain.name}</option
                                                >
                                            {/each}
                                        </select>
                                    </div>
                                    <div>
                                        <select
                                            bind:value={$form.competence2}
                                            placeholder="Laravel"
                                            type="text"
                                            class="block w-full text-gray-800 border placeholder:text-gray-400 border-gray-300 rounded-lg scrollable bg-gray-50 text-sm md:text-[13px] xl:text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        >
                                            {#each requirements as domain}
                                                <option
                                                    class="text-sm capitalize"
                                                    value={domain.name}
                                                    >{domain.name}</option
                                                >
                                            {/each}
                                        </select>
                                    </div>
                                    <div>
                                        <select
                                            bind:value={$form.competence3}
                                            placeholder=" Sveltekit"
                                            type="text"
                                            class="block w-full text-gray-800 border placeholder:text-gray-400 border-gray-300 rounded-lg scrollable bg-gray-50 text-sm md:text-[13px] xl:text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        >
                                            {#each requirements as domain}
                                                <option
                                                    class="text-sm capitalize"
                                                    value={domain.name}
                                                    >{domain.name}</option
                                                >
                                            {/each}
                                        </select>
                                    </div>
                                    <div>
                                        <select
                                            bind:value={$form.competence4}
                                            placeholder="React Js"
                                            type="text"
                                            class="block w-full text-gray-800 border placeholder:text-gray-400 border-gray-300 rounded-lg scrollable bg-gray-50 text-sm md:text-[13px] xl:text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        >
                                            {#each requirements as domain}
                                                <option
                                                    class="text-gray-700 text-sm capitalize"
                                                    value={domain.name}
                                                    >{domain.name}</option
                                                >
                                            {/each}
                                        </select>
                                    </div>

                                    {#if add_competence5}
                                        <div class="relative">
                                            <input
                                                bind:value={$form.competence5}
                                                placeholder="MySQL"
                                                type="text"
                                                class="block w-full text-gray-800 border-0 placeholder:text-gray-400 ring-2 rounded-lg bg-gray-50 text-sm md:text-[13px] xl:text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
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
                                                class="block w-full text-gray-800 border-0 placeholder:text-gray-400 ring-2 rounded-lg bg-gray-50 text-sm md:text-[13px] xl:text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            />
                                            <button
                                                type="button"
                                                class="absolute top-1.5 right-0.5"
                                                on:click={() => {
                                                    $form.competence6 = null;
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
                                    class="block mb-1 text-sm lg:text-sm text-gray-600 dark:text-white"
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
                                <div class="my-1">
                                    <label
                                        class="text-gray-500 text-sm lg:text-sm"
                                        for="name">Niveau d'etude</label
                                    >
                                </div>
                                <select
                                    type="text"
                                    bind:value={$form.formation}
                                    placeholder="exemple: Licence"
                                    class="border-0 w-full p-1 scrollable text-gray-700 ring-1 focus:ring-orange-600 text-sm lg:text-sm placeholder:text-gray-400 placeholder:text-sm rounded"
                                >
                                    <option
                                        class="text-gray-700 text-sm capitalize"
                                        value="BEPC">BEPC</option
                                    >
                                    <option
                                        class="text-gray-700 text-sm capitalize"
                                        value="BAC">BAC</option
                                    >
                                    <option
                                        class="text-gray-700 text-sm capitalize"
                                        value="BAC+1">BAC+1</option
                                    >
                                    <option
                                        class="text-gray-700 text-sm capitalize"
                                        value="BAC+2">BAC+2</option
                                    >
                                    <option
                                        class="text-gray-700 text-sm capitalize"
                                        value="BAC+3">BAC+3</option
                                    >
                                    <option
                                        class="text-gray-700 text-sm capitalize"
                                        value="BAC+4">BAC+4</option
                                    >
                                    <option
                                        class="text-gray-700 text-sm capitalize"
                                        value="BAC+5">BAC+5</option
                                    >
                                    <option
                                        class="text-gray-700 text-sm capitalize"
                                        value="BAC++">BAC++</option
                                    >
                                </select>
                            </div>
                        </div>
                    </section>

                    <div class="my-3 md:grid md:grid-cols-2 md:gap-2">
                        <div>
                            <label
                                for="small-input"
                                class="block mb-1 text-sm lg:text-sm text-gray-600 dark:text-white"
                                >Salaire</label
                            >
                            <input
                                bind:value={$form.salary}
                                type="number"
                                placeholder="300000"
                                class="block w-fit p-1 text-gray-800 border placeholder:text-gray-400 border-gray-300 rounded-lg bg-gray-50 text-sm md:text-[13px] xl:text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            />
                        </div>
                        <div class="md:my-0 my-3">
                            <label
                                for="small-input"
                                class="block mb-1 text-sm lg:text-sm text-gray-600 dark:text-white"
                                >Pays</label
                            >
                            <select
                                bind:value={$form.country}
                                placeholder="Douala"
                                class="block w-fit p-1 text-gray-800 border placeholder:text-gray-400 border-gray-300 rounded-lg bg-gray-50 text-sm md:text-[13px] xl:text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            >
                                {#each countries.world as country}
                                    <option value={country}>{country}</option>
                                {/each}
                            </select>
                        </div>
                    </div>

                    <div class="my-3 md:grid md:grid-cols-2 md:gap-2">
                        <div class="w-full">
                            <label
                                for="small-input"
                                class="block mb-1 text-sm lg:text-sm text-gray-600 dark:text-white"
                                >Date limite (dépôt de candidature)</label
                            >
                            <input
                                bind:value={$form.delay}
                                type="date"
                                class="block w-full text-gray-800 border placeholder:text-gray-400 border-gray-300 rounded-lg scrollable bg-gray-50 text-sm md:text-[13px] xl:text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            />
                        </div>
                        <div class="w-full my-3 md:my-0">
                            <label
                                for="small-input"
                                class="block mb-1 text-sm lg:text-sm text-gray-600 dark:text-white"
                                >Nombre de poste</label
                            >
                            <input
                                placeholder="2"
                                bind:value={$form.effective}
                                type="number"
                                class="block w-1/2 text-gray-800 border placeholder:text-gray-400 border-gray-300 rounded-lg bg-gray-50 text-sm md:text-[13px] xl:text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            />
                        </div>
                    </div>

                    <div class="my-3">
                        <label
                            for="description"
                            class="block mb-1 text-sm lg:text-sm text-gray-600 dark:text-white"
                            >Responsabilité</label
                        >
                        <textarea
                            required
                            bind:value={$form.mission}
                            id="message"
                            maxlength="1000"
                            rows="4"
                            class="block p-1.5 w-full placeholder:text-gray-400 text-sm text-gray-800 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Exemple : Chargé du developpement d'applications ..."
                        ></textarea>
                    </div>
                </div>
                <div class="mt-8 flex justify-end">
                    <button
                        type="submit"
                        class="bg-blue-600 p-2 text-white rounded"
                        >Créer une offre</button
                    >
                </div>
            </form>
        {:else}
            <div
                class="h-screen flex justify-center items-center text-gray-600"
            >
                <Spinner />
            </div>
        {/if}
    </div>
</main>
