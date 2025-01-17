
import toast from "svelte-french-toast";
import axios from "axios"

export const relativeTimeFormatter = (lang = "fr-FR", timestamp) => {
    let formatter = new Intl.RelativeTimeFormat(lang, { style: 'short', numeric: 'auto' }),
        F = new Intl.DateTimeFormat(lang, { month: "2-digit", day: '2-digit', year: 'numeric' }),
        referencyDate = new Date(timestamp).getTime() / 1000,
        currentDate = new Date().getTime() / 1000,
        times,
        relativeTime

    if (referencyDate < currentDate) {
        relativeTime = Math.ceil(currentDate - referencyDate)
        if (relativeTime > (3600 * 24 * 31)) {
            return F.format(referencyDate * 1000)
        }
        else if (relativeTime >= (3600 * 23)) {
            times = Math.ceil(-relativeTime / (3600 * 24));
            return formatter.format(times, 'days')
        } else if (relativeTime > 3600) {
            times = Math.ceil(-relativeTime / 3600);
            return formatter.format(times, 'hours')
        } else if (relativeTime > 60) {
            times = Math.ceil(-relativeTime / 60);
            return formatter.format(times, 'minutes')
        } else {
            times = Math.ceil(-relativeTime / 3600);
            return formatter.format(times, 'seconds')
        }
    } else {
        relativeTime = Math.ceil(referencyDate - currentDate)

        if (relativeTime >= (3600 * 23)) {
            times = Math.ceil(relativeTime / (3600 * 24));
            return formatter.format(times, 'days')
        } else if (relativeTime > 3600) {
            times = Math.ceil(relativeTime / 3600);
            return formatter.format(times, 'hours')
        } else if (relativeTime > 60) {
            times = Math.ceil(relativeTime / 60);
            return formatter.format(times, 'minutes')
        } else {
            times = Math.ceil(relativeTime / 3600);
            return formatter.format(times, 'seconds')
        }

    }
}

export const format_date_anglo_to_french = (date) => {
    const formatter = new Intl.DateTimeFormat('fr-FR', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit'
    }).format(date);
    return formatter;
}

export const formatTime = (time) => {
    const a = time.split(":");
    return `${a[0]}h ${a[1]}`
}

export const getFullDate = (date) => {
    const options = { day: '2-digit', month: 'long', year: 'numeric' };
    return new Intl.DateTimeFormat("FR-fr", options).format(new Date(date));
}

export function compareDate(date1, date2 = new Date().toISOString()) {
    const timestamp1 = new Date(date1).getTime(),
        timestamp2 = new Date(date2).getTime();

    return Math.round((timestamp1 - timestamp2) / 1000);
}

export const socialMediaUnitFormat = function (int) {
    const formatter = new Intl.NumberFormat(undefined, {
        notation: 'compact'
    })

    return formatter.format(int)
}

// previzualize image before upload 
export function PrevisualiseUploadedFile(fileInput, backgroundImage = null) {

    const valideExtension = ["jpeg", "jpg", "png", "avif", "webp"],
        reader = new FileReader(),
        file = fileInput.target.files[0];
    if (
        !valideExtension.includes(
            file.name.split(".").slice(-1)[0].toLowerCase(),
        )
    ) {
        toast.error("le fichier doit être de type (jpg ,jpeg ou png)");
        throw new Error("wrong extension");
    } else if (file.size > 600000) {
        toast.error("la taille de l'image ne depasse pas 600ko");
        throw new Error("file too large");
    }


    reader.onload = function () {
        const image = document.querySelector(".img-previsualize");
        if (backgroundImage) {
            backgroundImage.style.backgroundImage = `url(${reader.result})`
        } else {

            image.src = reader.result;
            image.alt = "previsualize";
        }
    };

    reader.readAsDataURL(file);
};


export function isRecent(timestamp) {
    let recent = new Date(timestamp).getTime();
    let now = new Date().getTime();
    let diff = (now - recent) / 1000;

    return (diff < 7200)
}

export function fadeIn(container, times = 1000) {
    container.style.opacity = 0
    for (let i = 0; i < times; i++) {
        ((i) => {
            setTimeout(() => {
                container.style.opacity = (i / times);
            }, 1 * i);
        })(i);
    }
}

export function fadeOut(container, times = 1000) {
    for (let i = times; i > 0; i--) {
        ((i) => {
            setTimeout(() => {
                container.style.opacity = (1 / times) * i;
            }, 1 * i);
        })(i);
    }
}



export function counter(integer, callback) {
    let timeOut
    for (let i = 0; i <= integer + 1; i++) {
        ((i) => {
            timeOut = setTimeout(() => {
                callback(i);
            }, i * 50);
        })(i);
    }
    clearTimeout(timeOut)
}


export function showTooltip(handle) {
    clearInterval(hidetime);
    time = setTimeout(() => {
        handle = true;
    }, 1000)
}


export function hideTooltip(handle) {
    clearInterval(time);
    hidetime = setTimeout(() => {
        handle = false;
    }, 1000)
}

export function cleanFilterParams(param) {
    return Object.fromEntries(
        Object.entries(param).filter(
            ([_, value]) => value !== null && value !== "",
        ),
    );
}

export async function autocomplete(word, url) {
    const request = await axios.post(url, {
        word: word,
    });
    return await request
}
