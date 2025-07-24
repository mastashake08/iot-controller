<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];
const { props } = usePage();
console.log('Dashboard props:', props);
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <!-- Balance Card -->
            <div class="mb-4 flex items-center gap-4">
                <div class="rounded-xl border border-sidebar-border/70 bg-white p-6 shadow dark:bg-neutral-900 dark:border-sidebar-border">
                    <div class="text-sm text-muted-foreground">Your Balance</div>
                    <div class="text-2xl font-bold text-foreground mt-1">
                        {{ props.balance ?? '0.00' }}
                    </div>
                    <a href="/checkout" class="mt-2 inline-block text-sm text-blue-600 hover:underline">
                        Top Up Balance
                    </a>
                </div>
            </div>
            <!-- Existing dashboard content -->
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
            </div>
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <PlaceholderPattern />
            </div>
        </div>
    </AppLayout>
</template>
