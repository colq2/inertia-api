<script setup>
import {Link, useForm} from '@inertiajs/vue3'
const props = defineProps(['post'])

const confirmDelete = () => {
  if (confirm('Are you sure you want to delete this post?')) {
    useForm({}).delete(`/posts/${props.post.id}`)
  }
}
</script>

<template>
<div>
  <Link class="underline" href="/posts">Back</Link>
  <h1 class="text-2xl font-bold mt-4">{{ post.title }}</h1>
  <p class="text-stone-700 mt-2">{{ post.body }}</p>

  <div class="text-sm text-stone-500 mt-4 flex ">
    Created by {{post.user.name}}
    <Link class="ml-2 underline" :href="`/posts/${post.id}/edit`">Edit</Link>
    <form @submit.prevent="confirmDelete">
      <button type="submit" class="ml-2 underline">Delete</button>
    </form>
  </div>
</div>
</template>