<script setup>
import {ref} from "vue";
import {usePage} from "@inertiajs/vue3";
import useMedia from "@/Hooks/useMedia.js";
import Popover from "@/Components/Popover.vue";
import MenuItem from "@/Components/Menu/MenuItem.vue";
import MenuList from "@/Components/Menu/MenuList.vue";
import ProfileInfo from "@/Pages/Cabinet/Profile/Partials/ProfileInfo.vue";
import ProfileTopics from "@/Pages/Cabinet/Profile/Partials/ProfileTopics.vue";
import CabinetLayout from "@/Layouts/Cabinet/CabinetLayout.vue";

const user = usePage().props.auth.user;

const profileNav = {
  whois: route('cabinet'),
};

const profileNavOpen = ref(false);

const currentNuvLink = ref('whois');

const selectNavLink = (link) => {
  currentNuvLink.value = link;
  profileNavOpen.value = false;
};

const isTablet = useMedia('(max-width: 1024px)');

const topics = [
  'Programming', 'Algorithms', 'IT-companies', 'Old hardware', 'History of IT', 'Software', 'Configuring Linux', 'DevOps', 'Server administration',
];
</script>

<template>
  <CabinetLayout>
    <div class="relative">
      <div class="relative p-4 bg-white z-10">
        <button
          class="flex items-center text-sm text-gray-700 font-semibold capitalize cursor-pointer select-none"
          @click.stop="() => profileNavOpen = !profileNavOpen"
        >
        <span>
          {{ currentNuvLink }}
        </span>

          <span
            class="material-icons transition duration-200 !text-[1.25rem]"
            :class="{'rotate-180': profileNavOpen}"
          >
         expand_more
       </span>
        </button>

        <Popover
          v-if="!isTablet"
          class="top-9 left-3"
          v-model:open="profileNavOpen"
        >
          <MenuList>
            <MenuItem
              class="py-2 px-4 text-sm capitalize"
              v-for="(_, link) in profileNav"
              :key="link"
              :selected="currentNuvLink === link"
              @click="() => selectNavLink(link)"
            >
              {{ link }}
            </MenuItem>
          </MenuList>
        </Popover>
      </div>

      <TransitionGroup
        enter-from-class="translate-y-[-100%]"
        enter-to-class="translate-y-0"
        enter-active-class="transition-transform duration-500"
        leave-from-class="translate-y-0"
        leave-to-class="translate-y-[-100%]"
        leave-active-class="absolute transition-transform duration-500"
        move-class="transition-transform duration-500"
      >
        <MenuList
          class="w-full !bg-sky-50"
          v-if="isTablet && profileNavOpen"
          :key="1"
        >
          <MenuItem
            class="py-2 px-4 text-sm capitalize "
            v-for="(_, link) in profileNav"
            :key="link"
            :selected="currentNuvLink === link"
            @click="() => selectNavLink(link)"
          >
            {{ link }}
          </MenuItem>
        </MenuList>

        <div class="mt-4 p-4 bg-white transition-transform" :key="2">
          <ProfileInfo
            class="mb-4 block lg:hidden"
            :user="user"
          />

          <ProfileTopics :topics="topics"/>
        </div>
      </TransitionGroup>
    </div>
  </CabinetLayout>
</template>
