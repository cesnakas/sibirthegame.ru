import {get_delivery, get_order, get_global} from '../../api/index';
export const orderingDialog = () => ({
  namespaced: true,
  state     : {
    ordering_dialog: {
      visible: false,
      data   : {
        name            : '',
        email           : '',
        phone           : '',
        delivery_method : 'courier',
        full_address    : '',
        city            : '',
        country         : '',
        apartment       : '',
        postcode        : '',
        entrance        : '',
        floor           : '',
        intercom        : '',
        radioGroup      : 'rus_post_land',
        quantity        : 1,
        cost            : 1701,
        cost_of_delivery: 0,
        toPay           : 1701,
        allDelivery     : null,
        formLink        : null,
        agreement       : false
      }
    },
    ordering_notification: {
      visible: false,
    }
  },
  mutations: {
    UPDATE_ORDERING_DIALOG_STATE(state, { key, value }) {
      state.ordering_dialog[key] = value;
    },
    UPDATE_ORDERING_DIALOG_DATA_STATE(state, { key, value }) {
      state.ordering_dialog.data[key] = value;

      let toPay;
      if (key === 'quantity' || key === 'cost_of_delivery') {
        toPay =  state.ordering_dialog.data.quantity*state.ordering_dialog.data.cost + state.ordering_dialog.data.cost_of_delivery;
        state.ordering_dialog.data.toPay = toPay;
      }
    },
    UPDATE_ORDERING_NOTIFICATION_STATE(state, { key, value }) {
      state.ordering_notification[key] = value;
    },
  },
  actions: {
    async send_order({ state, commit }) {
      try {
        const {quantity, city, country, postcode, name, phone,radioGroup, email, full_address, delivery_method, entrance, floor, intercom} = state.ordering_dialog.data;
        const arr = {
          quantity,
          city,
          zip     : postcode,
          name,
          phone,
          email,
          country,
          address : full_address.value === undefined ? full_address : full_address.value,
          entrance,
          floor,
          intercom,
          delivery: radioGroup === 'post_world' ? radioGroup : delivery_method,

        };
        const res = await get_order(arr);
        const response = res.data;
        if(response.success === true) {
          commit('UPDATE_ORDERING_DIALOG_DATA_STATE', { key : 'formLink', value : response.data.pay_form });
          // window.location.href = res.data.pay_form;
        }
        // data.append("quantity", "3");
        // data.append("city", "Москва");
        // data.append("zip", "115432");
        // data.append("name", "Test");
        // data.append("phone", "1111111");
        // data.append("email", "test3@test.ru");
        // data.append("address", "вадплодвлао дл владп одвлап вдлаподва");
        // data.append("delivery", "rus_post_avia");
        // const { data } = await axios.patch('/api/order', { params })
        // commit('UPDATE_ORDERING_DIALOG_STATE', { key : 'visible', value : false });
        // commit('UPDATE_ORDERING_NOTIFICATION_STATE', { key : 'visible', value : true });
      } catch (e) {
        console.error(e);
      }
    },
    async send_delivery({state, commit}) {
      try {
        const {quantity, city, postcode, delivery_method} = state.ordering_dialog.data;        
        let arra = {};
        if(city !== '' && postcode !== '') {
          arra = {
            quantity,
            city,
            zip: postcode,
          };
          const {data} = await get_delivery(arra);
          const res = data.filter(x => x.CODE === delivery_method);
          if(res.length !== 0) {
            commit('UPDATE_ORDERING_DIALOG_DATA_STATE', { key : 'cost_of_delivery', value : res[0].PRICE});  
          }else {
            commit('UPDATE_ORDERING_DIALOG_DATA_STATE', { key : 'cost_of_delivery', value : 0});
          }
        }
      } catch (error) {
        console.error(error);
      }
    },
    async get_global__info_Order({commit}) {
      try {
        const res = await get_global();    
        // commit('UPDATE_GLOBAL_STATE', { key : 'game_price', value : res.data.game_price});
        commit('UPDATE_ORDERING_DIALOG_DATA_STATE', { key : 'cost', value : res.data.game_price});
        commit('UPDATE_ORDERING_DIALOG_DATA_STATE', { key : 'toPay', value : res.data.game_price});
      } catch (error) {
        console.error(error);
      }
    }
  },
  getter: {
    get_delivery_method: state => state.ordering_dialog.delivery_method,
  }
});
