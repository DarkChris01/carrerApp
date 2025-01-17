<script>
    import Navbar from "@components/Navbar.svelte";
    import { Toaster } from "svelte-french-toast";
</script>

<div class="flex justify-center my-2">
    <div class="w-full xl:w-/4">
        <Navbar />

        <slot />
    </div>
</div>
<Toaster />
