import UIkit from "uikit"

export const notify = (message, status) => {
    UIkit.notification({
        message: message,
        status: status ?? 'danger',
        pos: 'top-right',
        timeout: 2000
    });
}

export const notifyErrors = (errors) => {
    for(var key in errors) {
        errors[key].map(error => {
            notify(`<b>"${key}"</b>: ${error}`)
        })
    }
}

export const randImageSrc = () => {
    return `/images/${(Math.floor(Math.random() * 20) + 1)}.jpg`
}

export const isAdmin = () => {
    const user = JSON.parse(localStorage.getItem('user'))
    return !!(user && user.roles.find(r => r.id === 1))
}
