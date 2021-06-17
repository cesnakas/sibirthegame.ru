<template>
    <section id="inBox" class="inBox">
        <div class="wrap inBox-wrap">
            <h2 class="h2 inBox__h2">{{ title }}</h2>
            <div class="inBox-list">
                <div v-for="(item, index) in inBox_list" :key="index" class="inBox-item">
                    <img :src="item.img" :alt="item.alt" class="inBox-item__img">
                    <h4 class="inBox-item__title">{{ item.title }}</h4>
                    <p v-if="item.descr" class="inBox-item__descr">{{ item.descr }}</p>
                </div>
            </div>
            <div class="swiper-container inBox-slider">
                <div class="swiper-wrapper">
                    <div v-for="(item, index) in inBox_list" :key="index" class="swiper-slide">
                        <div class="inBox-item">
                            <img :src="item.img" class="inBox-item__img" alt="">
                            <h4 class="inBox-item__title">{{ item.title }}</h4>
                            <p class="inBox-item__descr">{{ item.descr }}</p>
                        </div>
                    </div>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
        <a :href="rules" class="red-btn inBox-btn" target="_blank">Скачать правила .pdf </a>
    </section>
</template>

<script>
import { mapState, mapActions }                       from 'vuex';
import Swiper, { Navigation, Pagination }             from 'swiper';
import 'swiper/swiper-bundle.css';

Swiper.use([Navigation, Pagination]);

export default {
  computed: {
    ...mapState('inBox', ['title', 'inBox_list', 'regulations_file']),
    ...mapState('global', ['rules']),
  },
  async mounted() {
    await this.get_inBoxInfo();
    new Swiper('.swiper-container', {
      loop         : true,
      slidesPerView: 1,
      spaceBetween : 30,
      navigation   : {
	  nextEl: '.swiper-button-next',
	  prevEl: '.swiper-button-prev',
      },
      breakpoints: {
        740: {
          slidesPerView: 2,
        }
      }
    });
    this.alignSlides();
    window.addEventListener('resize', this.alignSlides);
  },
  methods: {
    ...mapActions('inBox', [
      'get_inBoxInfo'
    ]),
    alignSlides() {
      let maxHeight = -1;
      let difference = 0;
      
      const items = document.querySelectorAll('.inBox-item__img');
      items.forEach(item => {
        maxHeight = maxHeight > item.offsetHeight ? maxHeight : item.offsetHeight;
      });
      items.forEach(item => {
        difference = maxHeight - item.offsetHeight;
        item.style.marginTop = `${difference}px`;
      });
    }
  }
};
</script>