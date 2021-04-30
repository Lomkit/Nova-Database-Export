<template>
  <div class="mb-6 px-3 w-1/4">
    <card class="flex flex-col items-center justify-center px-3 py-3">
      <heading class="mb-3">{{ field.name }}</heading>
      <span
        class="w-full text-center whitespace-no-wrap px-2 py-2 uppercase text-xs font-bold border-2"
        :class="fieldStatus === 'lang' ? 'text-info-dark border-info-dark' : 'text-success-dark border-success-dark'"
      >
            {{ fieldStatus }}
        </span>
      <a class="btn btn-default btn-primary text-center w-full mt-3" :href="`/nova-vendor/export/fields/${index}`">
        Export
      </a>
    </card>
  </div>
</template>

<script>
export default {
    props: {
        field: {
            type: Array,
            required: true
        },
        index: {
            type: Number,
            required: true
        }
    },
    computed: {
        fieldStatus() {
            if (this.field.locales && this.field.locales !== false) {
                return 'lang'
            }
            return 'all'
        }
    }
}
</script>

<style>
/* Scoped Styles */
</style>
