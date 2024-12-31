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
        $form.post("/employer/udpate/avatar", {
            onSuccess: () => {
                toast.success("Update successfuly");
            },
            onError: (errors) => {
                toast.error(errors.avatar);
            },
        });
    };
</script>

<div class="">
    <div class="relative w-full">
        <div class="flex justify-center items-center">
            <div
                class="ring-orange-400 ring-offset-base-100 rounded-full ring w-24 h-24  md:w-32 md:h-32 ring-offset-2 m-2"
            >
                <img
                    class="rounded-full img-previsualize"
                    src={user.avatars ??
                        "https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp"}
                    alt="avatar"
                />
            </div>
        </div>
        <div class="absolute bottom-2 left-4">
            <div class="relative w-8 h-8 overflow-hidden me-2">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="size-7 top-0 absolute fill-blue-800 stroke-white"
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
                        PrevisualiseUploadedFile(e);
                        $form.avatar = e.target.files[0];
                    }}
                />
            </div>
        </div>
        <div class="absolute bottom-3 right-1">
            <form
                on:submit|preventDefault={update_avatar}
                enctype="multipart/form-data"
            >
                <button
                    disabled={$form.processing}
                    class="bg-indigo-600 rounded text-gray-100 hover:bg-indigo-600 border border-indigo-600 text-sm p-1 shadow"
                >
                    modifier
                </button>
            </form>
        </div>
    </div>
</div>
