import {onMounted, ref} from "vue";
import {useForm as useInertiaForm} from "@inertiajs/vue3";
import moment from "moment";

function useForm(article = null) {
  const form = useInertiaForm({
    text: article?.text ?? '',
    title: article?.title ?? '',
    summary: article?.summary ?? '',
    tags: article?.tags ?? [],
    topics: article?.topics ?? [],
    difficulty: article?.difficulty ?? null,
    lang: article?.lang ?? 'en',
    image: undefined,
    media: null,
    status: null,
  });

  const backup = ref(null);

  const update = (prop, value) => {
    form[prop] = value;

    localStorage.setItem('article_backup', JSON.stringify({
      ...form.data(),
      save_date: moment().format('DD-MM-YYYY HH:mm:ss'),
    }));
  };

  const restore = () => {
    form.text = backup.value.text;
    form.title = backup.value.title;
    form.summary = backup.value.summary;
    form.tags = backup.value.tags;
    form.topics = backup.value.topics;
    form.media = backup.value.media;
    form.difficulty = backup.value.difficulty;
  };

  const send = (params) => {
    const uri = article
      ? route('article.update', {article: article.id})
      : route('article.create');

    form
      .transform(data => ({
        ...data,
        tags: form.tags.map(tag => tag.id),
        topics: form.topics.map(topic => topic.id),
        _method: article ? 'patch' : 'post',
      }))
      .post(uri, params);
  };

  onMounted(() => {
    const data = localStorage.getItem('article_backup');

    if (data) {
      backup.value = JSON.parse(data);
    }
  });

  return {
    form,
    backup,
    update,
    restore,
    send,
  };
}

export default useForm;
