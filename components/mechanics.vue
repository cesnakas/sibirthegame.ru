<template>
    <section id="mechanics" class="mechanics">
        <div class="wrap mechanics-wrap">
            <h2 class="h2 mechanics__h2">{{ title }}</h2>
            <p v-if="descr" v-html="descr" class="mechanics__descr"></p>
            <div class="mechanics-list">
                <div v-for="(item, index) in mechanics_list" :key="index" class="mechanics-item">
                    <img :src="item.img" :alt="item.alt" class="mechanics-item__img">
                    <h4 class="mechanics-item__title">{{ item.title }}</h4>
                    <p class="mechanics-item__descr">{{ item.descr }}</p>
                </div>
            </div>
            <div v-if="video" class="mechanics__video">
                <iframe :src="video" width="560" height="315" 
                        title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen></iframe>
            </div>
        </div>
    </section>
</template>

<script>
import { mapState, mapActions } from 'vuex';

export default {
  computed: {
    ...mapState('mechanics', ['title', 'descr', 'mechanics_list', 'video']),
  },
  async mounted() {
    await this.get_mechanicsInfo();
  },
  methods: {
    ...mapActions('mechanics', ['get_mechanicsInfo'])
  }
};
</script>