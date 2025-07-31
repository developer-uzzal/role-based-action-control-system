<template>
<h1>Dashboard</h1>
<div class="col-md-4 shadow p-3 rounded border-bottom border-2 border-success">
<p class="fw-bold text-success text-center">{{ $page.props.userCount }} Users</p>

</div>


</template>
<script setup>
import AdminLayout from '../Layouts/AdminLayout.vue';

defineOptions({
    layout: AdminLayout
})

</script>