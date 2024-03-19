<script setup>
import {useForm} from "@inertiajs/vue3";

const props = defineProps(['post'])

const form = useForm({
  title: props.post.title,
  body: props.post.body,
})
</script>

<template>
<form @submit.prevent="form.put(`/posts/${props.post.id}`)">
  <h1 class="text-2xl font-semibold mb-4">Edit Post</h1>

  <input v-model="form.title" type="text" placeholder="Title" class="border p-2 mb-4 w-full">

  <textarea v-model="form.body" rows="10" placeholder="Body" class="border p-2 mb-4 w-full"></textarea>

  <button type="submit" class="bg-indigo-500 rounded text-white p-2">Submit</button>
</form>
</template>