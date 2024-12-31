<script>
    import { page } from "@dependencies/Stores/Store";
    import toast from "svelte-french-toast";
    import { onMount } from "svelte";
    import Cv from "@components/Cv/Cv.svelte";
    import { inertia } from "@inertiajs/svelte";
</script>

<div
    class="h-screen md:h-[32rem] lg:h-[36rem] 2xl:h-[55rem] overflow-y-auto scrollable p-1"
>
    <Cv />

    <div
        class="flex w-full justify-end items-center border-t bg-white px-2 md:px-4 p-2 mt-8 absolute bottom-0 left-0"
    >


        <button
            class="bg-indigo-700 rounded p-1 hover:bg-indigo-500 text-white"
        >
            <a use:inertia href="/profile"> Terminer </a>
        </button>
    </div>
</div>
