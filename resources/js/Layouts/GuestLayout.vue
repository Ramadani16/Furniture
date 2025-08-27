<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div>
        <Link href="/">
            <ApplicationLogo class="w-20 h-20 fill-current text-gray-500" />
        </Link>
        <slot />
    </div>
</template>

