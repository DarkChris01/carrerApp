<script>
    import { router } from "@inertiajs/svelte";
    export let notification;

    const archivate = () => {
        router.post(`/notifications/archivate${notifcation.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                toast.success("deleted successfuly !");
            },
            onError: () => {
                toast.error("error occured");
            },
        });
    };

    const destroy = () => {
        router.post(`/notifications/${notifcation.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                toast.success("deleted successfuly !");
            },
            onError: () => {
                toast.error("error occured");
            },
        });
    };
</script>

<div class="absolute top-5 right-2 bg-white shadow border rounded-lg p-2">
    <div class="hover:bg-gray-100 p-1">
        <button
            class=" text-gray-700 font-medium px-4 text-start py-0.5 rounded"
            on:click={() => destroy()}
        >
            Supprimer
        </button>
    </div>
    <div class="hover:bg-gray-100 p-1">
        <button
            class=" text-gray-700 font-medium px-4 text-start py-0.5 rounded"
            on:click={() => archivate()}
        >
            Archiver
        </button>
    </div>
</div>
