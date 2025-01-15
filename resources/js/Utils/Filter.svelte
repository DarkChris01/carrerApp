<script>
    import { inertia, page } from "@inertiajs/svelte";
    import { load_domains } from "@dependencies/load";
    import { autocomplete, cleanFilterParams } from "@dependencies/utilities";
    import { onMount, onDestroy } from "svelte";
    import { router } from "@inertiajs/svelte";
    import toast from "svelte-french-toast";
    import countries from "@dependencies/helpers/countries.json"
    import {
        AutoCompleteStoreComponent,
        candidaciesFilterComponent,
    } from "@dependencies/Stores/Modal";
    import AutoComplete from "@utils/AutoComplete.svelte";
    import Label from "@utils/Label.svelte";
    import PrimaryButton from "@utils/PrimaryButton.svelte";
    import Checkbox from "@utils/Checkbox.svelte";
    let domains = [];
       let words = [];
    let form;
    let searched_word;
    let isLoading_domain = true;
    let isLoading_country = true;
    let showDomainCheckbox = false;
    let showCountryCheckbox = false;
    let domainFilter = [];

    searched_word = new URLSearchParams(window.location.search).get("search");

    onMount(async () => {
        const response = await load_domains();

        if (response.status === 200) {
            const datas = await response.data;
            domains = datas.sort((a, b) => {
                return a.intitules.localeCompare(b.intitules);
            });
            isLoading_domain = false;
        }
        (() => {
            let activeFilter;
            const url = new URLSearchParams(window.location.search);

            if (url.has("domain[1]")) {
                activeFilter = "domain";
            } else if (url.has("country[1]")) {
                activeFilter = "country";
            }

            for (const element of url) {
                if (activeFilter === "domain") {
                    domainFilter = [...domainFilter, { domain: element[1] }];
                } else if (activeFilter === "country") {
                    countryFilter = [...countryFilter, { country: element[1] }];
                }
            }
        })();
    });

    const autoComplete = async (trigger) => {
        const word = trigger.target.value;
        if (word.length > 2) {
            const response = await autocomplete(word, "/domain/autocompletion");
            words = response.data;
            AutoCompleteStoreComponent.set(true);
        } else {
            if (word.length < 3) {
                AutoCompleteStoreComponent.set(false);
            }
        }
    };

    const rechercher = () => {
        if (searched_word === "") {
            toast.error("Remplissez le champ de recherche!");
        } else {
            router.visit(`?search=${searched_word}`, {
                onSuccess: () => {},
                preserveScroll: true,
            });
        }
    };

    const reset_all = () => {
        form.reset();
        showDomainCheckbox = false;
        showCountryCheckbox = false;
        (domainFilter = []), (countryFilter = []);
        AutoCompleteStoreComponent.set(false);
    };

    const reset_filter = () => {
        reset_all();
        router.get(window.location.origin + window.location.pathname);
    };

    const redirectTo = () => {
        const param = cleanFilterParams(filter);
        router.get("?", param);
    };
    const toggleDomainFilter = () => {
        showDomainCheckbox = !showDomainCheckbox;
        candidaciesFilterComponent.set(false);
        showCountryCheckbox = false;
    };

    const toogleCountryFilter = () => {
        showCountryCheckbox = !showCountryCheckbox;
        candidaciesFilterComponent.set(false);
        showDomainCheckbox = false;
    };

    const filterBycountry = (trigger) => {
        if (domainFilter.length > 0) {
            domainFilter = [];
        }
        if (trigger.target.checked) {
            if (
                !countryFilter.some(
                    (value) => value.country === trigger.target.value,
                )
            ) {
                countryFilter = [
                    ...countryFilter,
                    { country: trigger.target.value },
                ];

                const queryString = countryFilter
                    .map(
                        (value, index) =>
                            `country[${index + 1}]=${encodeURIComponent(value.country)}`,
                    )
                    .join("&");

                router.get(`?${queryString}`);
            }
        } else {
            countryFilter = countryFilter.filter(
                (v) => v.country !== trigger.target.value,
            );

            const queryString = countryFilter
                .map(
                    (value, index) =>
                        `country[${index + 1}]=${encodeURIComponent(value.country)}`,
                )
                .join("&");

            router.get(`?${queryString}`);
        }
    };

    const filterByDomain = (trigger) => {
        if (countryFilter.length > 0) {
            countryFilter = [];
        }
        if (trigger.target.checked) {
            if (
                !countryFilter.some(
                    (value) => value.domain === trigger.target.value,
                )
            ) {
                domainFilter = [
                    ...domainFilter,
                    { domain: trigger.target.value },
                ];

                const queryString = domainFilter
                    .map(
                        (value, index) =>
                            `domain[${index + 1}]=${encodeURIComponent(value.domain)}`,
                    )
                    .join("&");

                router.get(`?${queryString}`);
            }
        } else {
            domainFilter = domainFilter.filter(
                (v) => v.domain !== trigger.target.value,
            );

            const queryString = domainFilter
                .map(
                    (value, index) =>
                        `domain[${index + 1}]=${encodeURIComponent(value.domain)}`,
                )
                .join("&");
            router.get(`?${queryString}`);
        }
    };
