<script>
    import { relativeTimeFormatter } from "@dependencies/utilities";
    import { get_notifications } from "@dependencies/load";
    import UserNotification from "@components/Notifications/User-notification.svelte";
    import { notifications_store } from "@dependencies/Stores/Store";
    import { page } from "@inertiajs/svelte";
    import Spinner from "@utils/Spinner.svelte";
    import axios from "axios";
    import { onMount, onDestroy } from "svelte";

    let processing = false;
    let isLoading = true;

    onMount(async () => {
        const response = await get_notifications();
        if (response.status === 200) {
            notifications_store.set(response.data);
            isLoading = false;
        }
    });

    const unreadNotification = $notifications_store
        ? $notifications_store.filter((notification) => {
              return notification.read_at === null;
          })
        : null;

    const MarkAllAsRead = async () => {
        if (unreadNotification.length > 0) {
            processing = true;
            const response = await axios.patch("/notifications");
            if (response.status === 200) {
                notifications_store.set(response.data);
                processing = false;
            }
        }
    };
</script>

<div class="fixed inset-0 z-50 flex items-center justify-center modal-overlay">
    <div class="bg-white rounded-lg shadow-lg p-4">
        <div
            class="overflow-y-auto scrollable p-1 select-none h-screen lg:w-[30rem] 2xl:w-[35rem] lg:h-[30rem] 2xl:h-[50rem]"
        >
            {#if !isLoading}
                <div class="mb-4 flex justify-between items-center">
                    <button on:click class="lg:hidden">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="size-5"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 18 18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                    <button
                        disabled={processing ||
                            !$notifications_store.some(
                                (element) => element.read_at === null,
                            )}
                        on:click={MarkAllAsRead}
                        type="button"
                        class="btn btn-error btn-sm shadow p-0.5 rounded text-white"
                        >Tout marquer comme lu !</button
                    >
                </div>
                <div class="text-gray-600 border-b text-start">
                    NOTIFICATIONS
                </div>
                {#each $notifications_store as notification}
                    <UserNotification {notification} on:click />
                {/each}
            {:else}
                <div class="flex w-full h-full justify-center items-center">
                    <Spinner />
                </div>
            {/if}
        </div>
        <div>
            <button
                class="mt-4 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
                on:click
            >
                Fermer
            </button>
        </div>
    </div>
</div>
