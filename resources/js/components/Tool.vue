<template>
    <div>
        <heading class="mb-6">Export</heading>

        <card
            class="flex flex-col items-center justify-center"
            style="min-height: 300px"
            v-if="fields === undefined"
        >
            <svg
                class="spin fill-80 mb-6"
                width="69"
                height="72"
                viewBox="0 0 399.389 399.389"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    d="M340.896,58.489C303.18,20.773,253.031,0.001,199.693,0.001c-53.34,0-103.487,20.771-141.204,58.488
		C20.772,96.207,0,146.355,0,199.694c0,53.34,20.772,103.489,58.49,141.206c37.717,37.717,87.864,58.488,141.204,58.488
		c53.339,0,103.486-20.771,141.205-58.488c37.717-37.717,58.49-87.865,58.49-141.206C399.387,146.355,378.613,96.207,340.896,58.489
		z M328.061,71.326c34.289,34.289,53.172,79.878,53.172,128.368h-41.148c0-77.412-62.979-140.391-140.391-140.391
		c-4.593,0-9.134,0.229-13.615,0.662v-41.31c4.508-0.332,9.049-0.5,13.615-0.5C248.184,18.155,293.771,37.038,328.061,71.326z
		 M199.693,321.931c-67.401,0-122.236-54.835-122.236-122.236S132.292,77.458,199.693,77.458S321.93,132.293,321.93,199.694
		S267.094,321.931,199.693,321.931z"
                      fill-rule="evenodd"/>
            </svg>

            <h1 class="text-4xl text-90 font-light mb-6">
                Charging fields ...
            </h1>
        </card>
        <template v-else>
            <div class="flex flex-wrap -mx-3 mb-3">
                <Field v-for="(field, key) in fields" :field="field" :key="key" :index="key" />
            </div>
            <div class="flex">
                <div class="w-full text-right">
                    <a class="btn btn-default btn-primary text-center mt-3" href="/nova-vendor/export/fields">
                        Export All
                    </a>
                </div>
            </div>
        </template>
    </div>
</template>

<script>
import Field from "./Field";
export default {
    components: { Field },
    metaInfo() {
        return {
          title: 'Export',
        }
    },
    data() {
        return {
            fields: undefined
        }
    },
    mounted() {
        Nova.request()
            .get('/nova-vendor/export/get/fields')
            .then(({ data }) => {
                this.fields = data
            })
    },
}
</script>

<style>
/* Scoped Styles */
</style>
