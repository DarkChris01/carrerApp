<script>
    import CandidateProfile from "@modals/Candidat-profile-modal.svelte";
    import CandidateAction from "@components/Candidates/Candidate-action.svelte";
    import { relativeTimeFormatter } from "@dependencies/utilities";
    import { inertia, page } from "@inertiajs/svelte";
    import { compareDate } from "@/Dependencies/utilities";
    export let job;
    export let candidacy;
    let status;
console.log(candidacy.cv_id);

    $: if ($page.props) {
        if (candidacy.status === "pending") {
            status = "En attente";
        } else if (candidacy.status === "OK") {
            status = "OK";
        } else if (candidacy.status === "rejected") {
            status = "Rejeté";
        }
    }
</script>

<tr class="text-standard font-semibold text-sm text-gray-700 hover:bg-gray-50" id={candidacy.cv_id}>
    <td>
        <span class="text-gray-500"> </span>
    </td>

    <td class="flex items-center">
        <a
            class="flex me-1"
            use:inertia
            href="/employer/curicculum-vitae/{candidacy.cv_id}"
        >
            <div>
                <img
                    class="bg-gray-400 border p-0.5 2xl:w-10 w-8 2xl:h-10 h-8 rounded-full"
                    src={candidacy.cv.picture}
                    alt="logo"
                />
            </div>
        </a>

        <div class="capitalize">
            {candidacy.cv.firstName}
        </div>
    </td>
    <td>
        <div class="p-0.5 rounded capitalize">
            {job.poste}
        </div>
    </td>
    <td>
        {#if relativeTimeFormatter("Fr", job.expired_at).match(/il y a/g)}
            <div class="text-red-600">expiré</div>
        {:else}
            {relativeTimeFormatter("Fr", job.expired_at)}
        {/if}
    </td>

    <td>
        <div class="text-gray-600">
            {status}
        </div>
    </td>

    {#if compareDate(job.expired_at) > 0}
        <td>
            <CandidateAction {candidacy} {job} />
        </td>
    {/if}
</tr>
