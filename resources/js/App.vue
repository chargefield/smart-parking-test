<template>
  <div class="w-full">
    <transition name="fade" mode="out-in">
      <router-view></router-view>
    </transition>
    <portal-target name="modal" slim />
  </div>
</template>

<script>
export default {}
</script>
