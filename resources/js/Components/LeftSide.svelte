<script>
    import { useForm, page, inertia } from "@inertiajs/svelte";
    let show_create_job_form = false;
    let has_Enterprise = $page.props.enterprise !== null;
    import {
        notifications_store,
        entretiens_store,
    } from "@dependencies/Stores/Store";
    import { onMount } from "svelte";
    const form = useForm();

    entretiens_store.set($page.props.auth.entretiens);
    notifications_store.set($page.props.auth.notifications);

    const handleSubmit = () => {
        $form.post("/employer/logout");
    };
</script>

<div class="p-4 my-1">
    <div class>
        <a
            class="w-full flex justify-center my-1"
            use:inertia
            href="/employer/profile"
        >
            <div>
                <img
                    class=" flex-1 w-18 h-18 lg:w-24 lg:h-24 border rounded-full p-1 shadow-lg"
                    src={$page.props.auth.user.avatars ??
                        "/storage/avatars/default/man.png"}
                    alt=""
                />
            </div>
        </a>

        <div class="p-1">
            <h1
                class="text- text-center text-sm lg:text-sm font-bold tracking-tight text-nowrap text-gray-100 capitalize"
            >
                {$page.props.auth.user.name}
            </h1>
            <p class="text-center text-sm text-white/80">
                {$page.props.auth.user.post_}
            </p>
        </div>
    </div>
    <ul class="font-light text-gray-300 py-2 px-1 rounded text-sm">
        <li
            class="p-2 my-1 font-light text-gray-300 hover:bg-gray-700 rounded hover:text-white"
        >
            <a
                use:inertia
                href="/dashboard"
                class="w-full flex items-end"
                aria-current="page"
            >
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
                        d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z"
                    />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z"
                    />
                </svg>

                Dashboard</a
            >
        </li>
        {#if $page.props.auth.enterprise}
            <!-- content here -->
            <li
                class="p-2 my-1 font-light text-gray-300 hover:bg-gray-700 rounded hover:text-white"
            >
                <a
                    class="w-full flex items-end"
                    use:inertia
                    href="/my-enterprise"
                >
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
                            d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z"
                        />
                    </svg>

                    Mon entreprise</a
                >
            </li>
        {/if}

        <li
            class="p-2 my-1 font-light text-gray-300 hover:bg-gray-700 rounded hover:text-white"
        >
            <a
                use:inertia
                href="/employer/toutes-mes-offres"
                class="w-full flex items-end"
            >
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
                        d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z"
                    />
                </svg>

                Offres d'emplois</a
            >
        </li>
        <li
            class="p-2 my-1 font-light text-gray-300 hover:bg-gray-700 rounded hover:text-white"
        >
            <a
                use:inertia
                href="/candidatures"
                class="w-full flex items-end"
            >
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
                        d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z"
                    />
                </svg>

                Mes candidatures</a
            >
        </li>
        <li
            class="p-2 my-1 font-light text-gray-300 hover:bg-gray-700 rounded hover:text-white"
        >
            <a use:inertia href="/cvtheque" class="w-full flex items-end">
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
                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"
                    />
                </svg>

                Cvtheque</a
            >
        </li>
        <li
            class="relative p-2 my-1 font-light text-gray-300 hover:bg-gray-700 rounded hover:text-white"
        >
            <span
                class="absolute top-0 -left-1 flex items-center justify-center bg-red-600 text-white text-sm w-5 h-5 rounded-full p-1"
            >
                {$entretiens_store.length}
            </span>
            <a use:inertia href="/mes-entretiens" class="w-full flex items-end">
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
                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z"
                    />
                </svg>

                Mes Entretiens</a
            >
        </li>
        <li
            class="p-2 my-1 font-light relative text-gray-300 hover:bg-gray-700 rounded hover:text-white"
        >
            <span
                class="absolute top-0 -left-1 flex items-center justify-center bg-red-600 text-white text-sm w-5 h-5 rounded-full p-1"
            >
                {$notifications_store.filter((value) => value.read_at === null)
                    .length}
            </span>
            <a
                use:inertia
                href="/employer/notifications"
                class="w-full flex items-end"
            >
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

                Notifications</a
            >
        </li>

        <!-- <li>
            <a
                use:inertia
                href="/employer/mes-entretiens/"
                class="text-gray-100 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium"
                >Entretiens</a
            >
        </li> -->

        <li
            class="p-2 my-1 font-light text-gray-300 hover:bg-gray-700 rounded hover:text-white"
        >
            <a use:inertia href="/" class="w-full flex items-end">
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
                        d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 0 1 1.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.559.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.894.149c-.424.07-.764.383-.929.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 0 1-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.398.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 0 1-.12-1.45l.527-.737c.25-.35.272-.806.108-1.204-.165-.397-.506-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.108-1.204l-.526-.738a1.125 1.125 0 0 1 .12-1.45l.773-.773a1.125 1.125 0 0 1 1.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894Z"
                    />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                    />
                </svg>

                Parametres</a
            >
        </li>

        <li
            class="p-2 my-1 font-light text-gray-300 hover:bg-gray-700 rounded hover:text-white"
        >
            <a use:inertia href="/" class="w-full flex items-end">
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
                        d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z"
                    />
                </svg>

                About</a
            >
        </li>

        <div class="hidden px-1 text-sm md:flex justify-center">
            <form on:submit|preventDefault={handleSubmit}>
                <button
                    type="submit"
                    class="bg-red-600 text-white p-1 rounded shadow hover:shadow-gray-600/40 hover:bg-red-500"
                >
                    Deconnexion
                </button>
            </form>
        </div>
    </ul>
</div>
