<script>
    import { onMount } from "svelte";
    import { router, page, inertia } from "@inertiajs/svelte";
    import { load_country, get_all_enterprises } from "@dependencies/load";
    import AutoComplete from "@utils/AutoComplete.svelte";
    import { autocomplete } from "@dependencies/utilities";
    import Tooltip from "@utils/Tooltip.svelte";
    import {
        leftSideBarComponent,
        entretienModalComponent,
        autoCompletionModalComponent,
        candidatureModalComponent,
        notificationModalComponent,
    } from "@dependencies/Stores/Modal";
    import LeftSideBar from "./Left-side-bar.svelte";
    import LoadingSpinner from "@/Utils/Loading-spinner.svelte";
    let countries = [];
    let enterprises = [];
    let isLoading = true;
    let country_params;
    let enterprise_params;
    let searchValue = null;
    let domains;
    let loading = true;
    let is_empty = false;

    $: if ($page.props) {
        country_params = new URLSearchParams(
            new URL(window.location.href).search,
        ).get("country");

        enterprise_params = new URLSearchParams(
            new URL(window.location.href).search,
        ).get("enterprise");

        autoCompletionModalComponent.set(false);
    }

    onMount(async () => {
        const response = await load_country();
        const _response = await get_all_enterprises();
        if (response.status === 200) {
            const result = await response.data;
            countries = result.sort((a, b) => {
                return a.name.common.localeCompare(b.name.common);
            });
            isLoading = false;
        }
        if (_response.status === 200) {
            const __result = await _response.data;
            enterprises = __result.sort((a, b) => {
                return a.name.localeCompare(b.name);
            });
        }
    });
    const select_by_country = (target) => {
        if (target) {
            router.get("/?country=" + target.toLowerCase());
        } else {
            router.get("/");
        }
    };
    const select_by_enterprise = (target) => {
        if (target) {
            router.get("/?enterprise=" + target.toLowerCase());
        } else {
            router.get("/");
        }
    };

    const search = () => {
        if (searchValue) {
            router.get(`?search=${searchValue}`);
        } else {
            is_empty = true;
        }
    };

    const showLeftSideBar = () => {
        $leftSideBarComponent = !$leftSideBarComponent;
    };

    const autoComplete = async () => {
        if (searchValue.length > 2) {
            autoCompletionModalComponent.set(true);
            loading = true;
            let url = "/domain/autocompletion";
            const response = await autocomplete(searchValue, url);
            if (response.status === 200) {
                domains = response.data.sort((a, b) => {
                    return a.intitules.localeCompare(b.intitules);
                });
                loading = false;
            }
        } else {
            autoCompletionModalComponent.set(false);
        }
    };

    const resetAllModal = () => {
        entretienModalComponent.set(false);
        candidatureModalComponent.set(false);
        notificationModalComponent.set(false);
        autoCompletionModalComponent.set(false);
    };
</script>

<div
    class="md:flex w-full justify-between items-center my-2 bg-white p-2 border border-gray-400/40 rounded"
>
    <div class="flex items-center ring-indigo-300 border-b">
        <div class="relative flex justify-start items-center w-full">
            <button
                on:click={search}
                type="button"
                class="bg-gray-800 py-1 rounded h-full"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="size-5 mx-2 stroke-white stroke-2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"
                    />
                </svg>
                {#if is_empty}
                    <Tooltip message="Remplissez le champ" />
                {/if}
            </button>

            <input
                type="text"
                placeholder="search"
                on:focus={resetAllModal}
                bind:value={searchValue}
                on:keyup={autoComplete}
                class="border-none w-full placeholder:text-sm text-gray-500/80 placeholder:text-gray-600/30 focus:ring-0"
            />
            {#if !loading && $autoCompletionModalComponent && domains.length > 0}
                <div
                    class="absolute z-50 top-full text-xs left-0 shadow border w-max bg-white p-2"
                >
                    <ul>
                        {#each domains as domain}
                            <AutoComplete word={domain} />
                        {/each}
                    </ul>
                </div>
            {/if}
        </div>
    </div>
    <div>
        <div class="flex justify-center">
            <button on:click={showLeftSideBar} class="lg:hidden">
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
                    class="feather size-5 stroke-gray-500 feather-menu"
                    ><line x1="3" y1="12" x2="21" y2="12"></line><line
                        x1="3"
                        y1="6"
                        x2="21"
                        y2="6"
                    ></line><line x1="3" y1="18" x2="21" y2="18"></line></svg
                >
            </button>
            {#if !isLoading}
                <select
                    on:change={(e) => select_by_enterprise(e.target.value)}
                    class="rounded m-2 py-1 text-sm text-gray-600  scrollable ring-1 ring-gray-200 hover:ring-orange-500 border-0"
                >
                    <option value="">Choisissez une entreprise</option>
                    {#each enterprises as enterprise}
                        <option
                            value={enterprise.id}
                            selected={enterprise_params
                                ? enterprise_params == enterprise.id
                                : false}
                        >
                            {enterprise.name}</option
                        >
                    {/each}
                </select>
                <select
                    on:change={(e) => select_by_country(e.target.value)}
                    class=" rounded m-2 py-1 text-sm text-gray-600 ring-gray-200 scrollable ring-1 hover:ring-orange-500 border-0"
                >
                    <option value="">Choisissez un pays</option>
                    {#each countries as country}
                        <option
                            selected={country_params
                                ? country_params ==
                                  country.name.common.toLowerCase()
                                : false}
                            value={country.name.common}
                        >
                            {country.name.common.substr(0,12)}</option
                        >
                    {/each}
                </select>
            {:else}
                <LoadingSpinner
                    spinnerColor="border-black"
                    background="bg-transparent"
                />
            {/if}
        </div>
    </div>
</div>
{#if $leftSideBarComponent}
    <LeftSideBar on:click={showLeftSideBar} />
{/if}
