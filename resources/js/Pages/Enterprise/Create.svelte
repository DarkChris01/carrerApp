<script>
    import { useForm } from "@inertiajs/svelte";
    import { onMount, onDestroy } from "svelte";
    import Spinner from "@utils/Spinner.svelte"
    import axios from "axios";
    import toast from "svelte-french-toast";
    export let enterprise;

    let countries;
    let isLoading = true;
    let form = useForm({
        name: enterprise ? enterprise.name : null,
        company_name: enterprise ? enterprise.company_name : null,
        phone: enterprise ? enterprise.phone : null,
        sector1: enterprise ? enterprise.sector.sector1 : null,
        sector2: enterprise ? enterprise.sector.sector2 : null,
        sector3: enterprise ? enterprise.sector.sector3 : null,
        sector4: enterprise ? enterprise.sector.sector4 : null,
        type: enterprise ? enterprise.type : null,
        country: enterprise ? enterprise.country : null,
        region: enterprise ? enterprise.region : null,
        address: enterprise ? enterprise.address : null,
        email: enterprise ? enterprise.email : null,
        facebook: enterprise ? enterprise.facebook : null,
        linkedin: enterprise ? enterprise.linkedin : null,
        twitter: enterprise ? enterprise.twitter : null,
        postal: enterprise ? enterprise.postal : null,
        logo: "",
    });

    const handleCreateEnterprise = () => {
        $form.post("/my-enterprise", {
            onSuccess: () => {
                toast.success("Informations mis à jour!");
            },
        });
    };

    onMount(async () => {
        const response = await axios.get(
            "https://restcountries.com/v3.1/all?fields=name",
            { timeout: 10000 },
        );
        if (response.status === 200) {
            countries = await response.data;
            isLoading = false;
        }
    });
</script>

