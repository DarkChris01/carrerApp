<script>
    import { inertia, router, page } from "@inertiajs/svelte";
    import { load_domains } from "@dependencies/load";
    import { leftSideBarComponent } from "@dependencies/Stores/Modal";
    import Label from "@utils/Label.svelte";
    import CheckBox from "@utils/Checkbox.svelte";
    import { onMount, onDestroy } from "svelte";
    import Spinner from "@utils/Spinner.svelte";

    let params;
    let url;
    let domains;
    let isLoading = true;
    let domainsFilter = null;
    let contractFilter = null;
    let salaryFilter = null;
    let salaryMin = null;
    let salaryMax = null;

    $: if ($page.props) {
        url = window.location.href;
        params = new URLSearchParams(new URL(url).search);
    }

    onMount(async () => {
        const response = await load_domains();
        if (response.status === 200) {
            domains = response.data.sort((a, b) => {
                return a.intitules.localeCompare(b.intitules);
            });
            isLoading = false;
        }
        if ($leftSideBarComponent) {
            document.body.style.overflow = "hidden";
        }
    });

    onDestroy(() => {
        document.body.style.overflow = "";
    });

    const handleCheckDomain = (e) => {
        if (e.target.checked) {
            if (domainsFilter !== e.target.value) {
                domainsFilter = e.target.value;
                const params = cleanFilterParams({
                    domain: domainsFilter,
                    contract: contractFilter,
                    salary: salaryFilter,
                    min: salaryMin,
                    max: salaryMax,
                });
                router.get("/", params, { preserveScroll: true });
            }
        } else {
            domainsFilter = null;
            const params = cleanFilterParams({
                domain: domainsFilter,
                contract: contractFilter,
                salary: salaryFilter,
                min: salaryMin,
                max: salaryMax,
            });
            router.get("/", params, { preserveScroll: true });
        }
    };

    const handleCheckContract = (e) => {
        if (e.target.checked) {
            if (contractFilter !== e.target.value) {
                contractFilter = e.target.value;
            }

            const params = cleanFilterParams({
                domain: domainsFilter,
                contract: contractFilter,
                salary: salaryFilter,
                min: salaryMin,
                max: salaryMax,
            });
            router.get("/", params, { preserveScroll: true });
        } else {
            contractFilter = null;
            const params = cleanFilterParams({
                domain: domainsFilter,
                contract: contractFilter,
                salary: salaryFilter,
                min: salaryMin,
                max: salaryMax,
            });
            router.get("/", params, { preserveScroll: true });
        }
    };

    const handleCheckSalary = (e) => {
        if (e.target.checked) {
            if (salaryFilter !== e.target.value) {
                salaryFilter = e.target.value;
            }
            salaryMin = null;
            salaryMax = null;
            const params = cleanFilterParams({
                domain: domainsFilter,
                contract: contractFilter,
                salary: salaryFilter,
                min: salaryMin,
                max: salaryMax,
            });
            router.get("/", params, { preserveScroll: true });
        } else {
            salaryFilter = null;
            const params = cleanFilterParams({
                domain: domainsFilter,
                contract: contractFilter,
                salary: salaryFilter,
                min: salaryMin,
                max: salaryMax,
            });
            router.get("/", params, { preserveScroll: true });
        }
    };

    const handleMinMax = () => {
        if (salaryMin || salaryMax) {
            salaryFilter = null;
            const params = cleanFilterParams({
                domain: domainsFilter,
                contract: contractFilter,
                salary: salaryFilter,
                min: salaryMin,
                max: salaryMax,
            });
            router.get("/", params, { preserveScroll: true });
        }
    };

    function seturl(url) {
        url.toString();
    }
    function cleanFilterParams(params) {
        return Object.fromEntries(
            Object.entries(params).filter(
                ([_, value]) => value !== null && value !== "",
            ),
        );
    }
</script>

<div
    class="fixed z-10 top-0 left-0 w-full h-screen lg:h-fit overflow-y-auto scrollable bg-white lg:relative text-gray-500 p-3 cursor-pointer rounded"
