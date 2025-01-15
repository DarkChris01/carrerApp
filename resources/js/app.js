import { createInertiaApp } from '@inertiajs/svelte'
import Layout from "./Layouts/Layout.svelte"
import GuestLayout from './Layouts/GuestLayout.svelte'
import EmployerLayout from './Layouts/EmployerLayout.svelte'
import ErrorLayout from './Layouts/ErrorLayout.svelte'
import AcceuilLayout from './Layouts/AcceuilLayout.svelte'
import Profilelayout from './Layouts/Profilelayout.svelte'
import AuthenticationLayout from './Layouts/AuthenticationLayout.svelte'

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.svelte', { eager: true })
        let page = pages[`./Pages/${name}.svelte`]

        return { default: page.default, layout: name.startsWith("Auth") ? AuthenticationLayout : name.startsWith("Profile") || name.startsWith("Cv")  ? Profilelayout : name.startsWith("Employer") || name.startsWith("Enterprise") || name.startsWith("Candidates") || name.startsWith("Jobs") || name.startsWith("Notifications") ? EmployerLayout : name.startsWith("User") ? Layout : name.startsWith("404") ? ErrorLayout : name.startsWith("Visit")? GuestLayout  : AcceuilLayout }
    }, setup({ el, App, props }) {
        new App({ target: el, props })
    },

})
