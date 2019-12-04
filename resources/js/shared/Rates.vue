<template>
  <div v-if="hasRates">
    <p class="text-center uppercase font-bold text-sm">Daily Rates</p>
    <div
      class="flex flex-col sm:flex-row justify-center items-center flex-wrap bg-white rounded-lg p-4 shadow-inner uppercase mt-4"
    >
      <div class="px-4 py-2" v-for="rate in rates" :key="rate.duration">{{ rate.label }}</div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  created() {
    this.fetchRates()
  },
  computed: {
    ...mapGetters(['rates', 'hasRates'])
  },
  methods: {
    ...mapActions(['fetchRates'])
  }
}
</script>
