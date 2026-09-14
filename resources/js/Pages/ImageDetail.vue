<script setup>
import { Head, Link, usePage, router } from '@inertiajs/vue3';
import { ref, reactive } from 'vue';
import AppHeader from '@/Components/AppHeader.vue';
import AppFooter from '@/Components/AppFooter.vue';
import { useLocale } from '@/composables/useLocale.js';
import { useCardClick } from '@/composables/useCardClick.js';

const props = defineProps({
    image: Object,
    meta: Object,
});

const { handleCardClick } = useCardClick([props.image]);

const { t } = useLocale();
const page = usePage();

function backUrl() {
    return `/${page.props.locale}`;
}

const likes = ref(props.image.likes);
const liked = ref(props.image.liked);
const likeLoading = ref(false);

function toggleLike() {
    if (likeLoading.value) return;
    likeLoading.value = true;

    const url = `/${page.props.locale}/video/${props.image.slug}/like`;
    router.post(url, {}, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: (page) => {
            likes.value = page.props.image?.likes ?? likes.value;
            liked.value = page.props.image?.liked ?? liked.value;
        },
        onFinish: () => {
            likeLoading.value = false;
        },
    });
}

const similar = props.image.similar ?? [];
const similarLikesMap = reactive(Object.fromEntries(similar.map(img => [img.slug, img.likes])));
const similarLikedMap = reactive(Object.fromEntries(similar.map(img => [img.slug, img.liked ?? false])));
const similarLoadingMap = reactive(Object.fromEntries(similar.map(img => [img.slug, false])));

function toggleSimilarLike(event, item) {
    event.preventDefault();
    if (similarLoadingMap[item.slug]) return;
    similarLoadingMap[item.slug] = true;

    const wasLiked = similarLikedMap[item.slug];
    similarLikedMap[item.slug] = !wasLiked;
    similarLikesMap[item.slug] += wasLiked ? -1 : 1;

    router.post(`/${page.props.locale}/video/${item.slug}/like`, {}, {
        preserveScroll: true,
        preserveState: true,
        onError: () => {
            similarLikedMap[item.slug] = wasLiked;
            similarLikesMap[item.slug] += wasLiked ? 1 : -1;
        },
        onFinish: () => {
            similarLoadingMap[item.slug] = false;
        },
    });
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

                <!-- Main layout: image col + promo col -->
                <div class="flex gap-4 items-start">

                    <!-- Image column -->
                    <div class="flex-1 min-w-0">

                        <!-- Ad banners -->
                        <div class="mb-4">
                            <!-- Mobile banner (visible on small screens only) -->
                            <div class="block sm:hidden bg-gray-100 border border-gray-200 rounded flex items-center justify-center text-gray-400 text-sm w-full" style="height:50px;">
                                320×50
                            </div>
                            <!-- Desktop leaderboard banner (hidden on small screens) -->
                            <div class="hidden sm:flex flex-wrap gap-2 justify-center">
                                <div class="bg-gray-100 border border-gray-200 rounded flex items-center justify-center text-gray-400 text-sm" style="width:320px;height:50px;">
                                    320×50
                                </div>
                                <div class="bg-gray-100 border border-gray-200 rounded flex items-center justify-center text-gray-400 text-sm" style="width:320px;height:50px;">
                                    320×50
                                </div>
                            </div>
                        </div>

                        <!-- Image with overlay -->
                        <div
                            class="relative bg-black rounded overflow-hidden cursor-pointer"
                            @click="handleCardClick($event, image, `/${page.props.locale}/video/${image.slug}/video`)"
                        >
                            <img
                                :src="image.src"
                                :alt="image.caption"
                                class="w-full object-contain max-h-[480px]"
                            />
                            <!-- Play button -->
                            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                <div class="w-16 h-16 rounded-full bg-black/50 flex items-center justify-center">
                                    <svg class="w-7 h-7 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Info block below image -->
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
                                    <!-- Eye icon -->
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                    <span class="text-gray-700 ml-1">{{ image.views }}</span>
                                </li>
                                <li class="flex items-center gap-1">
                                    <!-- Heart icon -->
                                    <button
                                        type="button"
                                        class="flex items-center gap-1 transition-colors duration-200 cursor-pointer"
                                        :class="liked ? 'text-rose-500' : 'text-gray-500 hover:text-rose-500'"
                                        :disabled="likeLoading"
                                        @click.prevent="toggleLike"
                                    >
                                        <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            :fill="liked ? 'currentColor' : 'none'"
                                            stroke="currentColor"
                                        >
                                            <path d="M12 21C12 21 3 14.5 3 8.5a5 5 0 0 1 9-3 5 5 0 0 1 9 3c0 6-9 12.5-9 12.5z"/>
                                        </svg>
                                        {{ likes }}
                                    </button>
                                </li>
                                <li v-if="image.created_at" class="flex items-center gap-1">
                                    <!-- Calendar icon -->
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
                            <!-- Mobile banner (visible on small screens only) -->
                            <div class="block sm:hidden bg-gray-100 border border-gray-200 rounded flex items-center justify-center text-gray-400 text-sm w-full" style="height:50px;">
                                320×50
                            </div>
                            <!-- Desktop leaderboard banner (hidden on small screens) -->
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

                        <!-- Similar images -->
                        <div v-if="similar.length" class="mt-4">
                            <h2 class="text-base font-semibold text-gray-800 mb-3">{{ t('gallery.similar') }}</h2>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                <a
                                    v-for="item in similar"
                                    :key="item.slug"
                                    :href="`/${page.props.locale}/video/${item.slug}`"
                                    class="block"
                                >
                                    <figure class="group overflow-hidden rounded-2xl shadow-md bg-white hover:shadow-xl transition-shadow duration-300 cursor-pointer">
                                        <div class="overflow-hidden">
                                            <img
                                                :src="item.src"
                                                :alt="item.caption"
                                                class="w-full h-36 object-cover group-hover:scale-105 transition-transform duration-500"
                                                loading="lazy"
                                            />
                                        </div>
                                        <figcaption class="px-3 py-2 text-xs">
                                            <span class="block text-gray-700 font-medium text-center truncate">{{ item.caption }}</span>
                                        </figcaption>
                                    </figure>
                                </a>
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
