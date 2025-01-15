<script>
    import { get_competences } from "@dependencies/load";
    import { cv_Store } from "@dependencies/Stores/store";
    import toast from "svelte-french-toast";
    import { onMount } from "svelte";
    import Spinner from "@utils/Spinner.svelte";
    import { inertia, useForm } from "@inertiajs/svelte";
    export let competences;

    let competence3 = false;
    let competence4 = false;
    let competence5 = false;
    let loading = true;

    const technical = competences
        ? JSON.parse(competences.technical_competences)
        : null;

    const no_technical = competences
        ? JSON.parse(competences.no_technical_competences)
        : null;

    const form = useForm({
        competence1: technical ? technical[0] : null,
        competence2: technical ? technical[1] : null,
        competence3: technical ? technical[2] : null,
        competence4: technical ? technical[3] : null,
        competence5: technical ? technical[4] : null,
        competence6: no_technical ? no_technical[0] : null,
        competence7: no_technical ? no_technical[1] : null,
        competence8: no_technical ? no_technical[2] : null,
    });

    onMount(async () => {
        let response = await get_competences();

        if (response.status === 200) {
            const datas = await response.data;
            competences = datas.sort((a, b) => {
                return a.name.localeCompare(b.name);
            });
            loading = false;
        }
    });

    const HandleSubmit = () => {
        $form.post("/cv/competence", {
            onSuccess: () => {
                toast.success("SUPER !");
            },
            onError: (error) => {
                toast.error(error);
            },
            preserveScroll: true,
        });
    };
    const add_competence = () => {
        if (competence3 === false) {
            competence3 = true;
        } else if (competence4 === false) {
            competence4 = true;
        } else if (competence5 === false) {
            competence5 = true;
        }
    };

    const remove_competence = () => {
        if (competence5 === true) {
            competence5 = false;
            $form.competence5 = null;
        } else if (competence4 === true) {
            competence4 = false;
            $form.competence4 = null;
        } else if (competence3 === true) {
            competence3 = false;
            $form.competence3 = null;
        }
    };
</script>

