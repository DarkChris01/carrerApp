<script>
    import { router } from "@inertiajs/svelte";
    import { relativeTimeFormatter,format_date_anglo_to_french } from "@dependencies/utilities";
    export let notification;
</script>

<div class=" font-light">
    <div class="flex justify-start rounded">
        <div class="me-2 flex w-fit justify-center rounded">
            <img
                src={notification.data.sender.logo ??
                    "/storage/avatars/default/man.png"}
                class="size-14 m-1 rounded bg-primary"
                alt="avatar"
            />
        </div>
        <div class="text-gray-500 flex-1 text-start ">
            <button>
                <div class="text-gray-700 font-semibold text-start">
                    {notification.data.sender.name}
                </div>
                <p class="text-start">
                    {notification.data.content}
                </p>
            </button>
        </div>
    </div>
</div>
<div class="text-end text-sm text-red-600/80">
    {relativeTimeFormatter("fr-FR", new Date(notification.created_at))}
</div>