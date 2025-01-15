<script>
    import toast from "svelte-french-toast";
    import { useForm, inertia } from "@inertiajs/svelte";
    export let experiences;

    const exp = experiences
        ? JSON.parse(experiences.experience)
        : null;

    $: form = useForm({
        enterprise: exp ? exp[0]?.enterprise : null,
        role: exp ? exp[0]?.poste : null,
        task: exp ? exp[0]?.mission : null,
        start: exp ? exp[0]?.start : null,
        end: exp ? exp[0]?.end : null,

        enterprise2: exp ? exp[1]?.enterprise : null,
        role2: exp ? exp[1]?.poste : null,
        task2: exp ? exp[1]?.mission : null,
        start2: exp ? exp[1]?.start : null,
        end2: exp ? exp[1]?.end : null,
    });

    const submitExperience = () => {
        $form.post("/cv/experience", {
            onSuccess: () => {
                toast.success("ON Y EST DERNIERE ETAPE !");
            },
            onError: (error) => {
                toast.error(error);
            },
            preserveScroll:true
        });
    };
</script>

<div class="w-full lg:w-1/2 mx-auto bg-white border my-4 p-2 lg:p-4">
    <div class=" my-10">
        <div class="flex justify-center font-bold">
            <h1 class="text-sm md:text-xl xl:text-4xl text-gray-700">
                Experiences Professionelles
            </h1>
        </div>
        <p class="text-center text-gray-500 text-sm">
            Ces informations seront visibles uniquement pour les recruteurs!
        </p>
    </div>
    <div class="w-full flex justify-center items-center text-sm lg:text-sm">
        <form
            class="w-full flex justify-center mx-1"
            on:submit|preventDefault={submitExperience}
        >
            <div class="px-2 w-full">
                <div class="my-4 pb-4 w-full">
                    <div>
                        <div class="mt-2">
                            <div>
                                <label
                                    class="text-gray-500 text-sm lg:text-sm"
                                    for="enterprise">Enterprise</label
                                >
                            </div>
                            <input
                                type="text"
                                bind:value={$form.enterprise}
                                placeholder=" enterperise"
                                class="border-0 w-full p-2 text-gray-700 ring-1 focus:ring-orange-600 text-sm lg:text-sm placeholder:text-gray-400 placeholder:text-sm placeholder:capitalize rounded"
                            />
                        </div>

                        <div class="mt-2">
                            <div>
                                <label
                                    class="text-gray-500 text-sm lg:text-sm"
                                    for="post">Poste</label
                                >
                                <input
                                    type="text"
                                    bind:value={$form.role}
                                    placeholder=" comptable"
                                    class="border-0 w-full p-2 text-gray-700 ring-1 focus:ring-orange-600 text-sm lg:text-sm placeholder:text-gray-400 placeholder:text-sm placeholder:capitalize rounded"
                                />
                            </div>

                            <div class="mt-4">
                                <div class="grid lg:grid-cols-2 gap-2">
                                    <div>
                                        <label
                                            class="text-gray-500 text-sm lg:text-sm"
                                            for="periode">debut :</label
                                        >

                                        <input
                                            type="date"
                                            bind:value={$form.start}
                                            class="border-0 w-full p-2 text-gray-700 ring-1 focus:ring-orange-600 text-sm lg:text-sm placeholder:text-gray-400 placeholder:text-sm placeholder:capitalize rounded"
                                        />
                                    </div>
                                    <div>
                                        <div>
                                            <label
                                                class="text-gray-500 text-sm lg:text-sm"
                                                for="periode">fin :</label
                                            >

                                            <input
                                                type="date"
                                                bind:value={$form.end}
                                                class="border-0 w-full p-2 text-gray-700 ring-1 focus:ring-orange-600 text-sm lg:text-sm placeholder:text-gray-400 placeholder:text-sm placeholder:capitalize rounded"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2">
                                <div>
                                    <label
                                        class="text-gray-500 text-sm lg:text-sm"
                                        for="task">Responsabilité</label
                                    >
                                </div>
                                <textarea
                                    maxlength="1000"
                                    rows="5"
                                    class="border-0 scrollable w-full p-2 text-gray-700 ring-1 focus:ring-orange-600 text-sm lg:text-sm placeholder:text-gray-400 placeholder:text-sm placeholder:capitalize rounded"
                                    name="task"
                                    bind:value={$form.task}
                                ></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="my-20 pb-4 w-full">
                    <div>
                        <div class="mt-2">
                            <div>
                                <label
                                    class="text-gray-500 text-sm lg:text-sm"
                                    for="enterprise">Enterprise</label
                                >
                            </div>
                            <input
                                type="text"
                                bind:value={$form.enterprise2}
                                placeholder=" enterperise 2"
                                class="border-0 w-full p-2 text-gray-700 ring-1 focus:ring-orange-600 text-sm lg:text-sm placeholder:text-gray-400 placeholder:text-sm placeholder:capitalize rounded"
                            />
                        </div>

                        <div class="mt-2">
                            <div>
                                <label
                                    class="text-gray-500 text-sm lg:text-sm"
                                    for="post">Poste</label
                                >
                                <input
                                    type="text"
                                    bind:value={$form.role2}
                                    placeholder=" comptable"
                                    class="border-0 w-full p-2 text-gray-700 ring-1 focus:ring-orange-600 text-sm lg:text-sm placeholder:text-gray-400 placeholder:text-sm placeholder:capitalize rounded"
                                />
                            </div>

                            <div class="mt-4">
                                <div class="grid lg:grid-cols-2 gap-2">
                                    <div>
                                        <label
                                            class="text-gray-500 text-sm lg:text-sm"
                                            for="periode">debut :</label
                                        >

                                        <input
                                            type="date"
                                            bind:value={$form.start2}
                                            class="border-0 w-full p-2 text-gray-700 ring-1 focus:ring-orange-600 text-sm lg:text-sm placeholder:text-gray-400 placeholder:text-sm placeholder:capitalize rounded"
                                        />
                                    </div>
                                    <div>
                                        <div>
                                            <label
                                                class="text-gray-500 text-sm lg:text-sm"
                                                for="date">fin :</label
                                            >

                                            <input
                                                type="date"
                                                bind:value={$form.end2}
                                                class="border-0 w-full p-2 text-gray-700 ring-1 focus:ring-orange-600 text-sm lg:text-sm placeholder:text-gray-400 placeholder:text-sm placeholder:capitalize rounded"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2">
                                <div>
                                    <label
                                        class="text-gray-500 text-sm lg:text-sm"
                                        for="task">Responsabilité</label
                                    >
                                </div>
                                <textarea
                                    maxlength="1000"
                                    rows="5"
                                    class="border-0 scrollable w-full p-2 text-gray-700 ring-1 focus:ring-orange-600 text-sm lg:text-sm placeholder:text-gray-400 placeholder:text-sm placeholder:capitalize rounded"
                                    name="task"
                                    bind:value={$form.task2}
                                ></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="flex w-full justify-end items-center bg-white px-2 md:px-4 p-2 mt-8"
                >
                    <div class="flex">
                        <a
                            use:inertia
                            href="/cv"
                            as="button"
                            class="bg-red-600 rounded p-1 hover:bg-red-500 text-white me-2"
                            >Retourner vers mon cv
                        </a>

                        <button
                                type="submit"
                                class="btn btn-primary rounded p-1 btn-sm text-white"
                                >Suivant</button
                            >
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
