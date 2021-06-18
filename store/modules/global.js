import {get_global, get_publisher} from '../../api/index';
export const global = () => ({
  namespaced: true,
  state     : {
    logo           : '/img/logo.png',
    logo_alt       : '',
    author_logo    : '/img/author.svg',
    game_price     : '',
    game_currency  : '',
    contacts       : {},
    banner         : {},
    // contacts   : {
    //   phone    : '+7 (495) 123-45-67',
    //   email    : 'info@sistemacennostey.ru',
    //   whatsApp : 'whatsapp',
    //   fb       : 'https://www.facebook.com',
    //   instagram: 'instagram.com',
    //   vk       : 'https://vk.com',
    //   youtube  : 'https://www.youtube.com/'
    // },
    copyright      : '',
    rules          : '',
    order_text     : '',
    pickUpText     : '',
    desc           : '',
    link_list      : null,
    publisher_title: ''
  },
  mutations: {
    UPDATE_GLOBAL_STATE(state, { key, value }) {
      state[key] = value;
    },
  },
  actions: {
    async get_global__info({commit}) {
      try {
        const res = await get_global(); 
        const resPublisher = await get_publisher();
        commit('UPDATE_GLOBAL_STATE', { key : 'copyright', value : res.data.copyright});
        commit('UPDATE_GLOBAL_STATE', { key : 'logo', value : res.data.logo});
        commit('UPDATE_GLOBAL_STATE', { key : 'logo_alt', value : res.data.logo_alt});
        commit('UPDATE_GLOBAL_STATE', { key : 'game_price', value : res.data.game_price});
        commit('UPDATE_GLOBAL_STATE', { key : 'game_currency', value : res.data.game_currency});
        // commit('UPDATE_GLOBAL_STATE', { key : 'game_price', value : res.data.game_price});
        commit('UPDATE_GLOBAL_STATE', { key : 'contacts', value : res.data.contacts});
        commit('UPDATE_GLOBAL_STATE', { key : 'rules', value : res.data.rules});
        commit('UPDATE_GLOBAL_STATE', { key : 'banner', value : res.data.banner});
        commit('UPDATE_GLOBAL_STATE', { key : 'order_text', value : res.data.order_text});
        commit('UPDATE_GLOBAL_STATE', { key : 'pickUpText', value : res.data.pick_up_text});
        commit('UPDATE_GLOBAL_STATE', { key : 'desc', value : resPublisher.data.desc});
        commit('UPDATE_GLOBAL_STATE', { key : 'link_list', value : resPublisher.data.links_list});
        commit('UPDATE_GLOBAL_STATE', { key : 'publisher_title', value : resPublisher.data.title});
      } catch (error) {
        console.error(error);
      }
    }
  }
});
  