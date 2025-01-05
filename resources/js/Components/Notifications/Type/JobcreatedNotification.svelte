<script>
    import { router } from "@inertiajs/svelte";
    import { relativeTimeFormatter } from "@dependencies/utilities";

    export let notification;

    const redirectToJob = (job) => {
        router.visit(`/job/mon-offre/${job}`, { only: ["job"] });
    };
</script>

<div class=" font-light">
    <div class="flex w-fit justify-center items-start rounded-full">
        <!-- svelte-ignore a11y-no-static-element-interactions -->
        <!-- svelte-ignore a11y-click-events-have-key-events -->
        <div
            on:click
            class="me-2 border flex w-fit justify-center items-center bg-gray-100 rounded-full"
        >
            <img
                src={notification.data.sender.logo ??
                    "/storage/avatars/default/man.png"}
               class="size-14 m-1 rounded bg-primary"
                alt="avatar"
            />
        </div>
        <div class="flex-1 text-start ">
            {#if notification.type === "App\\Notifications\\NewJobCreatedNotification"}
                <button
                    on:click={() => redirectToJob(notification.data.job.id)}
                >
                    <div
                        class="text-gray-500 font-semibold text-start "
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
