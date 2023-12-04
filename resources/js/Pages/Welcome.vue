<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  laravelVersion: String,
  phpVersion: String,
  canResetPassword: Boolean,
  status: String,
});

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.transform(data => ({
    ...data,
    remember: form.remember ? 'on' : '',
  })).post(route('login'), {
    onFinish: () => form.reset('password'),
  });
};
</script>

<template>
  <Head title="Welcome" />

  <div class="logo">
    <img class="image-2" src="/image-2.png" />
    <div>
      <h1 style="
              font-family: Verdana, sans-serif;
              font-weight: bold;
              font-size: 44px;
              margin-top: 10px;
              ">One Baguio</h1>
      <div style="border-top: 1px solid black;"></div>
      <h2 style="
              font-family: Verdana, sans-serif;
              font-size: 20px;
              text-align: left;
              ">Electronic Healthcare Record System</h2>
    </div>
  </div>

  <div class="login-page">

    <div class="form">
      <div>
        <form @submit.prevent="submit">
          <div>
            <InputLabel for="email" value="Email" />
            <TextInput id="email" v-model="form.email" type="email" class="mt-1 block w-full" required autofocus />
            <InputError class="mt-2" :message="form.errors.email" />
          </div>

          <div class="mt-4">
            <InputLabel for="password" value="Password" />
            <TextInput id="password" v-model="form.password" type="password" class="mt-1 block w-full" required
              autocomplete="current-password" />
            <InputError class="mt-2" :message="form.errors.password" />
          </div>

          <div class="block mt-4">
            <label class="flex items-center">
              <Checkbox v-model:checked="form.remember" name="remember" />
              <span class="ml-2 text-sm text-#4f4f4f">Remember me</span>
            </label>
          </div>
          <div class="block mt-4">
            <Link :href="route('password.request')" style="margin-top: 20px;"
                class="underline text-sm text-gray-600 hover:text-gray-900">
              Forgot your password?
              </Link>
          </div>

          <div style="margin-top: 8px;">
            <Link
              class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150"
              :href="route('register')">
            Register
            </Link>

            <PrimaryButton class="ml-4" style="margin-right: 20px;" :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing">
              Log in
            </PrimaryButton>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<style>
.login-page {
  display: flex;
  width: 360px;
  /* padding: 8% 0 0; */
  margin: auto;
}

.form {
  display: flex;
  background: rgb(7, 157, 64);
  position: relative;
  z-index: 1;
  max-width: 360px;
  margin: 0 auto 100px;
  padding: 45px;
  text-align: center;
  box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
}

.logo {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 8% 0 0;
  margin-bottom: 30px;
}

.image-2 {
  width: 121px;
  height: 103px;
  left: 881px;
  top: 239px;
}

.container {
  position: relative;
  z-index: 1;
  max-width: 300px;
  margin: 0 auto;
}

.container:before,
.container:after {
  content: "";
  display: block;
  clear: both;
}

.container .info {
  margin: 50px auto;
  text-align: center;
}

.container .info h1 {
  margin: 0 0 15px;
  padding: 0;
  font-size: 36px;
  font-weight: 300;
  color: #1a1a1a;
}

.container .info span {
  color: #4d4d4d;
  font-size: 12px;
}

.container .info span a {
  color: #000000;
  text-decoration: none;
}

.container .info span .fa {
  color: #EF3B3A;
}

body {

  font-family: "Roboto", sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}</style>
