<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import AppHeader from '@/Components/AppHeader.vue';
import AppFooter from '@/Components/AppFooter.vue';
import { useLocale } from '@/composables/useLocale.js';

const props = defineProps({
    appName: String,
    categories: Array,
    meta: Object,
});

const { t } = useLocale();
const page = usePage();

function categoryUrl(slug) {
    return `/${page.props.locale}/category/${slug}`;
}
</script>

<template>
    <Head>
        <title>{{ meta.title }}</title>
        <meta name="description" :content="meta.description" />
        <meta property="og:title" :content="meta.title" />
        <meta property="og:description" :content="meta.description" />
        <meta property="og:type" content="website" />
    </Head>

    <div class="min-h-screen bg-gray-50 flex flex-col">
        <AppHeader />

        <div class="py-12 px-4">
            <h1 class="text-4xl font-bold text-center text-gray-800 mb-2">{{ t('nav.categories') }}</h1>
            <p class="text-center text-gray-500 mb-10 text-lg">{{ t('gallery.subtitle') }}</p>

            <div class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-6">
                <a
                    v-for="category in categories"
                    :key="category.slug"
                    :href="categoryUrl(category.slug)"
                    class="block"
                >
                    <figure class="group overflow-hidden rounded-2xl shadow-md bg-white hover:shadow-xl transition-shadow duration-300 cursor-pointer">
                        <div class="overflow-hidden">
                            <img
                                :src="category.image"
                                :alt="category.title"
                                class="w-full h-56 object-cover group-hover:scale-105 transition-transform duration-500"
                                loading="lazy"
                            />
                        </div>
                        <figcaption class="px-4 py-3 text-center">
                            <span class="text-gray-700 font-medium">{{ category.title }}</span>
                        </figcaption>
                    </figure>
                </a>
            </div>
        </div>

        <AppFooter />
    </div>
</template>
