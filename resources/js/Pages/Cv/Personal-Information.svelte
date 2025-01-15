<script>
    import countries from "@dependencies/helpers/countries.json";
    import { PrevisualiseUploadedFile } from "@dependencies/utilities";
    // import { page } from "@dependencies/Stores/Store";
    import { inertia, useForm } from "@inertiajs/svelte";
    import { onMount } from "svelte";
    import Spinner from "@utils/Spinner.svelte";
    import axios from "axios";
    import toast from "svelte-french-toast";
    import { get_user_cv_information } from "@dependencies/load";
    let datas;
    let loading = true;
    let formular;

    onMount(async () => {
        const response_ = await get_user_cv_information();
        if ((response_.status = 200)) {
            datas = await response_.data;
            loading = false;
        }
    });

    $: form = useForm({
        firstName: datas ? datas.firstName : null,
        lastName: datas ? datas.lastName : null,
        birth_date: datas ? datas.birth_date : null,
        email: datas ? datas.email : null,
        phone: datas ? datas.phone : null,
        sexe: datas ? datas.sexe : null,
        country: datas ? datas.country : null,
        profession: datas ? datas.profession : null,
        picture: "",
        cv: "",
    });

    const HandlerSubmit = () => {
        $form.post("/cv/information", {
            onSuccess: () => {
                toast.success("Etape Suivant !");
            },
            onError: (error) => {
                toast.error(error);
            },
        });
    };
</script>

