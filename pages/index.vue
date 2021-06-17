<template>
    <div>
        <Banner />
        <Limitations />
        <Mechanics />
        <InBox />
        <Vocabulary />
        <PreOrder />
    </div>
</template>

<script>
import Banner                from '~/components/banner.vue';
import Limitations           from '~/components/limitations.vue';
import Mechanics             from '~/components/mechanics.vue';
import InBox                 from '~/components/in_box.vue';
import Vocabulary            from '~/components/vocabulary.vue';
import PreOrder              from '~/components/preOrder.vue';

export default {
  components: {
    Banner,
    Limitations,
    Mechanics,
    InBox,
    Vocabulary,
    PreOrder
  },
  head: {
    title: 'Настольная игра «Сибирь. Начало»'
  },
  mounted() {
    const hash = window.location.hash;
    if(hash !== '') {
      return window.scrollTo({ top : document.querySelector(hash).offsetTop - 100, behavior : 'smooth' });  
    }    
  }
};
</script>
