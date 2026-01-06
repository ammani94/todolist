<template>
  <header class="app-header">
    <div class="header-content">
      <h1>{{ title }}</h1>
      <nav>
        <ul>
          <li v-for="link in navLinks" :key="link.path">
            <router-link :to="link.path">{{ link.text }}</router-link>
          </li>
        </ul>
      </nav>
    </div>
  </header>
</template>

<script setup>
const title = "ToDoList"
const navLinks = [
  { path: "/", text: "Accueil"},
  { path: "/about", text: "À propos" },
  { path: "/contact", text: "Contact" },
];
</script>

<style scoped>
.app-header {
  background-color: #2c3e50;
  color: white;
  padding: 1rem;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.header-content {
  display: flex;
  justify-content: space-between;
  align-items: center;
  max-width: 1200px;
  margin: 0 auto;
}

nav ul {
  display: flex;
  list-style: none;
  gap: 1rem;
}

nav a {
  color: white;
  text-decoration: none;
  font-weight: bold;
}

nav a:hover {
  text-decoration: underline;
}
</style>
