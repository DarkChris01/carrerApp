<script>
    import Job from "@components/jobs/Job.svelte";
    import PaginationNavBar from "@utils/Pagination-Navbar.svelte";
    export let jobs;
</script>

<div class="p-2">
    {#if jobs.data.length > 0}
        {#each jobs.data as job}
            <Job {job} />
        {/each}
        {#if jobs.data > 25}
            <PaginationNavBar datas={jobs} />
        {/if}
    {:else}
        <div
            class="h-screen lg:h-96 w-full mx-1 flex items-center justify-center text-gray-300 font-bold lg:text-sm xl:text-2xl"
        >
            Aucune offre
        </div>
    {/if}
</div>
