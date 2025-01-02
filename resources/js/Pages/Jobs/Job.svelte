<script>
    import JobDetail from "@components/Jobs/Job-detail.svelte";
    export let job;
</script>

<main
    class="w-full p-1 font-light flex justify-center text-gray-600 text-sm"
>
    
        <div>
            <JobDetail {job} />
        </div>        
   
</main>
