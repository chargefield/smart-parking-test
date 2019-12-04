<template>
  <div class="w-full">
    <div class="border-gray-400 bg-black border-4 rounded-lg">
      <div class="relative w-full py-2">
        <div class="absolute top-0 left-0 right-0 w-full px-4 py-1">
          <transition name="slide-down">
            <div
              v-if="showTicket"
              class="relative w-full bg-white shadow-2xl p-8 flex flex-col justify-center items-center"
            >
              <logo small />
              <div class="mt-4">{{ ticket.date }}</div>
              <div class="mt-4">
                <svg class="fill-current w-1/2 mx-auto" viewBox="0 0 511.626 511.627">
                  <path
                    d="M134.761 54.816h17.699v401.707h-17.699zM98.786 54.816h8.848v401.707h-8.848zM197.568 54.816h8.852v401.707h-8.852zM179.581 54.816h8.852v401.707h-8.852zM26.84 54.816h9.136v401.707H26.84zM53.959 54.816h8.851v401.707h-8.851zM0 54.816h17.987V456.81H0zM215.557 54.816h8.852v401.707h-8.852zM394.856 54.816h17.986v401.707h-17.986zM439.966 54.816h26.837v401.707h-26.837zM475.653 54.816h9.134v401.707h-9.134zM493.64 54.816h17.986V456.81H493.64zM332.045 54.816h17.987v401.707h-17.987zM368.019 54.816h17.987v401.707h-17.987zM296.072 54.816h17.986v401.707h-17.986zM251.243 54.816h17.989v401.707h-17.989z"
                  />
                </svg>
              </div>
              <div>{{ ticket.code }}</div>
              <div class="text-xs text-gray-700 text-center mt-4">
                <p>You will need the above code to pay for parking.</p>
                <button
                  type="button"
                  class="mt-2 text-blue-400 uppercase focus:outline-none"
                  @click="takeTicket"
                >Take Ticket</button>
              </div>
            </div>
          </transition>
        </div>
      </div>
    </div>
    <div class="flex justify-center items-center mt-8">
      <button
        class="w-20 h-20 border-gray-400 border-4 rounded-full bg-blue-400 text-white shadow-md flex justify-center items-center uppercase font-bold text-sm focus:outline-none"
        type="button"
        :disabled="showTicket"
        @click="createTicket"
      >Ticket</button>
    </div>
  </div>
</template>

<script>
import Logo from './../shared/Logo'

export default {
  components: {
    Logo
  },
  data() {
    return {
      showTicket: false,
      ticket: {
        date: '',
        code: ''
      },
      error: false
    }
  },
  methods: {
    createTicket() {
      axios
        .post('/api/tickets')
        .then(res => {
          this.ticket = res.data
          this.showTicket = true
          this.error = false
        })
        .catch(err => {
          this.showTicket = false
          this.error = true
          window.location.reload()
        })
    },
    takeTicket() {
      this.showTicket = false
      this.ticket = {
        date: '',
        code: ''
      }
      this.error = true
    }
  }
}
</script>
