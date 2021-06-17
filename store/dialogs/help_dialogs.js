import {get_helpDialogs} from '../../api/index';

export const helpDialogs = () => ({
  namespaced: true,
  state     : {
    requisites_dialog: {
      visible: false,
      data   : []
    },
    payment_dialog: {
      visible: false,
      data   : []
    },
    delivery_dialog: {
      visible: false,
      data   : []
    },
    purchaseReturns_dialog: {
      visible: false,
      data   : []
    }
  },
  mutations: {
    UPDATE_REQUISITES_DIALOG_STATE(state, { key, value }) {
      state.requisites_dialog[key] = value;
    },
    UPDATE_PAYMENT_DIALOG_STATE(state, { key, value }) {
      state.payment_dialog[key] = value;
    },
    UPDATE_DELIVERY_DIALOG_STATE(state, { key, value }) {
      state.delivery_dialog[key] = value;
    },
    UPDATE_PURCHASERETURNS_DIALOG_STATE(state, { key, value }) {
      state.purchaseReturns_dialog[key] = value;
    }
  },
  actions: {
    async get_help_dialogs({commit}) {
      try {
        const data = await get_helpDialogs();
        commit('UPDATE_REQUISITES_DIALOG_STATE', { key : 'data', value : data.data.data.requisites});
        commit('UPDATE_PAYMENT_DIALOG_STATE', { key : 'data', value : data.data.data.payment});
        commit('UPDATE_DELIVERY_DIALOG_STATE', { key : 'data', value : data.data.data.delivery});
        commit('UPDATE_PURCHASERETURNS_DIALOG_STATE', { key : 'data', value : data.data.data.refund});
      } catch (error) {
        console.error(error);
      }
    }
  }
});
