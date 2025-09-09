export default {
  data() {
    return {
      errors: {}
    }
  },
  methods: {

    clearErrors() {
      const clearedErrors = {};
      Object.keys(this.errors).forEach(key => {
        clearedErrors[key] = false;
      });
      this.errors = clearedErrors;
    },

    applyValidationErrors(validationErrors) {
      Object.keys(validationErrors).forEach(field => {
        if (Object.prototype.hasOwnProperty.call(this.errors, field)) {
          this.errors[field] = true;
        }
      });
    },

    handleValidationError(error, defaultMessage = 'Erro ao processar solicitação. Tente novamente.') {
      if (error.response?.data?.errors) {
        this.applyValidationErrors(error.response.data.errors);
        
        if (error.response?.data?.message) {
          this.$toast.error(error.response.data.message);
        }
      } else if (error.response?.data?.message) {
        this.$toast.error(error.response.data.message);
      } else {
        this.$toast.error(defaultMessage);
      }
    },

    createFieldWatchers(fields) {
      const watchers = {};
      
      fields.forEach(field => {
        watchers[`form.${field}`] = function() {
          if (this.errors[field]) {
            this.errors[field] = false;
          }
        };
      });
      
      return watchers;
    }
  }
}
