<script>
    import { relativeTimeFormatter } from "@dependencies/utilities";
    export let notification;
</script>

<div class=" font-light">
    <div class="flex w-fit justify-center items-end rounded-full">
        <!-- svelte-ignore a11y-no-static-element-interactions -->
        <div
            class="me-2 border flex w-fit justify-center items-center bg-gray-100 rounded-full"
        >
            <img
                src={notification.data.sender.avatars ??
                    "/storage/avatars/default/man.png"}
                class="size-8 m-1 rounded-full"
                alt="avatar"
            />
        </div>
        <div class="text-gray-600">
            {#if notification.type === "App\\Notifications\\NewJobCreatedNotification"}
                <button>
                    <div
                        class="text-gray-500 font-semibold text-start text-sm"
                    >
                        {notification.data.sender.name}
                    </div>
                    {notification.data.content}
                </button>
            {:else}
                <div class="text-gray-500 ">
                    {notification.data.sender.name}
                </div>
                {notification.data.content}
            {/if}
        </div>
    </div>
</div>
<div class="text-end text-sm text-red-600/80">
    {relativeTimeFormatter("fr-FR", new Date(notification.created_at))}
</div>
