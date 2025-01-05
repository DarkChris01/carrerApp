<script>
    import { onMount } from "svelte";
    import { Line, Bar } from "svelte-chartjs";
    import { counter } from "@dependencies/utilities";
    import { compareDate } from "@dependencies/utilities";
    import {
        datas,
        get_dashboard_data,
        open_jobs_graph_datas,
    } from "@dependencies/Dashboard";
    import Spinner from "@utils/Spinner.svelte";
    import {
        Chart as ChartJS,
        Title,
        Tooltip,
        Legend,
        LineElement,
        LinearScale,
        BarElement,
        PointElement,
        CategoryScale,
    } from "chart.js";

    ChartJS.register(
        Title,
        Tooltip,
        Legend,
        BarElement,
        LineElement,
        LinearScale,
        PointElement,
        CategoryScale,
    );
    let candidates = [];
    let jobs = [];
    let open_jobs = [];
    let data;
    let total_open_jobs = 0;
    let candidatures = 0;
    let total_jobs = 0;
    let isLoadingDiagramme = true;
    let isLoadingOpen_jobs = true;
    let diagramme;
    let period = new Date().getFullYear();

    onMount(async () => {
        diagramme = await open_jobs_graph_datas(period);
        data = await datas(period);

        const dashboard__datas = await get_dashboard_data(period);

        if (dashboard__datas.status === 200) {
            jobs = dashboard__datas.data.jobs;
            candidates = dashboard__datas.data.candidatures;
            open_jobs = jobs.filter((res) => {
                return compareDate(res.expired_at)>0;
            });
            render_counter_value(candidates, jobs, open_jobs);
            isLoadingDiagramme = false;
            isLoadingOpen_jobs = false;
        }
    });

    const updateDashboard = async (year) => {
        isLoadingDiagramme = true;
        data = await datas(year);
        diagramme = await open_jobs_graph_datas(period);

        const refreshed_diagram_data = await get_dashboard_data(year);
        if (refreshed_diagram_data.status === 200) {
            jobs = refreshed_diagram_data.data.jobs;
            candidates = refreshed_diagram_data.data.candidatures;
            open_jobs = jobs.filter((res) => {
                return compareDate(res.expired_at) > 0;
            });

            render_counter_value(candidates, jobs, open_jobs);
            isLoadingDiagramme = false;
        }
    };

    function render_counter_value(candidates, jobs, open_jobs) {
      

        counter(jobs.length, (value) => {
            total_jobs = value;
        });
        counter(candidates.length, (value) => {
            candidatures = value;
        });
        counter(open_jobs.length, (value) => {
            total_open_jobs = value;
        });
    }
</script>

<main class="lg:flex justify-between">
    <div
        class="w-full mx-0.5 min-h-52 bg-white rounded border border-gray-400/50 p-2"
    >
        <div>
            <select
                class="rounded text-xs py-1"
                on:change={(e) => updateDashboard(e.target.value)}
            >
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option selected value="2025">2025</option>
            </select>
        </div>
        {#if !isLoadingDiagramme}
            <Line {data} options={{ responsive: true }} />
        {:else}
            <div
                class="mx-auto text-gray-600/80 text-sm flex items-center justify-center w-full h-full"
            >
                <Spinner />
            </div>
        {/if}
    </div>

    <div
        class="mx-0.5 min-h-52 w-full bg-white rounded border border-gray-400/50 p-4"
    >
        {#if !isLoadingOpen_jobs}
            <Bar data={diagramme} options={{ responsive: true }} />
        {:else}
            <div
                class="mx-auto text-gray-600/80 text-sm flex items-center justify-center w-full h-full"
            >
                <Spinner />
            </div>
        {/if}
    </div>
</main>
<div
    class=" text-sm grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-x-1"
>
    <div
        class="bg-white border border-gray-400/80 text-gray-800 flex rounded justify-center items-center my-0.5 w-full cursor-pointer p-8"
    >
        <div>
            <div class="font-bold text-gray-800 text-2xl text-center">
                {total_open_jobs}
            </div>
            <div class="text-sm flex items-end">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="size-6 me-1 stroke-gray-800"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z"
                    />
                </svg>

                <p class="text-gray-600/50 text-center">
                    Nombre d'offres ouvertes
                </p>
                <p />
            </div>
        </div>
    </div>

    <div
        class="bg-white border border-gray-400/80 text-gray-800 flex rounded justify-center items-center my-0.5 w-full cursor-pointer p-8"
    >
        <div>
            <div class="font-bold text-2xl text-center text-blue-600">
                {candidatures}
            </div>
            <div class="text-sm flex items-end">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="size-6 me-1 stroke-blue-600"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"
                    />
                </svg>

                <p class="text-gray-600/50 text-center">
                    Nombre de candidatures
                </p>
                <p />
            </div>
        </div>
    </div>

    <div
        class="bg-white border border-gray-400/80 text-gray-800 flex rounded justify-center items-center my-0.5 w-full cursor-pointer p-8"
    >
        <div>
            <div class="font-bold text-red-600 text-2xl text-center">
                {total_jobs}
            </div>
            <div class="text-sm flex items-end">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="size-6 me-1 stroke-red-600"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z"
                    />
                </svg>

                <p class="text-gray-600/50 text-center">
                    Nombre d'offres générales
                </p>
                <p />
            </div>
        </div>
    </div>
</div>
