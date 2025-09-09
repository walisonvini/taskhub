FROM node:16-alpine

RUN addgroup -g 1001 -S nodejs
RUN adduser -S nextjs -u 1001

WORKDIR /app

COPY frontend/package*.json ./
RUN npm install

COPY frontend .

RUN chown -R nextjs:nodejs /app
USER nextjs

EXPOSE 8080

CMD ["npm", "run", "serve", "--", "--host", "0.0.0.0"]