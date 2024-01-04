<script setup>
import Divider from "@/Components/Divider.vue";
import AppHeader from "@/Components/AppHeader/AppHeader.vue";
import MainWrapper from "@/Components/MainWrapper.vue";
import NotificationWrapper from "@/Components/NotificationWrapper.vue";
import ProfileWidget from "@/Components/ProfileWidget.vue";
import NavigationTabs from "@/Pages/User/Partials/NavigationTabs.vue";

const props = defineProps({
  currentTab: {
    type: String,
    required: true,
  },

  user: {
    type: Object,
    required: true,
  },
});
</script>

<template>
  <NotificationWrapper>
    <AppHeader/>

    <MainWrapper>
      <div
        class="w-full flex flex-col items-center lg:items-start lg:flex-row lg:justify-between space-y-4 lg:space-y-0 lg:space-x-4">
        <div class="flex-1 w-full max-w-3xl">
          <div class="relative z-10 bg-white">
            <ProfileWidget
              :user="user"
              :auth="$page.props.auth"
              :subscription="$page.props.subscription"
            />

            <NavigationTabs
              :user="user"
              :current-tab="currentTab"
            />
          </div>

          <slot/>
        </div>

        <div class="hidden lg:block w-80 space-y-4">
          <div class="p-4 bg-white w-full lg:max-w-xs">
            <h2 class="text-sm text-gray-500 font-bold uppercase">
              Information
            </h2>

            <Divider class="my-4"/>

            <table class="w-full max-w-xs">
              <tr>
                <td class="pb-1 text-sm text-gray-700 font-bold">
                  Registered
                </td>
                <td class="pb-1 px-4 text-xs text-gray-700 font-medium">
                  {{ user.created_at }}
                </td>
              </tr>
              <tr>
                <td class="pt-2 text-sm text-gray-700 font-bold">
                  Activity
                </td>
                <td class="pt-2 px-4 text-xs text-gray-700 font-medium">
                  {{ $formatDate(user.login_at, 'DD MMM YYYY') }}
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </MainWrapper>
  </NotificationWrapper>
</template>
