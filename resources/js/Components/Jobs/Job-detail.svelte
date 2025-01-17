<script>
    import { router, useForm, inertia, page } from "@inertiajs/svelte";
    import {
        format_date_anglo_to_french,
        compareDate,
        getFullDate,
    } from "@dependencies/utilities.js";
    import {
        candidatureModalComponent,
        entretienModalComponent,
    } from "@dependencies/Stores/Modal";
    import toast from "svelte-french-toast";
    import axios from "axios";
    import { onMount } from "svelte";
    export let job;
    let job_id;

    let cv_error = false;

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
        if (!$page.props.auth.user.cv) {
            cv_error = true;
            return false;
        }
        $form.post(`/candidature/postulez`, {
            preserveScroll: true,
            onSuccess: () => {
                toast.success("Candidature envoyée");
            },
            onError: (error) => {
                if (error.alreadyApply) {
                    toast.error("Votre candidature est déja en examen !");
                }
            },
        });
    };
</script>

{#if !$page.props.auth.isEmployer && cv_error}
    <div
        class="fixed top-0 left-0 bg-yellow-100 rounded p-1 shadow border border-yellow-200/70 m-3"
    >
        <div class="flex justify-end items-center">
            <button on::click={() => (cv_error = false)}>
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="size-4 stroke-yellow-600 stroke-2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6 18 18 6M6 6l12 12"
                    />
                </svg>
            </button>
        </div>
        <div class="p-3">
            <h1 class="flex items-center text-base text-yellow-700 mb-1">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="size-5 me-1"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"
                    />
                </svg>

                Impossible de postuler sans cv
            </h1>
            <div class="text-yellow-500 text-sm">
                <button
                    class="btn bg-yellow-700 hover:bg-yellow-500 hover:border btn-sm p-1 w-full px-5 rounded text-white"
                    ><a use:inertia href="/cv">Cliquer ici !</a></button
                >
            </div>
        </div>
    </div>
{/if}

<div>
    <div class="my-1 flex w-full justify-end">
        {#if $page.props.auth.isEmployer}
            <div class="mt-1">
                <a use:inertia href="/employer/edit/jobs/{job.id}">
                    <button
                        type="button"
                        class="btn btn-primary text-white btn-sm 2xl:text-sm rounded flex items-center"
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
                        class="flex items-center btn btn-sm 2xl:text-sm btn-error text-white hover:text-white mx-2 rounded"
                        >Supprimer
                    </button>
                </form>
            </div>
        {/if}
    </div>

    <div class="max-w-5xl mx-auto p-6">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">
                Titre du poste
            </h1>
            <p class="text-gray-600 mb-2">
                <span class="font-semibold">Entreprise :</span>
                {job.enterprise.name}
            </p>
            <p class="text-gray-600 mb-2">
                <span class="font-semibold">Lieu :</span>
                {job.country}
            </p>
            <p class="text-gray-600 mb-4">
                <span class="font-semibold">Date de publication :</span>
                {getFullDate(job.created_at)}
            </p>
            <div class="mb-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-2">
                    Description du poste
                </h2>
                <p class="text-gray-700 leading-relaxed">
                    {job.missions}
                </p>
            </div>
            <div class="mb-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-2">
                    Compétences requises
                </h2>
                <ul class="list-disc list-inside text-gray-700">
                    {#each JSON.parse(job.competence.competence) as competence}
                        {#if competence}
                            <li>{competence}</li>
                        {/if}
                    {/each}
                </ul>
            </div>
            <div class="mb-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-2">
                    Conditions
                </h2>
                <p class="text-gray-700 leading-relaxed">
                    Contrat : {job.type}<br />
                    Salaire : {job.salary} XFA/ mois
                </p>
            </div>
            <div class="flex space-x-4">
                <button
                    disabled={job.candidacies.find((element) => {
                        if ($page.props.auth.user.cv) {
                            return (
                                $page.props.auth.user.cv.id === element.cv_id
                            );
                        }
                    })
                        ? true
                        : false}
                    on:click={handleSendCandidature}
                    class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700"
                >
                    Postuler maintenant
                </button>
                <a use:inertia href="/enterprise/{job.enterprise.id}">
                    <button
                        class="bg-gray-300 text-gray-800 px-4 py-2 rounded shadow hover:bg-gray-400"
                    >
                        Voir l'entreprise
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>
