<script>
    import { inertia } from "@inertiajs/svelte";
    import { format_date_anglo_to_french } from "@dependencies/utilities";
    export let cv;
    export let i;
</script>

<tr class="text-base font-semibold text-gray-700 hover:bg-gray-50">
    <td>
        {#if i + 1}
            {i + 1}
        {:else}
            --
        {/if}
    </td>
    <td>
        <div>
            <span class="capitalize">{cv.firstName}</span>
        </div>
    </td>

    <td>
        <div>
            <span>{cv.email}</span>
        </div>
    </td>
    <td>
        <span class="py-0.5 px-1 rounded capitalize"
            >{cv.profession ?? JSON.parse(cv.technical_competences)[0]}</span
        >
    </td>
    <td>
        <a
            class="flex justify-center items-center"
            use:inertia
            href="employer/curicculum-vitae/{cv.id}"
        >
            <button class="flex items-center  btn btn-success h-fit text-white btn-bas p-1 rounded  hover:scale-105">
                Inspecter
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="size-5 stroke-white ms-1"
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
            </button>
        </a>
    </td>
</tr>
