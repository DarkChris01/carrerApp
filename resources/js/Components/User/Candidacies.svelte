<script>
    import { get_user_candidacies } from "@dependencies/load";
    import Spinner from "@utils/Spinner.svelte";
    import { candidacies_store } from "@dependencies/Stores/Store";
    import { onMount, onDestroy } from "svelte";
    import { inertia, router } from "@inertiajs/svelte";
    import { candidatureModalComponent } from "@dependencies/Stores/Modal";
    let candidacies = [];
    let isLoading = true;
    let isProgress = false;

    onMount(async () => {
        const response = await get_user_candidacies();
        if (response.status === 200) {
            candidacies_store.set(response.data);
            isLoading = false;
        }
        document.body.style.overflow = "hidden";
    });

    onDestroy(() => {
        document.body.style.overflow = "";
    });

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

<!-- svelte-ignore a11y-click-events-have-key-events -->
<!-- svelte-ignore a11y-no-noninteractive-element-interactions -->
<main
    class="z-20 fixed lg:absolute w-full h-screen lg:w-[30rem] 2xl:w-[35rem] shadow overflow-y-auto scrollable bg-white lg:h-[35rem] 2xl:h-[50rem] border border-gray-400/20 rounded right-0 lg:right-4 top-0 lg:top-full"
>
    <div class="w-full h-full text-sm p-2 text-gray-500">
        {#if !isLoading}
            <button
                class="lg:hidden mb-8"
                on:click={() => {
                    candidatureModalComponent.set(false);
                }}
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="size-5 stroke-2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6 18 18 6M6 6l12 12"
                    />
                </svg>
            </button>

            {#each $candidacies_store as candidacy}
                <div class="p-1 my-4 border rounded">
                    <div class="flex text-start items-start">
                        <div class="bg-blue-600 w-fit me-2 p-2 rounded">
                            <img
                                src={candidacy.job.enterprise.logo}
                                class="w-10 h-10"
                                alt="logo"
                            />
                        </div>
                        <div>
                            <div class="font-bold">
                                {candidacy.job.enterprise.name}
                            </div>

                            <div class="text-red-600">
                                {candidacy.job.poste.toLowerCase()}
                            </div>
                        </div>
                    </div>
                    <div class="flex mt-3 capitalize justify-between items-end">
                        <div class="font-bold block">
                            {candidacy.status === "pending"
                                ? "en attente"
                                : candidacy.status === "rejected"
                                  ? "rejétée"
                                  : "acceptée"}
                        </div>
                        <div class="flex capitalize">
                            <button
                                class="me-2 btn text-white btn-success btn-xs xl:btn-xs rounded"
                            >
                                <a
                                    use:inertia
                                    href="/job/mon-offre/{candidacy.job.id}"
                                >
                                    voir l'offre</a
                                ></button
                            >

                            {#if candidacy.status == "pending"}
                                <button
                                    type="button"
                                    class="me-2 btn text-white btn-error btn-xs xl:btn-xs rounded"
                                >
                                    <a
                                        use:inertia={{ method: "delete" }}
                                        href="/candidature/{candidacy.id}"
                                    >
                                        supprimer
                                    </a>
                                </button>
                            {:else}
                                <form
                                    on:submit|preventDefault={archive(
                                        candidacy.id,
                                    )}
                                >
                                    <button
                                        disabled={isProgress}
                                        type="sumbit"
                                        class="me-2 btn text-white btn-info btn-xs xl:btn-xs rounded"
                                    >
                                        archiver
                                    </button>
                                </form>
                            {/if}
                        </div>
                    </div>
                </div>
            {:else}
                <div class="h-full font-light flex justify-center items-center">
                    Vous n'avez pas de demande en cours
                </div>
            {/each}
        {:else}
            <div class="flex w-full h-full justify-center items-center">
                <Spinner />
            </div>
        {/if}
    </div>
</main>
