<script>
    import { PrevisualiseUploadedFile } from "@dependencies/utilities.js";
    import { useForm } from "@inertiajs/svelte";
    import toast from "svelte-french-toast";
    export let user;
    let form = useForm({
        avatar: "",
    });
    let image;

    const update_avatar = () => {
        $form.post("/profile/avatar", {
            onSuccess: () => {
                toast.success("Update successfuly");
            },
        });
    };
</script>

<div class="flex justify-center items-center">
    <div>
        <div class="w-full flex justify-center items-center">
            <div
                bind:this={image}
                class=" relative avatar flex h-20 lg:w-32 w-20 lg:h-32 border rounded-full justify-center"
                style="background-image: url({user.avatars ??
                    'storage/avatars/default/man.png'});"
            ></div>
        </div>
        <form
            class="flex justify-between w-full"
            on:submit|preventDefault={update_avatar}
            enctype="multipart/form-data"
        >
            <div class="flex justify-between items-center w-full">
                <div class="relative w-6 h-6 overflow-hidden me-2">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="size-6 top-0 absolute"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z"
                        />
                    </svg>

                    <input
                        class="opacity-0 absolute top-0"
                        type="file"
                        on:input={(e) => {
                            PrevisualiseUploadedFile(e, image);
                            $form.avatar = e.target.files[0];
                        }}
                    />
                </div>
                <button
                    disabled={$form.processing}
                    class="bg-violet-700 border border-violet-600 rounded text-white hover:bg-violet-500 text-sm p-1 shadow"
                >
                    mettre à jour la photo
                </button>
            </div>
        </form>
    </div>
</div>
{#if $form.errors.avatar}
    {$form.errors.avatar}
{/if}
