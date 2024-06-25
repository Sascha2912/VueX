import {createI18n} from 'vue-i18n'
import store from './store';

const i18n = createI18n({
                            legacy: false,
                            locale     : store.state.constants.locale || 'en',
                            fallbackLng: 'en',
                            messages   : {
                                en: {},
                                de: {},
                            },
                        });

store.watch(
    (state) => state.constants,
    (constants) => {
        i18n.global.locale.value = constants.locale;
        i18n.global.setLocaleMessage(constants.locale, constants.lang);
    }
)

export default i18n;
