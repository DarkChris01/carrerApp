<script>
    import PrimaryButton from "@components/PrimaryButton.svelte";
    import { useForm, page } from "@inertiajs/svelte";
    import toast from "svelte-french-toast";
    export let user;

    let form = useForm({
        name: user.name,
        email: user.email,
    });

    const updateProfile = () => {
        $form.patch("/profile", {
            onSuccess: () => {
              $form.reset()
            },
            onError: (errors) => {
                toast.error(errors.email ? errors.email : errors.name);
            },
            preserveScroll: true,
            preserveState: false,
        });
    };
</script>

<div class="my-2">
    <form on:submit|preventDefault={updateProfile}>
        <div>
            <div class="border flex items-center my-2 rounded">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="currentColor"
                    class="size-6 mx-1 text-gray-600"
                >
                    <path
                        fill-rule="evenodd"
                        d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                        clip-rule="evenodd"
                    />
                </svg>
                <input
                    type="text"
                    bind:value={$form.name}
                    class="rounded p-1 border-0 ring-0 focus:ring-0 text-gray-600"
                />
            </div>
            <div class="border flex items-center my-2 rounded">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="currentColor"
                    class="size-6 mx-1 text-gray-600"
                >
                    <path
                        fill-rule="evenodd"
                        d="M17.834 6.166a8.25 8.25 0 1 0 0 11.668.75.75 0 0 1 1.06 1.06c-3.807 3.808-9.98 3.808-13.788 0-3.808-3.807-3.808-9.98 0-13.788 3.807-3.808 9.98-3.808 13.788 0A9.722 9.722 0 0 1 21.75 12c0 .975-.296 1.887-.809 2.571-.514.685-1.28 1.179-2.191 1.179-.904 0-1.666-.487-2.18-1.164a5.25 5.25 0 1 1-.82-6.26V8.25a.75.75 0 0 1 1.5 0V12c0 .682.208 1.27.509 1.671.3.401.659.579.991.579.332 0 .69-.178.991-.579.3-.4.509-.99.509-1.671a8.222 8.222 0 0 0-2.416-5.834ZM15.75 12a3.75 3.75 0 1 0-7.5 0 3.75 3.75 0 0 0 7.5 0Z"
                        clip-rule="evenodd"
                    />
                </svg>
                <input
                    type="email"
                    bind:value={$form.email}
                    class="rounded p-1 border-0 ring-0 focus:ring-0 text-gray-600"
                />
            </div>
            <div class="mt-2 w-full flex justify-end">
                <button
                    type="submit"
                    disabled={!$form.isDirty || $form.processing}
                    class="flex w-full content-center btn-primary btn btn-sm  2xl:btn-base  px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow shadow-gray-400/20 rounded focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    >Mettre à jour mes données</button
                >
            </div>
        </div>
    </form>
</div>
