(()=>{const{InputData:t,BaseSignal:e}=JetFormBuilderAbstract,{addAction:n,addFilter:i}=JetPlugins.hooks;function o(){t.call(this),this.value.current="",this.isSupported=function(t){return"checkin-checkout"===t.dataset.field},this.addListeners=function(){const[t]=this.nodes;jQuery(t).on("change.JetFormBuilderMain",(()=>{this.value.current=t.value}));const e=t.parentElement.querySelectorAll(".jet-abaf-field__input");for(const t of e)t.addEventListener("blur",(()=>this.reportOnBlur()))},this.checkIsRequired=function(){const[t]=this.nodes;return!!t.required||!!t.parentElement.querySelector(".jet-abaf-field__input[required]")},this.onClear=function(){this.silenceSet("")},this.setNode=function(e){t.prototype.setNode.call(this,e);let n=e.closest(".jet-abaf-separate-fields");n||(n=e.closest(".jet-abaf-field")),this.nodes.push(n)}}function r(){e.call(this),this.isSupported=function(t,e){return e instanceof o},this.runSignal=function(){}}o.prototype=Object.create(t.prototype),r.prototype=Object.create(e.prototype),n("jet.fb.observe.before","jet-form-builder/booking-compatibility",(function(t){const{rootNode:e}=t;for(const t of e.querySelectorAll(".field-type-check-in-out")){const e=t.querySelector('input[data-field="checkin-checkout"]');e&&(e.dataset.jfbSync=1)}})),i("jet.fb.inputs","jet-form-builder/booking-compatibility",(function(t){return[o,...t]})),i("jet.fb.signals","jet-form-builder/booking-compatibility",(function(t){return[r,...t]}));const c=[];i("jet.fb.onCalculate.part","jet-form-builder/booking-compatibility",(function(t,e){const n=t.match(/ADVANCED_PRICE::([\w\-]+)/);if(!n?.length||!e?.input)return t;const[,i]=n,o=e.input.root.getInput(i);if(!o)return 0;const r=e.input.getSubmit().getFormId();return c.includes(r+o.name)||(c.push(r+o.name),o.watch((()=>e.setResult()))),t}))})();