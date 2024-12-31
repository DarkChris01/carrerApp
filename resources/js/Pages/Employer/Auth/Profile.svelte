<script>
    import UpdateEmployerPicture from "@forms/Employer/Update-employer-picture.svelte";
    import UpdateEmployerdata from "@forms/Employer/Update-employer-data.svelte";
    import Enterprise from "@components/Employer/Enterprise.svelte";
    import { inertia } from "@inertiajs/svelte";
    export let user;
</script>

<main class="mt-8 flex justify-center">
    <div class="w-full md:w-2/3 xl:w-1/3 bg-white rounded shadow px-10 p-8 2xl:p-20">
        <div class="text-gray-300 border-gray-100 lg:text-sm border-b  2xl:text-2xl mb-10 text-center">
            <h1>PROFILE</h1>
        </div>
        <div class=" text-gray-600 rounded">
            <div class="avatar flex justify-center">
                <UpdateEmployerPicture {user} />
            </div>
            <div>
                <div class="p-2 font-thin text-sm">
                    <div>
                        <UpdateEmployerdata {user} />
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-">
            {#if user.enterprise}
                <Enterprise enterprise={user.enterprise} />
            {:else}
                <div
                    class="text-center w-full text-sm text-gray-600 md:flex justify-center items-center my-4"
                >
                    <div>
                        <button
                            type="button"
                            class="ms-2 w-full transition ease duration-300  hover:ring-2 ring-1 text-gray-800 p-1 rounded"
                            ><a
                                use:inertia
                                href="/my-enterprise/creer-une-entreprise"
                            >
                                Créer mon entreprise</a
                            ></button
                        >
                    </div>
                </div>
            {/if}
        </div>
    </div>
</main>