{#if !loading}
    <div class="w-full lg:w-1/2 mx-auto bg-white border my-4 p-2 lg:p-4">
        <div class=" my-10">
            <div class="flex justify-center font-bold">
                <h1 class="text-sm md:text-xl xl:text-4xl text-gray-700">
                    Competences
                </h1>
            </div>
            <p class="text-center text-gray-500 text-sm">
                Ces informations seront visibles uniquement pour les recruteurs!
            </p>
            <p class="text-center text-gray-600 text-sm mt-4">
                Veuillez à bien entrer vos competences, pour optimiser la
                recherche d'emploi.
            </p>
        </div>
        <div class="my-10 p-4">
            <form on:submit|preventDefault={HandleSubmit}>
                <div class="my-4">
                    <div class="my-4">
                        <div class="mb-1 flex justify-between items-center">
                            <label for="competence1" class="font-semibold"
                                >Competences techniques</label
                            >
                            <div class="flex">
                                {#if competence3}
                                    <div>
                                        <button
                                            type="button"
                                            class="mx-1 p-1 bg-red-600 text-sm hover:bg-red-500 text-white rounded"
                                            on:click={remove_competence}
                                            >Supprimer</button
                                        >
                                    </div>
                                {/if}
                                {#if !competence5}
                                    <div>
                                        <button
                                            type="button"
                                            class="mx-1 p-1 bg-blue-600 text-sm hover:bg-blue-500 text-white rounded"
                                            on:click={add_competence}
                                            >Ajouter</button
                                        >
                                    </div>
                                {/if}
                            </div>
                        </div>
                        <div class="my-3">
                            <select
                                required
                                placeholder="Travail en equipe"
                                class="border-0 w-full scrollable capitalize p-1.5 text-gray-700 ring-1 focus:ring-orange-600 text-sm lg:text-sm placeholder:text-gray-600 placeholder:text-sm placeholder:capitalize rounded"
                                bind:value={$form.competence1}
                            >
                                <option value=""></option>
                                {#each competences as competence}
                                    <option
                                        selected={$form.competence1 ==
                                            competence.name}
                                        class="capitalize text-sm"
                                        value={competence.name}
                                        >{competence.name}</option
                                    >
                                {/each}
                            </select>
                        </div>
                        <div class="my-3">
                            <select
                                required
                                placeholder="Travail en equipe"
                                class="border-0 w-full scrollable capitalize p-1.5 text-gray-700 ring-1 focus:ring-orange-600 text-sm lg:text-sm placeholder:text-gray-400 placeholder:text-sm placeholder:capitalize rounded"
                                bind:value={$form.competence2}
                            >
                                <option value=""></option>
                                {#each competences as competence}
                                    <option
                                        selected={$form.competence2 ==
                                            competence.name}
                                        class="capitalize text-sm"
                                        value={competence.name}
                                        >{competence.name}</option
                                    >
                                {/each}
                            </select>
                        </div>
                    </div>
                    {#if competence3}
                        <div class="my-3">
                            <select
                                placeholder="Travail en equipe"
                                class="border-0 w-full scrollable capitalize p-1.5 text-gray-700 ring-1 focus:ring-orange-600 text-sm lg:text-sm placeholder:text-gray-400 placeholder:text-sm placeholder:capitalize rounded"
                                bind:value={$form.competence3}
                            >
                                <option value=""></option>
                                {#each competences as competence}
                                    <option
                                        selected={$form.competence3 ==
                                            competence.name}
                                        class="capitalize text-sm"
                                        value={competence.name}
                                        >{competence.name}</option
                                    >
                                {/each}
                            </select>
                        </div>
                    {/if}
                    {#if competence4}
                        <div class="my-4">
                            <input
                                placeholder="laravel"
                                class="border-0 w-full capitalize text-gray-700 ring-1 focus:ring-orange-600 text-sm lg:text-sm placeholder:text-gray-400 placeholder:text-sm placeholder:capitalize rounded"
                                type="text"
                                bind:value={$form.competence4}
                            />
                        </div>
                    {/if}
                    {#if competence5}
                        <div class="my-4">
                            <input
                                placeholder="Python"
                                class="border-0 w-full capitalize text-gray-700 ring-1 focus:ring-orange-600 text-sm lg:text-sm placeholder:text-gray-400 placeholder:text-sm placeholder:capitalize rounded"
                                type="text"
                                bind:value={$form.competence5}
                            />
                        </div>
                    {/if}
                </div>
                <div class="my-10 mt-[5rem]">
                    <div class="my-4">
                        <div class="mb-1 font-semibold">
                            <label for="competence1"
                                >Competences non techniques</label
                            >
                        </div>
                        <div class="my-4">
                            <input
                                placeholder="Travail d'équipe"
                                class="border-0 w-full p-1.5 text-gray-700 ring-1 focus:ring-orange-600 text-sm lg:text-sm placeholder:text-gray-400 placeholder:text-sm placeholder:capitalize rounded"
                                type="text"
                                bind:value={$form.competence6}
                            />
                        </div>
                        <div class="my-4">
                            <input
                                placeholder="Communication"
                                class="border-0 w-full p-1.5 text-gray-700 ring-1 focus:ring-orange-600 text-sm lg:text-sm placeholder:text-gray-400 placeholder:text-sm placeholder:capitalize rounded"
                                type="text"
                                bind:value={$form.competence7}
                            />
                        </div>
                        <div class="my-4">
                            <input
                                placeholder="Flexibilité"
                                class="border-0 w-full p-1.5 text-gray-700 ring-1 focus:ring-orange-600 text-sm lg:text-sm placeholder:text-gray-400 placeholder:text-sm placeholder:capitalize rounded"
                                type="text"
                                bind:value={$form.competence8}
                            />
                        </div>
                    </div>
                </div>
                <div
                    class="flex w-full justify-end items-center bg-white px-2 md:px-4 p-2 mt-8"
                >
                    <div class="flex">
                        <a
                            use:inertia
                            href="/cv"
                            as="button"
                            class="bg-red-600 rounded p-1 hover:bg-red-500 text-white me-2"
                            >Retourner vers mon cv
                        </a>

                        <button
                            type="submit"
                            class="btn btn-primary rounded p-1 btn-sm text-white"
                            >Terminer</button
                        >
                    </div>
                </div>
            </form>
        </div>
    </div>
{:else}
    <div class="flex w-full h-48 justify-center text-gray-600 items-center">
        <Spinner />
    </div>
{/if}
