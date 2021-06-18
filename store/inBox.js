// import { TheMask } from 'vue-the-mask';
import {get_inBox} from '../api/index';
export const inBox = () => ({
  namespaced: true,
  state     : {
    title     : 'Что в коробке?',
    descr     : '',
    inBox_list: [
      // {
      //   img  : 'img/inBox_1.png',
      //   title: '1 стартовое игровое поле',
      //   descr: '(Уральский хребет);'
      // },
      // {
      //   img  : 'img/inBox_2.png',
      //   title: '90 квадратных двусторонних тайлов земель Сибири трех видов:',
      //   descr: '30 тайлов тундры, 30 тайлов тайги, 30 тайлов степи'
      // },
      // {
      //   img  : 'img/inBox_3.png',
      //   title: '20 фигурок ватажников',
      //   descr: '4 разных цветов'
      // },
      // {
      //   img  : 'img/inBox_4.png',
      //   title: '60 карт заданий:',
      //   descr: '20 заданий «Сокровища Сибири», 20 заданий «Новый уклад», 20 заданий «Свои да чужие»'
      // },
      // {
      //   img  : 'img/inBox_5.png',
      //   title: 'Правила игры и памятка превращения тайлов',
      //   descr: ''
      // },
    ],
    regulations_file: '/'
  },
  mutations: {
    UPDATE_INBOX_STATE(state, { key, value }) {
      state[key] = value;
    },
  },
  actions: {
    async get_inBoxInfo({commit}) {
      try {
        const res = await get_inBox();
        if(res.status === 200) {
          const data = res.data;
          commit('UPDATE_INBOX_STATE', { key : 'descr', value : data.descr});
          commit('UPDATE_INBOX_STATE', { key : 'inBox_list', value : data.slovnik_list}); 
        }
      } catch (error) {
        console.error(error);
      }
    }
  }
});