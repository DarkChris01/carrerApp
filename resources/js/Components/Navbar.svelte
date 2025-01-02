<script>
    import Tooltip from "@utils/Tooltip.svelte";
    import Badge from "@utils/Badge.svelte";
    import { inertia, page, useForm } from "@inertiajs/svelte";
    import {
        candidatureModalComponent,
        entretienModalComponent,
        notificationModalComponent,
        autoCompletionModalComponent,
    } from "@dependencies/Stores/Modal";
    import toast from "svelte-french-toast";
    import Logo from "@components/Logo.svelte";
    import NavItemsModal from "@modals/NavItems-modal.svelte";
    import NotificationModal from "@components/Notifications/Notification-modal.svelte";
    import { notifications_store } from "@dependencies/Stores/Store";
    import axios from "axios";
    import Candidacies from "@components/User/Candidacies.svelte";
    import Entretiens from "@components/User/Entretiens.svelte";
    let hover = false;
    let time;
    let form = useForm();
    let showmenu = false;
    let modal = false;
    let connected = $page.props.auth.user !== null;
    notifications_store.set($page.props.auth.notifications);

    const showTooltip = () => {
        time = setTimeout(() => {
            hover = true;
        }, 1000);
    };

    const showNavbarModal = () => {
        modal = !modal;
    };

    const hideTooltip = () => {
        clearTimeout(time);
        setTimeout(() => {
            hover = false;
        }, 1000);
    };

    $: if ($page.props) {
        notificationModalComponent.set(false);
        candidatureModalComponent.set(false);
        entretienModalComponent.set(false);
    }

    const logout = () => {
        $form.post("/logout", {
            onSuccess: () => {
                toast.success("Vous avez été deconnecté!");
            },
        });
    };
    const toggleMenu = () => {
        showmenu = !showmenu;
        notificationModalComponent.set(false);
        candidatureModalComponent.set(false);
        entretienModalComponent.set(false);
    };

    const ToogleNotificationModal = () => {
        showmenu = false;
        notificationModalComponent.set(!$notificationModalComponent);
        candidatureModalComponent.set(false);
        entretienModalComponent.set(false);
        autoCompletionModalComponent.set(false);
    };

    const toggleCandidature = () => {
        showmenu = false;
        candidatureModalComponent.set(!$candidatureModalComponent);
        entretienModalComponent.set(false);
        notificationModalComponent.set(false);
        autoCompletionModalComponent.set(false);
    };

    const toggleEntretien = () => {
        showmenu = false;
        entretienModalComponent.set(!$entretienModalComponent);
        candidatureModalComponent.set(false);
        notificationModalComponent.set(false);
        autoCompletionModalComponent.set(false);
    };
</script>

<div
    class="flex justify-between items-center relative text-xs p-1 bg-transparent"
