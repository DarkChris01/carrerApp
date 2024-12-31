<script>
    import toast from "svelte-french-toast";
    import { useForm } from "@inertiajs/svelte";
    import { notifications_store } from "@dependencies/Stores/Store";
    import { onMount, onDestroy } from "svelte";
    import {
        format_date_anglo_to_french,
        compareDate,
    } from "@dependencies/utilities";
    import axios from "axios";
    export let cv;
    let close;
    let isLoading = false;

    onMount(() => {
        document.body.overflow = "hidden";
    });

    onDestroy(() => {
        document.body.overflow = "";
    });

    const form = {
        user: cv.user.id,
        content: `Bonjour ${
            cv.sexe === "man" ? " Mr " : " Mme "
        }, nous sommes interessés par votre profil !`,
    };

    const HandleNotification = async () => {
        isLoading = true;
        const request = await axios.post(
            "/employer/notifications/invitation",
            form,
        );

        if (request.status === 200) {
            close.click();
            toast.success("Notification envoyé !");
            isLoading = false;
        } else {
            toast.success("error occured !");
            isLoading = false;
        }
    };
</script>

<div
    class="fixed bottom-2 right-2 text-sm lg:w-1/3 p-4 w-fit border shadow shadow-gray-500/40 bg-white rounded"
>
    <div>
        Envoyer un message à <span class="capilalize font-semibold"
            >{cv.firstName}</span
        >
    </div>
    <div>
        <form
            class="text-gray-600"
            on:submit|preventDefault={HandleNotification}
        >
            <div class="my-2">
                <textarea
                    required
                    class="border-0 rounded ring-1 hover:ring-indigo-600/50 ring-gray-400/40 p-2 w-full placeholder:text-gray-500"
                    rows="5"
                    placeholder="Bonjour "
                    bind:value={form.content}
                ></textarea>
            </div>

            <div class="flex justify-end w-full">
                <button
                    disabled={isLoading}
                    type="submit"
                    class=" btn btn-success btn-xs p-0.5 px-2 rounded text-white"
                    >ENVOYER</button
                >
            </div>
            <button
                class="absolute right-1 top-1 bg-white"
                type="button"
                bind:this={close}
                on:click
                ><svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="size-6 stroke-red-400 hover:stroke-red-500 transition duration-300 ease stroke-2"
                    ><path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6 18 18 6M6 6l12 12"
                        class="s-Bvfug3EMIymk"
                    ></path></svg
                ></button
            >
        </form>
    </div>
</div>
