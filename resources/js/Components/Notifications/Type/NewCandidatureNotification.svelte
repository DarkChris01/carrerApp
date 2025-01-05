<script>
    import { relativeTimeFormatter } from "@dependencies/utilities";
    import { router, page, inertia } from "@inertiajs/svelte";
    import { notifications_store } from "@dependencies/Stores/store";
    import axios from "axios";
    export let notification;

    const mark_as_read = async () => {
        const request = await axios.patch(
            `/employer/notifications/${notification.id}`,
        );
        if (request.status === 200) {
            notifications_store.update((notifications) => {
                const index = notifications.findIndex(
                    (value) => value.id == notification.id,
                );
                notifications[index].read_at = new Date();
                return notifications;
            });
        }
    };

    const delete_notification = async () => {
        const request = await axios.delete(
            "/employer/notifications/" + notification.id,
        );
        if (request.status === 200) {
            notifications_store.update((notifications) => {
                return notifications.filter(
                    (value) => value.id !== notification.id,
                );
                return notifications;
            });
        }
    };

    const redirecTo = () => {
        mark_as_read();
        router.visit(
            `/candidatures?offre=${notification.data.job.id}#${notification.data.cv.id}`,
            { preserveScroll: true },
        );
    };
</script>

<div>
    <div class="items-end flex justify-start">
        <div class="bg-primary w-fit">
            <img
                src={notification.notifiable.logo}
                alt="photo_employer"
                class="w-12 h-12 text-gray-800"
            />
        </div>

        <!-- svelte-ignore a11y-click-events-have-key-events -->
        <!-- svelte-ignore a11y-no-noninteractive-element-interactions -->
        <!-- svelte-ignore a11y-no-static-element-interactions -->
        <div on:click={redirecTo}>
            <p
                class="flex justify-end w-fit text-xs px-1 bg-red-600 rounded text-white ms-2"
            >
                {relativeTimeFormatter("FR-fr", notification.created_at)}
            </p>
            {#if notification.type === "App\\Notifications\\NewCandidatureNotification"}
                <p class="px-2">
                    {notification.data.content}
                </p>
            {/if}
        </div>
    </div>
</div>
<div class="absolute top-2 right-4 flex justify-end">
    <a use:inertia href="/employer/curicculum-vitae/{notification.data.cv.id}">
        <button
            class="btn flex items-center btn-info btn-xs me-1 text-white p-0.5 rounded my-1 px-2"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="size-4 stroke-white"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                />
            </svg>
            candidat
        </button>
    </a>

    {#if !notification.read_at}
        <button
            on:click={mark_as_read}
            class="btn btn-primary btn-xs text-white rounded p-0.5 my-1 px-2"
            >Marquer comme lu</button
        >
    {/if}
    <button
        on:click={delete_notification}
        class="text-white p-0.5 ro my-1 px-2"
        ><svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="size-5 stroke-red-600 hover:stroke-red-400"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
            />
        </svg>
    </button>
</div>
