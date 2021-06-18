<template>
    <header class="header">
        <div class="wrap header-wrap">
            <a href="/" class="header-logo">
                <img :src="logo" :alt="logo_alt" class="header-logo__img">
                <span class="header-logo__text">Историческая<br>настольная игра</span>
            </a>
            <nav class="header-nav" itemscope itemtype="http://schema.org/SiteNavigationElement">
                <ul class="header-nav__ul">
                    <li v-for="(item, index) in header_menu" :key="index"
                        class="header-nav__li">
                        <nuxt-link :to="{path: `${item.path}`, hash: `${item.hash}`}"  itemprop="url"
                                   class="header-nav__link">{{ item.name }}</nuxt-link>
                    </li>
                </ul>
            </nav>
            <a @click="click_buy" class="red-outline-btn header__btn">Купить игру</a>
            <img @click="toggle_menu" :src='is_mobile_menu_show ? `/img/close-menu.svg` : `/img/burger.svg`' class="header-burger js-header-btn"  
                 alt="Меню">
            <div :class="{'visible' : is_mobile_menu_show}" class="header-mobileMenu js-mobile-menu">
                <ul class="header-mobileMenu__ul">
                    <li v-for="(item, index) in header_menu" :key="index" @click="clickMobileLink()" 
                        class="header-mobileMenu__li">
                        <nuxt-link :to="{path: `${item.path}`, hash: `${item.hash}`}"
                                   class="header-mobileMenu__link">{{ item.name }}</nuxt-link>
                    </li>
                </ul>
                <a @click="click_buy" class="red-outline-btn header-mobileMenu__btn">
                    Купить игру
                </a>
            </div>
  
        </div>
    </header>
</template>

<script>
import { mapState, mapMutations, mapActions} from 'vuex';

export default {
  computed: {
    ...mapState('header', ['header_menu', 'is_mobile_menu_show']),
    ...mapState('global', ['logo', 'logo_alt']),
  },
  async mounted() {
    await this.get_global__info();
    await this.get_global__info_Order();
  }, 
  methods: {
    ...mapMutations('header', ['TOGGLE_MOBILE_MENU']),
    ...mapMutations('orderingDialog',
      [
        'UPDATE_ORDERING_DIALOG_STATE'
      ]
    ),
    ...mapActions('global', [
      'get_global__info',
    ]),
    ...mapActions('orderingDialog', [
      'get_global__info_Order',
    ]),
    toggle_menu() {
      this.TOGGLE_MOBILE_MENU(!this.is_mobile_menu_show);
    },
    click_buy() {
      this.UPDATE_ORDERING_DIALOG_STATE({ key : 'visible', value : true });
    },
    clickMobileLink() {
      this.TOGGLE_MOBILE_MENU(!this.is_mobile_menu_show);
    }
    // scrollMenu(e) {
    //   setTimeout(() => {
    //     this.$scrollTo(e);
    //   }, 300);
    // }
  }
};
</script>

