<template>
  <div class="flex flex-col justify-center items-center min-h-screen">
    <logo />
    <h4 class="text-xl text-black font-bold mt-6">Get Ticket</h4>
    <transition name="fade">
      <template v-if="!loading">
        <template v-if="spaces.hasSpaces">
          <create-ticket class="max-w-sm mt-8" />
        </template>
        <template v-else>
          <div class="w-full max-w-sm mt-8">
            <h3 class="text-center text-4xl text-red-700 leading-tight">Sorry</h3>
            <p
              class="text-center text-2xl text-red-700 leading-tight"
            >The parking lot is full at this time.</p>
          </div>
        </template>
      </template>
    </transition>
    <rates class="mt-8" />
    <router-link
      class="rounded-lg px-4 py-1 text-xl bg-blue-400 text-white no-underline font-bold uppercase mt-8 shadow-md"
      :to="{ name: 'home' }"
    >Main Menu</router-link>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import Logo from './../shared/Logo'
import Rates from './../shared/Rates'
import CreateTicket from './../shared/CreateTicket'

export default {
  components: {
    Logo,
    Rates,
    CreateTicket
  },
  created() {
    this.fetchSpacesAvailable()
  },
  computed: {
    ...mapGetters(['loading', 'spaces'])
  },
  methods: {
    ...mapActions(['fetchSpacesAvailable'])
  }
}
</script>
