import Vue                 from 'vue';
import VueScrollTo         from 'vue-scrollto';

// ui
import SbCheckbox          from '@/components/global/ui/sb_checkbox';
import SbTextField         from '@/components/global/ui/sb_text_field';
import SbDadataAdress      from '@/components/global/ui/sb_dadata_address.vue';

// ui
Vue.use(VueScrollTo);
Vue.component('SbCheckbox', SbCheckbox);
Vue.component('SbTextField', SbTextField);
Vue.component('SbDadataAdress', SbDadataAdress);
// Vue.component('vue-phone-number-input', VuePhoneNumberInput);

