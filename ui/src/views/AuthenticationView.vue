<script setup>
import { ref, toRaw } from 'vue'
import { useRouter } from 'vue-router'
const formData = ref({
  username: '',
  password: ''
})
const router = useRouter()
const submitForm = async () => {
  try {
    const response = await fetch('http://localhost:8080/login', {
      method: 'POST',
      credentials: 'include',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(toRaw(formData.value)),
    });

    const result = await response.json();
    if (result.success) {
        router.push({name: 'home'})
    } else {
      alert(result.message)
    }
  } catch (error) {
    console.error('Erreur :', error);
    alert('Une erreur est survenue.');
  }
};
</script>

<template>
  <div class="authentification">
    <form @submit.prevent="submitForm">
    <input v-model="formData.username" placeholder="Identifiant" required />
    <input v-model="formData.password" type="password" placeholder="Mot de passe" required />
    <button type="submit">Se connecter</button>
  </form>
  </div>
  <div class="signup">
    <router-link to="/signup">Créer un compte</router-link>
  </div>
</template>
