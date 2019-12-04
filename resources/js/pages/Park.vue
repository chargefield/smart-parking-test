<template>
  <div class="flex flex-col justify-center items-center min-h-screen">
    <logo />
    <rates class="mt-8" />
    <router-link
      class="rounded-lg px-4 py-1 text-xl bg-blue-400 text-white no-underline font-bold uppercase mt-8"
      :to="{ name: 'home' }"
    >Home</router-link>
  </div>
</template>

<script>
import Logo from './../shared/Logo'
import Rates from './../shared/Rates'

export default {
  components: {
    Logo,
    Rates
  }
}
</script>
