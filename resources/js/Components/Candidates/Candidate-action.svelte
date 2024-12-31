<script>
    import { router, inertia, page } from "@inertiajs/svelte";
    import toast from "svelte-french-toast";
    import { entretiens_store } from "@dependencies/Stores/Store";
    import { jobs_store } from "@dependencies/Stores/Store";
    import CreateEntretien from "@components/Create-entretien.svelte";
    import axios from "axios";
    export let candidacy;
    export let job;
    let showEntretien = false;
    let isLoading = false;
    entretiens_store.set($page.props.auth.entretiens);

    const rejected = async () => {
        isLoading = true;
        const response = await axios.patch(
            `/candidatures/rejected/${candidacy.id}`,
        );

        if (response.status === 200) {
            let values, index;
            toast.success("Candidature rejété !");
            jobs_store.update((jobs) => {
                jobs.forEach((job) => {
                    index = job.candidacies.findIndex((value) => {
                        return value.id === candidacy.id;
                    });
                    if (index !== -1) {
                        job.candidacies[index].status = "rejected";
                    }
                });
                return jobs;
            });
            entretiens_store.set([...$entretiens_store, response.data]);
            console.log($entretiens_store);
        } else {
            toast.error("Une errerur est survenue ,veuillez reesayez");
        }

        isLoading = false;
    };

    const toogleEntretien = () => {
        showEntretien = true;
    };

    const archive = (candidacy) => {
        router.post(
            "/archive",
            { candidacy: candidacy },
            {
                onStart: () => (isProgress = true),
                onFinish: () => (isProgress = false),
            },
        );
    };
</script>

<div class="flex justify-start items-center">
    {#if candidacy.status !== "rejected"}
        {#if Array.isArray($entretiens_store)}
            {#if !$entretiens_store.some((entretien) => entretien.candidacy.cv.id === candidacy.cv_id)}
                <div>
                    <button
                        on:click={toogleEntretien}
                        class="items-center btn btn-primary font-light rounded btn-xs text-white"
                    >
                        Créer entretien</button
                    >
                </div>

                <button
                    on:click={rejected}
                    disabled={isLoading}
                    class="flex items-center ms-2 font-thin text-white btn btn-error btn-xs rounded"
                >
                    Rejeter
                </button>
            {:else}
                <div>
                    <button class="font-bold btn-xs text-gray-600 rounded">
                        <a
                            use:inertia
                            href="/mes-entretiens?entretien={$entretiens_store.find(
                                (entretien) =>
                                    entretien.candidacy.cv.id ===
                                    candidacy.cv_id,
                            ).id}"
                            class="w-full flex items-center"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="size-5 ms-0.5"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z"
                                />
                            </svg>
                        </a></button
                    >
                </div>
                {#if true}
                    <button
                        disabled
                        class="flex items-center ms-2 font-thin text-white btn btn-error btn-xs rounded"
                    >
                        Entretien prevu
                    </button>
                {/if}
            {/if}
        {/if}
    {:else}
        Aucune
    {/if}
</div>

{#if showEntretien}
    <div>
        <div
            class="fixed w-full z-30 bottom-0 left-0 flex justify-end items-end"
        >
            <CreateEntretien
                {candidacy}
                {job}
                on:click={() => (showEntretien = false)}
            />
        </div>
    </div>
{/if}
