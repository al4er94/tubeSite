<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { useLocale } from '@/composables/useLocale.js';

const { locale, t, setLocale } = useLocale();

const searchQuery = ref('');
const mobileMenuOpen = ref(false);
const langDropdownOpen = ref(false);

function selectLang(code) {
    setLocale(code);
    langDropdownOpen.value = false;
}

function submitSearch() {
    const q = searchQuery.value.trim();
    if (!q) return;
    router.get(`/${locale.value.currentLocale}/search`, { q });
}
</script>

<template>
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 h-16 flex items-center gap-4">

            <!-- Logo -->
            <a href="/" class="flex items-center gap-2 shrink-0">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                </div>
                <span class="text-lg font-bold text-gray-800 tracking-tight hidden sm:block">Leaked girls</span>
            </a>

            <!-- Search -->
            <div class="flex-1 mx-2 sm:mx-6 max-w-xl">
                <form class="flex gap-2" @submit.prevent="submitSearch">
                    <div class="relative flex-1">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                        </svg>
                        <input
                            v-model="searchQuery"
                            type="text"
                            :placeholder="t('search.placeholder')"
                            class="w-full pl-9 pr-4 py-2 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition"
                        />
                    </div>
                    <button
                        type="submit"
                        class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium transition shrink-0"
                    >
                        {{ t('search.button') }}
                    </button>
                </form>
            </div>

            <!-- Nav — desktop -->
            <nav class="hidden md:flex items-center gap-1 shrink-0">

                <a
                    :href="`/${locale.currentLocale}/categories`"
                    class="px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 transition"
                >
                    {{ t('nav.categories') }}
                </a>

                <a :href="`/${locale.currentLocale}/favorites`" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 transition">
                    {{ t('nav.favorites') }}
                </a>

                <a :href="`/${locale.currentLocale}/popular`" class="px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 transition">
                    {{ t('nav.popular') }}
                </a>

                <!-- Language picker -->
                <div class="relative ml-1">
                    <button
                        @click="langDropdownOpen = !langDropdownOpen"
                        class="flex items-center gap-1 px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 transition"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253"/>
                        </svg>
                        {{ locale.currentLocale.toUpperCase() }}
                        <svg class="w-3 h-3 transition-transform" :class="{ 'rotate-180': langDropdownOpen }" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div
                        v-if="langDropdownOpen"
                        class="absolute right-0 mt-1 w-32 bg-white border border-gray-100 rounded-xl shadow-lg overflow-hidden z-50"
                    >
                        <button
                            v-for="lang in locale.languages"
                            :key="lang.code"
                            @click="selectLang(lang.code)"
                            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition"
                            :class="{ 'font-semibold text-indigo-600': lang.code === locale.currentLocale }"
                        >
                            {{ lang.name }}
                        </button>
                    </div>
                </div>
            </nav>

            <!-- Burger — mobile -->
            <button
                @click="mobileMenuOpen = !mobileMenuOpen"
                class="md:hidden ml-auto p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path v-if="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    <path v-else stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Mobile menu -->
        <div v-if="mobileMenuOpen" class="md:hidden border-t border-gray-100 bg-white px-4 py-3 flex flex-col gap-1">
            <a
                :href="`/${locale.currentLocale}/categories`"
                class="px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition"
            >
                {{ t('nav.categories') }}
            </a>
            <a :href="`/${locale.currentLocale}/favorites`" class="px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
                {{ t('nav.favorites') }}
            </a>
            <a :href="`/${locale.currentLocale}/popular`" class="px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
                {{ t('nav.popular') }}
            </a>
            <div class="flex gap-2 px-3 py-2">
                <button
                    v-for="lang in locale.languages"
                    :key="lang.code"
                    @click="selectLang(lang.code)"
                    class="px-3 py-1 rounded-lg text-sm border transition"
                    :class="lang.code === locale.currentLocale
                        ? 'bg-indigo-600 text-white border-indigo-600'
                        : 'border-gray-200 text-gray-600 hover:border-indigo-400 hover:text-indigo-600'"
                >
                    {{ lang.name }}
                </button>
            </div>
        </div>
    </header>
</template>
