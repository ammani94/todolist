<script setup>
import { ref, toRaw } from 'vue';
const formData = ref({
  username: '',
  password: '',
  message: '',
});

const submitForm = async () => {
  try {
    console.log('Données envoyées :', toRaw(formData.value));
    const response = await fetch('http://localhost:8080/api/formulaire', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(toRaw(formData.value)),
    });

    const result = await response.json();
    console.log('Réponse du serveur :', result);
    alert('Formulaire envoyé avec succès !');
  } catch (error) {
    console.error('Erreur :', error);
    alert('Une erreur est survenue.');
  }
};
</script>

<template>
  <div class="contact">
    <h2>Contact</h2>
    <p>Contactez-nous via ce formulaire.</p>
    <form @submit.prevent="submitForm">
    <input v-model="formData.username" placeholder="Identifiant" required />
    <input v-model="formData.password" type="password" placeholder="Mot de passe" required />
    <textarea v-model="formData.message" placeholder="Message" required></textarea>
    <button type="submit">Envoyer</button>
  </form>
  </div>
</template>
