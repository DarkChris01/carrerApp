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
            console.log(response.data);
            
            entretiens = response.data;
            isLoading = false;
        }
        document.body.style.overflow = "hidden";
    });
    onDestroy(() => {
        document.body.style.overflow = "";
    });
</script>

<main
    class="fixed lg:absolute overflow-y-auto scrollable bg-white select-none w-full h-screen lg:w-[30rem] 2xl:w-[35rem] lg:h-[30rem] 2xl:h-[50rem] border border-gray-400/20 rounded z-10 flex shadow right-0 lg:right-2 top-0 lg:top-full"
>
    <div class="text-sm lg:text-sm font-semibold w-full p-2 lg:p-2 text-gray-500">
        {#if !isLoading}
            <div class="flex justify-between mt-2 mb-4">
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
                <div class="p-2 my-2">
                    <div class="flex text-start items-start">
                        <div class="bg-blue-600 w-fit me-2 p-2 rounded">
                            <img
                                src={entretien.job.enterprise.logo}
                                class="w-16 h-16"
                                alt="logo"
                            />
                        </div>
                        <div>
                            <div class="text-sm lg:text-sm">
                                {entretien.job.enterprise.name}
                            </div>

                            <div>
                                Poste: <span class="capitalize text-orange-600">
                                    {entretien.job.poste}
                                </span>
                            </div>

                            <div>
                                Prevu le: {format_date_anglo_to_french(
                                    new Date(entretien.date),
                                )} à {entretien.time}
                            </div>

                            <div>
                                Lieu: <span class="text-orange-600">
                                    {entretien.lieu}</span
                                >
                            </div>
                        </div>
                    </div>
                    <div class="flex items-end justify-between mt-2">
                        <div class="flex justify-end items-center">
                            <div>
                                Status: <span class=" underline text-orange-600"
                                    >{entretien.status === "pending"
                                        ? "En attente"
                                        : entretien.status === "rejected"
                                          ? "REJETE"
                                          : "OK"}</span
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
                                        accepter</a
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
                                        refuser
                                    </a>
                                </button>
                            {/if}
                        </div>
                    </div>
                </div>
            {:else}
                <div class="flex h-48 font-bold text-sm text-gray-400/80 justify-center items-center">
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
