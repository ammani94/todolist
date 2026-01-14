<script setup>
import { ref, toRaw, onMounted } from 'vue'
import { useRouter } from 'vue-router'
const formData = ref({
  name: ''
})
let todolists = ref([]);
const router = useRouter()
const fetchTodolists = async () => {
  try {
    const response = await fetch('http://localhost:8080/fetch');
    const result = await response.json()
    if (result.success) {
      todolists.value = result.todolists
    }
  } catch (error) {
    console.error('Erreur lors de la récupération des données :', error)
  }
}
const submitForm = async () => {
  try {
    const response = await fetch('http://localhost:8080/add_todolist', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(toRaw(formData.value)),
    });

    const result = await response.json()
    console.log(result)
    if (result.success) {
        todolists.value.push(result.todolist)
        formData.value.name = ''
    }
  } catch (error) {
    console.error('Erreur :', error);
    alert('Une erreur est survenue.');
  }
};
onMounted(fetchTodolists)

</script>

<template>
  <div class="todolist">
    <form @submit.prevent="submitForm">
      <input v-model="formData.name" placeholder="Nom de la todolist" required />
      <button type="submit">Créer une todolist</button>
    </form>
    <ul>
      <li v-for="todolist in todolists" :key="todolist.id">
        <router-link :to="todolist.path">{{ todolist.name }}</router-link>
      </li>
    </ul>
  </div>
</template>
