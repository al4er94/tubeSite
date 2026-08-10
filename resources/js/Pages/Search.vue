<script setup>
import { computed, reactive } from 'vue';
import { Head, usePage, router } from '@inertiajs/vue3';
import AppHeader from '@/Components/AppHeader.vue';
import AppFooter from '@/Components/AppFooter.vue';
import { useLocale } from '@/composables/useLocale.js';

const props = defineProps({
    query: String,
    images: Object,
    categories: Array,
    meta: Object,
});

const { t } = useLocale();
const page = usePage();

function imageUrl(slug) {
    return `/${page.props.locale}/video/${slug}`;
}

function categoryUrl(slug) {
    return `/${page.props.locale}/category/${slug}`;
}

const hasImages = computed(() => props.images?.data?.length > 0);
const hasCategories = computed(() => props.categories?.length > 0);
const hasResults = computed(() => hasImages.value || hasCategories.value);

const likesMap = reactive(Object.fromEntries((props.images?.data ?? []).map(img => [img.slug, img.likes])));
const likedMap = reactive(Object.fromEntries((props.images?.data ?? []).map(img => [img.slug, img.liked ?? false])));
const loadingMap = reactive(Object.fromEntries((props.images?.data ?? []).map(img => [img.slug, false])));

function toggleLike(event, image) {
    event.preventDefault();
    if (loadingMap[image.slug]) return;
    loadingMap[image.slug] = true;

    const wasLiked = likedMap[image.slug];
    likedMap[image.slug] = !wasLiked;
    likesMap[image.slug] += wasLiked ? -1 : 1;

    router.post(`/${page.props.locale}/video/${image.slug}/like`, {}, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: (pg) => {
            const updated = pg.props.images?.data?.find(img => img.slug === image.slug);
            if (updated) {
                likesMap[image.slug] = updated.likes;
                likedMap[image.slug] = updated.liked ?? likedMap[image.slug];
            }
        },
        onError: () => {
            likedMap[image.slug] = wasLiked;
            likesMap[image.slug] += wasLiked ? 1 : -1;
        },
        onFinish: () => {
            loadingMap[image.slug] = false;
        },
    });
}
</script>

<template>
    <Head>
        <title>{{ meta.title }}</title>
        <meta name="description" :content="meta.description" />
    </Head>

    <div class="min-h-screen bg-gray-50 flex flex-col">
        <AppHeader />

        <div class="py-12 px-4 max-w-6xl mx-auto">

            <!-- Empty query -->
            <template v-if="!query">
                <p class="text-center text-gray-500 text-lg mt-20">{{ t('search.empty_query') }}</p>
            </template>

            <template v-else-if="!hasResults">
                <p class="text-center text-gray-500 text-lg mt-20">
                    {{ t('search.no_results') }} <span class="font-semibold text-gray-700">«{{ query }}»</span>
                </p>
            </template>

            <template v-else>

                <!-- Images section -->
                <section v-if="hasImages">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ t('search.results_images') }}</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-2">
                        <a
                            v-for="image in images.data"
                            :key="image.slug"
                            :href="imageUrl(image.slug)"
                            class="block"
                        >
                            <figure class="group overflow-hidden rounded-2xl shadow-md bg-white hover:shadow-xl transition-shadow duration-300 cursor-pointer">
                                <div class="overflow-hidden">
                                    <img
                                        :src="image.src"
                                        :alt="image.caption"
                                        class="w-full h-56 object-cover group-hover:scale-105 transition-transform duration-500"
                                        loading="lazy"
                                    />
                                </div>
                                <figcaption class="px-4 py-3 flex items-center gap-2 text-sm">
                                    <span class="flex items-center gap-1 text-gray-500 shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <ellipse cx="12" cy="12" rx="10" ry="6" />
                                            <circle cx="12" cy="12" r="2.5" fill="currentColor" stroke="none" />
                                        </svg>
                                        {{ image.views }}
                                    </span>
                                    <span class="flex-1 text-gray-700 font-medium text-center truncate">{{ image.caption }}</span>
                                    <button
                                        type="button"
                                        class="flex items-center gap-1 shrink-0 transition-colors duration-200 cursor-pointer"
                                        :class="likedMap[image.slug] ? 'text-rose-500' : 'text-gray-500 hover:text-rose-400'"
                                        :disabled="loadingMap[image.slug]"
                                        @click.stop.prevent="toggleLike($event, image)"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                            :fill="likedMap[image.slug] ? 'currentColor' : 'none'"
                                            :stroke="'currentColor'"
                                        >
                                            <path d="M12 21C12 21 3 14.5 3 8.5a5 5 0 0 1 9-3 5 5 0 0 1 9 3c0 6-9 12.5-9 12.5z"/>
                                        </svg>
                                        {{ likesMap[image.slug] }}
                                    </button>
                                </figcaption>
                            </figure>
                        </a>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-10 flex items-center justify-center gap-1">
                        <template v-for="link in images.links" :key="link.label">
                            <a
                                v-if="link.url"
                                :href="link.url"
                                class="px-3 py-2 rounded-lg text-sm font-medium transition"
                                :class="link.active
                                    ? 'bg-indigo-600 text-white'
                                    : 'text-gray-600 hover:bg-indigo-50 hover:text-indigo-600'"
                                v-html="link.label"
                            />
                            <span
                                v-else
                                class="px-3 py-2 rounded-lg text-sm font-medium text-gray-300"
                                v-html="link.label"
                            />
                        </template>
                    </div>
                </section>

                <!-- Categories section -->
                <section v-if="hasCategories" class="mt-12">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ t('search.results_categories') }}</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-6">
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
                </section>

            </template>
        </div>

        <AppFooter />
    </div>
</template>
