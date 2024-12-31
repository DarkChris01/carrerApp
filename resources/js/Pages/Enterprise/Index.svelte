<script>
    import { inertia } from "@inertiajs/svelte";
    import DeleteEnterpriseForm from "@forms/Enterprise/Delete-enterprise-form.svelte";
    export let enterprise;
    let show_create_form_enterprise = false;
    let delete_enterprise_form = false;
    const show_enterprise_form = () => {
        show_create_form_enterprise = !show_create_form_enterprise;
    };
</script>

<main class="lg:my-4">
    <div>
        <div
            class=" p-4 md:px-8 w-full lg:w-2/3 2xl:w-1/2 mx-auto bg-white cursor-pointer"
        >
            <div class="text-gray-300">
                <h1 class="md:text-xl text-center md:text-start">Entreprise</h1>

                <p
                    class="font-light text-gray-400 text-xs text-center md:text-start px-2"
                >
                    Vous pourrez modifier les données liées à l'entreprise. Ces
                    informations seront utilisé dans la mise en avant du serieux
                    et du professionalisme de votre entreprise.
                </p>
                <div
                    class="justify-start mt-8 flex items-end w-full mx-auto rounded"
                >
                    <div class="mb-5 w-full">
                        <div class="font-thin">
                            <div class="w-full lg:w-36 bg-primary rounded">
                                <img
                                    src={enterprise.logo ??
                                        "/storage/logo/default.png"}
                                    alt="logo_enterprise"
                                />
                            </div>
                            <!-- <p class="text-sm my-2 font-thin text-center">
                                Ce logo sera visible sur toutes vos offres!
                            </p> -->
                        </div>
                    </div>
                    <div class="mb-5 flex justify-around text-sm">
                        <a
                            use:inertia
                            href="/my-enterprise/creer-une-entreprise"
                        >
                            <button
                                on:click={show_enterprise_form}
                                class="p-1 mx-1 flex items-center btn btn-primary btn-xs text-white rounded"
                            >
                                Modifier
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="size-4 ms-1 stroke-1"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M3.75 5.25h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5"
                                    />
                                </svg>
                            </button>
                        </a>
                        <button
                            on:click={() => (delete_enterprise_form = true)}
                            class="p-1 flex items-center mx-1 btn btn-error btn-xs text-white rounded"
                        >
                            Supprimer
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="size-4 ms-1 stroke-1"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            {#if enterprise}
                <div
                    class="p-2 mt-2 text-sm rounded my-2 duration-300 text-gray-700 hover:text-black ease-in-out transition"
                >
                    <div class="me-4 border-b font-thin my-1">
                        Nom de l'entreprise
                    </div>
                    {enterprise.name}
                </div>
                <div
                    class="p-2 text-sm rounded my-2 duration-300 text-gray-700 hover:text-black ease-in-out transition"
                >
                    <div class="me-4 border-b font-thin my-1">
                        Raison sociale
                    </div>
                    <span class="capitalize">{enterprise.company_name}</span>
                </div>
                <div
                    class="p-2 text-sm rounded my-2 duration-300 text-gray-700 hover:text-black ease-in-out transition"
                >
                    <div class="me-4 border-b font-thin my-1">Secteur</div>
                    <div class="flex flex-wrap justify-start">
                        <span
                            class="me-2 border p-0.5 px-2 rounded bg-blue-600 text-white capitalize"
                        >
                            {enterprise.sector.sector1}
                        </span>
                        <span
                            class="me-2 border p-0.5 px-2 rounded bg-blue-600 text-white capitalize"
                        >
                            {enterprise.sector.sector2}
                        </span>
                        <span
                            class="me-2 border p-0.5 px-2 rounded bg-blue-600 text-white capitalize"
                        >
                            {enterprise.sector.sector3}
                        </span>
                        <span
                            class="me-2 border p-0.5 px-2 rounded bg-blue-600 text-white capitalize"
                        >
                            {enterprise.sector.sector4}
                        </span>
                    </div>
                </div>
                <div
                    class="p-2 text-sm rounded my-2 duration-300 text-gray-700 hover:text-black ease-in-out transition"
                >
                    <div class="me-4 border-b font-thin my-1">
                        Type d'entreprise
                    </div>
                    <span class="uppercase">
                        {enterprise.type}
                    </span>
                </div>
                <div
                    class="p-2 text-sm rounded my-2 duration-300 text-gray-700 hover:text-black ease-in-out transition"
                >
                    <div class="me-4 border-b font-thin my-1">Pays</div>
                    {enterprise.country}
                </div>
                <div
                    class="p-2 text-sm rounded my-2 duration-300 text-gray-700 hover:text-black ease-in-out transition"
                >
                    <div class="me-4 border-b font-thin my-1">Region</div>
                    {enterprise.region}
                </div>
                <div
                    class="p-2 text-sm rounded my-2 duration-300 text-gray-700 hover:text-black ease-in-out transition"
                >
                    <div class="me-4 border-b font-thin my-1">Addresse</div>
                    {enterprise.address}
                </div>
                <div
                    class="p-2 text-sm rounded my-2 duration-300 text-gray-700 hover:text-black ease-in-out transition"
                >
                    <div class="me-4 border-b font-thin my-1">Telephone</div>
                    {enterprise.phone}
                </div>
                <div
                    class="p-2 text-sm rounded my-2 duration-300 text-gray-700 hover:text-black ease-in-out transition"
                >
                    <div class="me-4 border-b font-thin my-1">Email</div>
                    {enterprise.email}
                </div>
                <div
                    class="p-2 text-sm flexrounded my-2 duration-300 text-gray-700 hover:text-black ease-in-out transition"
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
                        class="feather feather-facebook me-4 fill-blue-700 stroke-transparent"
                        ><path
                            d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"
                        ></path></svg
                    >
                    {enterprise.facebook ?? "aucune information"}
                </div>
                <div
                    class="p-2 text-sm flexrounded my-2 duration-300 text-gray-700 hover:text-black ease-in-out transition"
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
                        class="feather feather-linkedin me-4 bg-blue-600 fill-white stroke-transparent"
                        ><path
                            d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"
                        ></path><rect x="2" y="9" width="4" height="12"
                        ></rect><circle cx="4" cy="4" r="2"></circle></svg
                    >
                    {enterprise.linkedin ?? "aucune information"}
                </div>
                <div
                    class="p-2 text-sm flexrounded my-2 duration-300 text-gray-700 hover:text-black ease-in-out transition"
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
                        class="feather feather-twitter me-4 fill-blue-700 stroke-transparent"
                        ><path
                            d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"
                        ></path></svg
                    >
                    {enterprise.twitter ?? "aucune information"}
                </div>
            {/if}
        </div>
    </div>
</main>

{#if delete_enterprise_form}
    <DeleteEnterpriseForm on:click={() => (delete_enterprise_form = false)} />
{/if}
