<script>
    import {
        format_date_anglo_to_french,
        formatTime,
    } from "@dependencies/utilities";
    import Tooltip from "@utils/Tooltip.svelte";
    import CreateEntretien from "@components/Create-entretien.svelte";
    import { entretiens_store } from "@dependencies/Stores/Store";
    import { useForm, inertia } from "@inertiajs/svelte";
    import axios from "axios";
    import toast from "svelte-french-toast";
    export let entretien;
    export let i;
    let status;

    if (entretien.status === "pending") {
        status = "En attente";
    } else if (entretien.status === "accepted") {
        status = "OK";
    } else {
        status = "rejeté";
    }

    let tooltip = false;
    let showEntretien = false;
    let timeout;
    let hideTimeout;

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
</script>

<tr class="rounded text-gray-600/80 hover:text-gray-700 font-semibold">
    <td>{i + 1}</td>
    <td>
        <a
            use:inertia
            href="/employer/curicculum-vitae/{entretien.candidacy.cv.id}"
            class="flex items-center"
        >
            <img
                class="w-8 h-8 border rounded-full me-2"
                src={entretien.candidacy.cv.user.avatars ??
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
        <div class="flex items-center justify-start">
            {#if entretien.status !== "rejected"}
                <button
                    on:mouseenter={showTooltip}
                    on:mouseleave={hideTooltip}
                    on:click={() => (showEntretien = true)}
                    class="relative btn btn-xs btn-primary flex items-center text-white rounded"
                >
                    modifier
                    {#if tooltip}
                        <!-- content here -->
                        <Tooltip
                            x="right-[100%]"
                            y="-bottom-6"
                            size="text-sm"
                            message="Modifier la date ou l'heure"
                        />
                    {/if}
                </button>
            {/if}

            <button
                type="button"
                class="btn btn-xs btn-error rounded text-white flex items-center ms-3"
                on:click={handleDelete}
                >annuler
            </button>
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
