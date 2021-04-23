function capitalize(s) {
    return s[0].toUpperCase() + s.slice(1);
}

function displayOffset(offset) {
    offset = -offset / 60
    return "UTC" + (offset > 0 ? "+" : "-") + Math.abs(offset)
}

document.addEventListener("DOMContentLoaded", () => {
    /* *** Modals on <detail> *** */

    document.querySelectorAll("details.has-modal").forEach(modal => {
        const closers = modal.querySelectorAll(".modal-background, .modal-close")
        closers.forEach(closer => closer.addEventListener("click", () => {
            modal.removeAttribute("open")
        }))
    })


    /* *** Automatic timezone *** */

    const localTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone
    const dateFormat = new Intl.DateTimeFormat('fr', {
        timeZone: localTimezone,
        weekday: "long",
        day: "numeric",
        month: "long",
    })
    const timeFormat = new Intl.DateTimeFormat('fr', {
        timeZone: localTimezone,
        hour: "numeric",
        minute: "numeric",
    })

    // Used to display the original date so no timezone
    const originalDateTimeFormat = new Intl.DateTimeFormat('fr', {
        weekday: "long",
        day: "numeric",
        month: "long",
        hour: "numeric",
        minute: "numeric",
    })

    document.querySelectorAll("time.has-auto-timezone").forEach(timeElement => {
        let isoDate = timeElement.getAttribute("datetime")
        if (!isoDate) return

        const date = new Date(isoDate)

        timeElement.setAttribute("title", `${capitalize(originalDateTimeFormat.format(date))} ${displayOffset(date._offset || -120)}`)

        if (timeElement.classList.contains("is-date")) {
            timeElement.innerText = capitalize(dateFormat.format(date))
        } else {
            const timeParts = timeFormat.formatToParts(date)
            let hours, minutes
            timeParts.forEach(part => {
                if (part.type === "hour") hours = part.value
                else if (part.type === "minute") minutes = part.value
            })

            timeElement.innerText = `${hours}h${minutes !== "00" ? minutes : ""}`
        }
    })

    const timezoneDisplay = document.getElementById("timezone")
    if (timezoneDisplay) {
        const timezoneParts = localTimezone.split("/")
        timezoneDisplay.innerText = timezoneParts.length === 2 ? timezoneParts[1] : localTimezone
        timezoneDisplay.setAttribute("title", `Les horaires ont été convertis dans votre zone horaire détectée (${displayOffset(new Date().getTimezoneOffset())}). La date origiane est affichée dans une infobulle.`)
    }
})
