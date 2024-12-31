<script>
    export let content = "badge";
    export let background = "bg-red-600";
    export let color = "text-white";
    export let width = "w-4";
    export let height = "h-4";
    export let posX = "-left-1";
    export let posY = "-bottom-2";
    export let fontSize = "text-[12px]";
</script>

<span
    class="absolute {background} {width} {height} {color} {posX} {posY} {fontSize} flex justify-center items-center rounded-full"
    >{content}</span
>
