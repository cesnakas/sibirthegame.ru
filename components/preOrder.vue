<template>
    <section id="preorder" class="preOrder">
        <div class="wrap preOrder-wrap">
            <div class="preOrder--inner">
                <div class="preOrder-left">
                    <img class="preOrder-left__img" src="img/game_box.png" alt="Коробка с игрой">
                    <strong v-html="banner.bottom_banner_title" class="preOrder-left-content__descr mobile-only"></strong>
                    <p v-html="banner.bottom_banner_desc" class="preOrder-left-content__descr mobile-only"> </p>
                    <a @click="click_buy" class="black-btn preOrder-right__btn mobile-only">Купить</a>
                </div>
                <div class="preOrder-right">
                    <p class="preOrder-right__text">Цена:</p>
                    <p class="preOrder-right__price"><span class="preOrder-right__price--number">{{game_price}}</span> рубль</p>
                    <p v-html="banner.after_price" class="preOrder-right__descr"></p>
                    <a @click="click_buy" class="red-btn preOrder-right__btn mobile-none">Купить</a>
                    <h3 v-html="banner.bottom_banner_title" class="preOrder-left-content__title mobile-none"></h3>
                    <p v-html="banner.bottom_banner_desc" class="preOrder-left-content__descr mobile-none"></p>
                    <!-- <div class="preOder-dislaimer">
                        <p>* - предзаказная цена действительна до <b>1 декабря 2020 года</b></p>
                    </div> -->
                </div>
            </div>
            
        </div>
        <div id="publisher" class="publisher">
            <div class="wrap">
                <h2 class="h2 contacts__h2">
                    Об издателе
                </h2>
                <div class="publisher-content">
                    <div class="publisher-item">
                        <svg-icon name="logo_cvz" class="publisher-item--svg" />
                    </div>
                    <div class="publisher-item">
                        <div class="publisher-item-info">
                            <div v-if="desc" v-html="desc" class="infos"></div>
                            
                            <div class="publisher-item-info__links">
                                <div v-for="(item,index) in link_list" :key="index">
                                    <a :href="item.link" rel="nofollow" target="_blank">
                                        <svg-icon name="link-icons" class="publisher-links--svg" />{{item.text}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="contacts" class="contacts">
            <div class="wrap contacts-wrap">
                <h2 class="h2 contacts__h2">Контакты</h2>
                <div class="contacts-content">
                    <div class="contacts-content__list">
                        <p class="contacts-content__list__title">По всем вопросам:</p>
                        <p v-if="contacts && contacts.phone" class="contacts-content__list__text">Тел.: <a class="red-link" href="tel:+74951234567">{{ contacts.phone }}</a></p>
                        <p v-if="contacts && contacts.email" class="contacts-content__list__text">E-mail: <a class="red-link" href="mailto:info@sistemacennostey.ru">{{ contacts.email }}</a></p>
                    </div>
                    <!-- <div class="contacts-content__info">
                        <img class="contacts-content__info__img" src="img/whatsapp.svg" alt="">
                        <p class="contacts-content__info__text">Также вы можете заказать игру, связавшись с нами в <a :href="contacts.whatsapp" class="red-link">WhatsApp</a></p>
                    </div> -->
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import { mapState, mapMutations } from 'vuex';

export default {
  computed: {
    ...mapState('global', ['contacts']),
    ...mapState('global',
      ['game_price',
        'desc',
        'publisher_title',
        'link_list']
    ),
    ...mapState('global',
      ['game_price',
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