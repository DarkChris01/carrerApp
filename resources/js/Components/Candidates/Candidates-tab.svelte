<script>
    import CandidateProfile from "@modals/Candidat-profile-modal.svelte";
    import { router,inertia } from "@inertiajs/svelte";
    export let candidat;
    export let i;
    let show = false;
    let isLoading = false;
    const showCandidateProfile = () => {
        show = true;
    };

    const rejected = () => {
        isLoading = true;
        router.patch(
            `/candidatures/rejected/${candidat.candidature_id}`,
            {},
            {
                onSuccess: () => {
                    toast.success("Candidature rejété !");
                },
                onError: () => {
                    toast.error("Une errerur est survenue ,veuillez reesayez");
                },
                onFinish: () => {
                    isLoading = false;
                },
            },
        );
    };
</script>

<tr>
    <td>{i + 1}</td>
    <td class=" flex justify-start items-center"
        ><img
            src={candidat.picture}
            class="w-8 h-8 rounded-full me-2"
            alt="pictue"
        />
        {candidat.firstName}
    </td>
    <td>{candidat.profession} </td>
    <td>{candidat.poste}</td>

    <td>
        <div class="flex justify-start">
            <a use:inertia
            href="/employer/curicculum-vitae/{candidat.cv_id}">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="size-5 stroke-1 fill-gray-600 stroke-white"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"
                    />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                    />
                </svg>
            </a>
        </div>
    </td>
</tr>

{#if show}
    <CandidateProfile
        candidat_id={candidat.candidature_id}
        on:click={() => (show = false)}
    />
{/if}
