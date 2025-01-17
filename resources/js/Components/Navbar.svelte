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

<nav class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-14 items-center">
            <div class="flex">
                <!-- Logo -->
                <div class="hidden md:flex items-center">
                    <Logo />
                </div>
            </div>
            <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                {#if $page.props.auth.user && !$page.props.auth.isEmployer}
                    <div
                        class="relative inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-700 hover:border-blue-500 hover:text-blue-500"
                    >
                        <button
                            class="flex items-center"
                            on:click|self={toggleEntretien}
                        >
                            Entretiens<span
                                class="absolute -top-1 -right-2 text-xs text-white ms-1 bg-red-600 w-4 h-4 flex justify-center items-center p-1 rounded-full"
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
                    <div
                        class="relative inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-700 hover:border-blue-500 hover:text-blue-500"
                    >
                        <button
                            on:click|self={toggleCandidature}
                            class="flex items-center"
                        >
                            Candidatures
                            <span
                                class="absolute -top-1 -right-2 text-xs text-white bg-red-600 p-1 w-4 h-4 ms-1 flex justify-center items-center rounded-full"
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
                    <div
                        class="relative inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-700"
                    >
                        <button
                            on:click={ToogleNotificationModal}
                            class="flex items-center relative"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="size-6"
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
                                    posX="left-4"
                                    posY="-top-2"
                                    content={$notifications_store.filter(
                                        (notification) => {
                                            return (
                                                notification.read_at === null
                                            );
                                        },
                                    ).length < 9
                                        ? $notifications_store.filter(
                                              (notification) => {
                                                  return (
                                                      notification.read_at ===
                                                      null
                                                  );
                                              },
                                          ).length
                                        : "+9"}
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
                <div class="flex items-end text-sm font-semibold">
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
                        class="menu menu-base text-base font-medium p-2 absolute top-10 right-4 bg-base-100 rounded z-10 min-w-48 shadow"
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
                            <li class="mt-1">
                                <form on:submit|preventDefault={logout}>
                                    <li>
                                        <div class="relative text-nowrap p-0">
                                            <button
                                                on:mouseenter={showTooltip}
                                                on:mouseleave={hideTooltip}
                                            >
                                                Se déconnecter
                                            </button>
                                        </div>
                                    </li>
                                </form>
                            </li>
                        {:else}
                            <li>
                                <a use:inertia href="/login">Se connecter</a>
                            </li>
                            <li>
                                <a use:inertia href="/register"
                                    >Créer un compte</a
                                >
                            </li>
                        {/if}
                    </ul>
                {/if}
            </div>
        </div>
    </div>
</nav>

<style>
    .connected {
        background-color: green;
    }
</style>
