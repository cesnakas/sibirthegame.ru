<template>
    <section class="bannerEncyclopedia">
        <div class="wrap bannerEncyclopedia-wrap">
            <div class="bannerEncyclopedia-content">
                <img src="/img/slovnik-white.svg" class="bannerEncyclopedia-content__img" alt="Словник">
                <p v-html="descr" class="bannerEncyclopedia-content__descr"></p>
            </div>
        </div>
    </section>
</template>

<script>
import { mapState }                       from 'vuex';
export default {
  computed: {
    ...mapState('slovnik', ['descr']),
  }
};
</script>