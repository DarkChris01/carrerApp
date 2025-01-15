<script>
    import { inertia } from "@inertiajs/svelte";
    import { Toaster } from "svelte-french-toast";
    import { Link } from "@inertiajs/svelte";
</script>

<main class="background">
    <slot />
</main>
<div>
    <Toaster />
</div>

<style>
    .background {
        background-image: url("/storage/background/a.jpg");
    }
</style>