</script>

<main class="my-2 p-1">
    {#if !isLoading_domain}
        {#if !isLoading_country}
            <div class="lg:flex justify-between items-center">
                <div class="flex items-center">
                    <div class="me-2 text-gray-700 rounded">
                        <button
                            class="btn btn-ghost btn-sm 2xl:btn-sm rounded ring-1 ring-gray-600 flex items-center"
                            on:click={reset_filter}>Aucun</button
                        >
                    </div>
                    <div class="relative">
                        <button
                            class="p-1 rounded text-sm 2xl:text-sm items-center bg-gray-800 border flex border-gray-600 text-white px-2 me-3 shadow"
                            on:click={toggleDomainFilter}
                            >Domaine
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="ms-1 size-4"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m19.5 8.25-7.5 7.5-7.5-7.5"
                                />
                            </svg>
                        </button>
                        {#if showDomainCheckbox}
                            <div
                                class="absolute z-50 top-8 left-0 h-96 2xl:h-[30vw] border scrollable overflow-y-auto w-max bg-white rounded shadow p-4"
                            >
                                <h1
                                    class="mb-4 bg-gray-900 text-white p-1 text-sm"
                                >
                                    Domaine
                                </h1>
                                {#each domains as domain}
                                    <div class="flex text-sm">
                                        <div>
                                            <Checkbox
                                                checked={window.location.href.includes(
                                                    domain.intitules.replace(
                                                        " ",
                                                        "%20",
                                                    ),
                                                )}
                                                value={domain.intitules}
                                                on:change={(event) =>
                                                    filterByDomain(event)}
                                            >
                                                {domain.intitules}
                                            </Checkbox>
                                        </div>
                                        <Label style="ms-1" reason="domain">
                                            {domain.intitules}</Label
                                        >
                                    </div>
                                {/each}
                            </div>
                        {/if}
                    </div>

                    <div class="relative">
                        <PrimaryButton on:click={toogleCountryFilter}>
                            <div class="flex text-sm 2xl:text-sm items-center">
                                Pays
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="size-4 ms-1"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="m19.5 8.25-7.5 7.5-7.5-7.5"
                                    />
                                </svg>
                            </div>
                        </PrimaryButton>
                        {#if showCountryCheckbox}
                            <div
                                class="absolute z-50 top-8 left-0 h-96 2xl:h-[30vw] scrollable border overflow-y-auto w-max bg-white rounded shadow p-4"
                            >
                                <h1
                                    class="mb-4 bg-gray-900 text-white p-1 text-sm"
                                >
                                    Pays
                                </h1>
                                {#each countries.word as country}
                                    <div class="flex text-sm">
                                        <div>
                                            <Checkbox
                                                on:change={(event) =>
                                                    filterBycountry(event)}
                                                value={country}
                                                checked={window.location.href.includes(
                                                    country.replace(
                                                        " ",
                                                        "%20",
                                                    ),
                                                )}
                                            >
                                                {country}
                                            </Checkbox>
                                        </div>
                                        <Label reason="country" style="ms-1">
                                            {country}
                                        </Label>
                                    </div>
                                {/each}
                            </div>
                        {/if}
                    </div>
                </div>

                <div
                    class="flex justify-center lg:w-1/2 bg-gray-80 border border-gray-400 rounded"
                >
                    <form
                        bind:this={form}
                        class="relative w-full"
                        on:submit|preventDefault
                    >
                        <div class="flex items-center p-1">
                            <button on:click={rechercher} class="px-3">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="size-5 stroke-gray-700"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"
                                    />
                                </svg>
                            </button>
                            <input
                                bind:value={searched_word}
                                placeholder="Rechercher"
                                class=" w-full border-0 text-gray-600 bg-transparent text-sm font-bold focus:border-0 focus:ring-0 placeholder:font-thin placeholder:text-sm placeholder:text-gray-400 p-1"
                                type="text"
                                on:keyup={(e) => autoComplete(e)}
                                on:focus={(e) => {
                                    showCountryCheckbox = false;
                                    showDomainCheckbox = false;
                                    candidaciesFilterComponent.set(false);

                                    autoComplete(e);
                                }}
                            />
                            <button type="button" on:click={reset_all}>
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="size-4 stroke-gray-700 stroke-2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6 18 18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                        {#if $AutoCompleteStoreComponent && words.length > 0}
                            <div
                                class="absolute z-50 top-10 overflow-hidden p-1 left-0 w-full bg-white border text-gray-700 hover:text-gray-600 rounded"
                            >
                                {#each words as word}
                                    <AutoComplete {word} />
                                {/each}
                            </div>
                        {/if}
                    </form>
                </div>
            </div>
        {/if}
    {/if}
</main>
