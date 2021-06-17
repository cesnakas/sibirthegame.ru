<template>
    <section class="slovnik">
        <div class="wrap slovnik-wrap">
            <no-ssr>
                <div v-masonry transition-duration="2s" item-selector=".item" 
                     class="slovnik-list">
                    <div v-masonry-tile v-for="(item, index) in slovnik_list" :key="index" 
                         :class="{'slovnik-list-item--big' : item.img}"
                         class="item slovnik-list-item">
                        <img v-if="item.img" :src="item.img" :alt="item.alt" 
                             class="slovnik-list-item__img">
                        <div  class="slovnik-list-item__bottom">
                            <h3 class="slovnik-list-item__title">{{ item.title }}</h3>
                            <p class="slovnik-list-item__descr">{{ item.descr }}</p>
                        </div>
                    </div>
                </div>
            </no-ssr>
        </div>
    </section>
</template>

<script>
import { mapState, mapActions }                       from 'vuex';
import NoSSR                                          from 'vue-no-ssr';
export default {
  components: {
    'no-ssr': NoSSR
  },
  computed: {
    ...mapState('slovnik', ['slovnik_list']),
  },
  async mounted() {
    await this.get_info_slovink();
    if (typeof this.$redrawVueMasonry === 'function') {
      this.$redrawVueMasonry();
    }
  },
  methods: {
    ...mapActions('slovnik', [
      'get_info_slovink'
    ])
  }
};
</script>