<div class="w-full lg:w-1/2 mx-auto bg-white border my-4 p-2 lg:p-4">
    <div class="my-8">
        <div class="flex justify-center font-bold">
            <h1 class="text-sm md:text-xl xl:text-4xl text-gray-700">
                Informations personnelles
            </h1>
        </div>
        <p class="text-center text-gray-500 text-sm">
            Ces informations seront visibles uniquement pour les recruteurs!
        </p>
    </div>
    {#if !loading}
        <div class="w-full justify-center items-center text-sm lg:text-sm p-4">
            <form
                on:submit|preventDefault={HandlerSubmit}
                class="w-full"
                enctype="multipart/form-data"
            >
                <div class="w-full md:wfit mx-2 mb-[4rem]">
                    <div class="mt-2">
                        <div>
                            <label
                                class="text-gray-500 text-sm lg:text-sm"
                                for="name">Nom</label
                            >
                        </div>
                        <input
                            required
                            type="text"
                            bind:value={$form.firstName}
                            name="firstName"
                            placeholder="exemple: John"
                            class="border-0 w-full p-2 text-gray-700 ring-1 focus:ring-orange-600 text-sm lg:text-sm placeholder:text-gray-400 placeholder:text-sm rounded"
                        />
                    </div>
                    <div class="mt-2">
                        <div>
                            <label
                                class="text-gray-500 text-sm lg:text-sm"
                                for="prenom">Prenom</label
                            >
                        </div>
                        <input
                            required
                            type="text"
                            bind:value={$form.lastName}
                            name="lastName"
                            placeholder="exemple: Doe"
                            class="border-0 w-full p-2 text-gray-700 ring-1 focus:ring-orange-600 text-sm lg:text-sm placeholder:text-gray-400 placeholder:text-sm rounded"
                        />
                    </div>

                    <div class="mt-2">
                        <div>
                            <label
                                class="text-gray-500 text-sm lg:text-sm"
                                for="prenom">Specialité</label
                            >
                        </div>
                        <input
                            required
                            type="text"
                            bind:value={$form.profession}
                            name="profession"
                            placeholder="exemple: Programmeur"
                            class="border-0 w-full p-2 text-gray-700 ring-1 focus:ring-orange-600 text-sm lg:text-sm placeholder:text-gray-400 placeholder:text-sm rounded"
                        />
                    </div>

                    <div class="mt-2">
                        <div>
                            <label
                                class="text-gray-500 text-sm lg:text-sm"
                                for="birth_date">Date de naissance</label
                            >
                        </div>
                        <input
                            required
                            type="date"
                            bind:value={$form.birth_date}
                            name="birth_date"
                            class="border-0 w-full min-w-40 p-2 text-gray-700 ring-1 focus:ring-orange-600 text-sm lg:text-sm placeholder:text-gray-400 placeholder:text-sm rounded"
                        />
                    </div>

                    <div class="grid md:grid-cols-2 gap-2">
                        <div class="mt-2">
                            <div>
                                <label
                                    class="text-gray-500 text-sm lg:text-sm"
                                    for="phone">Telephone</label
                                >
                            </div>
                            <div>
                                <input
                                    required
                                    type="text"
                                    bind:value={$form.phone}
                                    name="phone"
                                    placeholder="693546789"
                                    class="border-0 w-full p-2 text-gray-700 ring-1 focus:ring-orange-600 text-sm lg:text-sm placeholder:text-gray-400 placeholder:text-sm rounded"
                                />
                            </div>
                        </div>

                        <div class="mt-2">
                            <div>
                                <label
                                    class="text-gray-500 text-sm lg:text-sm"
                                    for="email">Email</label
                                >
                            </div>
                            <input
                                required
                                type="email"
                                placeholder="joedoe@gmail.com"
                                bind:value={$form.email}
                                name="email"
                                class="border-0 w-full p-2 text-gray-700 ring-1 focus:ring-orange-600 text-sm lg:text-sm placeholder:text-gray-400 placeholder:text-sm rounded"
                            />
                        </div>
                    </div>
                    <div class="mt-2">
                        <div>
                            <label
                                class="text-gray-500 text-sm lg:text-sm"
                                for="nationale">Nationalité</label
                            >
                        </div>
                        <select
                            required
                            type="text"
                            bind:value={$form.country}
                            class="scrollable border-0 w-full min-w-40 p-2 text-gray-700 ring-1 focus:ring-orange-600 text-sm lg:text-sm placeholder:text-gray-400 placeholder:text-sm rounded"
                        >
                            {#each countries.world as country}
                                <option
                                    value={country}
                                    selected={country === $form.country}
                                >
                                    {country}</option
                                >
                            {/each}
                        </select>
                    </div>

                    <div class="mt-2">
                        <p class="text-gray-500 text-sm lg:text-sm">
                            Vous êtes ?
                        </p>
                        <div class="flex items-center">
                            <select
                                bind:value={$form.sexe}
                                class="block w-1/2 text-sm p-1 text-gray-800 border border-gray-300 rounded-lg ring-1 border-none focus:ring-orange-600"
                            >
                                <option value="man">Homme</option>
                                <option value="woman">Femme</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-8">
                        <label
                            class="block mt-2 text-gray-700 dark:text-white"
                            for="large_size"
                            >cette image apparaitra sur le cvet sera visible
                            pour les recruteurs</label
                        >
                        <input
                            on:input={(e) => {
                                PrevisualiseUploadedFile(e);
                                $form.picture = e.target.files[0];
                            }}
                            class="block w-full text-sm p-1 text-gray-700 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                            type="file"
                        />
                    </div>

                    <div class="mt-2">
                        <label
                            class="block text-gray-700 dark:text-white"
                            for="large_size">Envoyer votre cv (PDF)</label
                        >
                        <input
                            on:input={(e) => ($form.cv = e.target.files[0])}
                            class="block w-full text-sm p-1 text-gray-800 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                            type="file"
                        />
                    </div>

                    <div class=" flex justify-center mt-6 rounded p-2 w-full">
                        <img class="w-64 img-previsualize" alt="" />
                    </div>
                </div>
                <div
                    class="flex w-full justify-end items-center bg-white px-2 md:px-4 p-2 mt-8 bottom-0 left-0"
                >
                    <div class="flex">
                        <a
                            use:inertia
                            href="/cv"
                            as="button"
                            class="bg-red-600 rounded p-1 hover:bg-red-500 text-white me-2"
                            >Retourner vers mon cv
                        </a>

                        <button
                            type="submit"
                            class="btn btn-primary rounded p-1 btn-sm text-white"
                            >Suivant</button
                        >
                    </div>
                </div>
            </form>
        </div>
    {:else}
        <div
            class="flex justify-center items-center h-96 w-full text-gray-700 text-xl font-semibold"
        >
            <Spinner />
        </div>
    {/if}
</div>

<style>
    label {
        color: gray;
    }
    option {
        font-family: "Montserrat", "Trebuchet MS", "Lucida Sans Unicode",
            "Lucida Grande", "Lucida Sans", Arial, sans-serif;
    }
</style>
