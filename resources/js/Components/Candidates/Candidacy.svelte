<script>
    import CandidateProfile from "@modals/Candidat-profile-modal.svelte";
    import CandidateAction from "@components/Candidates/Candidate-action.svelte";
    import { relativeTimeFormatter } from "@dependencies/utilities";
    import Candidacy from "@components/Candidates/Candidacy.svelte";
    import { entretiens_store } from "@dependencies/Stores/Store";


    import { inertia, page } from "@inertiajs/svelte";
    import { compareDate } from "@/Dependencies/utilities";
    export let job;
    export let candidacy;
    let status;
    let showModal = false;
    entretiens_store.set($page.props.auth.entretiens);

    $: if ($page.props) {
        showModal = false;
        if (candidacy.status === "pending") {
            status = "En attente";
        } else if (candidacy.status === "rejected") {
            status = "Rejeté";
        } else if (candidacy.status === "process") {
            status = "En examen";
        } else if (candidacy.status === "recruited") {
            status = "Recruté";
        }
    }
    const toggleModal = () => {
        showModal = !showModal;
    };
</script>

<tr
    class="text-base font-semibold text-gray-700 hover:bg-gray-50"
    id={candidacy.cv_id}
>
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
        {#if compareDate(job.expired_at) < 0}
            <div class="text-red-600">fermé</div>
        {:else}
            {relativeTimeFormatter("Fr", job.expired_at)}
        {/if}
    </td>

    <td>
        <div class="text-gray-600">
            {status}
        </div>
    </td>

    <td>
        {#if compareDate(job.expired_at) > 0}
            <div class="relative inline-block text-left">
                {#if Array.isArray($entretiens_store)}
                    {#if !$entretiens_store.some((entretien) => entretien.candidacy.cv.id === candidacy.cv_id)}
                        <div>
                            <button class:disabled={candidacy.status === "rejected"}
                                disabled={candidacy.status === "rejected"}
                                on:click={toggleModal}
                                type="button"
                                class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white p-1 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                                id="menu-button"
                                aria-expanded="true"
                                aria-haspopup="true"
                            >
                                actions
                                <svg
                                    class="-mr-1 size-5 text-gray-400"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                    aria-hidden="true"
                                    data-slot="icon"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </button>
                        </div>
                    {:else}
                        <div>
                            <button class="font-bold p-1 text-gray-600 rounded">
                                <a
                                    use:inertia
                                    href="/mes-entretiens?entretien={$entretiens_store.find(
                                        (entretien) =>
                                            entretien.candidacy.cv.id ===
                                            candidacy.cv_id,
                                    ).id}"
                                    class="w-full flex items-center"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="size-5 ms-0.5"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z"
                                        />
                                    </svg>
                                </a></button
                            >
                        </div>
                    {/if}
                {/if}

                {#if showModal}
                    <div
                        class="absolute right-0 z-10 mt-1 px-2 p-1 min-w-56 origin-top-right rounded-md bg-white border shadow-lg ring-1 ring-black/5 focus:outline-none"
                        role="menu"
                        aria-orientation="vertical"
                        aria-labelledby="menu-button"
                        tabindex="-1"
                    >
                        <div class="py-1" role="none">
                            <CandidateAction {candidacy} {job} on:click={()=>showModal=false}/>
                        </div>
                    </div>
                {/if}
            </div>
        {/if}
    </td>
</tr>
<style>
    .disabled{
        background-color: rgb(209, 209, 209);
    }
</style>
