module.exports = {
  /*0
  ** Headers of the page
  */
  head: {
    headAttrs: {
      itemtype : 'http://schema.org/WPHeader',
      itemscope: ' '
    },
    htmlAttrs: {
      prefix: 'og: http://ogp.me/ns#',
    },
    title: '',
    meta : [
      { property : 'og:title', itemprop : 'headline', content : 'Настольная игра «Сибирь. Начало»'},
      { property : 'og:type', content : 'website' },
      { property : 'og:site_name', content : 'Настольная игра «Сибирь. Начало»' },
      { property : 'og:url', content : 'https://www.sibirthegame.ru' },
      { property : 'og:locale', content : 'ru' },
      { property : 'og:image', itemprop : 'image', content : '/img/seo-cover.png' },

      { charset : 'utf-8' },
      { name : 'viewport', content : 'width=device-width, initial-scale=1' },
      { hid : 'description', name : 'description', property : 'og:description', itemprop : 'description', content : 'Настольная игра «Сибирь. Начало» – игра для 2-4 игроков, которым интересно оказаться в роли покорителя Сибири XVIII века. Осваивайте со своим отрядом новые территории, находите сокровища, возводите церкви и остроги, основывайте поселения и сражайтесь с врагами! Станьте настоящим правителем земли сибирской!' },
      { name : 'theme-color', content : '#000' },
      { name : 'apple-mobile-web-app-status-bar-style', content : '#000' },
      { name : 'msapplication-navbutton-color', content : '#000' },
    ],
    link: [
      { rel : 'icon', type : 'image/x-icon', href : '/favicon.ico' },
      { rel : 'apple-touch-icon', sizes : '16x16', href : '/favicon-16x16.png' },
      { rel : 'apple-touch-icon', sizes : '32x32', href : '/favicon-32x32.png' },
      { rel : 'apple-touch-icon', sizes : '192x192', href : '/favicon-192x192.png' },
      { rel : 'apple-touch-icon', sizes : '512x512', href : '/favicon-512x512.png' },
      { rel : 'icon', type : 'image/png', sizes : '512x512', href : '/favicon-512x512.png' },
      { rel : 'icon', type : 'image/png', sizes : '192x192', href : '/favicon-192x192.png' },
      { rel : 'icon', type : 'image/png', sizes : '32x32', href : '/favicon-32x32.png' },
      { rel : 'icon', type : 'image/png', sizes : '16x16', href : '/favicon-16x16.png' },
    ],
  },
  css: [
    { src : '~assets/styles/style.scss', lang : 'scss' },
  ],
  /*
  ** Customize the progress bar color
  */
  loading: { color : '#3B8070' },
  modules: [
    '@nuxtjs/svg-sprite',
    '@nuxtjs/vuetify',
    'nuxt-facebook-pixel-module',
    ['@rkaliev/nuxtjs-yandex-metrika', 
      {
        id                 : '69334582',
        clickmap           : true,
        trackLinks         : true,
        accurateTrackBounce: true,
        webvisor           : true,
        defer              : false,
        ecommerce          : 'dataLayer',
        debug              : false,
      }
    ],
    // ['nuxt-facebook-pixel-module', 
    // // {
    // //   /* module options */
    // //   track       : 'PageView',
    // //   pixelId     : '393020765353226',
    // //   autoPageView: true,
    // //   disabled    : false
    // // }
    // ],
  ],
  facebook: {
    /* module options */
    track       : 'PageView',
    pixelId     : '393020765353226',
    autoPageView: true,
    disabled    : false
  },
  svgSprite: {
    // manipulate module options
  },
  /*
  ** Build module configuration
  */
  // buildModules: [
  //   '@nuxtjs/google-analytics',
  // ],
  /*
  ** Google Analytics configuration
  */
  // googleAnalytics: {
  //   id: 'G-WXMVBW6YL9', //Google ID
  // },
  // publicRuntimeConfig: {
  //   googleAnalytics: {
  //     id: 'G-WXMVBW6YL9'
  //   }
  // },
  /*
  ** Build configuration
  */
  build: {
    /*
    ** Run ESLint on save
    */
    parallel  : true,
    extractCSS: true,
    loaders   : {
      less: {
        sourceMap: true
      },
    },
    extend(config, { isDev, isClient }) {
      if (isDev && isClient) {
        config.module.rules.push({
          enforce: 'pre',
          test   : /\.(js|vue)$/,
          loader : 'eslint-loader',
          exclude: /(node_modules)/
        });
      }
    }
  },
  router: {
    async scrollBehavior(to, from, savedPosition) {
      if (savedPosition) {
        return savedPosition;
      }

      const findEl = async(hash, x = 0) => {
        return (
          document.querySelector(hash)
          || new Promise(resolve => {
            if (x > 50) {
              return resolve(document.querySelector('#app'));
            }
            setTimeout(() => {
              resolve(findEl(hash, ++x || 1));
            }, 100);
          })
        );
      };

      if (to.hash) {
        const el = await findEl(to.hash);
        if ('scrollBehavior' in document.documentElement.style) {
          return window.scrollTo({ top : el.offsetTop - 50, behavior : 'smooth' });
        } else {
          return window.scrollTo(0, el.offsetTop);
        }
      }

      return { x : 0, y : 0 };
    }
  },
  plugins: [
    { src : '~/plugins/vue-masonry', ssr : false },
    { src : '~/plugins/bitrix.js', mode : 'client'},
    { src : '~/plugins/googleAnalytics.js', mode : 'client'},
    // { src : '~/plugins/yandex.js', mode : 'client'}
  ],
};

