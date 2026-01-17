<script setup>
import { ref, toRaw, onMounted } from 'vue'
import { useRoute } from 'vue-router'
const route = useRoute()
const id = ref(route.params.id)
const formData = ref({
  name: ''
})

let todolists = ref([])
const fetchTodolists = async () => {
  try {
    const response = await fetch('http://localhost:8080/fetch/todolist/'+id.value)
    const result = await response.json()
    if (result.success) {
      todolists.value = result.todolists
    }
    console.log(todolists)
  } catch (error) {
    console.error('Erreur lors de la récupération des données :', error)
  }
}

const deleteItem = async(id) => {
    try {
    const response = await fetch('http://localhost:8080/delete_todolistItem/'+id, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(toRaw(formData.value)),
    });

    const result = await response.json()
    if (result.success) {
        todolists.value = todolists.value.filter((item) => item.id !== id);
    }
  } catch (error) {
    console.error('Erreur :', error);
    alert('Une erreur est survenue.');
  }
}

const submitForm = async () => {
  try {
    const response = await fetch('http://localhost:8080/add_todolistItem/'+id.value, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(toRaw(formData.value)),
    });

    const result = await response.json()
    if (result.success) {
        todolists.value.push(result.todolist)
        formData.value.name = ''
    }
  } catch (error) {
    console.error('Erreur :', error);
    alert('Une erreur est survenue.');
  }
}
onMounted(fetchTodolists)

</script>

<template>
  <div class="todolist">
    <form @submit.prevent="submitForm">
      <input v-model="formData.name" placeholder="..." required />
      <button type="submit">Ajouter un élément</button>
    </form>
  </div>
      <div v-for="todolist in todolists" :key="todolist.id">
  {{ todolist.name }}
  <form @submit.prevent="() => deleteItem(todolist.id)">
    <button type="submit">-</button>
  </form>
</div>

</template>