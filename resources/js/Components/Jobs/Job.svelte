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
        class="my-1 rounded p-1 lg:p-2 text-sm transition cursor-pointer ease duration-200 hover:bg-gray-50"
    >
        <div class="lg:flex">
            <div class="mx-1 w-1/6 px-1">
                <img
                    src={job.enterprise.logo}
                    alt="logo-entreprise"
                    class="w-[6rem] border bg-indigo-600 rounded-md"
                />
            </div>
            <div class="p-1 w-full lg:w-5/6 lg:px-4 text-sm">
                <div class="flex justify-between items-center">
                    <h1>
                        {job.enterprise.name}
                    </h1>

                    <span class="bg-indigo-500 text-white rounded p-1 text-xs"
                        >{format_date_anglo_to_french(
                            new Date(job.expired_at),
                        )}</span
                    >
                </div>
                <div class="lg:flex items-center text-gray-600">
                    <div class="uppercase text-sm">
                        {job.poste}
                    </div>
                    <div
                        class="w-1.5 h-1.5 mx-2 bg-gray-400 rounded-full hidden md:block"
                    ></div>
                    <div class="uppercase text-sm">
                        {job.experience}
                        {job.experience > 1 ? " ans" : " an"}
                    </div>
                    <div
                        class="w-1.5 h-1.5 mx-2 bg-gray-400 rounded-full hidden md:block"
                    ></div>
                    <div class="uppercase text-sm">
                        {job.type}
                    </div>
                    <div
                        class="w-1.5 h-1.5 mx-2 bg-gray-400 rounded-full hidden md:block"
                    ></div>
                    <div class="uppercase text-sm">
                        {job.country}
                    </div>
                </div>
                <div>
                    <div class="my-1 flex items-center flex-wrap">
                        {#each JSON.parse(job.competence.competence) as competence}
                            {#if competence}
                                <span
                                    class="px-2 rounded bg-gray-700 text-white p-0.5 flex items-center w-fit text-xs me-2 my-1"
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
