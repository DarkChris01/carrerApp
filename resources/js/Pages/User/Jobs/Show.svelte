<script>
    import toast from "svelte-french-toast";
    import UpdateJobForm from "@forms/Job/Update-job-form.svelte";
    import JobDetail from "@components/Jobs/Job-detail.svelte";
    export let job; 
</script>

<main
    class="p-1 font-light flex justify-center text-gray-600 text-sm md:text-[16px]"
>
    <div class="w-full lg:w-3/4 mx-auto p-0 rounded">
        <div>
            <JobDetail {job} />
        </div>        
    </div>
</main>
