import {get_limitations} from '../api/index';
export const limitations = () => ({
  namespaced: true,
  state     : {
    desc            : '',
    limitations_list: [
      // {
      //   img  : '/img/limitation_age.svg',
      //   title: 'Возраст',
      //   descr: 'от 8 лет'
      // },
      // {
      //   img  : '/img/limitation_players.svg',
      //   title: 'Количество игроков',
      //   descr: '2–4'
      // },
      // {
      //   img  : '/img/limitation_time.svg',
      //   title: 'Длительность игры',
      //   descr: '30–60 минут'
      // }
    ]
  },
  mutations: {
    UPDATE_LIMITATIONS_STATE(state, { key, value }) {
      state[key] = value;
    },
  },
  actions: {
    async get_inBoxInfo({commit}) {
      try {
        const res = await get_limitations();
        if(res.status === 200) {
          const data = res.data;
          commit('UPDATE_LIMITATIONS_STATE', { key : 'limitations_list', value : data.limitations_list});
          commit('UPDATE_LIMITATIONS_STATE', { key : 'desc', value : data.desc});
        }
      } catch (error) {
        console.error(error);
      }
    }
  }
});