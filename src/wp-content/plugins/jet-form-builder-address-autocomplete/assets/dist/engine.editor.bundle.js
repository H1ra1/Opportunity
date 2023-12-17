(()=>{"use strict";var e=function(){var e=this,l=e._self._c;return l("div",[l("JetFormEditorRow",{attrs:{label:e.labels.countries}},[l("select",{directives:[{name:"model",rawName:"v-model",value:e.response.countries,expression:"response.countries"}],attrs:{multiple:"",size:"10"},on:{change:function(l){var a=Array.prototype.filter.call(l.target.options,(function(e){return e.selected})).map((function(e){return"_value"in e?e._value:e.value}));e.$set(e.response,"countries",l.target.multiple?a:a[0])}}},e._l(e.countriesList,(function(a){var t=a.label,n=a.value;return l("option",{domProps:{value:n}},[e._v(e._s(t))])})),0)]),e._v(" "),l("JetFormEditorRow",{attrs:{label:e.labels.types},scopedSlots:e._u([{key:"helpLabel",fn:function(){return[e._v("\n\t\t\t"+e._s(e.help.types_link_label)+"\n\t\t\t"),l("a",{attrs:{href:e.help.types_link}},[e._v(e._s(e.help.types_link_name))])]},proxy:!0}])},[l("select",{directives:[{name:"model",rawName:"v-model",value:e.response.types,expression:"response.types"}],attrs:{multiple:"",size:"5"},on:{change:function(l){var a=Array.prototype.filter.call(l.target.options,(function(e){return e.selected})).map((function(e){return"_value"in e?e._value:e.value}));e.$set(e.response,"types",l.target.multiple?a:a[0])}}},e._l(e.types,(function(a){var t=a.label,n=a.value;return l("option",{domProps:{value:n}},[e._v(e._s(t))])})),0)])],1)};e._withStripped=!0;var l=function(){var e=this,l=e._self._c;return l("div",{staticClass:"jet-form-editor__row"},[l("div",{class:e.labelClassObject},[e._v("\n\t\t"+e._s(e.label)+"\n\t\t"),this.$slots.helpLabel?l("div",{class:e.helpClassObject},[e._t("helpLabel")],2):e._e()]),e._v(" "),l("div",{class:e.controlClassObject},[e._t("default"),e._v(" "),this.$slots.helpControl?l("div",{class:e.helpClassObject},[e._t("helpControl")],2):e._e()],2),e._v(" "),this.$slots.helpSide?l("div",{class:e.helpClassObject},[e._v("\n\t\t    "),e._t("helpSide")],2):e._e()])};function a(e,l,a,t,n,u,r,i){var o,s="function"==typeof e?e.options:e;if(l&&(s.render=l,s.staticRenderFns=a,s._compiled=!0),t&&(s.functional=!0),u&&(s._scopeId="data-v-"+u),r?(o=function(e){(e=e||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(e=__VUE_SSR_CONTEXT__),n&&n.call(this,e),e&&e._registeredComponents&&e._registeredComponents.add(r)},s._ssrRegister=o):n&&(o=i?function(){n.call(this,(s.functional?this.parent:this).$root.$options.shadowRoot)}:n),o)if(s.functional){s._injectStyles=o;var b=s.render;s.render=function(e,l){return o.call(l),b(e,l)}}else{var v=s.beforeCreate;s.beforeCreate=v?[].concat(v,o):[o]}return{exports:e,options:s}}l._withStripped=!0;const t=a({name:"jet-form-editor-row",props:{label:{type:String,default:""},labelClass:{type:String,default:""},helpClass:{type:String,default:""},controlClass:{type:String,default:""}},computed:{labelClassObject(){return this.getClass("defaultLabelClass","labelClass")},helpClassObject(){return this.getClass("defaultHelpClass","helpClass")},controlClassObject(){return this.getClass("defaultControlClass","controlClass")}},data:()=>({defaultLabelClass:"jet-form-editor__row-label",defaultHelpClass:"jet-form-editor__row-notice",defaultControlClass:"jet-form-editor__row-control"}),methods:{getClass(e,l){return{[`${this[e]} ${this[l]}`]:this[l],[this[e]]:!this[l]}}}},l,[],!1,null,null,null).exports,n=JSON.parse('[{"label":"Afghanistan","value":"AF"},{"label":"Åland Islands","value":"AX"},{"label":"Albania","value":"AL"},{"label":"Algeria","value":"DZ"},{"label":"American Samoa","value":"AS"},{"label":"AndorrA","value":"AD"},{"label":"Angola","value":"AO"},{"label":"Anguilla","value":"AI"},{"label":"Antarctica","value":"AQ"},{"label":"Antigua and Barbuda","value":"AG"},{"label":"Argentina","value":"AR"},{"label":"Armenia","value":"AM"},{"label":"Aruba","value":"AW"},{"label":"Australia","value":"AU"},{"label":"Austria","value":"AT"},{"label":"Azerbaijan","value":"AZ"},{"label":"Bahamas","value":"BS"},{"label":"Bahrain","value":"BH"},{"label":"Bangladesh","value":"BD"},{"label":"Barbados","value":"BB"},{"label":"Belarus","value":"BY"},{"label":"Belgium","value":"BE"},{"label":"Belize","value":"BZ"},{"label":"Benin","value":"BJ"},{"label":"Bermuda","value":"BM"},{"label":"Bhutan","value":"BT"},{"label":"Bolivia","value":"BO"},{"label":"Bosnia and Herzegovina","value":"BA"},{"label":"Botswana","value":"BW"},{"label":"Bouvet Island","value":"BV"},{"label":"Brazil","value":"BR"},{"label":"British Indian Ocean Territory","value":"IO"},{"label":"Brunei Darussalam","value":"BN"},{"label":"Bulgaria","value":"BG"},{"label":"Burkina Faso","value":"BF"},{"label":"Burundi","value":"BI"},{"label":"Cambodia","value":"KH"},{"label":"Cameroon","value":"CM"},{"label":"Canada","value":"CA"},{"label":"Cape Verde","value":"CV"},{"label":"Cayman Islands","value":"KY"},{"label":"Central African Republic","value":"CF"},{"label":"Chad","value":"TD"},{"label":"Chile","value":"CL"},{"label":"China","value":"CN"},{"label":"Christmas Island","value":"CX"},{"label":"Cocos (Keeling) Islands","value":"CC"},{"label":"Colombia","value":"CO"},{"label":"Comoros","value":"KM"},{"label":"Congo","value":"CG"},{"label":"Congo, The Democratic Republic of the","value":"CD"},{"label":"Cook Islands","value":"CK"},{"label":"Costa Rica","value":"CR"},{"label":"Cote D\'Ivoire","value":"CI"},{"label":"Croatia","value":"HR"},{"label":"Cuba","value":"CU"},{"label":"Cyprus","value":"CY"},{"label":"Czech Republic","value":"CZ"},{"label":"Denmark","value":"DK"},{"label":"Djibouti","value":"DJ"},{"label":"Dominica","value":"DM"},{"label":"Dominican Republic","value":"DO"},{"label":"Ecuador","value":"EC"},{"label":"Egypt","value":"EG"},{"label":"El Salvador","value":"SV"},{"label":"Equatorial Guinea","value":"GQ"},{"label":"Eritrea","value":"ER"},{"label":"Estonia","value":"EE"},{"label":"Ethiopia","value":"ET"},{"label":"Falkland Islands (Malvinas)","value":"FK"},{"label":"Faroe Islands","value":"FO"},{"label":"Fiji","value":"FJ"},{"label":"Finland","value":"FI"},{"label":"France","value":"FR"},{"label":"French Guiana","value":"GF"},{"label":"French Polynesia","value":"PF"},{"label":"French Southern Territories","value":"TF"},{"label":"Gabon","value":"GA"},{"label":"Gambia","value":"GM"},{"label":"Georgia","value":"GE"},{"label":"Germany","value":"DE"},{"label":"Ghana","value":"GH"},{"label":"Gibraltar","value":"GI"},{"label":"Greece","value":"GR"},{"label":"Greenland","value":"GL"},{"label":"Grenada","value":"GD"},{"label":"Guadeloupe","value":"GP"},{"label":"Guam","value":"GU"},{"label":"Guatemala","value":"GT"},{"label":"Guernsey","value":"GG"},{"label":"Guinea","value":"GN"},{"label":"Guinea-Bissau","value":"GW"},{"label":"Guyana","value":"GY"},{"label":"Haiti","value":"HT"},{"label":"Heard Island and Mcdonald Islands","value":"HM"},{"label":"Holy See (Vatican City State)","value":"VA"},{"label":"Honduras","value":"HN"},{"label":"Hong Kong","value":"HK"},{"label":"Hungary","value":"HU"},{"label":"Iceland","value":"IS"},{"label":"India","value":"IN"},{"label":"Indonesia","value":"ID"},{"label":"Iran, Islamic Republic Of","value":"IR"},{"label":"Iraq","value":"IQ"},{"label":"Ireland","value":"IE"},{"label":"Isle of Man","value":"IM"},{"label":"Israel","value":"IL"},{"label":"Italy","value":"IT"},{"label":"Jamaica","value":"JM"},{"label":"Japan","value":"JP"},{"label":"Jersey","value":"JE"},{"label":"Jordan","value":"JO"},{"label":"Kazakhstan","value":"KZ"},{"label":"Kenya","value":"KE"},{"label":"Kiribati","value":"KI"},{"label":"Korea, Democratic People\'s Republic of","value":"KP"},{"label":"Korea, Republic of","value":"KR"},{"label":"Kuwait","value":"KW"},{"label":"Kyrgyzstan","value":"KG"},{"label":"Lao People\'s Democratic Republic","value":"LA"},{"label":"Latvia","value":"LV"},{"label":"Lebanon","value":"LB"},{"label":"Lesotho","value":"LS"},{"label":"Liberia","value":"LR"},{"label":"Libyan Arab Jamahiriya","value":"LY"},{"label":"Liechtenstein","value":"LI"},{"label":"Lithuania","value":"LT"},{"label":"Luxembourg","value":"LU"},{"label":"Macao","value":"MO"},{"label":"Macedonia, The Former Yugoslav Republic of","value":"MK"},{"label":"Madagascar","value":"MG"},{"label":"Malawi","value":"MW"},{"label":"Malaysia","value":"MY"},{"label":"Maldives","value":"MV"},{"label":"Mali","value":"ML"},{"label":"Malta","value":"MT"},{"label":"Marshall Islands","value":"MH"},{"label":"Martinique","value":"MQ"},{"label":"Mauritania","value":"MR"},{"label":"Mauritius","value":"MU"},{"label":"Mayotte","value":"YT"},{"label":"Mexico","value":"MX"},{"label":"Micronesia, Federated States of","value":"FM"},{"label":"Moldova, Republic of","value":"MD"},{"label":"Monaco","value":"MC"},{"label":"Mongolia","value":"MN"},{"label":"Montserrat","value":"MS"},{"label":"Morocco","value":"MA"},{"label":"Mozambique","value":"MZ"},{"label":"Myanmar","value":"MM"},{"label":"Namibia","value":"NA"},{"label":"Nauru","value":"NR"},{"label":"Nepal","value":"NP"},{"label":"Netherlands","value":"NL"},{"label":"Netherlands Antilles","value":"AN"},{"label":"New Caledonia","value":"NC"},{"label":"New Zealand","value":"NZ"},{"label":"Nicaragua","value":"NI"},{"label":"Niger","value":"NE"},{"label":"Nigeria","value":"NG"},{"label":"Niue","value":"NU"},{"label":"Norfolk Island","value":"NF"},{"label":"Northern Mariana Islands","value":"MP"},{"label":"Norway","value":"NO"},{"label":"Oman","value":"OM"},{"label":"Pakistan","value":"PK"},{"label":"Palau","value":"PW"},{"label":"Palestinian Territory, Occupied","value":"PS"},{"label":"Panama","value":"PA"},{"label":"Papua New Guinea","value":"PG"},{"label":"Paraguay","value":"PY"},{"label":"Peru","value":"PE"},{"label":"Philippines","value":"PH"},{"label":"Pitcairn","value":"PN"},{"label":"Poland","value":"PL"},{"label":"Portugal","value":"PT"},{"label":"Puerto Rico","value":"PR"},{"label":"Qatar","value":"QA"},{"label":"Reunion","value":"RE"},{"label":"Romania","value":"RO"},{"label":"Russian Federation","value":"RU"},{"label":"RWANDA","value":"RW"},{"label":"Saint Helena","value":"SH"},{"label":"Saint Kitts and Nevis","value":"KN"},{"label":"Saint Lucia","value":"LC"},{"label":"Saint Pierre and Miquelon","value":"PM"},{"label":"Saint Vincent and the Grenadines","value":"VC"},{"label":"Samoa","value":"WS"},{"label":"San Marino","value":"SM"},{"label":"Sao Tome and Principe","value":"ST"},{"label":"Saudi Arabia","value":"SA"},{"label":"Senegal","value":"SN"},{"label":"Serbia and Montenegro","value":"CS"},{"label":"Seychelles","value":"SC"},{"label":"Sierra Leone","value":"SL"},{"label":"Singapore","value":"SG"},{"label":"Slovakia","value":"SK"},{"label":"Slovenia","value":"SI"},{"label":"Solomon Islands","value":"SB"},{"label":"Somalia","value":"SO"},{"label":"South Africa","value":"ZA"},{"label":"South Georgia and the South Sandwich Islands","value":"GS"},{"label":"Spain","value":"ES"},{"label":"Sri Lanka","value":"LK"},{"label":"Sudan","value":"SD"},{"label":"Suriname","value":"SR"},{"label":"Svalbard and Jan Mayen","value":"SJ"},{"label":"Swaziland","value":"SZ"},{"label":"Sweden","value":"SE"},{"label":"Switzerland","value":"CH"},{"label":"Syrian Arab Republic","value":"SY"},{"label":"Taiwan, Province of China","value":"TW"},{"label":"Tajikistan","value":"TJ"},{"label":"Tanzania, United Republic of","value":"TZ"},{"label":"Thailand","value":"TH"},{"label":"Timor-Leste","value":"TL"},{"label":"Togo","value":"TG"},{"label":"Tokelau","value":"TK"},{"label":"Tonga","value":"TO"},{"label":"Trinidad and Tobago","value":"TT"},{"label":"Tunisia","value":"TN"},{"label":"Turkey","value":"TR"},{"label":"Turkmenistan","value":"TM"},{"label":"Turks and Caicos Islands","value":"TC"},{"label":"Tuvalu","value":"TV"},{"label":"Uganda","value":"UG"},{"label":"Ukraine","value":"UA"},{"label":"United Arab Emirates","value":"AE"},{"label":"United Kingdom","value":"GB"},{"label":"United States","value":"US"},{"label":"United States Minor Outlying Islands","value":"UM"},{"label":"Uruguay","value":"UY"},{"label":"Uzbekistan","value":"UZ"},{"label":"Vanuatu","value":"VU"},{"label":"Venezuela","value":"VE"},{"label":"Viet Nam","value":"VN"},{"label":"Virgin Islands, British","value":"VG"},{"label":"Virgin Islands, U.S.","value":"VI"},{"label":"Wallis and Futuna","value":"WF"},{"label":"Western Sahara","value":"EH"},{"label":"Yemen","value":"YE"},{"label":"Zambia","value":"ZM"},{"label":"Zimbabwe","value":"ZW"}]');function u(e,l){(null==l||l>e.length)&&(l=e.length);for(var a=0,t=new Array(l);a<l;a++)t[a]=e[a];return t}var r,i=wp.i18n.__,o={countries:[],types:[]},s={countries:i("Countries allowed"),types:i("Place types")},b={types_link:"https://developers.google.com/maps/documentation/places/web-service/supported_types"},v={},c={},d=[],p=function(e,l){var a="undefined"!=typeof Symbol&&e[Symbol.iterator]||e["@@iterator"];if(!a){if(Array.isArray(e)||(a=function(e,l){if(e){if("string"==typeof e)return u(e,l);var a=Object.prototype.toString.call(e).slice(8,-1);return"Object"===a&&e.constructor&&(a=e.constructor.name),"Map"===a||"Set"===a?Array.from(e):"Arguments"===a||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(a)?u(e,l):void 0}}(e))){a&&(e=a);var t=0,n=function(){};return{s:n,n:function(){return t>=e.length?{done:!0}:{done:!1,value:e[t++]}},e:function(e){throw e},f:n}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var r,i=!0,o=!1;return{s:function(){a=a.call(e)},n:function(){var e=a.next();return i=e.done,e},e:function(e){o=!0,r=e},f:function(){try{i||null==a.return||a.return()}finally{if(o)throw r}}}}(n);try{for(p.s();!(r=p.n()).done;){var f=r.value,h=f.value,m=f.label;v[h]=m,c[m]=h,d.push(m)}}catch(e){p.e(e)}finally{p.f()}for(var y=[{value:"geocode",label:"Geocode"},{value:"address",label:"Address"},{value:"establishment",label:"Establishment"},{value:"(regions)",label:"Regions"},{value:"(cities)",label:"Cities"}],S={},C={},g=[],_=0,M=y;_<M.length;_++){var A=M[_],I=A.value,T=A.label;S[I]=T,C[T]=I,g.push(T)}function G(e){return G="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},G(e)}function P(e,l){var a=Object.keys(e);if(Object.getOwnPropertySymbols){var t=Object.getOwnPropertySymbols(e);l&&(t=t.filter((function(l){return Object.getOwnPropertyDescriptor(e,l).enumerable}))),a.push.apply(a,t)}return a}function O(e){for(var l=1;l<arguments.length;l++){var a=null!=arguments[l]?arguments[l]:{};l%2?P(Object(a),!0).forEach((function(l){N(e,l,a[l])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(a)):P(Object(a)).forEach((function(l){Object.defineProperty(e,l,Object.getOwnPropertyDescriptor(a,l))}))}return e}function N(e,l,a){return(l=function(e){var l=function(e,l){if("object"!==G(e)||null===e)return e;var a=e[Symbol.toPrimitive];if(void 0!==a){var t=a.call(e,"string");if("object"!==G(t))return t;throw new TypeError("@@toPrimitive must return a primitive value.")}return String(e)}(e);return"symbol"===G(l)?l:String(l)}(l))in e?Object.defineProperty(e,l,{value:a,enumerable:!0,configurable:!0,writable:!0}):e[l]=a,e}const B=a({name:"address_autocomplete",components:{JetFormEditorRow:t},props:["value"],data:function(){return{response:O({},o),labels:s,countriesList:n,types:y,help:b}},created:function(){this.response=O(O({},this.response),this.value)},watch:{response:function(e){this.$emit("input",e)}},methods:{}},e,[],!1,null,null,null).exports;(0,wp.hooks.addFilter)("jet.engine.register.fields","jet-engine",(function(e){return e.push(B),e}))})();
//# sourceMappingURL=engine.editor.bundle.js.map