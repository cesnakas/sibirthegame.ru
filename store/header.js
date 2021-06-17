export const header = () => ({
  namespaced: true,
  state     : {
    header_menu: [
      {
        name: 'Механика игры',
        path: '/',
        hash: '#mechanics',
      },
      {
        name: 'Что в коробке',
        path: '/',
        hash: '#inBox',
      },
      {
        name: 'Словник',
        path: '/encyclopedia',
        hash: '',
        // link: '/encyclopedia',
      },
      // {
      //   name: 'Предзаказ',
      //   path: '/',
      //   hash: '#preorder',
      // },
      {
        name: 'Об издателе',
        path: '/',
        hash: '#publisher',
      },
      {
        name: 'Контакты',
        path: '/',
        hash: '#contacts',
      }
    ],
    is_mobile_menu_show: false
  },
  mutations: {
    TOGGLE_MOBILE_MENU: (state, value) => {
      state.is_mobile_menu_show = value;
    },
  }
});
