<script setup>
    import InputError from "@/utils/InputError.svelte";
    import PrimaryButton from "@/utils/PrimaryButton.svelte";
    import { useForm } from "@inertiajs/svelte";

    const form = useForm({
        email: null,
    });

    const submit = () => {
        $form.post("/forgot-password");
    };
</script>

<main
    class="fixed flex h-screen w-full justify-center items-center top-0 left-0"
>
    <div class="w-full lg:w-1/3 mx-1 bg-white p-3 rounded shadow border">
        <div class="mb-4 text-sm text-gray-600">
            <h1 class="text-gray-700 font-semibold mb-4 text-sm">
                Mot de passe oublié ?
            </h1>

            Pas de panique entrez votre addresse email et vous recevrez un email
            contenant votre nouveau mot de passe
        </div>

        <form on:submit|preventDefault={submit}>
            <div>
                <label for="email" class="text-gray-600"> email</label>

                <input
                    id="email"
                    type="email"
                    class="mt-1 m-0 text-sm block w-full ring-1 border-none rounded focus:ring-orange-500"
                    bind:value={$form.email}
                    required
                    autocomplete="username"
                />
                {#if $form.errors.email}
                    <div class="mt-1">
                        <InputError
                            size="text-sm"
                            message={$form.errors.email}
                        />
                    </div>
                {/if}
            </div>

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton
                    content="Réinitialiser"
                    disabled={$form.processing}
                >
                    Envoyer
                </PrimaryButton>
            </div>
        </form>
    </div>
</main>
