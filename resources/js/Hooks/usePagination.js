import {computed} from "vue";
import useMedia from "@/Hooks/useMedia.js";

function usePagination(page, pages) {
  const isMobile = useMedia("(max-width: 640px)");

  return computed(() => {
    const pagination = [];

    const range = isMobile.value ? 1 : 2;

    const leftMax = range;
    const rightMin = pages - range;
    const centerMin = page - range;
    const centerMax = page + range;

    let space = false;

    for (let i = 1; i <= pages; i++) {
      if (i <= leftMax || rightMin < i) {
        pagination.push(i)
        space = false;
        continue;
      }

      if (centerMin <= i && i <= centerMax) {
        pagination.push(i);
        space = false;
        continue;
      }

      if (!space) {
        pagination.push('...');
        space = true;
      }
    }

    return pagination;
  });
}

export default usePagination;