>
    <div class="flex justify-between items-center my-4 px-1">
        <button on:click class="lg:hidden">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="size-5 stroke-gray-500"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M6 18 18 6M6 6l12 12"
                />
            </svg>
        </button>
        <div>
            <button
                class="text-white btn btn-primary btn-xs rounded"
                on:click={() => {
                    contractFilter = null;
                    domainsFilter = null;
                    salaryFilter = null;
                    router.get("/");
                }}
                >Réinitialiser
            </button>
        </div>
    </div>

    <div class="p-1 text-xs w-full">
        <div class="border-b text-gray-300 my-3">Domaine</div>

        <div class="h-96 scrollable text-xs w-full overflow-y-auto p-1">
            {#if !isLoading}
                {#each domains as domain}
                    <div class="my-1 capitalize">
                        <CheckBox
                            value={domain.id}
                            checked={params.get("domain")
                                ? params.get("domain") == domain.id
                                    ? true
                                    : false
                                : false}
                            on:change={(e) => handleCheckDomain(e)}
                        />

                        <Label reason="domain" style="ms-1"
                            >{domain.intitules.substr(0, 25)}
                            {domain.intitules.length > 25 ? "..." : ""}</Label
                        >
                    </div>
                {/each}
            {:else}
                <div class="h-full flex justify-center items-center">
                    <Spinner />
                </div>
            {/if}
        </div>
    </div>

    <div class="p-1 text-xs mt-10 min-h-48">
        <div class="border-b text-gray-300 mb-3">Type</div>
        {#if !isLoading}
            <div class="my-1 capitalize">
                <CheckBox
                    checked={params.has("contract")
                        ? params.get("contract") === "cdd"
                            ? true
                            : false
                        : false}
                    value="cdd"
                    style="border-0 ring-1 focus:ring-1"
                    on:change={(e) => handleCheckContract(e)}
                />

                <Label reason="contract">CDD</Label>
            </div>
            <div class="my-1 capitalize">
                <CheckBox
                    checked={params.has("contract")
                        ? params.get("contract") === "cdi"
                            ? true
                            : false
                        : false}
                    value="cdi"
                    style="border-0 ring-1 focus:ring-1"
                    on:change={(e) => handleCheckContract(e)}
                />

                <Label reason="contract">CDI</Label>
            </div>
            <div class="my-1 capitalize">
                <CheckBox
                    checked={params.has("contract")
                        ? params.get("contract") === "plein"
                            ? true
                            : false
                        : false}
                    value="plein"
                    style="border-0 ring-1 focus:ring-1"
                    on:change={(e) => handleCheckContract(e)}
                />

                <Label reason="contract">Temps plein</Label>
            </div>
            <div class="my-1 capitalize">
                <CheckBox
                    checked={params.has("contract")
                        ? params.get("contract") === "partiel"
                            ? true
                            : false
                        : false}
                    value="partiel"
                    style="border-0 ring-1 focus:ring-1"
                    on:change={(e) => handleCheckContract(e)}
                />

                <Label reason="contract">Temps partiel</Label>
            </div>
            <div class="my-1 capitalize">
                <CheckBox
                    checked={params.has("contract")
                        ? params.get("contract") === "freelance"
                            ? true
                            : false
                        : false}
                    value="freelance"
                    style="border-0 ring-1 focus:ring-1"
                    on:change={(e) => handleCheckContract(e)}
                />
                <Label reason="contract">Freelance</Label>
            </div>
            <div class="my-1 capitalize">
                <CheckBox
                    checked={params.has("contract")
                        ? params.get("contract") === "interim"
                            ? true
                            : false
                        : false}
                    value="interim"
                    style="border-0 ring-1 focus:ring-1"
                    on:change={(e) => handleCheckContract(e)}
                />

                <Label reason="contract">Interim</Label>
            </div>
            <div class="my-1 capitalize">
                <CheckBox
                    checked={params.has("contract")
                        ? params.get("contract") === "stage"
                            ? true
                            : false
                        : false}
                    value="stage"
                    style="border-0 ring-1 focus:ring-1"
                    on:change={(e) => handleCheckContract(e)}
                />

                <Label reason="contract">Stage</Label>
            </div>
        {:else}
            <div class="h-56 flex justify-center items-center">
                <Spinner />
            </div>
        {/if}
    </div>

    <div class="p-1 min-h-56 text-xs my-8">
        <div class="border-b text-gray-300 mb-3">
            Pretentions salariales (xfa)
        </div>
        {#if !isLoading}
            <div class="p-1 mb-4 text-xs">
                <div class="my-1">
                    <input
                        type="checkbox"
                        on:change={(e) => handleCheckSalary(e)}
                        checked={params.has("salary")
                            ? params.get("salary") == 50
                                ? true
                                : false
                            : false}
                        value="50"
                        class="border-0 ring-1 focus:ring-1"
                    />
                    <label for="salary" class="ms-1"> Inferieur à 100K</label>
                </div>
                <div class="my-1">
                    <input
                        type="checkbox"
                        on:change={(e) => handleCheckSalary(e)}
                        checked={params.has("salary")
                            ? params.get("salary") == 100
                                ? true
                                : false
                            : false}
                        value="100"
                        class="border-0 ring-1 focus:ring-1"
                    />
                    <label for="salary" class="ms-1">>100K</label>
                </div>
                <div class="my-1">
                    <input
                        type="checkbox"
                        on:change={(e) => handleCheckSalary(e)}
                        checked={params.has("salary")
                            ? params.get("salary") == 200
                                ? true
                                : false
                            : false}
                        value="200"
                        class="border-0 ring-1 focus:ring-1"
                    />
                    <label for="salary" class="ms-1">>200K</label>
                </div>

                <div class="my-1">
                    <input
                        type="checkbox"
                        on:change={(e) => handleCheckSalary(e)}
                        checked={params.has("salary")
                            ? params.get("salary") == 300
                                ? true
                                : false
                            : false}
                        value="300"
                        class="border-0 ring-1 focus:ring-1"
                    />
                    <label for="salary" class="ms-1">>300K</label>
                </div>
                <div>
                    <div>
                        <label for="min">Min</label>
                    </div>
                    <div>
                        <input
                            class="border-0 ring-1 focus:ring-1 p-1 rounded"
                            type="text"
                            bind:value={salaryMin}
                        />
                    </div>
                    <div>
                        <label for="max">Max</label>
                    </div>
                    <div>
                        <input
                            class="border-0 ring-1 p-1 focus:ring-1 rounded"
                            type="text"
                            bind:value={salaryMax}
                        />
                    </div>
                    <div class="my-2">
                        <button
                            class="btn btn-success btn-xs rounded text-white"
                            on:click={handleMinMax}>Rechercher</button
                        >
                    </div>
                </div>
            </div>
        {:else}
            <div class="h-56 flex justify-center items-center">
                <Spinner />
            </div>
        {/if}
    </div>
</div>

<div class="z-50 pb-6 pr-6 fixed bottom-0 right-0">
    <button
        class="lg:hidden btn btn-primary flex justify-center items-center btn-xs rounded-full w-10 h-10"
        type="button"
        on:click={() => leftSideBarComponent.set(false)}
    >
        <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="size-6 stroke-gray-100 stroke-2"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"
            />
        </svg>
    </button>
</div>
