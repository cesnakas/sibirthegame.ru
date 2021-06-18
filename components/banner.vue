<template>
    <section class="banner" itemscope itemtype="http://schema.org/Product">
        <div class="wrap banner-wrap">
            <div class="banner-left">
                <div class="banner-preOrder">
                    <div class="banner-preorder__left">
                        <img itemprop="image" src="/img/box-img.png" class="banner-preOrder__img" 
                             alt="Коробка с игрой">
                    </div>
                    <div class="banner-preOrder__right" itemprop="offers">
                        <meta itemprop="name" content="Настольная игра «Сибирь. Начало»">
                        <meta itemprop="description" content="Настольная игра «Сибирь. Начало» – игра для 2-4 игроков, которым интересно оказаться в роли покорителя Сибири XVIII века. Осваивайте со своим отрядом новые территории, находите сокровища, возводите церкви и остроги, основывайте поселения и сражайтесь с врагами! Станьте настоящим правителем земли сибирской!">
                        <meta itemprop="priceCurrency" content="RUB">
              
                        <p v-if="banner" v-html="banner.before_price" class="banner-preOrder__title"></p>
                        <p class="banner-preOrder__price"><span class="banner-preOrder__price--number" itemprop="price">{{game_price}}</span> {{game_currency}}</p>
                        <p v-if="banner.after_price" v-html="banner.after_price" class="banner-preOrder__footnote"></p>
                        <div class="banner-preOrder__img--mobile"></div>
                        <p v-if="banner.description" v-html="banner.description" class="banner-preOrder__descr"></p>
                        <div v-if="banner" v-html="banner.description" class="banner-preOrder__descr--mobile">
                        </div>
                        <a @click="click_buy" class="black-btn banner-preOrder__btn">Купить</a>
                    </div>
                </div>
            </div>
            <img src="/img/cover.png" class="banner-cover" alt="Персонажи">
            <div class="banner-cover--mobile" style="background-image: url(/img/cover-mobile.jpg);"></div>
        </div>
    </section>
</template>

<script>
import { mapMutations, mapState } from 'vuex';

export default {
  computed: {
    ...mapState('global',
      ['game_price', 'game_currency',
        'banner']
    )
  },
  methods: {
    ...mapMutations('orderingDialog',
      [
        'UPDATE_ORDERING_DIALOG_STATE'
      ]
    ),
    click_buy() {
      this.UPDATE_ORDERING_DIALOG_STATE({ key : 'visible', value : true });
    }
  }
};
</script>