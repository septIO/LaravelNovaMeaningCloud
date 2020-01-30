Nova.booting((Vue, router, store) => {
    Vue.component('index-laravel-meaningcloud', require('./components/IndexField'))
    Vue.component('detail-laravel-meaningcloud', require('./components/DetailField'))
    Vue.component('form-laravel-meaningcloud', require('./components/FormField'))
})
