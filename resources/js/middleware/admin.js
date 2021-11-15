export default function isAdmin ({ next, router, store }){
    console.log('Middleware: admin')
    if(!store.getters['auth/isAdmin']){
        return next({
            name: 'AccessDenied'
        })
    } else {
        return next()
    }
}
