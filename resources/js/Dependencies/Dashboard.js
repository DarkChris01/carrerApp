import axios from "axios";
const month = ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre'];




export let get_dashboard_data = async (year=2025) => {
    const request = await axios.get(`/employer/get-dashboard-datas/${year}`);
    return await request;
}


export async function datas(year) {
    let jobs = [];
    let candidatures = [];
    const request = await axios.get(`/employer/get-dashboard-datas/${year}`);
    if (request.status === 200) {
        const response = await request.data;

        for (let index = 0; index < month.length; index++) {
            const count_jobs = response.jobs.filter(a => {
                return new Date(a.created_at).getMonth() == index
            })

            const count_candidatures = response.candidatures.filter(a => {
                return new Date(a.date_creation).getMonth() == index
            })

            jobs[index] = count_jobs.length ?? 0
            candidatures[index] = count_candidatures.length ?? 0
        }
    }
    return await {
        labels: month,
        datasets: [
            {
                label: 'Offres',
                fill: true,
                borderWidth: 1.3,
                lineTension: 0.2,
                backgroundColor: 'rgba(225, 204,230, .3)',
                borderColor: 'rgb(255, 100, 88)',
                borderCapStyle: 'butt',
                borderDash: [],
                borderDashOffset: 0.0,
                borderJoinStyle: 'miter',
                pointBorderColor: 'rgb(205, 130,1 58)',
                pointBackgroundColor: 'rgb(255, 255, 255)',
                pointBorderWidth: 1,
                pointHoverRadius: 2,
                pointHoverBackgroundColor: 'rgb(0, 0, 0)',
                pointHoverBorderColor: 'rgba(220, 220, 220,1)',
                pointHoverBorderWidth: 1,
                pointRadius: 2,
                pointHitRadius: 2,
                data: jobs
            },
            {
                label: 'Candidatures',
                fill: true,
                borderWidth: 1.3,
                lineTension: 0.2,
                backgroundColor: 'rgba(184, 185, 210, .3)',
                borderColor: 'rgb(35, 26, 136)',
                borderCapStyle: 'butt',
                borderDash: [],
                borderDashOffset: 0.0,
                borderJoinStyle: 'miter',
                pointBorderColor: 'rgb(35, 26, 136)',
                pointBackgroundColor: 'rgb(255, 255, 255)',
                pointBorderWidth: 1,
                pointHoverRadius: 2,
                pointHoverBackgroundColor: 'rgb(0, 0, 0)',
                pointHoverBorderColor: 'rgba(220, 220, 220, 1)',
                pointHoverBorderWidth: 2,
                pointRadius: 2,
                pointHitRadius: 2,
                data: candidatures,
            },
        ],
    };
}



export async function open_jobs_graph_datas(year) {
    let job_postes = [];
    let candidats = [];
    const request = await axios.get(`/employer/get-open-jobs-datas/${year}`);
    if (request.status === 200) {
        const response = await request.data

        for (const job of response) {
            job_postes = [...job_postes, job.poste]
            candidats = [...candidats, job.candidacies.length];
        }

        return await {
            labels: job_postes,
            datasets: [
                {
                    label: 'Candidatures par poste',
                    indexAxis:"y",
                    data: candidats,
                    backgroundColor: [
                        'rgba(255, 134,159,0.4)',
                        'rgba(98,  182, 239,0.4)',
                        'rgba(255, 218, 128,0.4)',
                        'rgba(113, 205, 205,0.4)',
                        'rgba(170, 128, 252,0.4)',
                        'rgba(255, 177, 101,0.4)',
                    ],
                    borderWidth: 1,
                    borderColor: [
                        'rgba(255, 134, 159, 1)',
                        'rgba(98,  182, 239, 1)',
                        'rgba(255, 218, 128, 1)',
                        'rgba(113, 205, 205, 1)',
                        'rgba(170, 128, 252, 1)',
                        'rgba(255, 177, 101, 1)',
                    ],
                },
            ],
        }
    }
}



