<script>
    import Filter from "@utils/Filter.svelte";
    import Jobs from "@components/Jobs/Jobs.svelte";
    import PaginationNavBar from "@utils/Pagination-NavBar.svelte";
    import { inertia, page } from "@inertiajs/svelte";

    import { beforeUpdate } from "svelte";
    let has_Enterprise = $page.props.enterprise !== null;
    export let data;

    let slide;
    let slidebar;
    let hasSlide = false;
    let search;

    beforeUpdate(() => {
        search =
            new URLSearchParams(window.location.search).get("domain") ??
            new URLSearchParams(window.location.search).get("country") ??
            new URLSearchParams(window.location.search).get("town");
    });

    const slideleft = function () {
        if (!hasSlide) {
            slide = "translate-x-0";
            hasSlide = true;
        } else {
            slide = "translate-x-[-150%]";
            hasSlide = false;
        }
    };
</script>

<main>
    <div class="flex justify-center w-full relative">
        <div class="w-full me-1 lg:w-4/5">
            <div
                class="md:p-4 my-4 bg-white border shadow border-gray-400/80 rounded"
            >
                <div class=" mt-4">
                    <div class="flex justify-between items-center">
                        <div class="flex justify-start text-sm">
                            {#if search}
                                <div
                                    class="flex items-center w-fit text-sm capitalize rounded bg-red-600 text-white p-1"
                                >
                                    {search}

                                    <button>
                                        <a
                                            use:inertia={{
                                                preserveScroll: true,
                                            }}
                                            href="/employer/toutes-mes-offres"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.5"
                                                stroke="currentColor"
                                                class="size-4"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M6 18 18 6M6 6l12 12"
                                                />
                                            </svg>
                                        </a>
                                    </button>
                                </div>
                            {/if}
                        </div>
                        {#if $page.props.auth.enterprise}
                            <a
                                class="flex justify-end"
                                use:inertia
                                href="/employer/creer-une-offre"
                            >
                                <button
                                    class="btn btn-sm btn-neutral text-white flex items-center border-0 hover:ring-1 rounded p-1"
                                    disabled={!has_Enterprise}
                                >
                                    Créer une offre
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="size-4"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M12 4.5v15m7.5-7.5h-15"
                                        />
                                    </svg>
                                </button>
                            </a>
                        {:else}
                            <div class="flex items-center">
                                <button
                                    class="ms-2 btn btn-primary shadow btn-base rounded text-white "
                                    ><a
                                        use:inertia class="flex items-center"
                                        href="/my-enterprise/creer-une-entreprise"
                                    >
                                        Vous devez créer votre entreprise
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                            class="size-6 ms-1"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"
                                            />
                                        </svg>
                                    </a></button
                                >
                            </div>
                        {/if}
                    </div>
                </div>
                <div
                    class=" mt- mb-1 flex text-sm items-end text-gray-700 font-semibold"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="size-5 stroke-1"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z"
                        />
                    </svg>
                    Toutes les offres d'emploi
                </div>
                <Filter />

                {#if data.data.length > 0}
                    <table
                        class="w-full font-light min-h-24 text-sm px-2 rounded mt-8"
                    >
                        <tr class="font-semibold text-gray-700">
                            <td>#</td>
                            <td>poste</td>
                            <td>effectif</td>
                            <td>pays</td>
                            <td>date limite</td>
                            <td>actions</td>
                        </tr>
                        {#each data.data as job, i}
                            <Jobs {job} {i} />
                        {/each}
                    </table>
                    <PaginationNavBar datas={data} />
                {:else}
                    <div
                        class="flex h-96 w-full justify-center items-center text-gray-600/70 text-xl"
                    >
                        Vous n'avez aucune offre enregistrée
                    </div>
                {/if}
            </div>
        </div>
    </div>
</main>
