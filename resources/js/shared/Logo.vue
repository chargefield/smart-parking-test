<template>
  <div class="flex justify-center items-baseline italic" :class="small ? 'text-xl' : 'text-3xl'">
    <span>smart</span>
    <span :class="small ? 'text-3xl' : 'text-5xl'">PARK</span>
    <span :class="small ? 'text-2xl' : 'text-4xl'">ing</span>
  </div>
</template>

<script>
export default {
  props: {
    small: { type: Boolean, default: false }
  }
}
</script>
