<script>
    import { inertia } from "@inertiajs/svelte";
</script>

<div>
    <div class="flex items-baseline justify-end">
        <a
            use:inertia
            href="/faq"
            class="text-gray-100 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium"
            >FAQ</a
        >
    </div>
</div>
