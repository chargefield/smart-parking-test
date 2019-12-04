<template>
  <div class="flex flex-col justify-center items-center min-h-screen">
    <logo />
    <rates class="mt-8" />
    <router-link
      class="rounded-lg px-4 py-1 text-xl bg-blue-400 text-white no-underline uppercase font-bold mt-8"
      :to="{ name: 'home' }"
    >Main Menu</router-link>
  </div>
</template>

<script>
import Form from './../utilities/Form'
import Errors from './../utilities/Errors'
import Logo from './../shared/Logo'
import Rates from './../shared/Rates'

export default {
  components: {
    Logo,
    Rates
  },
  data() {
    return {
      form: new Form({
        plate: ''
      }),
      errors: new Errors({})
    }
  }
}
</script>
