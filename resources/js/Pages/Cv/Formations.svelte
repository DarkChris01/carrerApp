<script>
    import { Link } from "@inertiajs/svelte";
    import { page } from "@dependencies/Stores/Store";
    import toast from "svelte-french-toast";
    import { load_domains } from "@dependencies/load";
    import Spinner from "@utils/Spinner.svelte"
    import { onMount } from "svelte";
    import { useForm } from "@inertiajs/svelte";
    export let formations;


    let f = formations ? JSON.parse(formations.formations) : null;
    let add = false;
    let competences = [];
    let isloading = true;

    $: form = useForm({
        school: f ? f[0].school : null,
        degree: f ? f[0].degree : null,
        competence: f ? f[0].domain : null,
        date: f ? f[0].date : null,

        school2: f ? f[1].school : null,
        degree2: f ? f[1].degree : null,
        competence2: f ? f[1].domain : null,
        date2: f ? f[1].date : null,

        school3: f ? f[2].school : null,
        degree3: f ? f[2].degree : null,
        competence3: f ? f[2].domain : null,
        date3: f ? f[2].date : null,
    });

    onMount(async () => {
        if ($form.school3) {
            add = true;
        }
        const response = await load_domains();
        if (response.status === 200) {
            const datas = await response.data;
            competences = datas.sort((a, b) => {
                return a.intitules.localeCompare(b.intitules);
            });
            isloading = false;
        }
    });

    // submit new formation

    const submitFormation = () => {
        $form.post("/cv/formation", {
            onSuccess: () => {
                toast.success("informations validées !");
            },
            onError: (error) => {
                toast.error(error);
            },
            preserveScroll: true,
        });
    };
</script>

