import {useForm as useInertiaForm} from "@inertiajs/vue3";

function useForm(article = null) {
  const form = useInertiaForm({
    text: article?.text ?? '',
    title: article?.title ?? '',
    summary: article?.summary ?? '',
    tags: article?.tags ?? [],
    topics: article?.topics ?? [],
    difficulty: article?.difficulty ?? null,
    image: undefined,
    media: null,
    status: null,
  });

  const submit = (params) => {
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

  return {
    form,
    submit,
  };
}

export default useForm;
