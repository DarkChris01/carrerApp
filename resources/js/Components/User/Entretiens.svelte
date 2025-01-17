<script>
    import { get_user_entretiens } from "@dependencies/load";
    import { format_date_anglo_to_french } from "@dependencies/utilities";
    import { onMount, onDestroy } from "svelte";
    import { inertia } from "@inertiajs/svelte";
    import Spinner from "@utils/Spinner.svelte";
    import { entretienModalComponent } from "@dependencies/Stores/Modal";
    let isLoading = true;
    let entretiens = [];

    onMount(async () => {
        const response = await get_user_entretiens();
        if (response.status === 200) {
            entretiens = response.data;
            isLoading = false;
        }
    });
</script>

<main
    class="fixed lg:absolute overflow-y-auto scrollable bg-white select-none w-full h-screen lg:w-[30rem] 2xl:w-[35rem] lg:h-[35rem] 2xl:h-[50rem] border border-gray-400/20 rounded z-10 flex shadow right-0 lg:right-2 top-0 lg:top-10"
>
    <div class="text-sm lg:text-sm w-full p-2 text-gray-600">
        {#if !isLoading}
            <div class="flex justify-between">
                <button
                    class="lg:hidden"
                    on:click={() => {
                        entretienModalComponent.set(false);
                    }}
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="size-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 18 18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>
            {#each entretiens as entretien}
                <div class="my-6 p-2">
                    <div class="flex text-start items-start">
                        <div class="bg-blue-600 w-fit me-2 p-2 rounded">
                            <img
                                src={entretien.job.enterprise.logo}
                                class="w-14 h-14"
                                alt="logo"
                            />
                        </div>
                        <div>
                            <div class="font-bold text-gray-500 text-sm">
                                {entretien.job.enterprise.name}
                            </div>

                            <div>
                                <span class="capitalize text-red-600">
                                    {entretien.job.poste}
                                </span>
                            </div>

                            <div class="font-semibold">
                                {format_date_anglo_to_french(
                                    new Date(entretien.date),
                                )} à {entretien.time}
                            </div>

                            <div>
                                <span class="font-semibold">
                                    {entretien.lieu}</span
                                >
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-2">
                        <div class="flex justify-end items-center">
                            <div>
                                <span class=" font-semibold text-gray-700"
                                    >{entretien.status === "pending"
                                        ? "En attente"
                                        : entretien.status === "rejected"
                                          ? "Rejete"
                                          : entretien.status === "process"
                                            ? "En examen"
                                            : "Recruté"}</span
                                >
                            </div>
                        </div>

                        <div>
                            {#if entretien.status === "pending"}
                                <button
                                    class="ms-2 btn text-white btn-success btn-xs rounded"
                                >
                                    <a
                                        use:inertia={{
                                            method: "patch",
                                            data: {
                                                entretien: entretien.id,
                                            },
                                        }}
                                        href="/entretien/agree/{entretien.id}"
                                    >
                                        Accepter</a
                                    ></button
                                >

                                <button
                                    type="button"
                                    class="me-2 btn text-white btn-error btn-xs rounded"
                                >
                                    <a
                                        use:inertia={{
                                            method: "patch",
                                            data: { entretien: entretien.id },
                                        }}
                                        href="/entretien/disgree/{entretien.id}"
                                    >
                                        Refuser
                                    </a>
                                </button>
                            {/if}
                        </div>
                    </div>
                </div>
            {:else}
             
                <div class="h-full font-light flex justify-center items-center">
                    Vous n'avez pas d'entretien
                    
                </div>
            {/each}
        {:else}
            <div class="flex w-full h-full justify-center items-center">
                <Spinner />
            </div>
        {/if}
    </div>
</main>
