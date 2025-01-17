<script>
    import Job from "@components/jobs/Job.svelte";
    import PaginationNavBar from "@utils/Pagination-Navbar.svelte";
    import Partners from "@components/Enterprise/Partners.svelte";
    export let enterprises;
    export let jobs;
</script>

<!-- <div class="font-bold text-base my-2">
    { jobs.data.length > 1 ? jobs.data.length +" offres trouvées" :jobs.data.length + " offre trouvée"} 
</div> -->
<Partners {enterprises} />
<div class="p-6 mt-2 border border-gray-200/60">
    {#if jobs.data.length > 0}
        {#each jobs.data as job}
            <Job {job} />
        {/each}
        {#if jobs.data.length > 25}
            <PaginationNavBar datas={jobs} />
        {/if}
    {:else}
        <div
            class="h-screen lg:h-96 w-full mx-1 flex items-center justify-center text-gray-300 font-semibold lg:text-sm xl:text-xl"
        >
            Aucune offre
        </div>
    {/if}
</div>
