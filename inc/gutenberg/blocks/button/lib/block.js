!function u(a,c,i){function l(r,t){if(!c[r]){if(!a[r]){var e="function"==typeof require&&require;if(!t&&e)return e(r,!0);if(s)return s(r,!0);var n=new Error("Cannot find module '"+r+"'");throw n.code="MODULE_NOT_FOUND",n}var o=c[r]={exports:{}};a[r][0].call(o.exports,function(t){var e=a[r][1][t];return l(e||t)},o,o.exports,u,a,c,i)}return c[r].exports}for(var s="function"==typeof require&&require,t=0;t<i.length;t++)l(i[t]);return l}({1:[function(t,e,r){"use strict";wp.i18n.__;var n=wp.editor,a=(n.RichText,n.MediaUpload,n.PlainText),c=n.BlockControls,o=wp.blocks.registerBlockType,u=wp.components,i=u.DropdownMenu;u.Dropdown,u.Button;o("franklin/button",{title:"Button",keywords:["button"],icon:"admin-links",category:"layout",attributes:{text:{source:"text",selector:".usa-button"},url:{source:"text",selector:".url"},color:{}},edit:function(t){var e=t.attributes,r=(t.className,t.setAttributes),n=t.focus,o=[{title:"Primary",onClick:function(){return u("primary")}},{title:"Primary Alt",onClick:function(){return u("primary-alt")}},{title:"Secondary",onClick:function(){return u("secondary")}},{title:"Gray",onClick:function(){return u("gray")}},{title:"Outlined",onClick:function(){return u("outline")}}],u=function(t){r({color:t="usa-button-"+t})};return React.createElement("div",{class:"guttenberg-usa-button"},!n&&React.createElement(c,null,React.createElement(i,{icon:"art",label:"Choose a color",controls:o})),React.createElement("button",{className:"usa-button "+e.color},React.createElement(a,{onChange:function(t){return r({text:t})},value:e.text,placeholder:"Your button text",className:"button-text"})))},save:function(t){var e=t.attributes;return React.createElement("button",{className:"usa-button "+e.color},e.text)}})},{}]},{},[1]);
//# sourceMappingURL=maps/block.js.map