<script>
    import Navbar from "@components/Navbar.svelte";
    import { inertia, page } from "@inertiajs/svelte";
    import NavbarItems from "@components/Navbar-Items.svelte";
    import { Toaster } from "svelte-french-toast";
    import LeftSideBar from "@components/Left-side-bar.svelte";
</script>

<div class="flex justify-center">
    <div class="w-full lg:w-4/5 2xl:w-3/4">
            <Navbar />
        <div>
            <div class="flex w-full items-end justify-center">
                <NavbarItems />
            </div>
        </div>
        <section class="my-2">
            <div class="flex">
                <div
                    class="border border-gray-400/40 hidden md:block md:w-1/4 h-fit bg-white overflow-y-auto scrollable rounded"
                >
                    <LeftSideBar />
                </div>
                <div
                    class="w-full md:w-3/4 md:ms-1 bg-white p-1 lg:p-4 border border-gray-400/40"
                >
                    <slot />
                </div>
            </div>
        </section>
    </div>
</div>

<div class="text-sm">
    <Toaster />
</div>
