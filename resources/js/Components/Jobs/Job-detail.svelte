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

<div class="bg-white p-1 md:p-8 mx-auto border">
    <div class="my-1 flex justify-end">
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
    <div
        class="lg:p-4 text-sm md:flex-row flex-col-reverse items-center flex justify-around p-1 rounded border"
    >
        <div class="mt-2 md:mt-0">
            <div
                class="mb-1 ms-2 font-semibold text-sm text-center lg:text-xl"
            >
                {job.enterprise.name}
            </div>
            <div class="capitalize text-sm">
                <p class="text-center">{job.enterprise.country}</p>
                <p class="text-center">{job.enterprise.address}</p>
            </div>
            <div class="flex justify-center items-end mt-4">
                <div class="mb-1">
                    <div class="ms-2">
                        <a
                            class="hover:text-red-400 text-sm"
                            href="https://{job.enterprise.email}"
                            ><img
                                src="/storage/icones/gmail.png"
                                class="w-5"
                                alt=""
                            /></a
                        >
                    </div>
                </div>

                {#if job.enterprise.facebook}
                    <div class="flex mb-1">
                        <div class="ms-2">
                            <a
                                class="hover:text-red-400 text-sm"
                                href="https://{job.enterprise.facebook}"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="feather feather-facebook stroke-none fill-blue-500 w-6"
                                    ><path
                                        d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"
                                    ></path></svg
                                ></a
                            >
                        </div>
                    </div>
                {/if}
                {#if job.enterprise.linkedin}
                    <div class="flex mb-1">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-linkedin bg-blue-500 w-6"
                            ><path
                                d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"
                            ></path><rect x="2" y="9" width="4" height="12"
                            ></rect><circle cx="4" cy="4" r="2"></circle></svg
                        >
                        <div class="ms-2 font-semibold text-sm">
                            {job.enterprise.linkedin}
                        </div>
                    </div>
                {/if}
                {#if job.enterprise.twitter}
                    <div class="flex mb-1">
                        <img
                            src="/storage/icones/twitter.png"
                            class="w-5"
                            alt=""
                        />
                    </div>
                {/if}

                {#if job.enterprise.site}
                    <div class="flex mb-1">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="size-6"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418"
                            />
                        </svg>
                        <div class="ms-2 font-semibold text-sm">
                            <a
                                class="hover:text-red-400 text-sm"
                                href={job.enterprise.site}
                                >{job.enterprise.site}</a
                            >
                        </div>
                    </div>
                {/if}
            </div>
        </div>
        <div class="w-full md:w-40 bg-blue-600 rounded">
            <img
                class="w-full p-1"
                src={job.enterprise.logo}
                alt="enterprise-logo"
            />
        </div>
    </div>

    <div class="my-1 p-2">
        <div class=" my-1 p-2 rounded">
            <div class="my-2">
                <div class="text-gray-700">
                    Poste : <span
                        class="font-semibold text-sm capitalize"
                    >
                        {job.poste}</span
                    >
                </div>
            </div>

            <div class="my-2">
                <div class="text-gray-700">
                    Pays : <span class="font-semibold text-sm capitalize">
                        {job.country}</span
                    >
                </div>
            </div>
            <div class="my-2">
                <div class="text-gray-700">
                    Type de contrat proposé : <span
                        class="font-semibold text-sm uppercase"
                    >
                        {job.type}</span
                    >
                </div>
            </div>
            <div class="my-2">
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
            <div class="my-2">
                <div class="text-gray-700">
                    Experience minimale : <span
                        class="font-semibold text-sm uppercase"
                    >
                        {job.experience}</span
                    >
                    {job.experience > 1 ? "ans" : "an"}
                </div>
            </div>
            <div class="my-2">
                <div class="text-gray-700">
                    Salaire : <span class="font-semibold text-sm">
                        {job.salary} XFA</span
                    >
                </div>
            </div>

            <div class="my-2 mt-6">
                <div class="font-bold p-0 m-0"> Le candidat devra </div>
                <div class="text-gray-700 p-0 m-0">
                    <p
                        class="p-2 text-wrap cursor-pointer hover:text-gray-800"
                    >
                        {job.missions}
                    </p>
                </div>
            </div>

            <div class="my-2 text-sm">
                competences:
                <div class="text-gray-700 flex flex-wrap">
                    {#each JSON.parse(job.competence.competence) as competence}
                        {#if competence}
                            <div
                                class="bg-indigo-600 p-0.5 px-3 capitalize me-1 mt-1 text-white rounded"
                            >
                                <span> {competence}</span>
                            </div>
                        {/if}
                    {/each}
                </div>
            </div>

            {#if !$page.props.auth.isEmployer}
                <div>
                    <div class="flex items-center text-sm justify-end">
                        <button
                            disabled={job.candidacies.length > 0}
                            on:click={handleSendCandidature}
                            class="btn-success btn btn-xs text-white p-1 rounded me-2"
                            >Postuler à cette offre
                        </button>
                    </div>
                </div>
            {/if}
        </div>
    </div>
</div>
