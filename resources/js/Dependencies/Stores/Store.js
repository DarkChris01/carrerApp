import { writable } from 'svelte/store'

export let page = writable(0)
export let cv_Store = writable([])
export let enterprise_store = writable();
export let entretiens_store = writable([]);
export let notifications_store = writable([])
export let jobs_store = writable([])
export let candidacies_store = writable([])

