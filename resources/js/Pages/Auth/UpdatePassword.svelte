<script setup>
    import InputError from "@utils/InputError.svelte";
    import { useForm } from "@inertiajs/svelte";

    const form = useForm({
        current_password: null,
        password: null,
        password_confirmation: null,
    });

    const submit = () => {
        $form.put("/password");
    };
</script>

<main
    class="fixed flex h-screen w-full justify-center items-center top-0 left-0"
>
    <div class="w-full mx-1 lg:w-1/3 bg-white p-6 rounded shadow border">
        <div class="mb-14">
            <h1 class=" font-bold text-sm text-gray-600/90 text-center">
                Modifier votre mot de passe
            </h1>
        </div>
        <form on:submit|preventDefault={submit}>
            <div class="mt-4">
                <label for="current_password" class="text-gray-500 text-sm"
                    >Entrez votre mot de passe</label
                >
                <input
                    id="password"
                    type="password"
                    placeholder="votre mot de passe"
                    class="mt-1 block w-full placeholder:text-gray-400 p-1 rounded border-none ring-1 my-2 placeholder:text-sm"
                    bind:value={$form.current_password}
                    required
                />
                {#if $form.errors.current_password}
                    <div class="mt-2">
                        <InputError
                            size="text-sm"
                            message={$form.errors.current_password}
                        />
                    </div>
                {/if}
            </div>

            <div class="mt-4">
                <label for="current_password" class="text-gray-500 text-sm"
                    >Entrez votre nouveau mot de passe</label
                >

                <input
                    id="password"
                    type="password"
                    placeholder="nouveau mot de passe"
                    class="mt-1 block w-full placeholder:text-gray-400 p-1 rounded border-none ring-1 my-2 placeholder:text-sm"
                    bind:value={$form.password}
                    required
                />
            </div>

            <div class="mt-4">
                <label for="current_password" class="text-gray-500 text-sm"
                    >Confirmez votre mot de passe</label
                >

                <input
                    id="password_confirmation"
                    type="password"
                    placeholder="confirmer mot de passe"
                    class="mt-1 block w-full placeholder:text-gray-400 p-1 rounded border-none ring-1 my-2 placeholder:text-sm"
                    bind:value={$form.password_confirmation}
                    required
                />
                {#if $form.errors.password_confirmation}
                    <InputError
                        class="mt-2"
                        message={$form.errors.password_confirmation}
                    />
                {/if}
                {#if $form.errors.password}
                    <div class="mt-2">
                        <InputError
                            size="text-sm"
                            message={$form.errors.password}
                        />
                    </div>
                {/if}
            </div>

            <div class="flex items-center justify-end mt-4">
                <button
                    type="submit"
                    disabled={$form.processing || !$form.isDirty}
                    class="btn rounded btn-xs btn-warning"
                >
                   Modifier
                </button>
            </div>
        </form>
    </div>
</main>
