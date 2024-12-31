<script>
    import { router, useForm } from "@inertiajs/svelte";
    import { onMount, onDestroy } from "svelte";
    let error = false;
    onMount(() => {
        document.body.style.overflow = "hidden";
    });

    onDestroy(() => {
        document.body.style.overflow = "";
    });

    let form = useForm({
        password: null,
    });

    const handleDelete = () => {
        $form.delete("/profile");
    };
</script>

<section
    class="fixed h-screen top-0 left-0 w-full flex justify-center items-center bg-gray-800/80"
>
    <div class="mx-1 md:w-1/3 bg-white p-3 border rounded shadow">
        <button on:click>
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="size-8 stroke-gray-600 hover:stroke-gray-800"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M6 18 18 6M6 6l12 12"
                />
            </svg>
        </button>
        <div class="flex justify-center">
            <form on:submit|preventDefault={handleDelete}>
                <div>
                    <h1 class="text-center my-4 font-semibold text-gray-700">
                        Supprimer mon compte?
                    </h1>
                    <p>
                        En supprimant ce compte, vous perdrez toutes les données
                        relatives à celui-ci!
                    </p>
                    <p>Pour continuer entrez votre mot de passe et validez!</p>
                    <div class="md:flex justify-between w-full my-4">
                        <div class="md:w-full">
                            <input
                                class="border-0 w-full ring-2 rounded"
                                class:error
                                type="password"
                                bind:value={$form.password}
                            />
                        </div>
                        <button
                            class="bg-red-600 w-full md:w-fit text-white p-0.5 md:mx-1 my-2 md:my-0 rounded"
                            >continuer</button
                        >
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<style>
    .error {
        border: 1px solid rgb(250, 54, 54);
    }
    p {
        font-size: 12px;
        text-align: center;
        color: rgb(82, 82, 82);
    }
</style>
