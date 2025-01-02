<script>
    import { router, useForm, inertia, page } from "@inertiajs/svelte";
    import {
        candidatureModalComponent,
        entretienModalComponent,
    } from "@dependencies/Stores/Modal";
    import toast from "svelte-french-toast";
    import axios from "axios";
    import { onMount } from "svelte";
    export let job;
    let job_id;
console.log(job.enterprise);

    $: form = useForm({
        job: job.id,
    });

    $: if ($page.props) {
        candidatureModalComponent.set(false);
        entretienModalComponent.set(false);
    }

    const handleDelete = () => {
        $form.delete("/employer/job", {
            onSuccess: () => {
                toast.success("Offre supprimée");
            },
            onError: (error) => {
                toast.error(error);
            },
        });
    };

    const handleSendCandidature = () => {
        $form.post(`/candidature/postulez`, {
            preserveScroll: true,
            onSuccess: () => {
                toast.success("Candidature envoyée");
            },
            onError: (error) => {
                if (error.dejaCandidate) {
                    toast.error("Votre candidature est déja en examen !");
                }
            },
        });
    };
</script>

{#if !$page.props.auth.isEmployer && $page.props.errors.cv_error}
    <div
        class="fixed top-0 left-0 bg-red-100 rounded p-4 shadow border border-red-400 m-3"
    >
        <div class="text-red-600 text-[15px] flex items-center">
            Commencer par créer votre Cv
            <button
                class="ms-2 btn bg-indigo-600 hover:bg-indigo-500 hover:border btn-xs p-1 px-5 rounded text-white"
                ><a use:inertia href="/cv">Cliquer ici !</a></button
            >
        </div>
    </div>
{/if}

<div class="w-full bg-white p-1 md:p-2 mx-auto border">
    <div class="my-1 flex w-full justify-end">
        {#if $page.props.auth.isEmployer}
            <div class="mt-1">
                <a use:inertia href="/employer/edit/jobs/{job.id}">
                    <button
                        type="button"
                        class="btn btn-primary text-white btn-xs rounded flex items-center"
                    >
                        modifier</button
                    >
                </a>
            </div>
            <div class="mt-1">
                <form on:submit|preventDefault={handleDelete}>
                    <button
                        disabled={$form.processing}
                        type="submit"
                        class="flex items-center btn btn-xs btn-error text-white hover:text-white mx-2 rounded"
                        >Supprimer
                    </button>
                </form>
            </div>
        {/if}
    </div>

    <div class="my-1 p-2">
        <div class=" my-1 p-2 rounded">
            <div class="my-1">
                <div class="text-gray-700">
                    Poste : <span class="font-semibold text-sm capitalize">
                        {job.poste}</span
                    >
                </div>
            </div>

            <div class="my-1">
                <div class="text-gray-700">
                    Pays : <span class="font-semibold text-sm capitalize">
                        {job.country}</span
                    >
                </div>
            </div>
            <div class="my-1">
                <div class="text-gray-700">
                    Type de contrat proposé : <span
                        class="font-semibold text-sm uppercase"
                    >
                        {job.type}</span
                    >
                </div>
            </div>
            <div class="my-1">
                <div class="text-gray-700">
                    Formation minimale réquise : <span
                        class="font-semibold text-sm"
                    >
                        {#if job.formations === "bac++"}
                            Bac+5 et plus
                        {:else}
                            <!-- else content here -->
                            {job.formation}
                        {/if}
                    </span>
                </div>
            </div>
            <div class="my-1">
                <div class="text-gray-700">
                    Experience minimale : <span
                        class="font-semibold text-sm uppercase"
                    >
                        {job.experience}</span
                    >
                    {job.experience > 1 ? "ans" : "an"}
                </div>
            </div>
            <div class="my-1">
                <div class="text-gray-700">
                    Salaire : <span class="font-semibold text-sm">
                        {job.salary} XFA</span
                    >
                </div>
            </div>

            <div class="my-2 mt-6">
                <div class="font-bold text-gray-500/70 border-b p-0 m-0">Votre mission sera </div>
                <div class="text-gray-700 p-0 m-0">
                    <p class="my-2 text-wrap cursor-pointer hover:text-gray-800">
                        {job.missions}
                    </p>
                </div>
            </div>

            <div class="my-2 mt-6">
                <div class="text-gray-600/60">

                    competences:
                </div>
                <div class="text-gray-700 flex flex-wrap">
                    {#each JSON.parse(job.competence.competence) as competence}
                        {#if competence}
                            <div
                                class="bg-indigo-600 p-0.5 text-sm px-3 capitalize me-1 mt-1 text-white rounded"
                            >
                                <span> {competence}</span>
                            </div>
                        {/if}
                    {/each}
                </div>
            </div>

            <div>
                <div class="flex items-center text-sm justify-end">
                    {#if !$page.props.auth.isEmployer}
                        <button
                            disabled={job.candidacies.length > 0}
                            on:click={handleSendCandidature}
                            class="btn-success btn btn-xs text-white p-1 rounded me-2"
                            >Postuler à cette offre
                        </button>
                    {/if}
                    <a use:inertia href="/enterprise/{job.enterprise.id}">
                        <button
                            on:click={handleSendCandidature}
                            class="btn-error btn btn-xs text-white p-1 rounded me-2"
                            >Voir entreprise
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
