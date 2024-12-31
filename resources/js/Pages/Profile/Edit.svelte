<script>
    import UpdateUserForm from "@forms/UpdateUserForm.svelte";
    import UpdatePicForm from "@forms/UpdatePicForm.svelte";
    import { inertia, page } from "@inertiajs/svelte";
    import DeleteAccountForm from "@forms/Delete-account-form.svelte";
    import { onMount } from "svelte";
    import SocialMedia from "@utils/SocialMedia.svelte";
    let showdeleteForm = false;
</script>

<section class="w-full flex justify-center items-center mt-16">
    <div
        class="w-full md:w-1/2 xl:w-1/3 2xl:w-1/4 border border-gray-400/80/50 rounded-sm bg-white p-8"
    >
        <UpdatePicForm user={$page.props.auth.user} />
        <div class="text-center font-semibold text-gray-600 p-1 my-2">
            {$page.props.auth.user.name}
        </div>
        <UpdateUserForm user={$page.props.auth.user} />

        <div>
            <a use:inertia href="/cv">
                <button
                    class="flex w-full rounded justify-center items-center px-3 py-1 text-sm font-semibold btn btn-neutral btn-xs focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 transition ease duration-500"
                >
                    Creer mon Cv
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="size-4 ms-2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"
                        />
                    </svg>
                </button></a
            >
        </div>

        <div class="my-10">
            <div class="text-center font-semibold text-gray-600 my-2">
                <a use:inertia href="/password">
                    <button
                        class="btn bg-warning text-center w-full btn-xs rounded text-gray-900"
                    >
                        Modifier mot de passe
                    </button>
                </a>
            </div>
            <div>
                <button
                    type="button"
                    class="flex w-full justify-center items-center rounded shadow btn btn-xs bg-red-600 py-1.5 font-semibold leading-6 text-white hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600 transition ease duration-500"
                    on:click={() => (showdeleteForm = true)}
                >
                    Supprimer mon compte
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="size-4 ms-2 stroke-white"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                        />
                    </svg>
                </button>
            </div>
            {#if showdeleteForm}
                <DeleteAccountForm on:click={() => (showdeleteForm = false)} />
            {/if}
        </div>
        <SocialMedia />
    </div>
</section>
