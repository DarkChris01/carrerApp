<script>
    import { router, useForm, inertia, page } from "@inertiajs/svelte";
    import {
        format_date_anglo_to_french,
        compareDate,
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

<div class="w-full bg-white p-1 md:p-2 mx-auto border">
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

    <div class="my-1 p-2">
        <div class=" my-1 p-2 rounded">
            <div class="my-1">
                <div class="text-gray-800">
                    Entreprise : <span
                        class="font-semibold 2xl:text-base text-sm capitalize"
                    >
                        {job.enterprise.name}</span
                    >
                </div>
            </div>
            <div class="my-1">
                <div class="text-gray-800">
                    Poste : <span
                        class="font-semibold 2xl:text-base text-sm capitalize"
                    >
                        {job.poste}</span
                    >
                </div>
            </div>

            <div class="my-1">
                <div class="text-gray-800">
                    Pays : <span
                        class="font-semibold 2xl:text-base text-sm capitalize"
                    >
                        {job.country}</span
                    >
                </div>
            </div>
            <div class="my-1">
                <div class="text-gray-800">
                    Type de contrat proposé : <span
                        class="font-semibold 2xl:text-base text-sm uppercase"
                    >
                        {job.type}</span
                    >
                </div>
            </div>
            <div class="my-1">
                <div class="text-gray-800">
                    Formation minimale réquise : <span
                        class="font-semibold 2xl:text-base text-sm"
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
                <div class="text-gray-800">
                    Experience minimale : <span
                        class="font-semibold 2xl:text-base text-sm uppercase"
                    >
                        {job.experience}</span
                    >
                    {job.experience > 1 ? "ans" : "an"}
                </div>
            </div>
            <div class="my-1">
                <div class="text-gray-800">
                    Salaire : <span class="font-semibold 2xl:text-base text-sm">
                        {job.salary} XFA</span
                    >
                </div>
            </div>

            <div class="bg-indigo-600 w-fit text-white rounded p-1 text-sm">
                {compareDate(job.expired_at) < 0
                    ? "A expiré le " +
                      format_date_anglo_to_french(new Date(job.expired_at))
                    : "expire le " +
                      format_date_anglo_to_french(new Date(job.expired_at))}
            </div>

            <div class="my-6">
                <div class="font-bold text-gray-500/70 border-b p-0 m-0">
                    Votre mission sera
                </div>
                <div class="text-base text-gray-800 p-0 m-0">
                    <p
                        class="my-2 text-wrap cursor-pointer hover:text-gray-800"
                    >
                        {job.missions}
                    </p>
                </div>
            </div>

            <div class="my-2 mt-6">
                <div class="text-gray-600/60">competences:</div>
                <div class="text-gray-800 flex flex-wrap">
                    {#each JSON.parse(job.competence.competence) as competence}
                        {#if competence}
                            <div
                                class="bg-indigo-600 p-0.5 2xl:text-base text-sm px-3 capitalize me-1 mt-1 text-white rounded"
                            >
                                <span> {competence}</span>
                            </div>
                        {/if}
                    {/each}
                </div>
            </div>

            <div>
                <div
                    class="flex items-center 2xl:text-base text-sm justify-end"
                >
                    {#if !$page.props.auth.isEmployer}
                        <button
                            disabled={job.candidacies.find((element) => {
                                if ($page.props.auth.user.cv) {
                                    return (
                                        $page.props.auth.user.cv.id ===
                                        element.cv_id
                                    );
                                }
                            })
                                ? true
                                : false}
                            on:click={handleSendCandidature}
                            class="btn-success btn btn-sm 2xl:btn-sm text-white p-1 rounded me-2"
                            >Postuler à cette offre
                        </button>
                        <a use:inertia href="/enterprise/{job.enterprise.id}">
                            <button
                                on:click={handleSendCandidature}
                                class="btn-error btn btn-sm 2xl:btn-sm text-white p-1 rounded me-2"
                                >Voir l'entreprise
                            </button>
                        </a>
                    {/if}
                </div>
            </div>
        </div>
    </div>
</div>
