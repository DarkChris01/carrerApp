<script>
    import {
        format_date_anglo_to_french,
        formatTime,
    } from "@dependencies/utilities";
    import Tooltip from "@utils/Tooltip.svelte";
    import CreateEntretien from "@components/Create-entretien.svelte";
    import { entretiens_store } from "@dependencies/Stores/Store";
    import { useForm, inertia, page } from "@inertiajs/svelte";
    import axios from "axios";
    import toast from "svelte-french-toast";
    export let entretien;
    export let i;
    let status;
    let show = false;

    if (entretien.status === "pending") {
        status = "En attente";
    } else if (entretien.status === "process") {
        status = "en examen";
    } else {
        status = "rejeté";
    }
    $: if ($page.props) {
        show = false;
    }
    let tooltip = false;
    let showEntretien = false;
    let timeout;
    let hideTimeout;
    let form = useForm({
        entretien: entretien.id,
    });

    async function handleDelete() {
        const request = await axios.delete(`/mes-entretiens/${entretien.id}`);
        if (request.status === 200) {
            toast.success("Entretien supprimé !");
            entretiens_store.update((entretiens) => {
                const value = entretiens.filter((a) => {
                    return a.id !== entretien.id;
                });
                return value;
            });
        } else {
            toast.error("error occured");
        }
    }

    function showTooltip() {
        clearTimeout(hideTimeout);
        timeout = setTimeout(() => {
            tooltip = true;
        }, 700);
    }

    function hideTooltip() {
        clearTimeout(timeout);
        hideTimeout = setTimeout(() => {
            tooltip = false;
        }, 700);
    }

    const retenu = () => {
        $form.post("candidatures/candidate-selected", {
            onSuccess: () => {
                toast.success(
                    "Felicitation pour votre nouveau collaborateur !",
                );
            },
        });
    };

    const toggleModal = () => {
        show = !show;
    };
</script>

<tr class="rounded text-gray-600">
    <td>{i + 1}</td>
    <td>
        <a
            use:inertia
            href="/employer/curicculum-vitae/{entretien.candidacy.cv.id}"
            class="flex items-center"
        >
            <img
                class="w-8 h-8 border rounded-full me-2"
                src={entretien.candidacy.cv.picture ??
                    `/storage/avatars/default/${entretien.candidacy.cv.sexe}.png`}
                alt="avatar"
            />
            <p class="">{entretien.candidacy.cv.firstName}</p>
        </a>
    </td>

    <td>
        <a
            use:inertia
            href="/employer/offres-d'emploi/{entretien.candidacy.job_id}"
        >
            {entretien.candidacy.job_id}
        </a>
    </td>

    <td>
        {format_date_anglo_to_french(new Date(entretien.date))}
    </td>

    <td>
        <div>
            {formatTime(entretien.time)}
        </div>
    </td>

    <td>
        <div class="flex items-center">
            {status}
            {#if entretien.status === "accepted"}
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="size-4 stroke-green-600 ms-1"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                    />
                </svg>
            {/if}
        </div>
    </td>
    <td>
        <div class="relative inline-block text-left">
            <button
                on:click={toggleModal}
                type="button"
                class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white p-1 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                id="menu-button"
                aria-expanded="true"
                aria-haspopup="true"
            >
                actions
                <svg
                    class="-mr-1 size-5 text-gray-400"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    aria-hidden="true"
                    data-slot="icon"
                >
                    <path
                        fill-rule="evenodd"
                        d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                        clip-rule="evenodd"
                    />
                </svg>
            </button>
            {#if show}
                <!-- content here -->
                <div
                    class="absolute right-0 z-10 mt-1 px-2 p-1 min-w-56 origin-top-right rounded-md bg-white border shadow-lg ring-1 ring-black/5 focus:outline-none"
                    role="menu"
                    aria-orientation="vertical"
                    aria-labelledby="menu-button"
                    tabindex="-1"
                >
                    <div role="none" class="py-1 text-gray-500">
                        <div>
                            {#if entretien.status !== "rejected"}
                                <div
                                    class="w-full p-1 hover:bg-gray-100 hover:text-gray-900"
                                >
                                    <button
                                        on:mouseenter={showTooltip}
                                        on:mouseleave={hideTooltip}
                                        on:click={() => (showEntretien = true)}
                                        class="w-full text-start"
                                    >
                                        Modifier
                                        {#if tooltip}
                                            <!-- content here -->
                                            <Tooltip
                                                x="right-[100%]"
                                                y="-bottom-6"
                                                size="text-xs"
                                                message="Modifier la date ou l'heure"
                                            />
                                        {/if}
                                    </button>
                                </div>
                            {/if}
                            {#if entretien.status === "process"}
                                <div
                                    class="w-full p-1 hover:bg-gray-100 hover:text-gray-900"
                                >
                                    <button
                                        disabled={$form.isProcess}
                                        on:click={retenu}
                                        class="w-full text-start"
                                        >Recruter</button
                                    >
                                </div>
                            {/if}

                            <div
                                class="w-full p-1 hover:bg-gray-100 hover:text-gray-900"
                            >
                                <button
                                    type="button"
                                    class="w-full text-start"
                                    on:click={handleDelete}
                                    >Rejeter
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            {/if}
        </div>
    </td>
</tr>
{#if showEntretien}
    <CreateEntretien
        {entretien}
        url="mes-entretiens/update/{entretien.id}"
        on:click={() => (showEntretien = false)}
        buttonText="Modifier"
    />
{/if}
