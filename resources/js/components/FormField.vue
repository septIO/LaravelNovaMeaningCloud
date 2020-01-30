<template>
    <default-field :field="field" :errors="errors">
        <template slot="field">
            <textarea
                :id="field.name"
                rows="5"
                class="w-full form-control form-input form-input-bordered"
                :class="errorClasses"
                :placeholder="field.name"
                v-model="value"
                style="height: auto"
            />
            <button
                :disabled="loading || recentlyLoaded"
                @click.prevent="getResume"
                class="btn btn-default btn-primary inline-flex items-center relative mt-5">
                <span v-if="loading">Loading...</span>
                <span v-else-if="recentlyLoaded">Done</span>
                <span v-else>Load</span>
            </button>
        </template>
    </default-field>
</template>

<script>
    import {FormField, HandlesValidationErrors} from 'laravel-nova'

    export default {
        mixins: [FormField, HandlesValidationErrors],

        props: ['resourceName', 'resourceId', 'field'],
        data() {
            return {
                loading: false,
                recentlyLoaded: false
            }
        },
        methods: {
            /*
             * Set the initial, internal value for the field.
             */
            setInitialValue() {
                this.value = this.field.value || ''
            },

            /**
             * Fill the given FormData object with the field's internal value.
             */
            fill(formData) {
                formData.append(this.field.attribute, this.value || '')
            },

            /**
             * Update the field's internal value.
             */
            handleChange(value) {
                this.value = value
            },

            getResume() {
                this.loading = true
                let text = document.querySelector('*[placeholder=' + this.field.relation + ']').innerText
                text = text.replace(/^ /g, '')
                    .replace(/  +/g, ' ')
                    .replace(/[\u200B-\u200D\uFEFF\u200E\u200F]/g, '')
                    .replace(/\s+/, ' ')

                fetch(`https://api.meaningcloud.com/summarization-1.0?key=${Nova.config.key}&sentences=${this.field.sentences}&txt=${text}`)
                    .then(res => res.json())
                    .then(r => {
                        let s = r.summary
                        s = s.replace(/([\.,])([^\n\.\[\]\s])/g, '$1 $2')
                        this.value = s
                    })
                    .catch(err => console.error(err))
                    .finally(() => {
                        this.loading = false
                        this.recentlyLoaded = true
                        setTimeout(() => this.recentlyLoaded = false, 2500)
                    })
            }
        },
    }
</script>
