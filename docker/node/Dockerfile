FROM node:16-bullseye

WORKDIR /var/www/html

COPY ../../frontend/package*.json ./

RUN npm install -g @vue/cli@4 \
    && npm install

COPY ../../frontend .

EXPOSE 8080

CMD ["npm", "run", "serve", "--", "--host", "0.0.0.0"]
