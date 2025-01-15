<script>
    import { router, inertia, page } from "@inertiajs/svelte";
    import toast from "svelte-french-toast";
    import { entretiens_store } from "@dependencies/Stores/Store";
    import { jobs_store } from "@dependencies/Stores/Store";
    import CreateEntretien from "@components/Create-entretien.svelte";
    import axios from "axios";
    export let candidacy;
    export let job;
    let showEntretien = false;
    let isLoading = false;
    entretiens_store.set($page.props.auth.entretiens);

    const rejected = async () => {
        isLoading = true;
        router.patch(`/candidatures/rejected/${candidacy.id}`);
        isLoading = false;
    };

    const toogleEntretien = () => {
        showEntretien = true;
    };

    const archivate = (candidacy) => {
        router.post(
            "/archive",
            { candidacy: candidacy },
            {
                onStart: () => (isProgress = true),
                onFinish: () => (isProgress = false),
            },
        );
    };
</script>

<!-- svelte-ignore a11y-click-events-have-key-events -->
<!-- svelte-ignore a11y-click-events-have-key-events -->
<!-- svelte-ignore a11y-no-static-element-interactions -->
<div class="text-gray-800">
    <div>
        <button
            on:click={toogleEntretien}
            class="hover:bg-gray-100 text-start w-full rounded p-1"
        >
            Créer entretien</button
        >
    </div>
    <div>
        <button
            on:click={rejected}
            disabled={isLoading}
            class="hover:bg-gray-100 text-start w-full rounded p-1"
        >
            Rejeter
        </button>
    </div>
</div>

{#if showEntretien}
    <div>
        <div class="fixed z-30 bottom-0 left-0 flex justify-end items-end">
            <CreateEntretien
                {candidacy}
                {job}
                on:click={() => (showEntretien = false)}
            />
        </div>
    </div>
{/if}
