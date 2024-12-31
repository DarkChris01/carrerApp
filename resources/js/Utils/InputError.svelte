<script>
    export let message = "alert input error";
    export let size = "text-sm";
</script>

<div class="flex justify-start">
    <div class="p-1 bg-red-50 text-red-600 {size} w-fit px-2 rounded">
        {message}
    </div>
</div>