<main class="bg-white p-4 w-full md:w-1/2 xl:w-3/5 shadow rounded my-8 mx-auto">
    {#if !isLoading}
    <div class="flex justify-center my-12 text-sm">
        <div class="w-fit">
            <h1 class="text-center text-2xl">
                Entrer les données d'entreprise
            </h1>
            <p class="text-center font-thin text-sm">
                Vous ne pourrez créer qu'une seule entreprise
            </p>
        </div>
    </div>
        <div>
            <form
                class="p-6 mx-auto font-thin"
                on:submit|preventDefault={handleCreateEnterprise}
                enctype="multipart/form-data"
            >
                <div class="relative z-0 w-full mb-8 group">
                    <input
                        bind:value={$form.name}
                        type="text"
                        id="floating_enterprise_name"
                        class="block py-2.5 px-0 w-full text-gray-800 bg-transparent border-0 border-b-2 border-gray-400/80 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" "
                        required
                    />
                    <label
                        for="floating_enterprise_name"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                        >Nom de l'Entreprise</label
                    >
                </div>

                <div class="relative z-0 w-full mb-8 group">
                    <input
                        bind:value={$form.company_name}
                        type="text"
                        id="floating_company_name"
                        class="block py-2.5 px-0 w-full text-gray-800 bg-transparent border-0 border-b-2 border-gray-400/80 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" "
                        required
                    />
                    <label
                        for="floating_company_name"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                        >Raison sociale</label
                    >
                </div>
                <div
                    class="relative z-0 w-full mb-8 group grid grid-cols-2 gap-2 p-1 rounded"
                >
                    <input
                        bind:value={$form.sector1}
                        type="text"
                        id="floating_sector"
                        class="block py-2.5 px-0 w-full text-gray-800 bg-transparent border-0 border-b-2 border-gray-400/80 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" "
                        required
                    />
                    <input
                        bind:value={$form.sector2}
                        type="text"
                        id="floating_sector"
                        class="block py-2.5 px-0 w-full text-gray-800 bg-transparent border-0 border-b-2 border-gray-400/80 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" "
                        required
                    />
                    <input
                        bind:value={$form.sector3}
                        type="text"
                        id="floating_sector"
                        class="block py-2.5 px-0 w-full text-gray-800 bg-transparent border-0 border-b-2 border-gray-400/80 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" "
                        required
                    />
                    <input
                        bind:value={$form.sector4}
                        type="text"
                        id="floating_sector"
                        class="block py-2.5 px-0 w-full text-gray-800 bg-transparent border-0 border-b-2 border-gray-400/80 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" "
                        required
                    />
                    <label
                        for="floating_sector"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                        >Secteur d'activité (exemple: comptabilite)</label
                    >
                </div>
                <div class="relative z-0 w-full mb-8 group">
                    <select
                        bind:value={$form.type}
                        type="text"
                        id="floating_type"
                        class="block py-2.5 px-0 w-full text-gray-800 bg-transparent border-0 border-b-2 border-gray-400/80 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        required
                    >
                        <option selected={$form.type == "sarl"} value="sarl"
                            >SARL</option
                        >
                        <option selected={$form.type == "sa"} value="sa"
                            >SA</option
                        >
                        <option selected={$form.type == "sp"} value="sp"
                            >SP</option
                        >
                        <option selected={$form.type == "ei"} value="ei"
                            >EI</option
                        >
                    </select>
                    <label
                        for="floating_type"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                        >Type d'entreprise</label
                    >
                </div>

                <div class="relative z-0 w-full mb-8 group">
                    <input
                        bind:value={$form.phone}
                        type="text"
                        id="floating_phone"
                        class="block py-2.5 px-0 w-full text-gray-800 bg-transparent border-0 border-b-2 border-gray-400/80 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" "
                        required
                    />
                    <label
                        for="floating_phone"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                        >Telephone (+237673802236)</label
                    >
                </div>

                <div class="relative z-0 w-full mb-8 group">
                    <select
                        bind:value={$form.country}
                        aria-placeholder="Cameroon"
                        class="scrollable block py-2.5 px-0 w-full text-gray-800 bg-transparent border-0 border-b-2 border-gray-400/80 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    >
                        <option value="Choisissez votre pays"
                            >Choisissez votre pays</option
                        >
                        {#each countries as country}
                            <option
                                selected={country.name.common ===
                                    enterprise?.country}
                                >{country.name.common}</option
                            >
                        {/each}
                    </select>
                </div>
                <div class="relative z-0 w-full mb-8 group">
                    <input
                        bind:value={$form.region}
                        type="text"
                        id="floating_region"
                        class="block py-2.5 px-0 w-full text-gray-800 bg-transparent border-0 border-b-2 border-gray-400/80 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" "
                        required
                    />
                    <label
                        for="floating_region"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                        >Region</label
                    >
                </div>
                <div class="relative z-0 w-full mb-8 group">
                    <input
                        bind:value={$form.address}
                        type="text"
                        id="floating_address"
                        class="block py-2.5 px-0 w-full text-gray-800 bg-transparent border-0 border-b-2 border-gray-400/80 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" "
                        required
                    />
                    <label
                        for="floating_address"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                        >Addresse</label
                    >
                </div>

                <div class="relative z-0 w-full mb-8 group">
                    <input
                        bind:value={$form.email}
                        type="email"
                        id="floating_email"
                        class="block py-2.5 px-0 w-full text-gray-800 bg-transparent border-0 border-b-2 border-gray-400/80 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" "
                        required
                    />
                    <label
                        for="floating_email"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                        >Email</label
                    >
                </div>
                <div class="relative z-0 w-full mb-8 group">
                    <input
                        bind:value={$form.postal}
                        type="text"
                        id="floating_postal"
                        class="block py-2.5 px-0 w-full text-gray-800 bg-transparent border-0 border-b-2 border-gray-400/80 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" "
                    />
                    <label
                        for="floating_postal"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                        >Code postal</label
                    >
                </div>
                <div class="relative z-0 w-full mb-8 group">
                    <input
                        bind:value={$form.facebook}
                        type="email"
                        id="floating_facebook"
                        class="block py-2.5 px-0 w-full text-gray-800 bg-transparent border-0 border-b-2 border-gray-400/80 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" "
                    />
                    <label
                        for="floating_facebook"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                        ><svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-facebook fill-blue-700 stroke-transparent"
                            ><path
                                d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"
                            ></path></svg
                        ></label
                    >
                </div>
                <div class="relative z-0 w-full mb-8 group">
                    <input
                        bind:value={$form.linkedin}
                        type="email"
                        id="floating_linkedin"
                        class="block py-2.5 px-0 w-full text-gray-800 bg-transparent border-0 border-b-2 border-gray-400/80 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" "
                    />
                    <label
                        for="floating_linkedin"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                        ><svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-linkedin bg-blue-600 fill-white stroke-transparent"
                            ><path
                                d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"
                            ></path><rect x="2" y="9" width="4" height="12"
                            ></rect><circle cx="4" cy="4" r="2"></circle></svg
                        ></label
                    >
                </div>
                <div class="relative z-0 w-full mb-8 group">
                    <input
                        bind:value={$form.twitter}
                        type="email"
                        id="floating_tweeter"
                        class="block py-2.5 px-0 w-full text-gray-800 bg-transparent border-0 border-b-2 border-gray-400/80 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" "
                    />
                    <label
                        for="floating_twitter"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                        ><svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-twitter fill-blue-700 stroke-transparent"
                            ><path
                                d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"
                            ></path></svg
                        ></label
                    >
                </div>

                <div class="relative z-0 w-full mb-8 group">
                    <label
                        class="block mb-2 text-sm font-medium text-gray-800 dark:text-white"
                        for="large_size">Logo de l'entreprise</label
                    >
                    <input
                        on:change={(e) => ($form.logo = e.target.files[0])}
                        class="block w-full text-sm md:text-sm p-1 text-gray-800 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                        id="large_size"
                        type="file"
                    />
                </div>
                <div>
                    <div class="my-6 flex justify-end">
                        <button
                            type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded w-full sm:w-auto p-1 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            >Enregistrer</button
                        >
                    </div>
                </div>
            </form>
        </div>
    {:else}
        <div class="h-screen flex justify-center items-center text-gray-600">
           <Spinner/>
        </div>
    {/if}
</main>

<style>
    option {
        font-family: sans-serif;
    }
</style>
