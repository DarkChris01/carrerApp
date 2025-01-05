<script>
    import { inertia, page, useForm } from "@inertiajs/svelte";
    import {
        format_date_anglo_to_french,
        compareDate,
    } from "@dependencies/utilities";
    import toast from "svelte-french-toast";
    export let job;
    export let i;
    let form = useForm({
        job: job.id,
    });
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
        <div class="flex items-center justify-around">
            <div>
                <a
                    class="justify-between md:flex items-center mx-1"
                    use:inertia
                    href="/employer/offres-d'emploi/{job.id}"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="size-5 stroke-1 fill-gray-600 stroke-white"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                        />
                    </svg>
                </a>
            </div>
            <a use:inertia href="/candidatures?offre={job.id}" class="mx-1 z-0">
                <button
                    type="button"
                    on:click
                    class="relative rounded flex justify-center"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="size-5 stroke-1 stroke-blue-600"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z"
                        />
                    </svg>
                    {#if job.candidacies.length}
                        <span
                            class="absolute -top-2.5 -right-2 rounded-full w-4 h-4 text-sm text-white bg-red-500 flex items-center justify-center"
                            >{job.candidacies.length}</span
                        >
                    {/if}
                </button>
            </a>
        </div>
    </td>
</tr>
