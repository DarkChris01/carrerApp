import { writable } from "svelte/store";

export let candidatureModalComponent = writable(false);
export let entretienModalComponent = writable(false);
export let notificationModalComponent = writable(false);
export let autoCompletionModalComponent = writable(false);
export let leftSideBarComponent = writable(false);
export let AutoCompleteStoreComponent = writable(false);
export let candidaciesFilterComponent = writable(false);