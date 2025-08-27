<template>
  <div class="login-container">
    <div class="login-card">
      <div class="login-header">
        <div class="logo">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11V11.99z"/>
          </svg>
        </div>
        <h2>Admin Portal</h2>
        <p>Please sign in to continue</p>
      </div>

      <form @submit.prevent="login" class="login-form">
        <div class="form-group">
          <label for="email">Email Address</label>
          <div class="input-with-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
              <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
            </svg>
            <input 
              v-model="email" 
              id="email" 
              type="email" 
              placeholder="admin@example.com" 
              required
              :class="{ 'input-error': error }"
            >
          </div>
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <div class="input-with-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
              <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
            </svg>
            <input 
              v-model="password" 
              id="password" 
              type="password" 
              placeholder="••••••••" 
              required
              :class="{ 'input-error': error }"
            >
          </div>
        </div>

        <div v-if="error" class="error-message">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
          </svg>
          <span>{{ error }}</span>
        </div>

        <button type="submit" class="login-button" :disabled="isLoading">
          <span v-if="!isLoading">Sign In</span>
          <span v-else class="loading-spinner"></span>
        </button>
      </form>

      <div class="login-footer">
        <a href="#" class="forgot-password">Forgot password?</a>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
axios.defaults.withCredentials = true;

export default {
  data() {
    return {
      email: '',
      password: '',
      error: '',
      isLoading: false
    };
  },
  methods: {
    async login() {
      this.isLoading = true;
      this.error = '';
      
      try {
        await axios.get('/sanctum/csrf-cookie');
        const res = await axios.post('/admin/login', {
          email: this.email,
          password: this.password
        });

        if (res.status === 200) {
          this.$inertia.visit('/admin/dashboard');
        } else {
          this.error = res.data.message || 'Login failed. Please try again.';
        }
      } catch (err) {
        this.error = err.response?.data?.message || 
                   'Invalid credentials or server error. Please try again.';
      } finally {
        this.isLoading = false;
      }
    }
  }
}
</script>

<style scoped>
.login-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-color: #f8fafc;
  background-image: radial-gradient(circle at 10% 20%, rgba(237, 242, 253, 0.8) 0%, rgba(255, 255, 255, 1) 90%);
  padding: 20px;
}

.login-card {
  background: white;
  border-radius: 12px;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
  padding: 25px;
  width: 100%;
  max-width: 400px;
  transition: transform 0.3s ease;
}

.login-card:hover {
  transform: translateY(-2px);
}

.login-header {
  text-align: center;
  margin-bottom: 32px;
}

.logo {
  width: 60px;
  height: 60px;
  margin: 0 auto 16px;
  background-color: #4f46e5;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
}

.logo svg {
  width: 30px;
  height: 30px;
}

.login-header h2 {
  font-size: 24px;
  font-weight: 600;
  color: #1e293b;
  margin-bottom: 8px;
}

.login-header p {
  color: #64748b;
  font-size: 14px;
}

.login-form {
  margin-bottom: 24px;
}

.form-group {
  margin-bottom: 20px;
}

.form-group label {
  display: block;
  font-size: 14px;
  color: #475569;
  margin-bottom: 8px;
  font-weight: 500;
}

.input-with-icon {
  position: relative;
}

.input-with-icon svg {
  position: absolute;
  left: 12px;
  top: 50%;
  transform: translateY(-50%);
  width: 18px;
  height: 18px;
  color: #94a3b8;
}

.input-with-icon input {
  width: 100%;
  padding: 12px 12px 12px 40px;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  font-size: 14px;
  transition: all 0.2s ease;
  background-color: #f8fafc;
}

.input-with-icon input:focus {
  outline: none;
  border-color: #4f46e5;
  box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
  background-color: white;
}

.input-with-icon input.input-error {
  border-color: #ef4444;
}

.input-with-icon input.input-error:focus {
  box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
}

.error-message {
  display: flex;
  align-items: center;
  padding: 12px;
  background-color: #fef2f2;
  color: #dc2626;
  border-radius: 6px;
  font-size: 14px;
  margin-bottom: 20px;
}

.error-message svg {
  width: 18px;
  height: 18px;
  margin-right: 8px;
}

.login-button {
  width: 100%;
  padding: 14px;
  background-color: #4f46e5;
  color: white;
  border: none;
  border-radius: 8px;
  font-size: 16px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s ease;
}

.login-button:hover {
  background-color: #4338ca;
}

.login-button:disabled {
  background-color: #a5b4fc;
  cursor: not-allowed;
}

.loading-spinner {
  display: inline-block;
  width: 20px;
  height: 20px;
  border: 3px solid rgba(255, 255, 255, 0.3);
  border-radius: 50%;
  border-top-color: white;
  animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

.login-footer {
  text-align: center;
  font-size: 14px;
}

.forgot-password {
  color: #4f46e5;
  text-decoration: none;
  font-weight: 500;
  transition: color 0.2s ease;
}

.forgot-password:hover {
  color: #4338ca;
  text-decoration: underline;
}

@media (max-width: 480px) {
  .login-card {
    padding: 30px 20px;
  }
}
</style>