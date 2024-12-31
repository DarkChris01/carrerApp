<script>
    import { inertia } from "@inertiajs/svelte";
    export let datas;
</script>

<div
    class="flex font-thin justify-center items-end text-gray-500 text-sm p-1 mt-4"
>
    <div class="hidden md:block">
        {#if datas.to}
            <div class="mx-2">
                from {datas.from} to {datas.to} on {datas.total}
            </div>
        {/if}
    </div>
    <div>
        {#each datas.links as link}
            <button type="button">
                <a
                    class:unClickable={link.url === null}
                    use:inertia={{ preserveScroll: true }}
                    class={link.active
                        ? "border px-2 mx-0.5 shadow lg:px-4 p-0.5 bg-indigo-400 border-indgo-800 text-gray-300 pointer-events-none"
                        : "px-2 border mx-0.5 shadow lg:px-4 p-0.5 hover:bg-gray-400 hover:text-white"}
                    href={link.url}
                    aria-label="pagination"
                >
                    {@html link.label}
                </a>
            </button>
        {/each}
    </div>
</div>

<style>
    .unClickable {
        pointer-events: none;
    }
</style>
