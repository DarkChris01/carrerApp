<script>
    export let background = "bg-indigo-500";
    export let spinnerColor = "border-white";
    export let height = "h-8";
    export let width = "w-8";
    export let margin ="mr-3"
</script>

<div type="button" class="{background} rounded p-1 flex items-end" disabled>
    <svg
        class="animate-spin {height} {width} {margin} border-l-2 border-t-2 rounded-full {spinnerColor}"
        viewBox="0 0 24 24"
    >
    </svg>
</div>
