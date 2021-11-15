export const randImageSrc = () => {
    return `/images/${(Math.floor(Math.random() * 20) + 1)}.jpg`
}

export const isAdmin = () => {
    const user = JSON.parse(localStorage.getItem('user'))
    return !!(user && user.roles.find(r => r.id === 1))
}