<div class="w-full lg:w-1/2 mx-auto bg-white border my-4 p-2 lg:p-4">
    <div class="my-10">
        <div class="flex justify-center font-bold">
            <h1 class="text-sm md:text-xl xl:text-4xl text-gray-700">
                Formations
            </h1>
        </div>
        <p class="text-center text-gray-500 text-sm">
            Ces informations seront visibles uniquement pour les recruteurs!
        </p>
    </div>
    {#if !isloading}
        <!-- content here -->

        <div
            class="w-full flex justify-center items-center text-sm lg:text-sm"
        >
            <form
                class="w-full flex justify-center px-4"
                on:submit|preventDefault={submitFormation}
            >
                <div class=" w-full mb-[4rem]">
                    <div class="pb-4 my-10">
                        <div class="mt-2">
                            <div>
                                <label
                                    class="text-gray-500 text-sm lg:text-sm"
                                    for="name">Ecole</label
                                >
                            </div>
                            <input
                                type="text"
                                bind:value={$form.school}
                                placeholder="exemple: Institut 1"
                                class="border-0 w-full p-1 scrollable text-gray-700 ring-1 focus:ring-orange-600 text-sm lg:text-sm placeholder:text-gray-400 placeholder:text-sm rounded"
                            />
                        </div>
                        <div class="mt-2">
                            <div>
                                <label
                                    class="text-gray-500 text-sm lg:text-sm"
                                    for="name">Domaine</label
                                >
                            </div>
                            <select
                                type="text"
                                bind:value={$form.competence}
                                placeholder="exemple: Institut 1"
                                class="border-0 w-full p-1 scrollable text-gray-700 ring-1 focus:ring-orange-600 text-sm lg:text-sm placeholder:text-gray-400 placeholder:text-sm rounded"
                            >
                                {#each competences as competence}
                                    <option
                                        selected={competence.intitules ==
                                            $form.competence}
                                        value={competence.intitules}
                                        >{competence.intitules}</option
                                    >
                                {/each}
                            </select>
                        </div>
                        <div class="mt-4 grid lg:grid-cols-2 gap-2">
                            <div>
                                <div>
                                    <label
                                        class="text-gray-500 text-sm lg:text-sm"
                                        for="name"
                                        >Niveau
                                    </label>
                                </div>
                                <select
                                    type="text"
                                    bind:value={$form.degree}
                                    placeholder="exemple: Licence"
                                    class="border-0 w-full p-1 scrollable text-gray-700 ring-1 focus:ring-orange-600 text-sm lg:text-sm placeholder:text-gray-400 placeholder:text-sm rounded"
                                >
                                    <option value=""></option>
                                    <option value="BAC">BAC</option>
                                    <option value="BAC+1">BAC+1</option>
                                    <option value="BAC+2">BAC+2</option>
                                    <option value="BAC+3">BAC+3</option>
                                    <option value="BAC+4">BAC+4</option>
                                    <option value="BAC+5">BAC+5</option>
                                    <option value="BAC++">BAC++</option>
                                </select>
                            </div>
                            <div>
                                <div>
                                    <label for="dtae"> Année </label>
                                </div>
                                <div>
                                    <input
                                        type="date"
                                        class="border-0 ring-1 p-1 rounded"
                                        bind:value={$form.date}
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="relative pb-4 my-6">
                        <div class="mt-2">
                            <div>
                                <label
                                    class="text-gray-500 text-sm lg:text-sm"
                                    for="name">Ecole</label
                                >
                            </div>
                            <input
                                type="text"
                                bind:value={$form.school2}
                                placeholder="exemple: Institut 1"
                                class="border-0 w-full p-1 scrollable text-gray-700 ring-1 focus:ring-orange-600 text-sm lg:text-sm placeholder:text-gray-400 placeholder:text-sm rounded"
                            />
                        </div>
                        <div class="mt-2">
                            <div>
                                <label
                                    class="text-gray-500 text-sm lg:text-sm"
                                    for="name">Domaine</label
                                >
                            </div>
                            <select
                                type="text"
                                bind:value={$form.competence2}
                                placeholder="exemple: Institut 2"
                                class="border-0 w-full p-1 scrollable text-gray-700 ring-1 focus:ring-orange-600 text-sm lg:text-sm placeholder:text-gray-400 placeholder:text-sm rounded"
                            >
                                <option value=""></option>
                                {#each competences as competence}
                                    <option
                                        selected={competence.intitules ==
                                            $form.competence2}
                                        value={competence.intitules}
                                        >{competence.intitules}</option
                                    >
                                {/each}
                            </select>
                        </div>
                        <div class="mt-4 grid lg:grid-cols-2 gap-2">
                            <div>
                                <div>
                                    <label
                                        class="text-gray-500 text-sm lg:text-sm"
                                        for="name">Niveau</label
                                    >
                                </div>
                                <select
                                    type="text"
                                    bind:value={$form.degree2}
                                    class="border-0 w-full p-1 scrollable text-gray-700 ring-1 focus:ring-orange-600 text-sm lg:text-sm placeholder:text-gray-400 placeholder:text-sm rounded"
                                >
                                    <option value=""></option>
                                    <option value="BAC">BAC</option>
                                    <option value="BAC+1">BAC+1</option>
                                    <option value="BAC+2">BAC+2</option>
                                    <option value="BAC+3">BAC+3</option>
                                    <option value="BAC+4">BAC+4</option>
                                    <option value="BAC+5">BAC+5</option>
                                    <option value="BAC++">BAC++</option>
                                </select>
                            </div>
                            <div>
                                <div>
                                    <label for="date"> Année </label>
                                </div>
                                <div>
                                    <input
                                        type="date"
                                        class="border-0 ring-1 p-1 rounded"
                                        bind:value={$form.date2}
                                    />
                                </div>
                            </div>
                        </div>

                        {#if !add}
                            <button type="button" on:click={() => (add = true)}
                                ><svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="currentColor"
                                    class="absolute bottom-0 left-0 size-5 fill-indigo-600 hover:fill-indigo-400"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </button>
                        {:else}
                            <button
                                type="button"
                                on:click={() => {
                                    $form.school3 = null;
                                    $form.degree3 = null;
                                    add = false;
                                }}
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="currentColor"
                                    class="absolute bottom-0 left-0 size-5 fill-orange-600 hover:fill-orange-400"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm3 10.5a.75.75 0 0 0 0-1.5H9a.75.75 0 0 0 0 1.5h6Z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </button>
                        {/if}
                    </div>
                    {#if add}
                        <div>
                            <h2 class="text-sm text-gray-500">
                                Formation supplementaire
                            </h2>
                            <div class="pb-4 my-4">
                                <div class="mt-2">
                                    <div>
                                        <label
                                            class="text-gray-500 text-sm lg:text-sm"
                                            for="name">Ecole</label
                                        >
                                    </div>
                                    <input
                                        type="text"
                                        bind:value={$form.school3}
                                        placeholder="exemple: Institut 3"
                                        class="border-0 w-full p-1 scrollable text-gray-700 ring-1 focus:ring-orange-600 text-sm lg:text-sm placeholder:text-gray-400 placeholder:text-sm rounded"
                                    />
                                </div>
                                <div class="mt-2">
                                    <div>
                                        <label
                                            class="text-gray-500 text-sm lg:text-sm"
                                            for="name">Domaine</label
                                        >
                                    </div>
                                    <select
                                        type="text"
                                        bind:value={$form.competence3}
                                        placeholder="exemple: Institut 1"
                                        class="border-0 w-full p-1 scrollable text-gray-700 ring-1 focus:ring-orange-600 text-sm lg:text-sm placeholder:text-gray-400 placeholder:text-sm rounded"
                                    >
                                        <option value=""></option>
                                        {#each competences as competence}
                                            <option
                                                selected={competence.school3 ==
                                                    $form.competence3}
                                                value={competence.intitules}
                                                >{competence.intitules}</option
                                            >
                                        {/each}
                                    </select>
                                </div>
                                <div class="mt-4 grid lg:grid-cols-2 gap-2">
                                    <div>
                                        <div>
                                            <label
                                                class="text-gray-500 text-sm lg:text-sm"
                                                for="name">Niveau</label
                                            >
                                        </div>
                                        <select
                                            type="text"
                                            bind:value={$form.degree3}
                                            class="border-0 w-full p-1 scrollable text-gray-700 ring-1 focus:ring-orange-600 text-sm lg:text-sm placeholder:text-gray-400 placeholder:text-sm rounded"
                                        >
                                            <option value=""></option>
                                            <option value="BAC">BAC</option>
                                            <option value="BAC+1">BAC+1</option>
                                            <option value="BAC+2">BAC+2</option>
                                            <option value="BAC+3">BAC+3</option>
                                            <option value="BAC+4">BAC+4</option>
                                            <option value="BAC+5">BAC+5</option>
                                            <option value="BAC++">BAC++</option>
                                        </select>
                                    </div>
                                    <div>
                                        <div>
                                            <label for="dtae"> Année </label>
                                        </div>
                                        <div>
                                            <input
                                                type="date"
                                                class="border-0 ring-1 p-1 rounded"
                                                bind:value={$form.date3}
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {/if}
                    <div
                        class="flex w-full justify-end items-center bg-white px-2 md:px-4 p-2 mt-8"
                    >
                        <div class="flex">
                            <Link
                                href="/cv"
                                preserveScroll
                                replace
                                as="button"
                                class="bg-red-600 rounded p-1 hover:bg-red-500 text-white me-2"
                                >
                                annuler
                            </Link>

                            <button
                                type="submit"
                                class="btn btn-primary rounded p-1 btn-xs text-white"
                                >suivant</button
                            >
                        </div>
                    </div>
                </div>
            </form>
        </div>
    {:else}
        <div class="flex w-full h-96 justify-center items-center">
            <Spinner/>
        </div>
    {/if}
</div>
