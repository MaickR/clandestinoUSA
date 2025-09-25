const purgecss = require('@fullhuman/postcss-purgecss').default;

module.exports = {
  plugins: [
    require('autoprefixer'),
    purgecss({
      content: [
        './**/*.html',
        './assets/js/**/*.js'
      ],
      safelist: {
        standard: [
          /active/, /open/, /show/, /fade/, /collaps/, /aria-/,
          /swiper/, /lightbox/, /gallery/, /menu/, /nav/, /hero/,
          /kf-/, /clandestino-/
        ],
        deep: [ /kf-/, /clandestino-/ ],
        greedy: []
      },
      defaultExtractor: content => content.match(/[A-Za-z0-9-_:/]+/g) || []
    })
  ]
};
