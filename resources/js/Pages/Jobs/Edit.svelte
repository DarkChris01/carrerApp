<script>
    import { fadeIn,format_date_anglo_to_french } from "@dependencies/utilities";
    import { load_domains } from "@dependencies/load";
    import { useForm, router } from "@inertiajs/svelte";
    import { onMount, onDestroy } from "svelte";
        import toast from "svelte-french-toast";
    import axios from "axios";
    import Spinner from "@/Utils/Spinner.svelte";
    export let job;
    let add_competence5 = false;
    let add_competence6 = false;
    let show_button5 = true;
    let show_button6 = false;
    let btn_reset_competence5 = false;
    let btn_reset_competence6 = false;
    let domains = [];
    let loading = true;
    let load_country = true;
    let countries;
    let competences = JSON.parse(job.competence.competence);
    

    onMount(async () => {
        const a = await axios.get(
            "https://restcountries.com/v3.1/all?fields=name",
            { timeout: 10000 },
        );
        if (a.status === 200) {
            const datas = await a.data;
            countries = datas.sort((a, b) => {
                return a.name.common.localeCompare(b.name.common);
            });
            load_country = false;
        }

        const response = await load_domains();
        if (response.status === 200) {
            const datas = await response.data;
            domains = datas.sort((a, b) => {
                return a.intitules.localeCompare(b.intitules);
            });
        }
        loading = false;
    });

    const form = {
        poste: job.poste,
        mission: job.mission,
        formation: job.formation,
        domain: job.domain,
        experience: job.experience,
        country: job.country,
        type: job.type,
        salary: job.salary,
        delay: job.expired_at,
        effective: job.effective,
        competence1: competences[0],
        competence2: competences[1],
        competence3: competences[2],
        competence4: competences[3],
        competence5: competences[4],
        competence6: competences[5],
    };

    const create_Job = (event) => {
        const formdata = new FormData(event.target);

        router.post("/employer/update/" + job.id, formdata, {
            onSuccess: () => {
                toast.success("modofication effectuée !");
            },
        });
    };
</script>

