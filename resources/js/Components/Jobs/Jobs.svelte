<script>
    import { inertia, page, useForm } from "@inertiajs/svelte";
    import {
        format_date_anglo_to_french,
        compareDate,
    } from "@dependencies/utilities";
    import toast from "svelte-french-toast";
    export let job;
    export let i;
    let show = false;

    let form = useForm({
        job: job.id,
    });
    const toggleModal = () => {
        show = !show;
    };
</script>

<tr>
    <td>
        <div class="p-1">
            {i + 1}
        </div>
    </td>

    <td>
        <div class="px-1">
            <div class="text-gray-600 flex justify-between">
                <span class="capitalize">{job.poste} </span>
                <span class="text-red-600">
                    {compareDate(job.expired_at) < 0 ? "expiré" : ""}
                </span>
            </div>
        </div>
    </td>
    <td>
        <div class="px-1">
            <div class="text-gray-600">
                <span>{job.effective} </span>
            </div>
        </div>
    </td>
    <td>
        <div class="px-1">
            <div class="text-gray-600 capitalize">
                <span>{job.country} </span>
            </div>
        </div>
    </td>
    <td>
        <div class="px-1">
            <div class="text-gray-600 text-sm">
                <span>
                    {format_date_anglo_to_french(new Date(job.expired_at))}
                </span>
            </div>
        </div>
    </td>

    <td>
        <div class="relative text-sm inline-block text-left text-gray-600">
            <div>
                <button
                    on:click={toggleModal}
                    type="button"
                    class="inline-flex w-full items-center justify-center gap-x-1.5 rounded-md bg-white p-1 text-xs font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                    id="menu-button"
                    aria-expanded="true"
                    aria-haspopup="true"
                >
                    Actions
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
            </div>
            {#if show}
                <div
                    class="absolute border right-0 z-10 mt-2 w-56 p-1 origin-top-right text-gray-700 font-semibold rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none"
                    role="menu"
                    aria-orientation="vertical"
                    aria-labelledby="menu-button"
                    tabindex="-1"
                >
                    <div class="py-1" role="none">
                        <div class="p-0.5 hover:text-gray-800 hover:bg-gray-100">
                            <a
                                class="justify-start flex items-center mx-1"
                                use:inertia
                                href="/employer/offres-d'emploi/{job.id}"
                            >
                                Inspecter
                            </a>
                        </div>
                        <a
                            use:inertia
                            href="/candidatures?offre={job.id}"
                            class="mx-1 flex hover:text-gray-800 p-0.5 hover:bg-gray-100"
                        >
                            <button
                                type="button"
                                on:click
                                class="relative rounded flex justify-start items-center"
                            >
                                Candidatures

                                {#if job.candidacies.length}
                                    <span
                                        class="absolute -top-2.5 -right-2 rounded-full ms-1 w-4 h-4 text-sm text-white bg-red-500 flex items-center justify-center"
                                        >{job.candidacies.length}</span
                                    >
                                {/if}
                            </button>
                        </a>
                    </div>
                </div>
            {/if}
        </div>
    </td>
</tr>
