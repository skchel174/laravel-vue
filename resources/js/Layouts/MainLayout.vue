<script setup>
import NotificationWrapper from "@/Components/NotificationWrapper.vue";
import AppHeader from "@/Components/AppHeader/AppHeader.vue";
import MainWrapper from "@/Components/MainWrapper.vue";
import AdvertWrapper from "@/Components/Advert/AdvertWrapper.vue";
</script>

<template>
  <NotificationWrapper>
    <AppHeader/>

    <MainWrapper>
      <AdvertWrapper>
        <slot/>
      </AdvertWrapper>
    </MainWrapper>
  </NotificationWrapper>
</template>
