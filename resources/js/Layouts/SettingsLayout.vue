<script setup>
import AppHeader from "@/Components/AppHeader/AppHeader.vue";
import MainWrapper from "@/Components/MainWrapper.vue";</script>

<template>
  <AppHeader/>

  <MainWrapper>
    <slot/>
  </MainWrapper>
</template>
