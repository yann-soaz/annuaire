!function(){"use strict";var n,e={325:function(n,e,r){var t=window.wp.blocks,o=window.wp.element,i=(window.wp.i18n,window.wp.blockEditor),u=window.wp.serverSideRender,s=r.n(u),a=window.wp.editor,c=window.wp.data;function l(){return(0,o.createElement)("p",null,"Formulaire en cours de chargement...")}(0,t.registerBlockType)("ys-annuaire/site-form",{edit:function(){const{isSaving:n,isSavingNonPostEntityChanges:e}=(0,c.useSelect)((n=>{const{isSavingPost:e,isSavingNonPostEntityChanges:r}=n(a.store);return{isSaving:e(),isSavingNonPostEntityChanges:r()}}));return(0,o.createElement)("div",(0,i.useBlockProps)(),n||e?(0,o.createElement)("p",null,"Mise a jour en cours..."):(0,o.createElement)(s(),{LoadingResponsePlaceholder:l,block:"ys-annuaire/site-form"}))},save:()=>null})}},r={};function t(n){var o=r[n];if(void 0!==o)return o.exports;var i=r[n]={exports:{}};return e[n](i,i.exports,t),i.exports}t.m=e,n=[],t.O=function(e,r,o,i){if(!r){var u=1/0;for(l=0;l<n.length;l++){r=n[l][0],o=n[l][1],i=n[l][2];for(var s=!0,a=0;a<r.length;a++)(!1&i||u>=i)&&Object.keys(t.O).every((function(n){return t.O[n](r[a])}))?r.splice(a--,1):(s=!1,i<u&&(u=i));if(s){n.splice(l--,1);var c=o();void 0!==c&&(e=c)}}return e}i=i||0;for(var l=n.length;l>0&&n[l-1][2]>i;l--)n[l]=n[l-1];n[l]=[r,o,i]},t.n=function(n){var e=n&&n.__esModule?function(){return n.default}:function(){return n};return t.d(e,{a:e}),e},t.d=function(n,e){for(var r in e)t.o(e,r)&&!t.o(n,r)&&Object.defineProperty(n,r,{enumerable:!0,get:e[r]})},t.o=function(n,e){return Object.prototype.hasOwnProperty.call(n,e)},function(){var n={826:0,431:0};t.O.j=function(e){return 0===n[e]};var e=function(e,r){var o,i,u=r[0],s=r[1],a=r[2],c=0;if(u.some((function(e){return 0!==n[e]}))){for(o in s)t.o(s,o)&&(t.m[o]=s[o]);if(a)var l=a(t)}for(e&&e(r);c<u.length;c++)i=u[c],t.o(n,i)&&n[i]&&n[i][0](),n[i]=0;return t.O(l)},r=self.webpackChunksite_url=self.webpackChunksite_url||[];r.forEach(e.bind(null,0)),r.push=e.bind(null,r.push.bind(r))}();var o=t.O(void 0,[431],(function(){return t(325)}));o=t.O(o)}();