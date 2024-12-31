<script>
    import {
        format_date_anglo_to_french,
        relativeTimeFormatter,
    } from "@dependencies/utilities";
    export let job;
</script>

<div class="border-b text-gray-600 my-2 p-2 hover:text-gray-800">
    <div class="text-sm lg:text-xl w-fit rounded capitalize">
        <h1>{job.enterprise.name}</h1>
    </div>
    <div class="font-light text-[16px] mt-2">
        <div class="capitalize">{job.poste}</div>
        <div>
            {job.effective} candidatures
        </div>
        <div class=" text-gray-600 text-[15px]">
            date limite depot de candidature {format_date_anglo_to_french(
                new Date(job.expired_at),
            )}
        </div>
    </div>
</div>
