<script>
    import toast from "svelte-french-toast";
    import { onMount, onDestroy } from "svelte";
    import { entretiens_store } from "@dependencies/Stores/Store";
    import axios from "axios";
    import Spinner from "@utils/Spinner.svelte";
    import {
        format_date_anglo_to_french,
        compareDate,
        formatTime,
    } from "@dependencies/utilities";
    import LoadingSpinner from "@/Utils/Loading-spinner.svelte";
    export let entretien = null;
    export let url = "/mes-entretiens/store";
    export let buttonText = "Planifier et notifier le candidat";
    let isLoading = false;
    export let job;
    export let candidacy;
    let close;

    let form = !entretien
        ? {
              candidacy_id: candidacy.id,
              job_id: job.id,
              date: null,
              time: null,
              lieu: null,
          }
        : {
              entretien: entretien.id,
              date: entretien.date,
              time: entretien.time,
              lieu: entretien.lieu,
          };

    onMount(() => {
        document.body.style.overflow = "hidden";
    });

    onDestroy(() => {
        document.body.style.overflow = "";
    });

    const submit = async () => {
        isLoading = true;
        const request = await axios.post(url, form);
        if (request.status === 201 || 200) {
            toast.success("Le candidat a bien été notifié !");
            if (entretien) {
                entretiens_store.update((entretiens) => {
                    const index = entretiens.findIndex((value) => {
                        return value.id === entretien.id;
                    });
                    entretiens[index].time = form.time;
                    entretiens[index].date = form.date;
                    entretiens[index].lieu = form.lieu;
                    return entretiens;
                });
                isLoading = false;
            } else {
                entretiens_store.update((entretiens) => {
                    const value = [request.data, ...entretiens];

                    return value;
                });
            }
            close.click();
        } else {
            isLoading = false;
            toast.error(errors);
        }
        isLoading = false;
    };
</script>

<!-- svelte-ignore a11y-click-events-have-key-events -->
<!-- svelte-ignore a11y-no-static-element-interactions -->
<div on:click|self
    class="fixed w-full bg-black/10 top-0 h-screen left-0 flex justify-center items-center"
>
    <div
        class="w-full text-nowrap lg:w-1/3 m-2 p-6 text-sm border shadow shadow-gray-600/40 bg-white rounded"
    >
        <div class="my-6">
            <div class="my-1 text-s">
                Date entretien

                {#if entretien && entretien.date}
                    <span class="text-orange-600"
                        >{format_date_anglo_to_french(new Date(entretien.date))}
                        à {formatTime(entretien.time)}
                        {#if form.lieu}
                            <div class="capitalize">
                                {form.lieu}
                            </div>
                        {/if}</span
                    >
                {/if}
            </div>
            <div class="text-gray-600">
                <form on:submit|preventDefault={submit}>
                    <div>
                        <input
                            class="border-0 rounded ring-1 w-full ring-gray-400/40 p-1 placeholder:text-gray-500"
                            type="date"
                            bind:value={form.date}
                        />
                        <div class="mt-2">
                            <div>
                                <label for="time">Precisez une heure</label>
                            </div>
                            <input
                                class="border-0 rounded ring-1 w-fit ring-gray-400/40 p-1 placeholder:text-gray-500"
                                type="time"
                                bind:value={form.time}
                            />
                        </div>

                        <div class="mt-2">
                            <div>
                                <label for="lieu"> Lieu</label>
                            </div>
                            <input
                                class="capitalize border-0 rounded ring-1 w-full ring-gray-400/40 p-1 placeholder:text-gray-500"
                                type="text"
                                bind:value={form.lieu}
                            />
                        </div>
                    </div>
                    <div>
                        <button
                            type="submit"
                            disabled={isLoading}
                            class="hover:bg-green-600 flex justify-center items-center bg-green-700 p-2 my-2 text-white shadow rounded w-full"
                        >
                            {buttonText}
                            {#if isLoading}
                                <div class="ms-2">
                                    <LoadingSpinner
                                        height="h-5"
                                        width="w-5"
                                        background={"bg-transparent"}
                                    />
                                </div>
                            {/if}
                        </button>
                    </div>
                    <button
                        class="absolute right-3 top-3 bg-white"
                        type="button"
                        bind:this={close}
                        on:click
                        ><svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="size-6 stroke-red-400 hover:stroke-red-500 transition duration-300 ease stroke-2"
                            ><path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 18 18 6M6 6l12 12"
                                class="s-Bvfug3EMIymk"
                            ></path></svg
                        ></button
                    >
                </form>
            </div>
        </div>
    </div>
</div>
