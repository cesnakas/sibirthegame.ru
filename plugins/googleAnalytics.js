/* eslint-disable */

export default function ({app}) {
  if (process.env.NODE_ENV !== 'development'){
  const script = document.createElement('script')
  script.src = 'https://www.googletagmanager.com/gtag/js?id=G-WXMVBW6YL9'
  script.async = true
  document.getElementsByTagName('head')[0].appendChild(script)
  window.dataLayer = window.dataLayer || [];
  function gtag() {
    dataLayer.push(arguments);
  }
  gtag('js', new Date());

  gtag('config', 'G-WXMVBW6YL9');
  }
}