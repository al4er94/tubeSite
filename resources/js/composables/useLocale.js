import { computed } from 'vue';
import { usePage, router } from '@inertiajs/vue3';

export function useLocale() {
    const page = usePage();

    const locale = computed(() => ({
        currentLocale: page.props.locale,
        languages: page.props.languages,
    }));

    function t(key) {
        return page.props.translations[key] ?? key;
    }

    function setLocale(code) {
        router.visit('/' + code);
    }

    return {
        locale,
        t,
        setLocale,
    };
}
