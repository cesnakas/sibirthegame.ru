export const footer = () => ({
  namespaced: true,
  state     : {
    footer_menu: [
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
      {
        name: 'Предзаказ',
        path: '/',
        hash: '#preorder',
      },
      {
        name: 'Контакты',
        path: '/',
        hash: '#contacts',
      }
    ]
  },
  mutations: {}
});
