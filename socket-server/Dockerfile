FROM node:20-alpine

# Set working directory
WORKDIR /usr/src/app

# Salin package.json dan package-lock.json
COPY package*.json ./

# Pasang dependensi Node.js
RUN npm install --production

# Salin seluruh berkas socket-server
COPY . .

# Expose port yang digunakan socket-server
EXPOSE 3000

# Jalankan server WebSocket
CMD ["node", "server.js"]
