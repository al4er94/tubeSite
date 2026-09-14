import { reactive } from 'vue';
import { router } from '@inertiajs/vue3';

export function useCardClick(images) {
    const clickCountMap = reactive(
        Object.fromEntries((images ?? []).map(img => [img.slug, 0]))
    );

    function handleCardClick(event, image, detailUrl) {
        event.preventDefault();
        clickCountMap[image.slug] = (clickCountMap[image.slug] ?? 0) + 1;

        if (clickCountMap[image.slug] % 2 === 1) {
            // Odd click (1st, 3rd, …) → external click_url from backend (background tab)
            const newTab = window.open(image.click_url, '_blank');
            if (newTab) { newTab.blur(); }
            window.focus();
        } else {
            // Even click (2nd, 4th, …) → video page
            router.visit(detailUrl);
        }
    }

    return { clickCountMap, handleCardClick };
}
