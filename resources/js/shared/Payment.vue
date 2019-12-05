<template>
  <div
    class="fixed top-0 left-0 right-0 bottom-0 w-screen h-screen bg-gray-100 z-50 flex flex-col justify-center items-center"
  >
    <logo />
    <h4 class="text-xl text-black font-bold mt-6">Pay Ticket</h4>
    <div class="w-full max-w-sm mt-8">
      <p class="text-lg text-center">Your current parking rate:</p>
      <h2
        class="text-center text-5xl font-bold uppercase"
        :class="completed ? 'text-green-400' : 'text-blue-400'"
      >{{ ticket.rate.label }}</h2>
      <p class="text-center">Code: {{ ticket.code }}</p>
      <p class="text-center">Date: {{ ticket.date }}</p>
      <div v-if="!completed" class="mt-4">
        <p class="text-sm text-center">Payment Method</p>
        <form class="w-full mt-2" action="/api/tickets" method="POST" @submit.prevent="submit">
          <input
            class="w-full rounded-lg text-center px-4 py-2 bg-white border border-gray-400 focus:outline-none mx-2"
            v-model="form.card"
            type="text"
            autofocus
          />
          <div class="flex items-center mt-2">
            <input
              class="w-1/4 rounded-lg text-center px-4 py-2 bg-white border border-gray-400 focus:outline-none mx-2"
              v-model="form.exp"
              placeholder="MM/YY"
              type="text"
            />
            <input
              class="w-1/4 rounded-lg text-center px-4 py-2 bg-white border border-gray-400 focus:outline-none mx-2"
              v-model="form.cvc"
              placeholder="CVC"
              type="text"
            />
            <button
              class="flex-1 rounded-lg text-center px-4 py-1 text-xl bg-blue-400 text-white no-underline uppercase font-bold shadow-md ml-2 whitespace-no-wrap"
              type="submit"
            >Pay {{ ticket.rate.price }}</button>
          </div>
        </form>
      </div>
      <div v-else class="mt-4">
        <p class="text-2xl text-center text-green-400">Thank You!</p>
        <p class="text-lg text-center mt-1">You may now exit the parking garage.</p>
      </div>
    </div>
    <rates class="mt-8" />
    <router-link
      class="rounded-lg px-4 py-1 text-xl bg-blue-400 text-white no-underline uppercase font-bold mt-8 shadow-md"
      :to="{ name: 'home' }"
    >{{ completed ? 'Main Menu' : 'Pay Later' }}</router-link>
  </div>
</template>

<script>
import Form from './../utilities/Form'
import Logo from './../shared/Logo'
import Rates from './../shared/Rates'

export default {
  components: {
    Logo,
    Rates
  },
  props: {
    ticket: Object
  },
  data() {
    return {
      loading: false,
      form: new Form({
        card: '',
        exp: '',
        cvc: ''
      }),
      completed: false
    }
  },
  methods: {
    submit() {
      this.loading = true

      axios
        .patch('/api/tickets', { ...this.form.data(), code: this.ticket.code })
        .then(res => {
          this.form.reset()
          this.completed = true
          this.loading = false
          setTimeout(() => {
            this.$router.replace({ name: 'home' })
          }, 3000)
        })
        .catch(err => {
          console.log(err.response.data)
          this.completed = false
          this.loading = false
        })
    }
  }
}
</script>
