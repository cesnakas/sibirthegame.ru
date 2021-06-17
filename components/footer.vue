<template>
    <footer class="footer" itemscope itemtype="http://schema.org/WPFooter">
        <!-- <svg-icon name="arrowToTop" class="footer-arrow" /> -->
        <div class="wrap footer-wrap">
            <!--nav class="footer-nav">
                <ul class="footer-nav__ul">
                    <li v-for="(item, index) in footer_menu" :key="index" class="footer-nav__li">
                        <!-- <nuxt-link  :to="`${item.link}`"
                                    class="footer-nav__link">{{ item.name }}</nuxt-link> -->
            <!--nuxt-link  :to="{path: `${item.path}`, hash: `${item.hash}`}"
                                    class="footer-nav__link">{{ item.name }}</nuxt-link>
                    </li>
                </ul>
            </nav-->
            <div class="footer-bottom">
                <div class="footer-copyrigh">
                    <svg-icon name="logo_cvz" class="footer-copyrigh__img" />
                    <p class="footer-copyrigh__text">{{ copyright }}</p>
                    <meta itemprop="copyrightYear" content="2021">
                    <meta itemprop="copyrightHolder" content="Система вечных ценностей">
                </div>
                <img :src="logo" :alt="logo_alt" class="footer__logo">
                <div class="footer-info">
                    <div class="footer-info__col">
                        <h4 class="footer-info__h4">Помощь</h4>
                        <a @click="open_requisites_dialog" class="footer-info__link">Реквизиты</a>
                        <a @click="open_payment_dialog" class="footer-info__link">Способы оплаты</a>
                        <a @click="open_delivery_dialog" class="footer-info__link">Доставка</a>
                        <a @click="open_purchaseReturns_dialog" class="footer-info__link">Правила возврата товара</a>
                    </div>
                </div>
                <div class="footer-social">
                    <a v-if="contacts  && contacts.fb" :href="contacts.fb" target="_blank" 
                       rel="nofollow" 
                       class="footer-social__link">
                        <svg-icon name="facebook" class="footer-social__img" />
                    </a>
                </div>
            </div>
        </div>
    </footer>
</template>

<script>
import { mapState, mapMutations } from 'vuex';

export default {
  computed: {
    ...mapState('global', ['logo', 'logo_alt', 'contacts', 'copyright']),
  },
  methods: {
    ...mapMutations('helpDialogs',
      [
        'UPDATE_REQUISITES_DIALOG_STATE',
        'UPDATE_PAYMENT_DIALOG_STATE',
        'UPDATE_DELIVERY_DIALOG_STATE',
        'UPDATE_PURCHASERETURNS_DIALOG_STATE'
      ]
    ),
    open_requisites_dialog() {
      this.UPDATE_REQUISITES_DIALOG_STATE({ key : 'visible', value : true });
    },
    open_payment_dialog() {
      this.UPDATE_PAYMENT_DIALOG_STATE({ key : 'visible', value : true });
    },
    open_delivery_dialog() {
      this.UPDATE_DELIVERY_DIALOG_STATE({ key : 'visible', value : true });
    },
    open_purchaseReturns_dialog() {
      this.UPDATE_PURCHASERETURNS_DIALOG_STATE({ key : 'visible', value : true });
    }
  }
};
</script>

