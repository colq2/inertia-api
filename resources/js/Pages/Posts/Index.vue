<script setup>
import {Link} from '@inertiajs/vue3'
const props = defineProps(['posts'])
</script>

<template>
<div>
  <h1 class="text-2xl font-semibold">Posts</h1>
  <p v-if="!props.posts.data.length">No posts found.</p>
  <ul class="list-disc pl-6 mt-4">
    <li v-for="post in props.posts.data" :key="post.id">
      <Link class="underline" :href="`/posts/${post.id}`">{{ post.title }}</Link> by {{ post.user.name }}
    </li>
  </ul>
</div>
</template>