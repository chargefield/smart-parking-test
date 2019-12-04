<template>
  <div v-if="hasRates">
    <p class="text-center uppercase font-bold text-sm">Our Rates</p>
    <div
      class="flex flex-col sm:flex-row justify-center items-center flex-wrap bg-white rounded-lg p-4 shadow-inner uppercase mt-4"
    >
      <div class="px-4 py-2" v-for="rate in allRates" :key="rate.duration">{{ rate.label }}</div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  mounted() {
    this.fetchRates()
  },
  computed: {
    ...mapGetters(['allRates', 'hasRates'])
  },
  methods: {
    ...mapActions(['fetchRates'])
  }
}
</script>