<!-- svelte-ignore a11y-click-events-have-key-events -->
<!-- svelte-ignore a11y-no-noninteractive-element-interactions -->
<main class="flex font-light justify-center">
    {#if !load_country}
        {#if !loading}
            <div
                class=" md:mx-0 mx-auto p-2 md:p-8 text-[13px] xl:text-sm 2xl:text-sm bg-white my-8"
            >
                <form on:submit|preventDefault={(e) => create_Job(e)}>
                    <div>
                        <div class="my-3">
                            <label
                                for="small-input"
                                class="block mb-1 text-sm lg:text-sm text-gray-600 dark:text-white"
                                >Poste</label
                            >
                            <input
                                required
                                value={job.poste}
                                name="poste"
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
                                value={job.type}
                                name="type"
                                type="text"
                                class="block w-full text-gray-800 border placeholder:text-gray-400 border-gray-300 rounded-lg scrollable bg-gray-50 text-sm md:text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            >
                                <option value="cdi">CDI</option>
                                <option value="cdd" selected>CDD</option>
                                <option value="temps plein" selected>Temps plein</option>
                                <option value="temps partial" selected>Temps partiel</option>
                                <option value="stage">Interimaire</option>
                                <option value="stage">Essai</option>
                                <option value="stage">Stagiaire</option>
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
                                        bind:value={job.domain.initules}
                                        name="domain"
                                        type="text"
                                        class="scrollable block w-full capitalize p-1 text-gray-700 border border-gray-300 rounded-lg bg-gray-50 text-sm md:text-[12px] xl:text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    >
                                        {#each domains as domain}
                                            <option
                                                class="capitalize text-sm"
                                                selected={domain.id ==
                                                    job.domain_id}
                                                value={domain.id}
                                                >{domain.intitules}</option
                                            >
                                        {/each}
                                    </select>
                                </div>
                            </div>
                            <section class="competences">
                                <div class="my-3">
                                    <label
                                        for="small-input"
                                        class="block mb-1 text-sm lg:text-sm text-gray-600 dark:text-white"
                                        >Competences</label
                                    >
                                    <div
                                        class="grid md:grid-cols-2 grid-cols-1 gap-2"
                                    >
                                        <div>
                                            <select
                                                required
                                                value={competences[0]}
                                                name="competence1"
                                                placeholder="PHP "
                                                type="text"
                                                class="block w-full text-gray-800 border placeholder:text-gray-400 border-gray-300 rounded-lg scrollable bg-gray-50 text-sm md:text-[13px] xl:text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            >
                                                {#each domains as domain}
                                                    <option
                                                        class="text-sm capitalize"
                                                        value={domain.intitules}
                                                        >{domain.intitules}</option
                                                    >
                                                {/each}
                                            </select>
                                        </div>
                                        <div>
                                            <select
                                                value={competences[1]}
                                                name="competence2"
                                                placeholder="Laravel"
                                                type="text"
                                                class="block w-full text-gray-800 border placeholder:text-gray-400 border-gray-300 rounded-lg scrollable bg-gray-50 text-sm md:text-[13px] xl:text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            >
                                                {#each domains as domain}
                                                    <option
                                                        class="text-sm capitalize"
                                                        value={domain.intitules}
                                                        >{domain.intitules}</option
                                                    >
                                                {/each}
                                            </select>
                                        </div>
                                        <div>
                                            <select
                                                value={competences[2]}
                                                name="competence3"
                                                placeholder=" Sveltekit"
                                                type="text"
                                                class="block w-full text-gray-800 border placeholder:text-gray-400 border-gray-300 rounded-lg scrollable bg-gray-50 text-sm md:text-[13px] xl:text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            >
                                                {#each domains as domain}
                                                    <option
                                                        class="text-sm capitalize"
                                                        value={domain.intitules}
                                                        >{domain.intitules}</option
                                                    >
                                                {/each}
                                            </select>
                                        </div>
                                        <div>
                                            <select
                                                value={competences[3]}
                                                name="competence4"
                                                placeholder="React Js"
                                                type="text"
                                                class="block w-full text-gray-800 border placeholder:text-gray-400 border-gray-300 rounded-lg scrollable bg-gray-50 text-sm md:text-[13px] xl:text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            >
                                                {#each domains as domain}
                                                    <option
                                                        class="text-gray-700 text-sm capitalize"
                                                        value={domain.intitules}
                                                        >{domain.intitules}</option
                                                    >
                                                {/each}
                                            </select>
                                        </div>

                                        <div class="relative">
                                            <input
                                                value={competences[4]}
                                                name="competence5"
                                                placeholder="MySQL"
                                                type="text"
                                                class="block w-full text-gray-800 border-0 placeholder:text-gray-400 ring-2 rounded-lg bg-gray-50 text-sm md:text-[13px] xl:text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            />
                                        </div>

                                        <div class="relative">
                                            <input
                                                value={competences[5]}
                                                name="competence6"
                                                placeholder="Javascript"
                                                type="text"
                                                class="block w-full text-gray-800 border-0 placeholder:text-gray-400 ring-2 rounded-lg bg-gray-50 text-sm md:text-[13px] xl:text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <div class="my-3 md:grid md:grid-cols-2 md:gap-2">
                                <div class="my-3">
                                    <label
                                        for="small-input"
                                        class="block mb-1 text-sm lg:text-sm text-gray-600 dark:text-white"
                                        >Experience professionelle</label
                                    >
                                    <input
                                        value={job.experience}
                                        name="experience"
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
                                        value={job.formation}
                                        name="formation"
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
                                    value={job.salary}
                                    name="salary"
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
                                    name="country"
                                    class="block w-fit p-1 text-gray-800 border placeholder:text-gray-400 border-gray-300 rounded-lg bg-gray-50 text-sm md:text-[13px] xl:text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                >
                                    {#each countries as pays}
                                        <option
                                            selected={job.country.toLowerCase() ==
                                                pays.name.common.toLowerCase()}
                                            value={pays.name.common}
                                            >{pays.name.common}</option
                                        >
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
                                    value={form.delay}
                                    name="delay"
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
                                    value={form.effective}
                                    name="effective"
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
                                name="mission"
                                id="message"
                                maxlength="1000"
                                rows="6"
                                class="block p-1.5 w-full placeholder:text-gray-400 text-sm text-gray-800 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Exemple : Chargé du developpement d'applications ..."
                                >{job.missions}</textarea
                            >
                        </div>
                    </div>
                    <div class="mt-8 flex justify-end">
                        <button
                            type="submit"
                            class="bg-blue-600 p-2 text-white rounded"
                            >Modifier</button
                        >
                    </div>
                </form>
            </div>
        {:else}
            <div
                class="flex w-full h-screen justify-center items-center text-gray-700 text-2xl"
            >
            <Spinner/>
            </div>
        {/if}
    {:else}
        <div
            class="flex w-full h-screen justify-center items-center text-gray-700 text-2xl"
        >
           <Spinner/>
        </div>
    {/if}
</main>
