<script>
    import PrimaryButton from "@components/PrimaryButton.svelte";
    import { useForm, page } from "@inertiajs/svelte";
    import toast from "svelte-french-toast";
    export let user;

    let form = useForm({
        name: user.name,
        email: user.email,
        poste: user.poste,
    });

    const updateProfile = () => {
        $form.patch("/employer/profile", {
            onError: (errors) => {
                toast.error(errors.email ? errors.email : errors.name);
            },
            preserveScroll: true,
            preserveState: false,
        });
    };
</script>
<main>
    <div class="my-2">
        <form on:submit|preventDefault={updateProfile}>
            <div class="flex items-center my-2 rounded ring-2">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="size-6 mx-1 text-gray-600"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z"
                    />
                </svg>

                <input
                    type="text"
                    bind:value={$form.poste}
                    class="rounded p-1 w-full bg-transparent  border-0 focus:ring-0 text-gray-600"
                />
            </div>
            <div>
                <div class="flex items-center my-2 rounded ring-2">
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
                        class="rounded p-1 w-full bg-transparent border-0 focus:ring-0 text-gray-600"
                    />
                </div>
                <div class="flex items-center my-2 rounded ring-2">
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
                        class="rounded p-1 w-full bg-transparent border-0 focus:ring-0 text-gray-600"
                    />
                </div>
                <div class="mt-2 flex justify-end">
                    <button
                        disabled={$form.processing}
                        type="submit"
                        class="flex justify-center w-full rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow shadow-indigo-600/50 hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        >Mettre à jour mes données</button
                    >
                </div>
            </div>
        </form>
    </div>
</main>
