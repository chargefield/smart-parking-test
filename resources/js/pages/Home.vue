<template>
  <div class="flex flex-col justify-center items-center min-h-screen">
    <logo />
    <div class="flex flex-col sm:flex-row justify-center items-center mt-8">
      <router-link
        class="m-2 rounded-lg px-8 py-3 text-4xl bg-blue-400 text-white no-underline font-bold uppercase shadow-md"
        :to="{ name: 'park' }"
      >Park</router-link>
      <router-link
        class="m-2 rounded-lg px-8 py-3 text-4xl bg-blue-400 text-white no-underline font-bold uppercase shadow-md"
        :to="{ name: 'pay' }"
      >Pay</router-link>
      <router-link
        class="m-2 rounded-lg px-8 py-3 text-4xl bg-blue-400 text-white no-underline font-bold uppercase shadow-md"
        :to="{ name: 'exit' }"
      >Exit</router-link>
    </div>
    <rates class="mt-8" />
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
