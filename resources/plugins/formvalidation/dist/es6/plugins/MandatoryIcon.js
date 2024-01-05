import e from"../core/Plugin";import t from"../utils/classSet";export default class i extends e{constructor(e){super(e);this.removedIcons={Invalid:"",NotValidated:"",Valid:"",Validating:""};this.icons=new Map;this.elementValidatingHandler=this.onElementValidating.bind(this);this.elementValidatedHandler=this.onElementValidated.bind(this);this.elementNotValidatedHandler=this.onElementNotValidated.bind(this);this.iconPlacedHandler=this.onIconPlaced.bind(this);this.iconSetHandler=this.onIconSet.bind(this)}install(){this.core.on("core.element.validating",this.elementValidatingHandler).on("core.element.validated",this.elementValidatedHandler).on("core.element.notvalidated",this.elementNotValidatedHandler).on("plugins.icon.placed",this.iconPlacedHandler).on("plugins.icon.set",this.iconSetHandler)}uninstall(){this.icons.clear();this.core.off("core.element.validating",this.elementValidatingHandler).off("core.element.validated",this.elementValidatedHandler).off("core.element.notvalidated",this.elementNotValidatedHandler).off("plugins.icon.placed",this.iconPlacedHandler).off("plugins.icon.set",this.iconSetHandler)}onIconPlaced(e){const i=this.core.getFields()[e.field].validators;const s=this.core.getElements(e.field);if(i&&i["notEmpty"]&&i["notEmpty"].enabled!==false&&s.length){this.icons.set(e.element,e.iconElement);const i=s[0].getAttribute("type");const n=!i?"":i.toLowerCase();const l="checkbox"===n||"radio"===n?[s[0]]:s;for(const i of l){if(this.core.getElementValue(e.field,i)===""){t(e.iconElement,{[this.opts.icon]:true})}}}this.iconClasses=e.classes;const n=this.opts.icon.split(" ");const l={Invalid:this.iconClasses.invalid?this.iconClasses.invalid.split(" "):[],Valid:this.iconClasses.valid?this.iconClasses.valid.split(" "):[],Validating:this.iconClasses.validating?this.iconClasses.validating.split(" "):[]};Object.keys(l).forEach(e=>{const t=[];for(const i of n){if(l[e].indexOf(i)===-1){t.push(i)}}this.removedIcons[e]=t.join(" ")})}onElementValidating(e){this.updateIconClasses(e.element,"Validating")}onElementValidated(e){this.updateIconClasses(e.element,e.valid?"Valid":"Invalid")}onElementNotValidated(e){this.updateIconClasses(e.element,"NotValidated")}updateIconClasses(e,i){const s=this.icons.get(e);if(s&&this.iconClasses&&(this.iconClasses.valid||this.iconClasses.invalid||this.iconClasses.validating)){t(s,{[this.removedIcons[i]]:false,[this.opts.icon]:false})}}onIconSet(e){const i=this.icons.get(e.element);if(i&&e.status==="NotValidated"&&this.core.getElementValue(e.field,e.element)===""){t(i,{[this.opts.icon]:true})}}}