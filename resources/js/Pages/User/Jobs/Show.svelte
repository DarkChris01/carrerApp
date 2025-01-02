<script>
    import toast from "svelte-french-toast";
    import UpdateJobForm from "@forms/Job/Update-job-form.svelte";
    import JobDetail from "@components/Jobs/Job-detail.svelte";
    export let job;
</script>

<main
    class="p-1 w-full font-light flex justify-center text-gray-600 text-sm md:text-[16px]"
>
    <JobDetail {job} />
</main>
