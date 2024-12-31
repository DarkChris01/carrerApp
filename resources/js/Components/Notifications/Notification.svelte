<script>
    import NewCandidatureNotification from "@components/Notifications/Type/NewCandidatureNotification.svelte";
    import axios from "axios";
    export let notification;
</script>

<!-- svelte-ignore missing-declaration -->
<!-- svelte-ignore a11y-click-events-have-key-events -->
<!-- svelte-ignore a11y-no-static-element-interactions -->
<div
    class="font-light rounded text-start relative p-2 my-4 cursor-pointer hover:bg-gray-50"
    class:unreadDiv={!notification.read_at}
>
    <span
        class="w-4 h-4 rounded-full absolute -top-2 -left-2"
        class:unread={!notification.read_at}
    ></span>

    {#if notification.type === "App\\Notifications\\NewCandidatureNotification"}
        <NewCandidatureNotification {notification} />
    {/if}
</div>

<style>
    .unread {
        background-color: rgb(0, 130, 0);
    }

    .unreadDiv {
        background-color: rgba(233, 233, 233, 0.226);
    }
</style>
