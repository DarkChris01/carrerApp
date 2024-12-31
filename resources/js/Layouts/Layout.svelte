<script>
    import Navbar from "@components/Navbar.svelte";
    import { Toaster } from "svelte-french-toast";
</script>


<div>
    <Navbar />
</div>
<slot></slot>
<div class="text-sm">
    <Toaster />
</div>
