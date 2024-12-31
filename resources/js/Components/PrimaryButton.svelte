<script>
    export let disabled = "false";
    export let background = "bg-indigo-600";
    export let color = "text-white";
    export let content = "primary button";
    export let large = "w-fit";
</script>

<button
  type="button"
    {disabled}
    class="inline-flex {large} justify-center items-center px-4 py-1.5 {background} border border-transparent rounded-md font-semibold text-sm {color} uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
>
    {content}
</button>
