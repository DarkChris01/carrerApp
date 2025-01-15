<script setup>
    import Filter from "@utils/Filter.svelte";
    import Cvs from "@components/Cv/Cvs.svelte";
    import { inertia } from "@inertiajs/svelte";
    import MostsCvs from "@components/Cv/Mosts_cvs.svelte";
    import PaginationNavBar from "@utils/Pagination-NavBar.svelte";
    import { beforeUpdate } from "svelte";
    export let datas;
    let search;

    beforeUpdate(() => {
        if (new URLSearchParams(window.location.search).get("domain")) {
            search = new URLSearchParams(window.location.search).get("domain");
        } else if (new URLSearchParams(window.location.search).get("country")) {
            search = new URLSearchParams(window.location.search).get("country");
        } else {
            search = new URLSearchParams(window.location.search).get("town");
        }
    });
</script>

<main class="w-full font-thin relative mt-1 mb-6">
    <div>
        <div class="flex justify-center">
            <div class="w-full pe-1 md:w-3/4">
                <!-- {#if $page.props.auth.user.isVip} -->
                <div class="bg-white md:p-2 border border-gray-600/30 my-10">
                    <div>
                        <MostsCvs />
                    </div>
                </div>
                <!-- {/if} -->

                <div
                    class="mt-2 p-4 lg:p-6 border rounded bg-white shadow border-gray-600/30"
                >
                    <div class="flex justify-start items-center text-sm my-1">
                        {#if search}
                            <div
                                class="flex items-center w-fit capitalize rounded bg-red-600 text-white p-0.5 px-1 "
                            >
                                {search}

                                <button class="ms-1">
                                    <a
                                        use:inertia={{ preserveScroll: true }}
                                        href="/cvtheque"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                            class="size-3 lg:size-4 stroke-2"
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
                    <div class="mb-2 min-h-48 lg:p-4">
                        <div class="flex content-center">
                            <p
                                class="flex items-center text-gray-800 text-sm font-bold mb-1 p-0"
                            >
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
                                    class="feather feather-file-text size-4 me-1 stroke-1"
                                    ><path
                                        d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"
                                    ></path><polyline points="14 2 14 8 20 8"
                                    ></polyline><line
                                        x1="16"
                                        y1="13"
                                        x2="8"
                                        y2="13"
                                    ></line><line x1="16" y1="17" x2="8" y2="17"
                                    ></line><polyline points="10 9 9 9 8 9"
                                    ></polyline></svg
                                >

                                Cvtheque
                            </p>
                        </div>
                        <Filter />
                        <table
                            class="w-full font-light text-sm min-h-32 px-2 mt-4 rounded text-gray-600"
                        >
                        <tr class="text-sm lg:text-sm ">
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Domaine</th>
                            <th></th>
                        </tr>
                            {#each datas.data as cv, i}
                                <Cvs {cv} {i} />
                            {:else}
                                <div
                                    class="flex justify-center items-center w-full h-48 text-sm text-gray-500/80"
                                >
                                    <!--  -->
                                </div>
                            {/each}
                        </table>
                    </div>
                    <PaginationNavBar {datas} />
                </div>
            </div>
        </div>
    </div>
</main>