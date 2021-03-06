<template>
  <div class="flex flex-col justify-center items-center min-h-screen">
    <logo />
    <h4 class="text-xl text-black font-bold mt-6">Pay Ticket</h4>
    <div class="w-full max-w-sm mt-8">
      <p class="text-center text-sm">Please enter the code on your ticket.</p>
      <form
        class="flex flex-col justify-center items-center mt-2"
        action="/api/ticket"
        method="POST"
        autocomplete="off"
        @submit.prevent="submit"
      >
        <input
          class="w-full rounded-lg text-center text-2xl px-4 py-2 bg-white border-4 border-gray-400 focus:outline-none"
          :class="{'border-red-700': errors.has('code')}"
          v-model="form.code"
          type="text"
          autofocus
        />
        <p
          v-if="errors.has('code')"
          class="text-center text-sm text-red-700 mt-2"
        >{{ errors.first('code') }}</p>
        <button
          class="mt-4 w-20 h-20 border-gray-400 border-4 rounded-full bg-blue-400 text-white shadow-md flex justify-center items-center uppercase font-bold text-sm focus:outline-none"
          type="submit"
          :disabled="loading"
        >Find</button>
      </form>
    </div>
    <rates class="mt-8" />
    <router-link
      class="rounded-lg px-4 py-1 text-xl bg-blue-400 text-white no-underline uppercase font-bold mt-8 shadow-md"
      :to="{ name: 'home' }"
    >Main Menu</router-link>
    <portal v-if="payScreen" to="modal">
      <transition name="fade">
        <payment :ticket="ticket" />
      </transition>
    </portal>
  </div>
</template>

<script>
import Form from './../utilities/Form'
import Errors from './../utilities/Errors'
import Logo from './../shared/Logo'
import Rates from './../shared/Rates'
import Payment from './../shared/Payment'

export default {
  components: {
    Logo,
    Rates,
    Payment
  },
  data() {
    return {
      loading: false,
      form: new Form({
        code: ''
      }),
      errors: new Errors({}),
      ticket: {},
      payScreen: false
    }
  },
  methods: {
    submit() {
      this.loading = true

      axios
        .post('/api/tickets/show', this.form.data())
        .then(res => {
          this.ticket = res.data
          this.form.reset()
          this.errors.clearAll()
          this.payScreen = true
          this.loading = false
        })
        .catch(err => {
          this.errors = new Errors(err.response.data.errors)
          this.payScreen = false
          this.loading = false
        })
    }
  }
}
</script>
