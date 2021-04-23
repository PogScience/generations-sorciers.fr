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

    /**
     * Automatic timezone is simple to use: time elements (with the real datetime in its
     * attribute, as required by the HTML standard) and with the `has-auto-timezone` class
     * will be updated to use the browser's timezone.
     *
     * If the date is different, a span.real-day element will be appended to the time element,
     * containing the date in the user's timezone. Or prepended, if the class `has-real-day-prepended`
     * is added to the time element.
     *
     * Finally, with the `is-date` class, instead of the hour, the day will be displayed.
     */

    const localTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone
    const dateFormat = new Intl.DateTimeFormat('fr', {
        timeZone: localTimezone,
        weekday: "long",
        day: "numeric",
        month: "long",
    })
    const shortDateFormat = new Intl.DateTimeFormat('fr', {
        timeZone: localTimezone,
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

            // Display the date if it is different
            const dateParts = dateFormat.formatToParts(date)
            const origDateParts = originalDateTimeFormat.formatToParts(date)
            let day, origDay
            dateParts.forEach(part => {
                if (part.type === "day") day = part.value
            })
            origDateParts.forEach(part => {
                if (part.type === "day") origDay = part.value
            })

            if (day !== origDay) {
                const realDayElement = document.createElement("span")
                realDayElement.classList.add("real-day")
                realDayElement.innerText = shortDateFormat.format(date)

                if (timeElement.classList.contains("has-real-day-prepended")) {
                    realDayElement.innerText += " "
                    timeElement.prepend(realDayElement)
                } else {
                    timeElement.appendChild(realDayElement)
                }
            }
        }
    })

    const timezoneDisplay = document.getElementById("timezone")
    if (timezoneDisplay) {
        const timezoneParts = localTimezone.split("/")
        timezoneDisplay.innerText = timezoneParts.length === 2 ? timezoneParts[1] : localTimezone
        timezoneDisplay.setAttribute("title", `Les horaires ont été convertis dans votre zone horaire détectée (${displayOffset(new Date().getTimezoneOffset())}). La date origiane est affichée dans une infobulle.`)
    }
})
