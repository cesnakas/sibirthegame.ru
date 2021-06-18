import {get_mechanics} from '../api/index';
export const mechanics = () => ({
  namespaced: true,
  state     : {
    // title         : 'Механика игры',
    title         : '',
    descr         : '',
    // descr         : 'Поочередно выставляя от стартового поля и осваивая тайлы карты земель Сибири, игроки передвигают по ней своих ватажников так, чтобы их расположение на объектах карты соответствовало требованиям различных заданий. В конце каждого хода игрок должен постараться выполнить одно или несколько выбранных им заданий.<br> Каждое выполненное задание приносит игроку победные очки. <br> <span class="red-text">Побеждает в игре тот, кто в конце партии наберет наибольшее количество очков.</span>',
    mechanics_list: [
      // {
      //   img  : '/img/mechanics_1.png',
      //   title: 'Открывай новые территории',
      //   descr: 'Выкладывай тайлы новых земель и передвигай своих ватажников по тундре,  тайге и степи. Осваивай земли, переворачивая тайлы.'
      // },
      // {
      //   img  : '/img/mechanics_2.png',
      //   title: 'Выполняй задания',
      //   descr: 'Выбирай карточки заданий, выполняй их и зарабатывай очки для победы в игре. Сложные задания дают больше очков!'
      // },
      // {
      //   img  : '/img/mechanics_3.png',
      //   title: 'Действуй стратегически',
      //   descr: 'Выстраивай своих ватажников таким образом, чтобы быстрее выполнять задания и мешать делать это соперникам.'
      // }
    ],
    video: ''
  },
  mutations: {
    UPDATE_MECHANICS_STATE(state, { key, value }) {
      state[key] = value;
    },
  },
  actions: {
    async get_mechanicsInfo({commit}) {
      try {
        const res = await get_mechanics();
        if(res.status === 200) {
          const data = res.data;
          commit('UPDATE_MECHANICS_STATE', { key : 'title', value : data.title});
          commit('UPDATE_MECHANICS_STATE', { key : 'descr', value : data.descr});
          commit('UPDATE_MECHANICS_STATE', { key : 'mechanics_list', value : data.mechanics_list});
          commit('UPDATE_MECHANICS_STATE', { key : 'video', value : data.video});
        }
      } catch (error) {
        console.error(error);
      }
    }
  }
});