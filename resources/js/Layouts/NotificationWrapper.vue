<script setup>
import {provide} from "vue";
import Notification from "@/Components/Notification.vue";
import useNotification from "@/Hooks/useNotification.js";

const {notice, showNotification} = useNotification();

provide('notify', showNotification);
</script>

<template>
  <slot/>

  <Notification
    :type="notice.type"
    :duration="notice.duration"
    v-model:visible="notice.visible"
  >
    {{ notice.message }}
  </Notification>
</template>
