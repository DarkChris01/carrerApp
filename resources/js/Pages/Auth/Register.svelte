<script>
    import RegisterEmployer from "@forms/Auth/Register-employer.svelte";
    import RegisterUser from "@forms/Auth/Register-user.svelte";
   
    let isEmployer = false;
</script>

<div
    class="background top-0 w-full h-screen flex justify-center items-center"
    style="background-image: url('/storage/background/a.jpg');"
>
    <div
        class=" w-full mx-2 2xl:w-1/4 lg:w-1/3 md:w-1/2 flex-col justify-center px-6 py-4 lg:px-8 bg-white rounded shadow border-2"
    >
        {#if isEmployer}
            <RegisterEmployer />
        {:else}
            <RegisterUser />
        {/if}

        <div class="mt-6">
            <div class="w-full grid md:grid-cols-2 gap-2 mb-6">
                <div>
                    <button
                        on:click={() => (isEmployer = false)}
                        class="w-full bg-green-600 rounded text-white p-1 shadow hover:bg-green-500"
                        >Chercheur d'emploi</button
                    >
                </div>
                <div>
                    <button
                        on:click={() => (isEmployer = true)}
                        class="w-full bg-red-600 rounded text-white p-1 shadow hover:bg-red-500"
                        >Recruteur</button
                    >
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .background {
        background-size: cover;
        background-position: center;
        background-attachment: scroll;
        background-repeat: no-repeat;
    }
</style>
