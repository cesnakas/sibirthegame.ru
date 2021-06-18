<template>
    <div>
        <Banner />
        <Slovnik />
    </div>
</template>

<script>
import Banner                from '~/components/encyclopedia/banner.vue';
import Slovnik               from '~/components/encyclopedia/slovnik.vue';

export default {
  components: {
    Banner,
    Slovnik
  },
  head: {
    title: 'Словник - Настольная игра «Сибирь. Начало»'
  },
};
</script>