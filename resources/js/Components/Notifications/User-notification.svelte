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
</script>

<button
    class="mt-1 text-sm w-full cursor-pointer hover:bg-gray-50 rounded p-1 text-gray-600 hover:text-gray-800"
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
</button>

<style>
    .unread {
        background-color: rgba(245, 245, 245, 0.171);
        border: 0.5px solid rgba(240, 240, 240, 0.397);
    }
</style>
