<script>
    import toast from "svelte-french-toast";
    import { useForm, page, inertia } from "@inertiajs/svelte";
    import { fadeIn } from "@dependencies/utilities";
    import { onMount } from "svelte";
    let target;

    let form = useForm({
        email: null,
        password: null,
    });

    const login = () => {
        $form.post("/employer/login", {
            onSuccess: () => {
                toast.success(`Vous êtes connecté !`);
            },
            onError: (errors) => {
                toast.error(errors.email);
            },
            preserveScroll: true,
        });
    };

    onMount(() => {
        fadeIn(target, 400);
    });
</script>

<div bind:this={target}>
    <div class="sm:mx-auto sm:w-full sm:max-w-sm my-6">
        <h2
            class="mt-6 text-center text-2xl leading-9 tracking-tight text-gray-800"
        >
            Connexion Recruteur
        </h2>
    </div>
    <form on:submit|preventDefault={login}>
        <div>
            <div
                class="mt-1 items-center flex border ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 rounded"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="currentColor"
                    class="size-6 mx-2"
                >
                    <path
                        fill-rule="evenodd"
                        d="M17.834 6.166a8.25 8.25 0 1 0 0 11.668.75.75 0 0 1 1.06 1.06c-3.807 3.808-9.98 3.808-13.788 0-3.808-3.807-3.808-9.98 0-13.788 3.807-3.808 9.98-3.808 13.788 0A9.722 9.722 0 0 1 21.75 12c0 .975-.296 1.887-.809 2.571-.514.685-1.28 1.179-2.191 1.179-.904 0-1.666-.487-2.18-1.164a5.25 5.25 0 1 1-.82-6.26V8.25a.75.75 0 0 1 1.5 0V12c0 .682.208 1.27.509 1.671.3.401.659.579.991.579.332 0 .69-.178.991-.579.3-.4.509-.99.509-1.671a8.222 8.222 0 0 0-2.416-5.834ZM15.75 12a3.75 3.75 0 1 0-7.5 0 3.75 3.75 0 0 0 7.5 0Z"
                        clip-rule="evenodd"
                    />
                </svg>
                <input
                    id="password"
                    bind:value={$form.email}
                    type="email"
                    placeholder="email"
                    autocomplete="email"
                    required
                    class="block w-full bg-transparent border-0 rounded py-2 text-gray-800 shadow-sm placeholder:text-gray-400 sm:text-sm sm:leading-6 focus:ring-0"
                />
            </div>
        </div>

        <div class="mb-6">
            <div class="text-end font-semibold text-gray-600 p-1">
                <a use:inertia href="/forgot-password">
                    <button
                        class="text-center w-fit btn-sm rounded text-indigo-600"
                    >
                        Mot de passe oublié
                    </button>
                </a>
            </div>
            <div
                class="mt-1 items-center flex border ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 rounded"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="currentColor"
                    class="size-6 mx-2"
                >
                    <path
                        fill-rule="evenodd"
                        d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z"
                        clip-rule="evenodd"
                    />
                </svg>
                <input
                    id="password"
                    bind:value={$form.password}
                    type="password"
                    placeholder="password"
                    required
                    class="block w-full bg-transparent border-0 rounded py-2 text-gray-800 shadow-sm placeholder:text-gray-400 sm:text-sm sm:leading-6 focus:ring-0"
                />
            </div>
        </div>

        <div>
            <button
                disabled={$form.processing}
                type="submit"
                class="flex w-full justify-center rounded-md bg-indigo-600 px-d py-2 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                >connexion</button
            >
        </div>
    </form>
</div>
