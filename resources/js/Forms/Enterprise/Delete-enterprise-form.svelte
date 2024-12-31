<script>
    import { useForm } from "@inertiajs/svelte";
    import toast from "svelte-french-toast";

    const form = useForm({
        password: null,
    });

    const handleDelete = () => {
        $form.delete("/my-enterprise", {
            onSuccess: () => {
                toast.success("Suppression reussie!");
            },
        });
    };
</script>

<!-- svelte-ignore a11y-click-events-have-key-events -->
<!-- svelte-ignore a11y-no-noninteractive-element-interactions -->
<main
    on:click|self
    class="fixed left-0 top-0 flex justify-center items-center w-full h-full bg-gray-950/90"
>
    <div
        class="bg-white p-4 w-full mx-2 md:w-2/5 rounded overflow-y-auto scrollable"
    >
        <div>
            <h1 class="text-center">
                Vous allez effacer toutes les données de votre entreprise
            </h1>
            <p class="text-gray-500 text-sm font-thin text-center">
                <span class="text-red-600 text-md">ATTENTION </span>Les donnéées
                supprimées ne pourront être recupérées!
            </p>
        </div>
        <form on:submit|preventDefault={handleDelete}>
            <div class="flex p-2">
                <input
                    class="w-full rounded ring-2 border-0"
                    type="password"
                    bind:value={$form.password}
                />
                <button
                    type="submit"
                    class="text-white rounded px-3 bg-red-600 p-1 ms-4"
                    >Delete</button
                >
            </div>
        </form>
    </div>
</main>
