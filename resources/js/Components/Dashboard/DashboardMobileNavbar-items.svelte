<script>
    let show = false;

    const toggleMenu = () => {
        show = !show;
    };
</script>

<div class="md:hidden py-4">
    <button on:click={toggleMenu}
        ><svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="size-6 stroke-gray-100"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"
            />
        </svg>
    </button>
</div>
{#if show}
    <!-- content here -->
    <!-- Mobile menu, show/hide based on menu state -->
    <div class="md:hidden" id="mobile-menu">
        <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
            <a
                href="/dashboard"
                class="bg-gray-900 text-white block rounded-md px-3 py-2 text-sm font-medium"
                aria-current="page">Acceuil</a
            >
            <a
                href="/employer/toutes-mes-offres"
                class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-sm font-medium"
                >Mes offres</a
            >
            <a
                href="/cvtheques"
                class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-sm font-medium"
                >Cvtheques</a
            >
            <a
                href="/employer/mes-entretiens/"
                class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-sm font-medium"
                >Entretiens</a
            >
            <a
                href="/notifications"
                class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-sm font-medium"
                >Notifications</a
            >
            <a
                href="/faq"
                class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-sm font-medium"
                >FAQ</a
            >
        </div>
        <div class="border-t border-gray-700 pb-3 pt-4">
            <div class="flex items-center px-5">
                <div class="md:block lg:block sm:hidden max-w-md mx-auto">
                    <div
                        class="relative flex items-center w-full h-8 border border-gray-500 rounded-sm bg-gray-600 overflow-hidden"
                    >
                        <div
                            class="grid place-items-center w-12 bg-gray-600 text-gray-300"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6 bg-gray-600"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                />
                            </svg>
                        </div>

                        <input
                            class="bg-gray-600 outline-none text-sm text-gray-300 pr-2"
                            type="text"
                            id="search"
                            placeholder="Search something.."
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
{/if}
