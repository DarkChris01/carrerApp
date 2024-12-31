<script>
    export let disabled;
    export let background;
    export let color;
    export let content;
    export let type;
</script>

<button
    {type}
    {disabled}
    class="inline-flex items-center px-4 py-2 {background="bg-red-600"} border border-transparent rounded-md font-semibold text-sm {color} uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
>
    {content}
</button>
