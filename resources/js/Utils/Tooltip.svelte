<script>
    export let color = "text-gray-500";
    export let background = "bg-white";
    export let size="text-sm";
    export let message = "i am a tooltip";
    export let x = "left-5";
    export let y = "-bottom-4";
</script>

<span
    class="absolute z-50 border shadow {size} {y} {color} {background} p-1 px-2 rounded {x} w-max"
>
    {message}
</span>
