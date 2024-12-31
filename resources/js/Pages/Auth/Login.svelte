<script>
    import { inertia, useForm, page } from "@inertiajs/svelte";
    import LoginUser from "@forms/Auth/Login-user.svelte";
    import LoginEmployer from "@forms/Auth/Login-employer.svelte";
    let isEmployer = false;
</script>

{#if $page.props.flash.success}
    <div class="fixed top-10 left-0 w-full flex justify-center items-center">
        <div
            class="w-fit bg-blue-600 text-white text-sm p-3 rounded shadow border border-blue-500 text-center flex"
        >
            <span
                ><svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="size-5 me-1"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"
                    />
                </svg>
            </span>
            {$page.props.flash.success}
        </div>
    </div>
{/if}
<section
    class="w-full background h-screen flex justify-center items-center"
    style="background-image: url('/storage/background/b.svg')"
>
    <div
        class="flex w-full 2xl:w-1/4 lg:w-1/3 md:w-1/2 mx-2 flex-col justify-center px-6 py-4 lg:px-8 bg-white rounded shadow border-2"
    >
        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-sm">
            {#if isEmployer}
                <LoginEmployer />
            {:else}
                <LoginUser />
            {/if}

            <p class="mt-10 text-center text-sm text-gray-500">
                Not a member?
                <a
                    use:inertia
                    href="/register"
                    class="font-semibold leading-6 text-indigo-600 hover:text-indigo-400"
                    >registered now</a
                >
            </p>
        </div>
        <div class="mt-6">
            <div class="w-full grid md:grid-cols-2 gap-2 mb-6">
                <div>
                    <button
                        on:click={() => (isEmployer = false)}
                        class="w-full bg-green-600 rounded text-white p-1 shadow hover:bg-green-500"
                        >Chercheur d'emploi</button
                    >
                </div>
                <div>
                    <button
                        on:click={() => (isEmployer = true)}
                        class="w-full bg-red-600 rounded text-white p-1 shadow hover:bg-red-500"
                        >Recruteur</button
                    >
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .background {
        background-size: cover;
        background-position: center;
        background-attachment: scroll;
        background-repeat: no-repeat;
    }
</style>
