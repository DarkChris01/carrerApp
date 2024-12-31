<script>
    import Notification from "@components/Notifications/Notification.svelte";
    import { notifications_store } from "@dependencies/Stores/Store";
    import { page } from "@inertiajs/svelte";
    import axios from "axios";
    import { onMount } from "svelte";

    notifications_store.set($page.props.auth.notifications);

    const mark_all_as_read = async () => {
        const request = await axios.patch("/employer/notifications");
        if (request.status === 200) {
            notifications_store.set(request.data);
        }
    };

    const delete_all = async () => {
        const request = await axios.delete("/employer/notifications");
        if (request.status === 200) {
            notifications_store.set([]);
        }
    };
</script>

<main class="my-10 p-1 lg:p-8">
    <div class="mx-auto min-h-[50rem] p-4 w-full lg:w-3/4 2xl:w-2/3 border rounded bg-white">
        <div>
            <h1 class="flex items-center">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="size-5 me-1"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"
                    />
                </svg>

                Notifications
            </h1>
        </div>
        <div class="flex justify-end text-sm">
            {#if $notifications_store.some((notification) => notification.read_at === null)}
                <button
                    on:click={mark_all_as_read}
                    class="p-1 bg-orange-600 text-white text-sm rounded hover:bg-orange-500 shadow hover:shadow-gray-200/80 shadow-400/80"
                    >Tout marquer comme lu</button
                >
            {/if}

            {#if $notifications_store.length > 0}
                <button
                    on:click={delete_all}
                    class="p-1 ms-3 flex items-center bg-red-600 text-white text-sm rounded hover:bg-red-500 shadow hover:shadow-gray-200/80 shadow-400/80"
                    >Tout supprimer <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="size-4 ms-2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                        />
                    </svg>
                </button>
            {/if}
        </div>
        <div class="text-gray-600 text-sm">
            {#each $notifications_store as notification}
                <Notification {notification} />
            {:else}
                <div
                    class="text-center justify-center h-[18rem] text-sm items-center flex"
                >
                    Aucune notification
                </div>
            {/each}
        </div>
    </div>
</main>
