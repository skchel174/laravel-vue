import {useForm} from "@inertiajs/vue3";

function useComment(data = {}) {
  const form = useForm({text: '', ...data});

  const sendForm = (method, url, options) => {
    form[method](url, {
      preserveScroll: true,
      ...options,
    });
  };

  return {form, sendForm};
}

export default useComment;
