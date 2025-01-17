<script>
    import {
        relativeTimeFormatter,
        format_date_anglo_to_french,
    } from "@dependencies/utilities";
    import { notifications_store } from "@dependencies/Stores/Store";
    import ApprobationNotification from "@components/Notifications/Type/ApprobationNotification.svelte";
    import EntretienNotification from "@components/Notifications/Type/EntretienNotification.svelte";
    import JobCreatedNotification from "@components/Notifications/Type/JobCreatedNotification.svelte";
    import RejectionNotification from "@components/Notifications/Type/RejectionNotification.svelte";
    import InvitationNotification from "@components/Notifications/Type/InvitationNotification.svelte";
    import DeleteEntretienNotification from "@components/Notifications/Type/DeleteEntretienNotification.svelte";
    import UpdateEntretienNotification from "@components/Notifications/Type/UpdateEntretienNotification.svelte";
    import NotifyWhereUserSelectedForJob from "@components/Notifications/Type/NotifyWhereUserSelectedForJob.svelte";
    import NotificationAction from "@components/Notifications/NotificationAction.svelte";
    import axios from "axios";
    import { inertia, router } from "@inertiajs/svelte";
    export let notification;

    const markAsRead = async () => {
        if (!notification.read) {
            const response = await axios.patch(
                `/notifications/${notification.id}`,
            );
            if (response.status === 200) {
                notifications_store.update((notifications) => {
                    const index = notifications.findIndex(
                        (n) => n.id === notification.id,
                    );
                    notifications[index].read_at = format_date_anglo_to_french(
                        new Date(),
                    );
                    return notifications;
                });
            }
        }
    };

    let showAction = false;
    const toogleAction = () => {
        showAction = !showAction;
    };
</script>

<button
    class="my-2 relative text-sm w-full cursor-pointer hover:bg-gray-100 rounded p-2 text-gray-600 hover:text-gray-800"
    class:unread={!notification.read_at}
    on:click={markAsRead}
>
    {#if notification.type === "App\\Notifications\\ApprouvedNotification"}
        <ApprobationNotification {notification} />
    {:else if notification.type === "App\\Notifications\\CandidacyRejectedNotification"}
        <RejectionNotification {notification} />
    {:else if notification.type === "App\\Notifications\\EmployerInvitationNotification"}
        <InvitationNotification {notification} />
    {:else if notification.type === "App\\Notifications\\NewEntretienNotification"}
        <EntretienNotification {notification} />
    {:else if notification.type === "App\\Notifications\\NewJobCreatedNotification"}
        <JobCreatedNotification {notification} />
    {:else if notification.type === "App\\Notifications\\UpdateEntretienNotification"}
        <UpdateEntretienNotification {notification} />
    {:else if notification.type === "App\\Notifications\\DeleteEntretienNotification"}
        <DeleteEntretienNotification {notification} />
    {:else if notification.type === "App\\Notifications\\NotifyWhereUserSelectedForJob"}
        <NotifyWhereUserSelectedForJob {notification} />
    {/if}

    <div class="absolute top-1 right-2 z-50">
        <div class="relative">
            <button type="button" on:click={toogleAction}>
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="size-6"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"
                    />
                </svg>
            </button>
            {#if showAction}
                <!-- content here -->
                <NotificationAction {notification} />
            {/if}
        </div>
    </div>
</button>

<style>
    .unread {
        background-color: rgba(245, 245, 245, 0.171);
        border: 0.5px solid rgba(240, 240, 240, 0.397);
    }
</style>
