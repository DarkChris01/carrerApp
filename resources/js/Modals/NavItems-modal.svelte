<script>
    import { page, useForm } from "@inertiajs/svelte";
    import { onMount } from "svelte";
    import { fadeIn } from "@dependencies/utilities.js";
    let target;
    let form = useForm();

    const logout = () => {
        $form.post("/logout", {
            onSuccess: () => {
                toast.success("Vous avez été deconnecté!");
            },
        });
    };
    onMount(() => {
        fadeIn(target, 200);
    });

    
</script>

<section
    class="md:hidden w-full opacity-0 absolute top-16 rounded left-0 bg-white border shadow"
    bind:this={target}
>
    <div class="p-1">
        <div class="">
            <button
                class="p-1 rounded hover:bg-gray-200 text-[14px] text-start w-full transition ease-in-out duration-300"
                >Toutes les offres</button
            >
        </div>
        <div class="">
            <button
                class="p-1 rounded hover:bg-gray-200 text-[14px] text-start w-full transition ease-in-out duration-300"
                >Mon secteur</button
            >
        </div>
        <div class="">
            <button
                class="p-1 rounded hover:bg-gray-200 text-[14px] text-start w-full transition ease-in-out duration-300"
                >Notifications</button
            >
        </div>
        <div class="">
            <button
                class="p-1 rounded hover:bg-gray-200 text-[14px] text-start w-full transition ease-in-out duration-300"
                >FAQ</button
            >
        </div>
    </div>
    {#if $page.props.auth.user}
        <form on:submit|preventDefault={logout}>
            <div class="relative">
                <div class="p-1">
                    <button
                        class="bg-red-600 p-1 flex justify-center items-center text-white rounded w-full"
                        >deconnexion</button
                    >
                </div>
            </div>
        </form>
    {/if}
</section>
