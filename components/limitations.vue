<template>
    <section class="limitations">
        <div class="wrap limitations-wrap">
            <div v-html="desc" class="limitations--text">  </div>
            <div class="limitations-list">
                <div v-for="(item, index) in limitations_list" :key="index" class="limitations-list__item">
                    <img :src="item.img" class="limitations-list__item__img" alt="">
                    <b class="limitations-list__item__title">{{ item.title }}</b>
                    <p class="limitations-list__item__descr">{{ item.descr }}</p>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import { mapState, mapActions } from 'vuex';

export default {
  computed: {
    ...mapState('limitations', ['limitations_list', 'desc']),
  },
  async mounted() {
    await this.get_inBoxInfo();
  },
  methods: {
    ...mapActions('limitations',['get_inBoxInfo'])
  }
};
</script>