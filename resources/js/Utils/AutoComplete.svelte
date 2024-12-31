<script>
    import { inertia, router } from "@inertiajs/svelte";
    import { AutoCompleteStoreComponent } from "@dependencies/Stores/Modal";
    export let word;
    const redirectTo = () => {
        AutoCompleteStoreComponent.set(false);
        router.get(`?`, { search: word.intitules }, { preserveScroll: true });
    };
</script>

<button
    on:click={redirectTo}
    class="w-full text-nowrap text-start text-sm mb-1 block capitalize hover:bg-gray-50 transition duration-50 ease-linear rounded p-1 px-2"
>
    {word.intitules}
</button>
