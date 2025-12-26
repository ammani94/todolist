# ui/Dockerfile
FROM node:20-alpine AS development

ENV NODE_ENV development
WORKDIR /var/www/app

# Copiez package.json et yarn.lock
COPY package.json yarn.lock ./
RUN yarn install --frozen-lockfile

# Copiez le reste des fichiers
COPY . .

# Exposez le port
EXPOSE 3000

# Démarrez l'application
CMD ["yarn", "dev"]