>
    <div class="hidden md:flex items-center">
        <Logo />
    </div>

    <div class="flex justify-between items-center w-full">
        <div
            class="flex items-center justify-start lg:justify-end w-full h-full text-xs flex-nowrap"
        >
            {#if $page.props.auth.user && !$page.props.auth.isEmployer}
                <div class="relative">
                    <button
                        on:click|self={toggleEntretien}
                        class="text-nowrap btn hidden btn-xs text-xs mx-2 lg:flex items-center hover:bg-gray-300 rounded"
                    >
                        Entretiens
                        <span class="text-red-600 bg-white  w-5 h-5 flex justify-center items-center p-1 rounded-full"
                            >{$page.props.auth.entretiens}</span
                        >
                    </button>
                    {#if $entretienModalComponent}
                        <div>
                            <Entretiens
                                on:click={() =>
                                    entretienModalComponent.set(false)}
                            />
                        </div>
                    {/if}
                </div>
                <div class="relative">
                    <button
                        on:click|self={toggleCandidature}
                        class="text-nowrap btn btn-xs hidden lg:flex text-xs mx-2 items-center hover:bg-gray-300 rounded"
                    >
                        candidatures
                        <span class="text-red-600 bg-white p-1 w-5 h-5 flex justify-center items-center rounded-full"
                            >{$page.props.auth.candidacies}</span
                        >
                    </button>
                    {#if $candidatureModalComponent}
                        <div>
                            <Candidacies
                                on:click={() =>
                                    candidatureModalComponent.set(false)}
                            />
                        </div>
                    {/if}
                </div>

                <div class="relative flex justify-center items-end">
                    <button
                        type="button"
                        on:click={ToogleNotificationModal}
                        class="ms-2"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="size-5 lg:size-6"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"
                            />
                        </svg>

                        {#if $notifications_store.filter((notification) => {
                            return notification.read_at === null;
                        }).length}
                            <Badge
                                posX="left-5"
                                posY="-top-2"
                                content={$notifications_store.filter(
                                    (notification) => {
                                        return notification.read_at === null;
                                    },
                                ).length < 20
                                    ? $notifications_store.filter(
                                          (notification) => {
                                              return (
                                                  notification.read_at === null
                                              );
                                          },
                                      ).length
                                    : "+20"}
                            />
                        {/if}
                    </button>
                    {#if $notificationModalComponent}
                        <NotificationModal
                            notifications={$notifications_store}
                            on:click={() =>
                                notificationModalComponent.set(false)}
                        />
                    {/if}
                </div>
            {/if}
        </div>
        <div class="relative ms-8">
            <div class="flex items-end text-xs font-semibold">
                <button on:click={toggleMenu}>
                    <img
                        alt="avatar"
                        class="w-10 h-10 p-0.5 rounded-full border"
                        src={$page.props.auth.user?.avatars ??
                            "/storage/avatars/default/man.png"}
                    />
                    <div
                        class="badge absolute bottom-0 badge-error left-0 badge-xs"
                        class:connected
                    ></div>
                </button>
            </div>

            {#if showmenu}
                <ul
                    class="menu menu-base absolute top-8 right-4 bg-base-100 rounded z-10 mt-3 min-w-48 p-2 shadow"
                >
                    {#if $page.props.auth.user}
                        <li class="mt-1">
                            <a
                                class="justify-between flex items-center"
                                use:inertia
                                href="/profile"
                            >
                                Profil

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="size-6 ms-1 stroke-indigo-600 stroke-2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                                    />
                                </svg>
                            </a>
                        </li>

                        <div class="relative px-1">
                            <li>
                                <button
                                    on:click|self={toggleEntretien}
                                    class="text-nowrap flex items-center justify-start lg:hidden w-full px-2 mt-1 rounded p-0.5"
                                >
                                    Entretiens
                                    <span
                                        class="text-white w-4 h-4 flex justify-center items-center bg-red-600 p-1 rounded-full"
                                        >{$page.props.auth.entretiens}</span
                                    >
                                </button>
                            </li>
                            {#if $entretienModalComponent}
                                <div>
                                    <Entretiens
                                        on:click={() =>
                                            entretienModalComponent.set(false)}
                                    />
                                </div>
                            {/if}
                        </div>
                        <div class="relative px-1">
                            <li>
                                <button
                                    on:click|self={toggleCandidature}
                                    class="text-nowrap flex items-center justify-start px-2 mt-1 lg:hidden w-full rounded p-0.5"
                                >
                                    Candidatures
                                    <span
                                        class="text-white w-4 h-4 flex justify-center items-center bg-red-600 p-1 rounded-full"
                                        >{$page.props.auth.candidacies}</span
                                    >
                                </button>
                            </li>
                            {#if $candidatureModalComponent}
                                <div class="z-50">
                                    <Candidacies
                                        on:click={() =>
                                            candidatureModalComponent.set(
                                                false,
                                            )}
                                    />
                                </div>
                            {/if}
                        </div>

                        <form on:submit|preventDefault={logout}>
                            <li>
                                <div class="relative text-nowrap">
                                    <button
                                        on:mouseenter={showTooltip}
                                        on:mouseleave={hideTooltip}
                                        class="relative"
                                    >
                                        Se déconnecter
                                    </button>
                                </div>
                            </li>
                        </form>
                    {:else}
                        <li><a use:inertia href="/login">Se connecter</a></li>
                        <li>
                            <a use:inertia href="/register">Créer un compte</a>
                        </li>
                    {/if}
                </ul>
            {/if}
        </div>
    </div>
</div>

<style>
    .connected {
        background-color: green;
    }
</style>
