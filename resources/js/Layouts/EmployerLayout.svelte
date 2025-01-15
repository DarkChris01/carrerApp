<script>
    import LeftSide from "@components/LeftSide.svelte";
    import DashBoardNavbarItems from "@components/Dashboard/DashboardNavbar-items.svelte";
    import { page, inertia } from "@inertiajs/svelte";
    import DashboardMobileNavbarItems from "@components/Dashboard/DashboardMobileNavbar-items.svelte";
    import EmployerSearch from "@forms/Employer-search.svelte";
    import { Toaster } from "svelte-french-toast";
</script>


<div>
    <div class="flex-auto">
        <div>
            <div class="lg:flex">
                <div
                    class="w-1/6 hidden lg:block bg-gray-800 sticky top-0 me-1 h-screen overflow-y-auto scrollable"
                >
                    <!-- Left Side -->
                    <LeftSide />
                </div>
                <div class="w-full lg:w-5/6 rounded-l- rounded-t">
                    <div>
                        <div>
                            <slot />
                        </div>
                    </div>
                    <!-- End of profile tab -->
                </div>
            </div>
        </div>
    </div>
</div>

<div class="text-sm">

    <Toaster />
</div>
