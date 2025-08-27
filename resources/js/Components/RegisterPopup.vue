<template>
  <transition name="modal-fade">
    <div class="fixed inset-0 bg-black/30 backdrop-blur-sm flex items-center justify-center z-50 p-4">
      <transition name="modal-scale" appear>
        <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl w-full max-w-md border border-gray-100 dark:border-gray-700">
          
          <!-- Header -->
          <div class="flex justify-between items-start mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Welcome</h2>
            <button @click="$emit('close')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>

          <!-- Google Login -->
          <div class="mb-4">
            <button 
              @click.prevent="$emit('login-with-google')" 
              class="w-full flex items-center justify-center gap-3 px-6 py-3 rounded-lg border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-200 font-medium bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition"
            >
              <img src="/images/google.png" alt="Google" class="h-5 w-5" />
              Login with Google
            </button>
          </div>

          <!-- Divider -->
          <div class="flex items-center my-4">
            <div class="flex-1 border-t border-gray-200 dark:border-gray-600"></div>
            <span class="px-3 text-sm text-gray-500 dark:text-gray-400">or</span>
            <div class="flex-1 border-t border-gray-200 dark:border-gray-600"></div>
          </div>

          <!-- Email & Register -->
          <div class="space-y-4">
            <!-- Email Login -->
            <a 
              :href="route('login')" 
              class="flex items-center justify-center gap-2 px-6 py-3 rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium hover:shadow-lg transition-all hover:scale-[1.02]"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
              </svg>
              Login with Email
            </a>

            <!-- Register -->
            <a 
              :href="route('register')" 
              class="flex items-center justify-center gap-2 px-6 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6z" />
                <path fill-rule="evenodd" d="M15 7a3 3 0 11-6 0 3 3 0 016 0zm3 3a6 6 0 11-12 0 6 6 0 0112 0z" clip-rule="evenodd" />
              </svg>
              Create New Account
            </a>
          </div>

          <!-- Terms -->
          <div class="mt-6 pt-6 border-t border-gray-100 dark:border-gray-700">
            <p class="text-center text-sm text-gray-500 dark:text-gray-400">
              By continuing, you agree to our 
              <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">Terms</a> and 
              <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">Privacy Policy</a>.
            </p>
          </div>

        </div>
      </transition>
    </div>
  </transition>
</template>

<script>
export default {
  emits: ['close', 'login-with-google']
}
</script>

<style scoped>
.modal-fade-enter-active,
.modal-fade-leave-active {
  transition: opacity 0.3s ease;
}

.modal-fade-enter-from,
.modal-fade-leave-to {
  opacity: 0;
}

.modal-scale-enter-active,
.modal-scale-leave-active {
  transition: all 0.3s ease;
}

.modal-scale-enter-from,
.modal-scale-leave-to {
  opacity: 0;
  transform: scale(0.95);
}

.img {
  mix-blend-mode: multiply;
  height: 1.25rem; /* sama dengan h-5 */
  width: 1.25rem;  /* sama dengan w-5 */
}

</style>
