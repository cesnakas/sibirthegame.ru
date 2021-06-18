/* eslint-disable */

export default function ({app}) {
  if (process.env.NODE_ENV !== 'production'){
  (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
  m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
  (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
    
  ym(69334582, "init", {
    clickmap:true,
    trackLinks:true,
    accurateTrackBounce:true,
    webvisor:true,
    ecommerce:"dataLayer"
  });

  const noscript =  document.createElement('noscript')
  const div = document.createElement('div')
  const img = document.createElement('img')
  img.src = 'https://mc.yandex.ru/watch/69334582';
  img.style.position = 'absolute';
  img.style.left = '-9999px';
  div.append(img)
  noscript.append(div)

  document.getElementsByTagName('head')[0].appendChild(noscript)

  ym('69334582', 'hit', window.location.href)
  ym('69334582', 'params', window.location.href)
  }
}