import Vue                               from 'vue';
import Vuex                              from 'vuex';
import './global_components';

import { global }                          from './modules/global';
import { header }                          from './header';
import { footer }                          from './footer';
import { orderingDialog }                  from './dialogs/ordering_dialog';
import { helpDialogs }                     from './dialogs/help_dialogs';
import { limitations }                     from './limitations';
import { mechanics }                       from './mechanics';
import { inBox }                           from './inBox';
import { slovnik }                         from './slovnik';
import VueTheMask                          from 'vue-the-mask';

Vue.use(Vuex);
Vue.use(VueTheMask);

const store = () =>  new Vuex.Store({
  state: {
    device: 'desktop',
    phone : '+77777777777'
  },
  mutations: {
    SET_DEVICE: (state, value) => {
      state.device = value;
    }
  },
  actions: {},
  modules: {
    global        : global(),
    header        : header(),
    footer        : footer(),
    orderingDialog: orderingDialog(),
    helpDialogs   : helpDialogs(),
    inBox         : inBox(),
    slovnik       : slovnik(),
    limitations   : limitations(),
    mechanics     : mechanics()
  }
});

export default store;
