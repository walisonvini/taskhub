<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 px-4">
    <div class="max-w-md w-full space-y-8">
      <div class="text-center">
        <h2 class="mt-6 text-3xl font-bold text-gray-900 dark:text-white">
          TaskHub
        </h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
          Faça login para continuar
        </p>
      </div>
      
      <form class="mt-8 space-y-6" @submit.prevent="login">
        <div class="space-y-4">
          <div>
            <Label for-id="email" :required="true">Email</Label>
            <Input
              id="email"
              v-model="form.email"
              type="email"
              placeholder="seu@email.com"
              :required="true"
              :has-error="errors.email"
            />
          </div>
          
          <div>
            <Label for-id="password" :required="true">Senha</Label>
            <Input
              id="password"
              v-model="form.password"
              type="password"
              placeholder="Sua senha"
              :has-error="errors.password"
            />
          </div>
        </div>

        <div>
          <Button
            type="submit"
            variant="primary"
            size="md"
            :full-width="true"
          >
            Entrar
          </Button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { login } from '@/api/auth';
import Button from '@/components/ui/Button.vue';
import Input from '@/components/ui/Input.vue';
import Label from '@/components/ui/Label.vue';
import formValidationMixin from '@/mixins/formValidation.js';

export default {
  name: "LoginPage",
  mixins: [formValidationMixin],
  components: {
    Button,
    Input,
    Label
  },
  data() {
    return {
      form: {
        email: "",
        password: "",
      },
      errors: {
        email: false,
        password: false,
      },
    };
  },
  methods: {
    async login() {
      this.clearErrors();
      
      try {
        const response = await login(this.form);
        const token = response.data.data.token.access_token;
        const user = response.data.data.user;

        this.$store.dispatch('login', { token: token, user: user });

        this.$router.push({ name: 'home' });
      } catch (error) {
        this.handleValidationError(error, "Erro ao fazer login. Tente novamente.");
      }
    },
  },
  watch: {
    ...formValidationMixin.methods.createFieldWatchers(['email', 'password'])
  },
};
</script>


