(()=>{"use strict";var t,e={1609:t=>{t.exports=window.React},4773:(t,e,a)=>{a(1609);var r=a(6087),n=a(3554);function i(t,e){(null==e||e>t.length)&&(e=t.length);for(var a=0,r=Array(e);a<e;a++)r[a]=t[a];return r}var o=function(t){var e,a,r=t.wrapper,i=t._autoplay,o=t._muted,s=r.getAttribute("data-url"),l=(r.getAttribute("data-option"),"true"===r.getAttribute("data-controls")),c="true"===r.getAttribute("data-loop"),d=o||"true"===r.getAttribute("data-muted"),u=i||"true"===r.getAttribute("data-playing"),m="true"===r.getAttribute("data-overlay"),y=r.getAttribute("data-light"),p="true"===r.getAttribute("data-customPlayIcon"),b=r.getAttribute("data-playicon"),f=r.getAttribute("data-customPlayIconType"),v=r.getAttribute("data-customPlayIconLib"),g=r.getAttribute("data-download");return e=!(!0!==m||!y)&&y,a=1==m&&1==p&&"image"==f?React.createElement("img",{src:b}):1==m&&1==p&&"icon"==f?React.createElement("i",{class:v}):null,React.createElement(React.Fragment,null,React.createElement(n.A,{className:"eb-react-player",width:"100%",height:"100%",url:s,controls:l,loop:c,muted:d,playing:u,light:e,playIcon:a,volume:.5,config:{file:{attributes:{controlsList:"false"===g?"nodownload":""}}}}))};document.addEventListener("DOMContentLoaded",(function(t){var e,a=function(t,e){var a="undefined"!=typeof Symbol&&t[Symbol.iterator]||t["@@iterator"];if(!a){if(Array.isArray(t)||(a=function(t,e){if(t){if("string"==typeof t)return i(t,e);var a={}.toString.call(t).slice(8,-1);return"Object"===a&&t.constructor&&(a=t.constructor.name),"Map"===a||"Set"===a?Array.from(t):"Arguments"===a||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(a)?i(t,e):void 0}}(t))||e&&t&&"number"==typeof t.length){a&&(t=a);var r=0,n=function(){};return{s:n,n:function(){return r>=t.length?{done:!0}:{done:!1,value:t[r++]}},e:function(t){throw t},f:n}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var o,s=!0,l=!1;return{s:function(){a=a.call(t)},n:function(){var t=a.next();return s=t.done,t},e:function(t){l=!0,o=t},f:function(){try{s||null==a.return||a.return()}finally{if(l)throw o}}}}(document.getElementsByClassName("eb-advanced-video-wrapper"));try{var n,s,l,c,d,u,m,y=function(){var t=e.value,a=t.getElementsByClassName("eb-player-option")[0],i="true"===a.getAttribute("data-overlay"),y=(a.getAttribute("data-id"),a.getAttribute("data-option"));if(i&&a.addEventListener("click",(function(t){(0,r.render)(React.createElement(o,{wrapper:a,_autoplay:!0,_muted:!1}),a)})),(0,r.render)(React.createElement(o,{wrapper:a}),a),"eb-sticky"===y){(n=document.querySelector(".eb-player-option.eb-sticky")).innerHeight,s=document.querySelector(".eb-react-player").offsetHeight,l=a.closest(".eb-sticky").closest(".wp-block-essential-blocks-advanced-video").offsetTop,c=a.querySelector(".eb-sticky-video-close"),(d=document.createElement("span")).innerHTML="&times;",d.setAttribute("class","eb-sticky-video-close");var p="stuck-out",b=0,f=a.getAttribute("data-stickyVisibility"),v=a.getAttribute("data-stickyVisibilityTAB"),g=a.getAttribute("data-stickyVisibilityMOB");window.matchMedia("(min-width: 1025px)").matches&&"hidden"!=f&&document.addEventListener("scroll",(function(){var t=s+l+200,e=s+l+320,a=window.pageYOffset;a<=t?n.classList.remove(p):window.scrollY>t?window.scrollY>e?(n.classList.remove("stuck-out"),n.classList.add("stuck"),null==c&&n.prepend(d),d.style.display="inline",d.addEventListener("click",(function(){n.classList.remove("eb-sticky")}))):(a<b&&n.classList.contains("stuck")&&(n.classList.remove("stuck"),n.classList.add(p)),b=a):n.classList.remove("stuck-out")})),window.matchMedia("(min-width: 768px) and (max-width: 1024px)").matches&&"hidden"!=v&&document.addEventListener("scroll",(function(){var t=s+l+200,e=s+l+320,a=window.pageYOffset;a<=t?n.classList.remove(p):window.scrollY>t?window.scrollY>e?(n.classList.remove("stuck-out"),n.classList.add("stuck"),null==c&&n.prepend(d),d.style.display="inline",d.addEventListener("click",(function(){n.classList.remove("eb-sticky")}))):(a<b&&n.classList.contains("stuck")&&(n.classList.remove("stuck"),n.classList.add(p)),b=a):n.classList.remove("stuck-out")})),window.matchMedia("(max-width: 767px)").matches&&"hidden"!=g&&document.addEventListener("scroll",(function(){var t=s+l+200,e=s+l+320,a=window.pageYOffset;a<=t?n.classList.remove(p):window.scrollY>t?window.scrollY>e?(n.classList.remove("stuck-out"),n.classList.add("stuck"),null==c&&n.prepend(d),d.style.display="inline",d.addEventListener("click",(function(){n.classList.remove("eb-sticky")}))):(a<b&&n.classList.contains("stuck")&&(n.classList.remove("stuck"),n.classList.add(p)),b=a):n.classList.remove("stuck-out")}))}if(t.classList.contains("lightbox")){var w=t.getAttribute("data-id"),h=document.querySelector('[data-id="'.concat(w,'"]')),k="#eb-modal-"+w,L="#myBtn-"+w;h.querySelector(k),u=h.querySelector(L),m=h.getElementsByClassName("eb-modal-close")[0],u.onclick=function(){var t="#eb-modal-"+this.id.substring(6),e=document.querySelector(t),n=e.getElementsByClassName("lightbox")[0].getAttribute("data-autoplay");e.style.display="block","true"===n&&(0,r.render)(React.createElement(o,{wrapper:a,_autoplay:!0,_muted:!1}),a)},m.onclick=function(){var t="#eb-modal-"+this.id.substring(6);document.querySelector(t).style.display="none",(0,r.render)(React.createElement(o,{wrapper:a,_autoplay:!1}),a)},window.onclick=function(t){t.target.classList.contains("eb-modal-player")&&(document.getElementById(t.target.id).style.display="none",(0,r.render)(React.createElement(o,{wrapper:a,_autoplay:!1}),a))}}};for(a.s();!(e=a.n()).done;)y()}catch(t){a.e(t)}finally{a.f()}}))},6087:t=>{t.exports=window.wp.element}},a={};function r(t){var n=a[t];if(void 0!==n)return n.exports;var i=a[t]={id:t,loaded:!1,exports:{}};return e[t].call(i.exports,i,i.exports,r),i.loaded=!0,i.exports}r.m=e,t=[],r.O=(e,a,n,i)=>{if(!a){var o=1/0;for(d=0;d<t.length;d++){for(var[a,n,i]=t[d],s=!0,l=0;l<a.length;l++)(!1&i||o>=i)&&Object.keys(r.O).every((t=>r.O[t](a[l])))?a.splice(l--,1):(s=!1,i<o&&(o=i));if(s){t.splice(d--,1);var c=n();void 0!==c&&(e=c)}}return e}i=i||0;for(var d=t.length;d>0&&t[d-1][2]>i;d--)t[d]=t[d-1];t[d]=[a,n,i]},r.n=t=>{var e=t&&t.__esModule?()=>t.default:()=>t;return r.d(e,{a:e}),e},r.d=(t,e)=>{for(var a in e)r.o(e,a)&&!r.o(t,a)&&Object.defineProperty(t,a,{enumerable:!0,get:e[a]})},r.g=function(){if("object"==typeof globalThis)return globalThis;try{return this||new Function("return this")()}catch(t){if("object"==typeof window)return window}}(),r.o=(t,e)=>Object.prototype.hasOwnProperty.call(t,e),r.r=t=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},r.nmd=t=>(t.paths=[],t.children||(t.children=[]),t),r.j=6695,(()=>{var t={6695:0};r.O.j=e=>0===t[e];var e=(e,a)=>{var n,i,[o,s,l]=a,c=0;if(o.some((e=>0!==t[e]))){for(n in s)r.o(s,n)&&(r.m[n]=s[n]);if(l)var d=l(r)}for(e&&e(a);c<o.length;c++)i=o[c],r.o(t,i)&&t[i]&&t[i][0](),t[i]=0;return r.O(d)},a=globalThis.webpackChunkessential_blocks=globalThis.webpackChunkessential_blocks||[];a.forEach(e.bind(null,0)),a.push=e.bind(null,a.push.bind(a))})(),r.nc=void 0;var n=r.O(void 0,[7916],(()=>r(4773)));n=r.O(n)})();