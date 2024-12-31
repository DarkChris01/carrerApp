import axios from "axios";
import toast from "svelte-french-toast"


export async function load_domains() {
    const request = await axios.get("/load-domains", { timeout: 10000 });
    return await request;
}


export async function load_enterprises() {
    const response_enterprise = await axios.get("/load-enterprise");
    return await response_enterprise.data;
}

export async function load_cv_data() {
    const response = await axios.get("/cv/load-data")
    return await response.data
}

export async function get_mosts_cvs() {
    const request = axios.get("get-most-cv",
        { timeout: 20000 }).catch(error => {
            return error
        });

    return await request
}

export async function load_country() {
    const request = await axios
        .get("https://restcountries.com/v3.1/all?fields=name,idd", {
            timeout: 20000,
        }).catch((error) => {            
            if (error.code === "ERR_NETWORK") {                
                toast.error("Probleme de connexion !");
            }
        });

    return request
}

export async function get_candadite_information(candidate_id) {
    const request = await axios.get(`/employer/get-candidate-datas/${candidate_id}`);
    return await request
}

export async function get_notifications(user_id) {
    const request = await axios.get(`/user/get-notifications`);
    return await request
}

export async function get_user_cv_information() {
    const request = await axios.get(`/cv/get-user-cv-information/`);
    return await request
}

export async function get_all_enterprises() {
    const request = await axios.get(`/get-all-enterprises`);
    return await request
}

export async function get_user_candidacies() {
    const request = await axios.get(`/candidature`);
    return await request
}

export async function get_user_entretiens() {
    const request = await axios.get(`/entretien`);
    return await request
}

export async function rateCandidate(url) {
    const request = await axios.get(url);
    return await request
}


export async function get_job_posts() {
    const request = await axios.get("/postes");
    return await request
}
