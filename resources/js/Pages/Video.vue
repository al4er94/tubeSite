<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import AppHeader from '@/Components/AppHeader.vue';
import AppFooter from '@/Components/AppFooter.vue';
import { useLocale } from '@/composables/useLocale.js';

const props = defineProps({
    image: Object,
    meta: Object,
});

const { t } = useLocale();
const page = usePage();

function backUrl() {
    return `/${page.props.locale}/video/${props.image.slug}`;
}
</script>

<template>
    <Head>
        <title>{{ meta.title }}</title>
        <meta name="description" :content="meta.description" />
        <meta property="og:title" :content="meta.title" />
        <meta property="og:description" :content="meta.description" />
        <meta property="og:type" content="website" />
        <meta property="og:image" :content="image.src" />
    </Head>

    <div class="min-h-screen bg-gray-50 text-gray-900 flex flex-col">

        <AppHeader />

        <div class="py-8 px-4">
            <div class="max-w-5xl mx-auto">

                <!-- Back link -->
                <Link
                    :href="backUrl()"
                    class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-900 mb-6 transition"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                    </svg>
                    {{ t('gallery.back') }}
                </Link>

                <!-- Title -->
                <h1 class="text-xl font-bold text-gray-900 mb-4 leading-snug">{{ image.caption }}</h1>

                <!-- Main layout: video col + promo col -->
                <div class="flex gap-4 items-start">

                    <!-- Video column -->
                    <div class="flex-1 min-w-0">

                        <!-- Ad banners -->
                        <div class="mb-4">
                            <div class="block sm:hidden bg-gray-100 border border-gray-200 rounded flex items-center justify-center text-gray-400 text-sm w-full" style="height:50px;">
                                320×50
                            </div>
                            <div class="hidden sm:flex flex-wrap gap-2 justify-center">
                                <div class="bg-gray-100 border border-gray-200 rounded flex items-center justify-center text-gray-400 text-sm" style="width:320px;height:50px;">
                                    320×50
                                </div>
                                <div class="bg-gray-100 border border-gray-200 rounded flex items-center justify-center text-gray-400 text-sm" style="width:320px;height:50px;">
                                    320×50
                                </div>
                            </div>
                        </div>

                        <!-- Video player placeholder -->
                        <div class="relative bg-black rounded overflow-hidden flex items-center justify-center" style="min-height:360px;">
                            <img
                                :src="image.src"
                                :alt="image.caption"
                                class="w-full object-contain max-h-[480px] opacity-60"
                            />
                        </div>

                        <!-- Info block below video -->
                        <div class="bg-white border border-gray-200 rounded mt-1 px-4 py-3 flex flex-col gap-3">

                            <!-- Tags (categories) -->
                            <ul class="flex flex-wrap gap-2">
                                <li v-for="category in image.categories" :key="category.slug">
                                    <Link
                                        :href="`/${page.props.locale}/category/${category.slug}`"
                                        class="inline-flex items-center gap-1 text-sm text-orange-400 hover:text-orange-300 transition"
                                    >
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4.5 2A2.5 2.5 0 0 0 2 4.5v3.379a2.5 2.5 0 0 0 .732 1.767l7.122 7.122a2.5 2.5 0 0 0 3.536 0l3.379-3.379a2.5 2.5 0 0 0 0-3.536L9.647 2.732A2.5 2.5 0 0 0 7.879 2H4.5zM5.5 6a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                                        </svg>
                                        {{ category.title }}
                                    </Link>
                                </li>
                            </ul>

                            <!-- Stats -->
                            <ul class="flex flex-wrap gap-4 text-sm text-gray-500">
                                <li class="flex items-center gap-1">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                    <span class="text-gray-700 ml-1">{{ image.views }}</span>
                                </li>
                                <li class="flex items-center gap-1">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M12 21C12 21 3 14.5 3 8.5a5 5 0 0 1 9-3 5 5 0 0 1 9 3c0 6-9 12.5-9 12.5z" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span class="text-gray-700 ml-1">{{ image.likes }}</span>
                                </li>
                                <li v-if="image.created_at" class="flex items-center gap-1">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                                        <path d="M16 2v4M8 2v4M3 10h18"/>
                                    </svg>
                                    <span class="text-gray-700 ml-1">{{ image.created_at }}</span>
                                </li>
                            </ul>

                            <!-- Description -->
                            <p v-if="image.description" class="text-sm text-gray-600 leading-relaxed">
                                {{ image.description }}
                            </p>

                            <!-- Keywords -->
                            <ul v-if="image.keywords && image.keywords.length" class="flex flex-wrap gap-2">
                                <li v-for="keyword in image.keywords" :key="keyword">
                                    <span class="inline-flex items-center gap-1 text-sm text-gray-500">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4.5 2A2.5 2.5 0 0 0 2 4.5v3.379a2.5 2.5 0 0 0 .732 1.767l7.122 7.122a2.5 2.5 0 0 0 3.536 0l3.379-3.379a2.5 2.5 0 0 0 0-3.536L9.647 2.732A2.5 2.5 0 0 0 7.879 2H4.5zM5.5 6a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                                        </svg>
                                        {{ keyword }}
                                    </span>
                                </li>
                            </ul>

                        </div>

                        <!-- Ad banners -->
                        <div class="mt-4">
                            <div class="block sm:hidden bg-gray-100 border border-gray-200 rounded flex items-center justify-center text-gray-400 text-sm w-full" style="height:50px;">
                                320×50
                            </div>
                            <div class="hidden sm:flex flex-wrap gap-2 justify-center">
                                <div class="bg-gray-100 border border-gray-200 rounded flex items-center justify-center text-gray-400 text-sm" style="width:320px;height:50px;">
                                    320×50
                                </div>
                                <div class="bg-gray-100 border border-gray-200 rounded flex items-center justify-center text-gray-400 text-sm" style="width:320px;height:50px;">
                                    320×50
                                </div>
                                <div class="bg-gray-100 border border-gray-200 rounded flex items-center justify-center text-gray-400 text-sm" style="width:320px;height:50px;">
                                    320×50
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Promo sidebar -->
                    <div class="flex flex-col gap-3 shrink-0 w-[300px] hidden lg:flex">
                        <div class="bg-gray-100 border border-gray-200 rounded flex items-center justify-center text-gray-400 text-sm" style="width:300px;height:250px;">
                            300×250
                        </div>
                        <div class="bg-gray-100 border border-gray-200 rounded flex items-center justify-center text-gray-400 text-sm" style="width:300px;height:250px;">
                            300×250
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <AppFooter />
    </div>
</template>
