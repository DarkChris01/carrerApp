<script>
    import InputError from "@/utils/InputError.svelte";
    import { useForm, inertia } from "@inertiajs/svelte";
    import { fadeIn } from "@dependencies/Utilities";
    import { onMount } from "svelte";
    let target;

    onMount(() => {
        fadeIn(target, 500);
    });

    const form = useForm({
        name: null,
        email: null,
        post_: null,
        password: null,
        password_confirmation: null,
    });

    const register = () => {
        $form.post("/employer/register", {
            preserveScroll: true,
        });
    };
</script>

<div bind:this={target}>
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <h2
            class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-800"
        >
            Creer votre compte Recruteur
        </h2>
    </div>

    <form on:submit|preventDefault={register}>
        <div class="border flex items-center rounded px-1 mt-2">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                class="size-6"
            >
                <path
                    fill-rule="evenodd"
                    d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                    clip-rule="evenodd"
                />
            </svg>
            <input
                id="name"
                type="text"
                placeholder="nom"
                class="block w-full border-none focus:ring-0 placeholder:text-gray-400 placeholder:text-sm"
                bind:value={$form.name}
                required
                autocomplete="name"
            />
        </div>
        {#if $form.errors.name}
            <InputError class="mt-2" error={$form.errors.name} />
        {/if}

        <div class="border flex items-center rounded px-1 mt-2">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                class="size-6"
            >
                <path
                    fill-rule="evenodd"
                    d="M17.834 6.166a8.25 8.25 0 1 0 0 11.668.75.75 0 0 1 1.06 1.06c-3.807 3.808-9.98 3.808-13.788 0-3.808-3.807-3.808-9.98 0-13.788 3.807-3.808 9.98-3.808 13.788 0A9.722 9.722 0 0 1 21.75 12c0 .975-.296 1.887-.809 2.571-.514.685-1.28 1.179-2.191 1.179-.904 0-1.666-.487-2.18-1.164a5.25 5.25 0 1 1-.82-6.26V8.25a.75.75 0 0 1 1.5 0V12c0 .682.208 1.27.509 1.671.3.401.659.579.991.579.332 0 .69-.178.991-.579.3-.4.509-.99.509-1.671a8.222 8.222 0 0 0-2.416-5.834ZM15.75 12a3.75 3.75 0 1 0-7.5 0 3.75 3.75 0 0 0 7.5 0Z"
                    clip-rule="evenodd"
                />
            </svg>

            <input
                id="email"
                type="email"
                placeholder="email"
                class="block w-full border-none focus:ring-0 placeholder:text-gray-400 placeholder:text-sm"
                bind:value={$form.email}
                required
                autocomplete="email"
            />
        </div>
        {#if $form.errors.email}
            <InputError class="mt-2" error={$form.errors.email} />
        {/if}

        <div class="border flex items-center rounded px-1 mt-2">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                class="size-6"
            >
                <path
                    fill-rule="evenodd"
                    d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z"
                    clip-rule="evenodd"
                />
            </svg>

            <input
                id="password"
                type="password"
                placeholder="mot de passe"
                class="block w-full border-none focus:ring-0 placeholder:text-gray-400 placeholder:text-sm"
                bind:value={$form.password}
                required
            />
        </div>
        {#if $form.errors.password}
            <InputError class="mt-2" error={$form.errors.password} />
        {/if}

        <div class="border flex items-center rounded px-1 mt-2">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                class="size-6"
            >
                <path
                    fill-rule="evenodd"
                    d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z"
                    clip-rule="evenodd"
                />
            </svg>

            <input
                id="password_confirmation"
                type="password"
                placeholder="confirmer mot de passe"
                class="block w-full border-none focus:ring-0 placeholder:text-gray-400 placeholder:text-sm"
                bind:value={$form.password_confirmation}
                required
            />
        </div>

        <div class="border flex items-center rounded px-1 mt-2">
            <input
                id="post"
                type="text"
                placeholder="Sr.RH administrator"
                class="block w-full border-none focus:ring-0 placeholder:text-gray-400 placeholder:text-sm"
                bind:value={$form.post_}
                required
            />
        </div>
        {#if $form.errors.password_confirmation}
            <!-- content here -->
            <InputError
                class="mt-2"
                error={$form.errors.password_confirmation}
            />
        {/if}

        <div class="flex items-center justify-end mt-4">
            <a
                use:inertia
                href="/login"
                class="mx-2 underline text-sm text-gray-500 hover:text-gray-800 rounded-md focus:outline-none"
            >
                J'ai déja compte!
            </a>
            <button
                type="submit"
                background="bg-blue-700"
                color="text-white"
                class="bg-indigo-600 hover:bg-indigo-400 text-white rounded p-0.5"
                >Créer un compte <button />
            </button>
        </div>
    </form>
</div>
