<script>
    import CandidateProfile from "@modals/Candidat-profile-modal.svelte";
    export let candidat;
    let showCandidatInfoModal = false;

    const showProfile = () => {
        showCandidatInfoModal = !showCandidatInfoModal;
    };
</script>

<div class=" my-1 p-2 px-4 border-b cursor-pointer text-gray-700 hover:bg-gray-100">
    <li>
        <div class="flex text-[16px] justify-between font-thin items-center">
            <div>
                <div>{candidat.name}</div>
            </div>
            <div>
                <div>
                    <button
                        on:click={showProfile}
                        class="bg-blue-600 text-gray-100 hover:text-white p-0.5 rounded"
                        >Profile</button
                    >
                </div>
            </div>
        </div>
    </li>
</div>

{#if showCandidatInfoModal}
    <CandidateProfile {candidat} on:click={showProfile} />
{/if}
