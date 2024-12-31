<script>
    import { inertia } from "@inertiajs/svelte";
    import { Toaster } from "svelte-french-toast";
    import { Link } from "@inertiajs/svelte";
</script>

<main class="min-h-screen my-8 p-0 bg-gradient-to-r">
    <div class="flex justify-end">
        <Link class="px-4 flex items-center text-sm p-2" href="/">
            <span class="mx-1"
                ><svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="size-4 hover:scale-125 stroke-gray-800"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"
                    />
                </svg>
            </span> acceuil</Link
        >
    </div>
    <slot />
</main>
<div class="text-sm">
    <Toaster />
</div>

