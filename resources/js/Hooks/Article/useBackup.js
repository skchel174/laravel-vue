import {onMounted, ref} from "vue";
import moment from "moment";

function useBackup() {
  const backup = ref(null);

  const makeBackup = (form) => {
    localStorage.setItem('article_backup', JSON.stringify({
      ...form.data(),
      save_date: moment().format(),
    }));
  };

  const backupForm = (form) => {
    form.text = backup.value.text;
    form.title = backup.value.title;
    form.summary = backup.value.summary;
    form.tags = backup.value.tags;
    form.topics = backup.value.topics;
    form.media = backup.value.media;
    form.difficulty = backup.value.difficulty;
  };

  onMounted(() => {
    const data = localStorage.getItem('article_backup');

    if (data) {
      backup.value = JSON.parse(data);
    }
  });

  return {
    backup,
    makeBackup,
    backupForm,
  }
}

export default useBackup;
