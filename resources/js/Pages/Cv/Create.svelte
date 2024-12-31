<script>
    import Cv from "@components/Cv/Cv.svelte";
    import Tooltip from "@utils/Tooltip.svelte";
    import Spinner from "@utils/Spinner.svelte";
    import { inertia } from "@inertiajs/svelte";
    import axios from "axios";
    export let cv;
    let loading = true;
    let tooltip = false;
    let showCvModal = false;
    let time;
    let hidetime;

    const print = () => {
        window.print();
    };

    const showTooltip = () => {
        clearTimeout(hidetime);
        time = setTimeout(() => {
            tooltip = true;
        }, 500);
    };

    const hideTooltip = () => {
        clearTimeout(time);
        hidetime = setTimeout(() => {
            tooltip = false;
        }, 500);
    };
</script>

<section>
    <div class="relative lg:p-2 lg:w-4/5 2xl:w-3/4 mx-auto w-auto">
        <div>
            <div class="flex justify-between px-2 items-center">
                {#if cv}
                    <button
                        class=" p-1 rounded relative"
                        on:click={print}
                        on:mouseenter={showTooltip}
                        on:mouseleave={hideTooltip}
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="size-6 stroke-gray-950 stroke-1 rounded"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z"
                            />
                        </svg>
                        {#if tooltip}
                            <Tooltip message="Impression" />
                        {/if}
                    </button>
                {/if}
            </div>
        </div>
        <div
            class="w-full flex justify-center text-gray-800 overflow-y-auto scrollable"
        >
            {#if cv}
                <div class="w-full">
                    <Cv {cv} />
                </div>
            {:else}
                <div class="h-96 flex justify-center items-center text-xl">
                    <div>Commencer à créer votre Curriculum vitae</div>
                    <div>
                        <button
                            class="text-xl ms-2 p-0.5 bg-orange-600 hover:bg-transparent border border-orange-500 hover:text-orange-600 transition duration-300 ease-out w-full text-white rounded"
                        >
                            <a use:inertia href="/cv/personal-informations">
                                Créer un Cv!
                            </a>
                        </button>
                    </div>
                </div>
            {/if}
        </div>
    </div>
</section>
