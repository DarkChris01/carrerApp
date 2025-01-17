<script>
    import { inertia } from "@inertiajs/svelte";
    import { format_date_anglo_to_french } from "@dependencies/utilities";
    import Tooltip from "@utils/Tooltip.svelte";
    export let job;

    let tooltip = false,
        timeout,
        hidetimeout;
    const hideTooltip = () => {
        clearTimeout(timeout);
        hidetimeout = setTimeout(() => {
            tooltip = false;
        }, 500);
    };
    const showTooltip = () => {
        clearTimeout(hidetimeout);
        timeout = setTimeout(() => {
            tooltip = true;
        }, 500);
    };
</script>

<a use:inertia href="/job/mon-offre/{job.id}">
    <div
        class="my-1 rounded p-1 lg:p-2 text-base transition cursor-pointer ease duration-200 hover:bg-gray-100"
    >
        <div class="lg:flex">
            <div class="p-1 w-full lg:px-4 text-base">
                <div class="flex font-extrabold justify-between items-center">
                    <h3 class="text-lg font-extrabold text-gray-800 mb-2">
                        {job.poste}
                    </h3>
                    <span class="bg-gray-800 text-white rounded p-1 text-xs"
                        >{format_date_anglo_to_french(
                            new Date(job.expired_at),
                        )}</span
                    >
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">
                        <strong>Entreprise :</strong>
                        {job.enterprise.name}
                    </p>
                </div>
                <div class="lg:flex items-center text-gray-600">
                    <div class="uppercase text-base">
                        {job.type}
                    </div>
                    <div
                        class="w-1.5 h-1.5 mx-2 bg-gray-400 rounded-full hidden md:block"
                    ></div>
                    <div class="uppercase text-base">
                        {job.country}
                    </div>
                </div>
                <div>
                    <div class="my-1 flex items-center flex-wrap">
                        {#each JSON.parse(job.competence.competence) as competence}
                            {#if competence}
                                <span
                                    class="rounded bg-blue-800 px-4 text-white p-0.5 flex items-center w-fit text-sm me-2 my-1"
                                >
                                    {competence}
                                </span>
                            {/if}
                        {/each}
                    </div>
                </div>
            </div>
        </div>
    </div>
</a>
