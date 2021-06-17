<template>
    <div data-app>
        <Header></Header>
        <main class="content">
            <nuxt/>
            <orderingDialog/>
            <orderingNotification/>
            <requisitesDialog/>
            <deliveryDialog/>
            <purchaseReturnsDialog/>
            <paymentDialog/>
        </main>
        <Footer></Footer>
    </div>
</template>
<script>
import { mapMutations, mapActions }                         from 'vuex';
import Header                                               from '~/components/header.vue';
import Footer                                               from '~/components/footer.vue';
import orderingDialog                                       from '~/components/dialogs/ordering_dialog';
import orderingNotification                                 from '~/components/dialogs/ordering_notification';
import requisitesDialog                                     from '~/components/dialogs/requisites_dialog';
import paymentDialog                                        from '~/components/dialogs/payment_dialog';
import deliveryDialog                                       from '~/components/dialogs/delivery_dialog';
import purchaseReturnsDialog                                from '~/components/dialogs/purchaseReturns_dialog';
import debounce                                             from 'debounce';
export default {
  components: {
    Header,
    Footer,
    orderingDialog,
    orderingNotification,
    requisitesDialog,
    deliveryDialog,
    purchaseReturnsDialog,
    paymentDialog
  },
  mounted() {
    this.sendYandexMetrikaHit();
    this.get_help_dialogs();
  },
  created() {
    if(process.client) {
      this.set_device_value();
      const adaptive_resize = debounce(this.set_device_value, 200);
      window.addEventListener('resize', adaptive_resize);
    }
  },
  methods: {
    ...mapMutations(['SET_DEVICE']),
    ...mapActions('helpDialogs',['get_help_dialogs']),
    set_device_value() {
      const window_width = window.innerWidth;
      if(window_width <= 740) {
        this.SET_DEVICE('mobile');
      } else if(window_width >= 741 && window_width < 1025) {
        this.SET_DEVICE('tablet');
      } else if(window_width >= 1025) {
        this.SET_DEVICE('desktop');
      }
    },
    sendYandexMetrikaHit() {
      this.$yandexMetrika.hit(window.location.href);
    }
  }
};
</script>
