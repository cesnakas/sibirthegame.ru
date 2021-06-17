<template>
    <v-dialog v-model="ordering_notification_model"
              max-width="810">
        <v-card>
            <div class="order-notification">
                <img class="order-notification__img" src="img/order-motification.png" alt="Персонаж">
                <div v-if="orderStatus === 'y'" class="status">
                    <h3 class="order-notification__title">Заказ оформлен. Спасибо!</h3>
                    <p class="order-notification__descr">Номер вашего заказа <span class="red-text">#{{orderNumber}}</span></p>
                    <p class="order-notification__text">Мы свяжемся с вами в ближайшее время для уточнения даты и деталей доставки.</p>
                </div>
                <div v-else class="status">
                    <h3 class="order-notification__title">Заказ не оформлен!</h3>
                    <p class="order-notification__descr">Номер вашего заказа <span class="red-text">#{{orderNumber}}</span></p>
                    <p class="order-notification__text">Мы свяжемся с вами в ближайшее время для уточнения даты и деталей доставки.</p>  
                </div>
                <a @click="close_dialog" class="black-outline-btn order-notification__btn">Закрыть</a>
            </div>
        </v-card>
    </v-dialog>

</template>

<script>
import { mapMutations, mapState } from 'vuex';

export default {
  name: 'ModalOrderingNotification',
  data() {
    return {
      orderNumber: '',
      orderStatus: '',
    };
  },
  computed: {
    ...mapState('orderingDialog',
      [
        'ordering_notification'
      ]
    ),
    ...mapState('global',
      ['game_price']
    ),
    ordering_notification_model: {
      get() {
        return this.ordering_notification.visible;
      },
      set(value) {
        this.UPDATE_ORDERING_NOTIFICATION_STATE({ key : 'visible', value });
      }
    },
    price: {
      get() {
        return this.game_price;
      }
    }
  },
  // watch: {
  //   price(value, oldValue) {
  //     if(value !== oldValue) {
  //       this.$fb.query('track', 'Purchase', {value, currency : 'RUB'});
  //     }
  //   }
  // },
  mounted() {
    const href = window.location.search;
    const res = this.getUrlParams(href);
    if(res.success === 'y') {
      this.orderStatus = 'y';
      this.orderNumber = res.orderId;
      this.UPDATE_ORDERING_NOTIFICATION_STATE({ key : 'visible', value : true });
      setTimeout(() => {
        this.$fb.query('track', 'Purchase', {value : this.game_price, currency : 'RUB'});
        this.$fb.track('track', 'Purchase', {value : this.game_price, currency : 'RUB'});
        this.$yandexMetrika.reachGoal('gamebuy');
      }, 300);
      // this.$fb.query('track', 'Purchase', )
    }else if(res.success === 'n') {
      this.orderStatus = 'n';
      this.orderNumber = res.orderId;
      this.UPDATE_ORDERING_NOTIFICATION_STATE({ key : 'visible', value : true });
    }else {
      this.orderStatus = '';
      this.orderNumber = '';
    }
  },
  methods: {
    ...mapMutations('orderingDialog',
      [
        'UPDATE_ORDERING_NOTIFICATION_STATE'
      ]
    ),
    close_dialog() {
      this.UPDATE_ORDERING_NOTIFICATION_STATE({ key : 'visible', value : false });
    },
    getUrlParams(search) {
      const hashes = search.slice(search.indexOf('?') + 1).split('&');
      return hashes.reduce((params, hash) => {
        const [key, val] = hash.split('=');
        return Object.assign(params, {[key] : decodeURIComponent(val)});
      }, {});
    }
  }
};
</script>